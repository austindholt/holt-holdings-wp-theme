import { readFile } from "node:fs/promises";

const SITE_URL = "https://holtholdings.us";
const HOME_URL = `${SITE_URL}/`;
const CONTACT_EMAIL = "holtholdingsllc@outlook.com";
const failures = [];
const warnings = [];
const passes = [];
const warnedHosts = new Set();

const pass = (message) => passes.push(message);
const fail = (message) => failures.push(message);
const warn = (message) => warnings.push(message);
const attr = (tag, name) => tag.match(new RegExp(`${name}\\s*=\\s*["']([^"']*)["']`, "i"))?.[1]?.replaceAll("&amp;", "&") || "";

async function fetchTimed(url, options = {}) {
  const controller = new AbortController();
  const timeout = setTimeout(() => controller.abort(), options.timeoutMs || 15000);
  try {
    return await fetch(url, {
      redirect: "follow",
      headers: { "user-agent": "Holt Holdings weekly site audit" },
      ...options,
      signal: controller.signal
    });
  } finally {
    clearTimeout(timeout);
  }
}

async function checkUrl(url) {
  try {
    let response = await fetchTimed(url, { method: "HEAD", timeoutMs: 12000 });
    if ([401, 403, 405, 429].includes(response.status)) {
      response = await fetchTimed(url, { method: "GET", timeoutMs: 12000 });
    }
    return { status: response.status, ok: response.status >= 200 && response.status < 400 };
  } catch (error) {
    return { status: "timeout/error", ok: false, error: error.message };
  }
}

function tags(html, name) {
  return html.match(new RegExp(`<${name}\\b[^>]*>`, "gi")) || [];
}

function anchorLabel(html, tag) {
  const start = html.indexOf(tag);
  const end = html.indexOf("</a>", start);
  return end > start ? html.slice(start + tag.length, end).replace(/<[^>]+>/g, " ").replace(/\s+/g, " ").trim() : "unlabeled link";
}

async function main() {
  const style = await readFile("style.css", "utf8");
  const expectedVersion = style.match(/^Version:\s*(\S+)/m)?.[1];
  if (!expectedVersion) fail("Repository theme version is missing from style.css.");

  const response = await fetchTimed(HOME_URL, { method: "GET", timeoutMs: 20000 });
  if (response.status !== 200) {
    fail(`Homepage returned HTTP ${response.status}, expected 200.`);
  } else {
    pass("Homepage returned HTTP 200.");
  }

  const rawHtml = await response.text();
  const html = rawHtml.replaceAll("&amp;", "&");
  const anchors = tags(rawHtml, "a").map((tag) => ({
    tag,
    href: attr(tag, "href"),
    rel: attr(tag, "rel"),
    target: attr(tag, "target"),
    label: anchorLabel(rawHtml, tag)
  }));
  const ids = new Set(Array.from(rawHtml.matchAll(/\sid=["']([^"']+)["']/gi), (match) => match[1]));

  for (const id of ["products", "merch", "resources", "contact"]) {
    ids.has(id) ? pass(`#${id} section exists.`) : fail(`Required homepage section missing: #${id}`);
  }

  if (html.includes(CONTACT_EMAIL) && html.includes(`mailto:${CONTACT_EMAIL}`)) pass("Contact email and mailto are correct.");
  else fail(`Missing ${CONTACT_EMAIL} or its mailto link.`);

  if (/Fatal error|Parse error|Uncaught Error|WordPress database error/i.test(html)) fail("Visible WordPress/PHP fatal error text found.");
  else pass("No visible WordPress/PHP fatal error text found.");

  if (tags(rawHtml, "h1").length === 1) pass("Exactly one H1 exists.");
  else fail(`Expected exactly one H1; found ${tags(rawHtml, "h1").length}.`);

  for (const [label, pattern] of [
    ["title", /<title>[^<]+<\/title>/i],
    ["meta description", /<meta\s+name=["']description["']\s+content=["'][^"']+["']/i],
    ["og:title", /<meta\s+property=["']og:title["']\s+content=["'][^"']+["']/i],
    ["og:description", /<meta\s+property=["']og:description["']\s+content=["'][^"']+["']/i],
    ["og:url", /<meta\s+property=["']og:url["']\s+content=["'][^"']+["']/i],
    ["og:image", /<meta\s+property=["']og:image["']\s+content=["'][^"']+["']/i],
    ["Twitter card", /<meta\s+name=["']twitter:card["']\s+content=["'][^"']+["']/i]
  ]) pattern.test(rawHtml) ? pass(`${label} exists.`) : fail(`${label} is missing.`);

  const canonicals = tags(rawHtml, "link")
    .filter((tag) => attr(tag, "rel").toLowerCase().split(/\s+/).includes("canonical"))
    .map((tag) => attr(tag, "href"));
  canonicals.length === 1 && canonicals[0] === HOME_URL
    ? pass(`Canonical is ${HOME_URL}.`)
    : fail(`Expected one canonical ${HOME_URL}; found ${canonicals.join(", ") || "none"}.`);

  const liveVersion = html.match(/Holt Holdings theme version:\s*([^<\s]+)/i)?.[1];
  liveVersion === expectedVersion
    ? pass(`Live theme version ${liveVersion} matches repository.`)
    : fail(`Live deployment marker ${liveVersion || "missing"} does not match repository ${expectedVersion}.`);

  if (html.includes("https://a.co/d/0aEp6yu6")) fail("Known broken Amazon short URL is still rendered.");
  else pass("Known broken Amazon short URL is absent.");

  for (const anchor of anchors) {
    if (!anchor.href || anchor.href === "#") fail(`Empty/fake href on “${anchor.label}”.`);
    if (anchor.href.startsWith("#") && anchor.href !== "#" && !ids.has(decodeURIComponent(anchor.href.slice(1)))) {
      fail(`Internal anchor destination missing for “${anchor.label}”: ${anchor.href}`);
    }
  }

  const productSection = rawHtml.match(/<section\b[^>]*id=["']products["'][\s\S]*?<\/section>/i)?.[0] || "";
  const productAnchors = tags(productSection, "a").map((tag) => attr(tag, "href")).filter((href) => href.includes("payhip.com"));
  if (productAnchors.length === 0) fail("No active Payhip product links are rendered.");
  else if (productAnchors.every((href) => /^https:\/\/(?:www\.)?payhip\.com\//i.test(href))) pass(`${productAnchors.length} rendered Payhip links use valid HTTPS URLs.`);
  else fail("A rendered product has a non-HTTPS or non-Payhip URL.");

  const merchSection = rawHtml.match(/<section\b[^>]*id=["']merch["'][\s\S]*?<\/section>/i)?.[0] || "";
  const merchCards = merchSection.match(/<article\b[^>]*class=["'][^"']*merch-card[^"']*["'][\s\S]*?<\/article>/gi) || [];
  if (merchCards.length < 6) fail(`Expected at least six merchandise cards; found ${merchCards.length}.`);
  else pass(`${merchCards.length} merchandise cards are rendered.`);
  for (const card of merchCards) {
    const status = attr(card.match(/<article\b[^>]*>/i)?.[0] || "", "data-merch-status");
    const cardAnchors = tags(card, "a");
    if (status === "inquiry" && cardAnchors.length === 0) fail("Available merchandise card has no inquiry action.");
    if (["coming_soon", "out_of_stock"].includes(status) && cardAnchors.length > 0) fail("Unavailable merchandise card is clickable.");
  }
  if (/name=["']holt_merch_nonce["']/.test(merchSection) && /name=["']website["']/.test(merchSection)) pass("Merch form includes nonce and honeypot fields.");
  else fail("Merch form security fields are missing.");

  const amazonAnchors = anchors.filter(({ href }) => /(?:amazon\.com|amzn\.to|a\.co)/i.test(href));
  if (amazonAnchors.length > 0) {
    if (!html.includes("As an Amazon Associate I earn from qualifying purchases")) fail("Affiliate disclosure is missing.");
    for (const anchor of amazonAnchors) {
      const rel = anchor.rel.toLowerCase().split(/\s+/);
      for (const token of ["sponsored", "noopener", "noreferrer"]) if (!rel.includes(token)) fail(`Amazon link “${anchor.label}” lacks rel=${token}.`);
      if (anchor.target !== "_blank") fail(`Amazon link “${anchor.label}” must open in a new tab.`);
    }
  }

  for (const path of ["/sitemap.xml", "/robots.txt"]) {
    const result = await checkUrl(`${SITE_URL}${path}`);
    result.ok ? pass(`${path} is available (${result.status}).`) : fail(`${path} is unavailable (${result.status}).`);
  }

  const unique = new Map();
  for (const anchor of anchors) {
    if (/^(#|mailto:|tel:)/i.test(anchor.href)) continue;
    try {
      const url = new URL(anchor.href, HOME_URL).toString();
      if (!unique.has(url)) unique.set(url, anchor.label);
    } catch {
      fail(`Invalid URL on “${anchor.label}”: ${anchor.href}`);
    }
  }

  for (const [url, label] of unique) {
    const result = await checkUrl(url);
    if (result.ok) continue;
    const host = new URL(url).hostname.replace(/^www\./, "");
    const botProtected = ["payhip.com", "facebook.com", "instagram.com", "tiktok.com", "youtube.com", "amazon.com", "amzn.to", "linktr.ee"]
      .some((allowed) => host === allowed || host.endsWith(`.${allowed}`));
    if (botProtected && [401, 403, 405, 429, "timeout/error"].includes(result.status)) {
      if (!warnedHosts.has(host)) {
        warnedHosts.add(host);
        warn(`${host} automated checks are blocked or inconclusive (${result.status}); rendered links were validated.`);
      }
    } else if ([404, 410].includes(result.status) || new URL(url).origin === SITE_URL) {
      fail(`Broken link from “${label}”: ${url} (${result.status}).`);
    } else {
      warn(`External link from “${label}” could not be confirmed: ${url} (${result.status}).`);
    }
  }

  for (const message of passes) console.log(`PASS: ${message}`);
  for (const message of warnings) console.log(`WARN: ${message}`);
  for (const message of failures) console.log(`FAIL: ${message}`);
  console.log(`SUMMARY: ${passes.length} PASS, ${warnings.length} WARN, ${failures.length} FAIL`);
  if (failures.length) process.exit(1);
}

await main().catch((error) => {
  console.error(`FAIL: Audit crashed: ${error.stack || error}`);
  process.exit(1);
});
