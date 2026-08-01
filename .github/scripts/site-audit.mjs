import { readFile } from "node:fs/promises";

const SITE_URL = "https://holtholdings.us";
const CONTACT_EMAIL = "holtholdingsllc@outlook.com";
const routes = ["/", "/businesses-projects/", "/digital-products/", "/tools-resources/", "/merch/", "/about/", "/contact/"];
const failures = [];
const warnings = [];
const passes = [];
const warnedHosts = new Set();
const pass = (message) => passes.push(message);
const fail = (message) => failures.push(message);
const warn = (message) => warnings.push(message);
const attr = (tag, name) => tag.match(new RegExp(`${name}\\s*=\\s*["']([^"']*)["']`, "i"))?.[1]?.replaceAll("&amp;", "&") || "";
const tags = (html, name) => html.match(new RegExp(`<${name}\\b[^>]*>`, "gi")) || [];

async function fetchTimed(url, options = {}) {
  const controller = new AbortController();
  const timeout = setTimeout(() => controller.abort(), options.timeoutMs || 15000);
  try {
    return await fetch(url, { redirect: "follow", headers: { "user-agent": "Holt Holdings weekly site audit" }, ...options, signal: controller.signal });
  } finally { clearTimeout(timeout); }
}

async function checkUrl(url) {
  try {
    let response = await fetchTimed(url, { method: "HEAD", timeoutMs: 12000 });
    if ([401, 403, 405, 429].includes(response.status)) response = await fetchTimed(url, { method: "GET", timeoutMs: 12000 });
    return { status: response.status, ok: response.status >= 200 && response.status < 400 };
  } catch (error) { return { status: "timeout/error", ok: false, error: error.message }; }
}

function anchorLabel(html, tag) {
  const start = html.indexOf(tag);
  const end = html.indexOf("</a>", start);
  return end > start ? html.slice(start + tag.length, end).replace(/<[^>]+>/g, " ").replace(/\s+/g, " ").trim() : "unlabeled link";
}

async function main() {
  const style = await readFile("style.css", "utf8");
  const expectedVersion = style.match(/^Version:\s*(\S+)/m)?.[1];
  if (!expectedVersion) fail("Repository theme version is missing.");

  const pages = new Map();
  const allAnchors = [];
  const titles = new Set();
  const descriptions = new Set();

  for (const route of routes) {
    const url = `${SITE_URL}${route}`;
    const response = await fetchTimed(url, { method: "GET", timeoutMs: 20000 });
    if (response.status !== 200) { fail(`${route} returned HTTP ${response.status}.`); continue; }
    const rawHtml = await response.text();
    const html = rawHtml.replaceAll("&amp;", "&");
    pages.set(route, rawHtml);
    pass(`${route} returned HTTP 200.`);

    if (/Fatal error|Parse error|Uncaught Error|WordPress database error/i.test(html)) fail(`${route} exposes a WordPress/PHP error.`);
    const h1Count = tags(rawHtml, "h1").length;
    h1Count === 1 ? pass(`${route} has one H1.`) : fail(`${route} has ${h1Count} H1 elements.`);

    const title = rawHtml.match(/<title>([^<]+)<\/title>/i)?.[1]?.trim() || "";
    const descriptionTag = tags(rawHtml, "meta").find((tag) => attr(tag, "name").toLowerCase() === "description");
    const description = descriptionTag ? attr(descriptionTag, "content") : "";
    if (!title) fail(`${route} is missing a title.`); else if (titles.has(title)) fail(`${route} duplicates title: ${title}`); else titles.add(title);
    if (!description) fail(`${route} is missing a meta description.`); else if (descriptions.has(description)) fail(`${route} duplicates its meta description.`); else descriptions.add(description);
    for (const property of ["og:title", "og:description", "og:url", "og:image"]) {
      if (!tags(rawHtml, "meta").some((tag) => attr(tag, "property").toLowerCase() === property && attr(tag, "content"))) fail(`${route} is missing ${property}.`);
    }
    if (!tags(rawHtml, "meta").some((tag) => attr(tag, "name").toLowerCase() === "twitter:card")) fail(`${route} is missing Twitter card metadata.`);

    const canonicals = tags(rawHtml, "link").filter((tag) => attr(tag, "rel").toLowerCase().split(/\s+/).includes("canonical")).map((tag) => attr(tag, "href"));
    canonicals.length === 1 && canonicals[0] === url ? pass(`${route} canonical is correct.`) : fail(`${route} canonical is incorrect: ${canonicals.join(", ") || "missing"}.`);

    const ids = new Set(Array.from(rawHtml.matchAll(/\sid=["']([^"']+)["']/gi), (match) => match[1]));
    for (const tag of tags(rawHtml, "a")) {
      const href = attr(tag, "href");
      const anchor = { route, tag, href, rel: attr(tag, "rel"), target: attr(tag, "target"), label: anchorLabel(rawHtml, tag) };
      allAnchors.push(anchor);
      if (!href || href === "#") fail(`${route} has an empty/fake link: ${anchor.label}.`);
      if (href.startsWith("#") && !ids.has(decodeURIComponent(href.slice(1)))) fail(`${route} has a missing anchor target: ${href}.`);
    }
    if (/href=["'][^"']*github\.com\//i.test(rawHtml)) fail(`${route} renders a public GitHub link.`);
    if (/deploy automation|deploy test|weekly audit enabled|external links fixed test/i.test(rawHtml)) fail(`${route} exposes legacy deployment comments.`);
  }

  const home = pages.get("/") || "";
  for (const route of routes.slice(1)) if (!home.includes(`href="${SITE_URL}${route}"`)) fail(`Homepage does not link to ${route}.`);
  if (/<form\b[^>]*holt_merch/i.test(home) || /name=["']holt_merch_nonce["']/i.test(home)) fail("Homepage duplicates the merchandise form.");
  else pass("Homepage is curated and does not duplicate the merchandise form.");

  const products = pages.get("/digital-products/") || "";
  if (/https:\/\/lowvoltvault\.com\/?/i.test(products) && /Browse LowVolt Vault/i.test(products)) pass("LowVolt Vault feature is on Digital Products."); else fail("LowVolt Vault feature is missing.");
  const payhipLinks = tags(products, "a").map((tag) => attr(tag, "href")).filter((href) => /^https:\/\/(?:www\.)?payhip\.com\//i.test(href));
  payhipLinks.length >= 13 ? pass(`${payhipLinks.length} Payhip links are preserved.`) : fail(`Expected at least 13 Payhip links; found ${payhipLinks.length}.`);

  const merch = pages.get("/merch/") || "";
  const merchCards = merch.match(/<article\b[^>]*class=["'][^"']*merch-card[^"']*["'][\s\S]*?<\/article>/gi) || [];
  merchCards.length >= 6 ? pass(`${merchCards.length} merchandise cards are on /merch/.`) : fail(`Expected six merchandise cards; found ${merchCards.length}.`);
  if (/name=["']holt_merch_nonce["']/.test(merch) && /name=["']website["']/.test(merch) && /admin-post\.php/.test(merch)) pass("Merch form endpoint, nonce, and honeypot are present."); else fail("Merch form security fields are incomplete.");

  const contact = pages.get("/contact/") || "";
  if (contact.includes(CONTACT_EMAIL) && contact.includes(`mailto:${CONTACT_EMAIL}`)) pass("Contact destination is correct."); else fail("Contact destination is incorrect.");

  const resources = pages.get("/tools-resources/") || "";
  const amazonAnchors = allAnchors.filter(({ route, href }) => route === "/tools-resources/" && /(?:amazon\.com|amzn\.to|a\.co)/i.test(href));
  if (!resources.includes("As an Amazon Associate I earn from qualifying purchases")) fail("Affiliate disclosure is missing from Tools & Resources.");
  for (const anchor of amazonAnchors) {
    const rel = anchor.rel.toLowerCase().split(/\s+/);
    for (const token of ["sponsored", "noopener", "noreferrer"]) if (!rel.includes(token)) fail(`Amazon link ${anchor.label} lacks rel=${token}.`);
    if (anchor.target !== "_blank") fail(`Amazon link ${anchor.label} must open in a new tab.`);
  }

  const versionMeta = tags(home, "meta").find((tag) => attr(tag, "name") === "holt-theme-version");
  const liveVersion = versionMeta ? attr(versionMeta, "content") : "";
  liveVersion === expectedVersion ? pass(`Live version ${liveVersion} matches repository.`) : fail(`Live version ${liveVersion || "missing"} does not match ${expectedVersion}.`);
  if ([...pages.values()].some((html) => html.includes("https://a.co/d/0aEp6yu6"))) fail("Known broken Amazon short URL is rendered.");

  for (const path of ["/sitemap.xml", "/robots.txt"]) {
    const result = await checkUrl(`${SITE_URL}${path}`);
    result.ok ? pass(`${path} is available (${result.status}).`) : fail(`${path} is unavailable (${result.status}).`);
  }

  const unique = new Map();
  for (const anchor of allAnchors) {
    if (/^(#|mailto:|tel:)/i.test(anchor.href)) continue;
    try { const url = new URL(anchor.href, `${SITE_URL}${anchor.route}`).toString(); if (!unique.has(url)) unique.set(url, `${anchor.route}: ${anchor.label}`); }
    catch { fail(`Invalid URL on ${anchor.route}: ${anchor.href}`); }
  }
  for (const [url, label] of unique) {
    const result = await checkUrl(url);
    if (result.ok) continue;
    const host = new URL(url).hostname.replace(/^www\./, "");
    const protectedHost = ["payhip.com", "facebook.com", "instagram.com", "tiktok.com", "youtube.com", "amazon.com", "amzn.to", "linktr.ee"].some((allowed) => host === allowed || host.endsWith(`.${allowed}`));
    if (protectedHost && [401, 403, 405, 429, "timeout/error"].includes(result.status)) {
      if (!warnedHosts.has(host)) { warnedHosts.add(host); warn(`${host} automated checks are inconclusive (${result.status}); rendered URLs were validated.`); }
    } else if ([404, 410].includes(result.status) || new URL(url).origin === SITE_URL) fail(`Broken link from ${label}: ${url} (${result.status}).`);
    else warn(`External link from ${label} could not be confirmed: ${url} (${result.status}).`);
  }

  for (const message of passes) console.log(`PASS: ${message}`);
  for (const message of warnings) console.log(`WARN: ${message}`);
  for (const message of failures) console.log(`FAIL: ${message}`);
  console.log(`SUMMARY: ${passes.length} PASS, ${warnings.length} WARN, ${failures.length} FAIL`);
  if (failures.length) process.exit(1);
}

await main().catch((error) => { console.error(`FAIL: Audit crashed: ${error.stack || error}`); process.exit(1); });
