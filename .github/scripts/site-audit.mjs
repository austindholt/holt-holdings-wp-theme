const SITE_URL = "https://holtholdings.us";
const EXPECTED_HOMEPAGE_CANONICAL = "https://holtholdings.us/";
const CONTACT_EMAIL = "holtholdings@outlook.com";
const OLD_CONTACT_EMAIL = "hello@holtholdings.us";
const AFFILIATE_DISCLOSURE = "As an Amazon Associate I earn from qualifying purchases";
const FOOTER_DISCLAIMER = "Holt Holdings LLC is a portfolio and project hub";
const DEPLOYMENT_MARKER = "Holt Holdings theme version";

const REQUIRED_LINKS = [
  "https://www.amazon.com/shop/austindholt",
  "https://amzn.to/4u1aeBb",
  "https://amzn.to/4twRitV",
  "https://amzn.to/4wY2e6H",
  "https://payhip.com/LowVoltHolt",
  "https://payhip.com/b/6gMCy",
  "https://payhip.com/b/3GVP5",
  "https://payhip.com/b/AYP01",
  "https://payhip.com/b/NK4IS",
  "https://payhip.com/b/mGHjT",
  "https://payhip.com/b/9iMt1",
  "https://payhip.com/b/T9YW2",
  "https://payhip.com/b/sa17H",
  "https://payhip.com/b/nV37U",
  "https://payhip.com/b/6CjV7",
  "https://payhip.com/b/kROjv",
  "https://payhip.com/b/xEdtR",
  "https://handsonidaho.com/",
  "https://www.instagram.com/handsonidaho/",
  "https://www.facebook.com/share/1GvksuadZf/?mibextid=wwXIfr",
  "https://g.page/r/CWVQEsDBWd1GEBM/review",
  "https://dirtydumpshaulingco.com/",
  "https://www.instagram.com/dirtydumpshaulingco/",
  "https://bitreadyindex.com/",
  "https://github.com/austindholt/bitready",
  "https://linktr.ee/austindholt",
  "https://www.instagram.com/austindholt/",
  "https://youtube.com/@austindholt",
  "https://www.tiktok.com/@austindholt",
  "https://www.facebook.com/share/1HF3jGFF8L/?mibextid=wwXIfr"
];

const THIRD_PARTY_WARNING_HOSTS = [
  "payhip.com",
  "amazon.com",
  "a.co",
  "amzn.to",
  "facebook.com",
  "instagram.com",
  "tiktok.com",
  "youtube.com",
  "youtu.be",
  "linktr.ee"
];

const AMAZON_LINKS = [
  "https://www.amazon.com/shop/austindholt",
  "https://amzn.to/4u1aeBb",
  "https://amzn.to/4twRitV",
  "https://amzn.to/4wY2e6H"
];

const failures = [];
const warnings = [];
const passed = [];
const seenWarnings = new Set();

function normalizeHtml(value) {
  return value.replaceAll("&amp;", "&");
}

function reportPass(message) {
  passed.push(message);
}

function reportFailure(message) {
  failures.push(message);
}

function reportWarning(message) {
  if (!seenWarnings.has(message)) {
    seenWarnings.add(message);
    warnings.push(message);
  }
}

async function fetchWithTimeout(url, options = {}) {
  const controller = new AbortController();
  const { timeoutMs = 15000, ...fetchOptions } = options;
  const timeout = setTimeout(() => controller.abort(), timeoutMs);

  try {
    return await fetch(url, {
      redirect: "follow",
      headers: {
        "user-agent": "Holt Holdings weekly site audit"
      },
      ...fetchOptions,
      signal: controller.signal
    });
  } finally {
    clearTimeout(timeout);
  }
}

async function checkUrl(url) {
  try {
    let response = await fetchWithTimeout(url, { method: "HEAD", timeoutMs: 12000 });

    if ([403, 405, 429].includes(response.status)) {
      response = await fetchWithTimeout(url, { method: "GET", timeoutMs: 12000 });
    }

    return { ok: response.status >= 200 && response.status < 400, status: response.status };
  } catch (error) {
    return { ok: false, status: "timeout/error", error: error.message };
  }
}

function getAttribute(tag, name) {
  const pattern = new RegExp(`${name}\\s*=\\s*["']([^"']*)["']`, "i");
  return tag.match(pattern)?.[1] || "";
}

function extractAnchors(html) {
  const anchors = [];
  const pattern = /<a\b[^>]*>/gi;
  let match;

  while ((match = pattern.exec(html))) {
    const tag = match[0];
    const href = getAttribute(tag, "href");

    anchors.push({
      tag,
      href: normalizeHtml(href),
      rel: getAttribute(tag, "rel"),
      target: getAttribute(tag, "target")
    });
  }

  return anchors;
}

function extractCanonicalHrefs(html) {
  const linkTags = html.match(/<link\b[^>]*>/gi) || [];

  return linkTags
    .filter((tag) => getAttribute(tag, "rel").toLowerCase().split(/\s+/).includes("canonical"))
    .map((tag) => normalizeHtml(getAttribute(tag, "href")))
    .filter(Boolean);
}

function shouldSkipLink(href) {
  return (
    href.startsWith("#") ||
    href.startsWith("mailto:") ||
    href.startsWith("tel:")
  );
}

function resolveLink(href) {
  try {
    return new URL(href, SITE_URL).toString();
  } catch {
    return null;
  }
}

function isSoftThirdPartyFailure(url, status) {
  const host = new URL(url).hostname.replace(/^www\./, "");

  return THIRD_PARTY_WARNING_HOSTS.some((allowedHost) => host === allowedHost || host.endsWith(`.${allowedHost}`))
    && ([403, 405, 429, "timeout/error"].includes(status));
}

function textIncludesLink(html, link) {
  return html.includes(link) || html.includes(link.replace(/\/$/, ""));
}

function checkInternalAnchors(anchors, html) {
  const ids = new Set(Array.from(html.matchAll(/\sid=["']([^"']+)["']/gi)).map((match) => match[1]));

  for (const anchor of anchors) {
    if (!anchor.href.startsWith("#") || anchor.href === "#") {
      continue;
    }

    const destination = decodeURIComponent(anchor.href.slice(1));
    if (!ids.has(destination)) {
      reportFailure(`Internal anchor destination missing: ${anchor.href}`);
    }
  }
}

async function main() {
  console.log("Holt Holdings weekly site audit");
  console.log(`Target: ${SITE_URL}`);

  const homepageResponse = await fetchWithTimeout(SITE_URL, { method: "GET", timeoutMs: 20000 });

  if (homepageResponse.status !== 200) {
    reportFailure(`Homepage returned HTTP ${homepageResponse.status}, expected 200.`);
  } else {
    reportPass("Homepage returned HTTP 200.");
  }

  const rawHtml = await homepageResponse.text();
  const html = normalizeHtml(rawHtml);
  const anchors = extractAnchors(rawHtml);

  if (/Holt Holdings/i.test(html)) {
    reportPass("Holt Holdings content exists.");
  } else {
    reportFailure("Holt Holdings content is missing.");
  }

  if (html.includes(CONTACT_EMAIL) && html.includes(`mailto:${CONTACT_EMAIL}`)) {
    reportPass("Correct Holt Holdings contact email and mailto are present.");
  } else {
    reportFailure(`Missing ${CONTACT_EMAIL} or mailto:${CONTACT_EMAIL}.`);
  }

  if (html.includes(OLD_CONTACT_EMAIL)) {
    reportFailure(`Old contact email is still present: ${OLD_CONTACT_EMAIL}`);
  } else {
    reportPass("Old contact email is not present.");
  }

  for (const link of REQUIRED_LINKS) {
    if (textIncludesLink(html, link)) {
      reportPass(`Required link present: ${link}`);
    } else {
      reportFailure(`Required link missing: ${link}`);
    }
  }

  for (const anchor of anchors) {
    if (anchor.href === "" || anchor.href === "#") {
      reportFailure(`Empty or fake clickable href found: ${anchor.tag}`);
    }
  }

  const clickableSocialPlaceholders = anchors.filter((anchor) =>
    /social-card/i.test(anchor.tag) && (anchor.href === "" || anchor.href === "#")
  );
  if (clickableSocialPlaceholders.length > 0) {
    reportFailure("Empty clickable social links are present.");
  } else {
    reportPass("No empty clickable social links found.");
  }

  for (const link of AMAZON_LINKS) {
    const matchingAnchors = anchors.filter((anchor) => anchor.href === link || anchor.href === link.replace(/\/$/, ""));

    if (matchingAnchors.length === 0) {
      reportFailure(`Amazon affiliate link missing from anchors: ${link}`);
      continue;
    }

    for (const anchor of matchingAnchors) {
      const relTokens = anchor.rel.toLowerCase().split(/\s+/).filter(Boolean);

      for (const token of ["sponsored", "noopener", "noreferrer"]) {
        if (!relTokens.includes(token)) {
          reportFailure(`Amazon link ${link} is missing rel token: ${token}`);
        }
      }

      if (anchor.target !== "_blank") {
        reportFailure(`Amazon link ${link} does not open in a new tab.`);
      }
    }
  }

  if (html.includes(AFFILIATE_DISCLOSURE)) {
    reportPass("Affiliate disclosure is visible in homepage HTML.");
  } else {
    reportFailure("Affiliate disclosure is missing from homepage HTML.");
  }

  if (html.includes(FOOTER_DISCLAIMER)) {
    reportPass("Footer portfolio disclaimer is visible.");
  } else {
    reportFailure("Footer portfolio disclaimer is missing.");
  }

  if (html.includes(DEPLOYMENT_MARKER)) {
    reportPass("Deployment/version marker exists.");
  } else {
    reportFailure("Deployment/version marker is missing.");
  }

  if (/<title>[^<]+<\/title>/i.test(rawHtml)) {
    reportPass("Title tag exists.");
  } else {
    reportFailure("Title tag is missing.");
  }

  if (/<meta\s+name=["']description["']\s+content=["'][^"']+["']/i.test(rawHtml)) {
    reportPass("Meta description exists.");
  } else {
    reportFailure("Meta description is missing.");
  }

  for (const property of ["og:title", "og:description", "og:url", "og:image"]) {
    if (new RegExp(`<meta\\s+property=["']${property}["']\\s+content=["'][^"']+["']`, "i").test(rawHtml)) {
      reportPass(`${property} exists.`);
    } else {
      reportFailure(`${property} is missing.`);
    }
  }

  const canonicalHrefs = extractCanonicalHrefs(rawHtml);
  if (canonicalHrefs.length === 0) {
    reportFailure("Canonical URL is missing.");
  } else if (canonicalHrefs.length > 1) {
    reportFailure(`Expected one canonical URL, found ${canonicalHrefs.length}.`);
  } else if (canonicalHrefs[0] !== EXPECTED_HOMEPAGE_CANONICAL) {
    reportFailure(`Homepage canonical should be ${EXPECTED_HOMEPAGE_CANONICAL}; found ${canonicalHrefs[0]}.`);
  } else {
    reportPass(`Homepage canonical URL is correct: ${canonicalHrefs[0]}`);
  }

  const h1Count = (rawHtml.match(/<h1\b/gi) || []).length;
  if (h1Count === 1) {
    reportPass("Exactly one H1 exists.");
  } else {
    reportFailure(`Expected exactly one H1, found ${h1Count}.`);
  }

  const imageTags = rawHtml.match(/<img\b[^>]*>/gi) || [];
  const imagesWithoutAlt = imageTags.filter((tag) => !/\salt\s*=\s*["'][^"']*["']/i.test(tag));

  if (imagesWithoutAlt.length > 0) {
    reportWarning(`${imagesWithoutAlt.length} image(s) may be missing alt text.`);
  } else {
    reportPass("No missing image alt text found in homepage HTML.");
  }

  if (/Fatal error|Warning:|Notice:|Parse error/i.test(html)) {
    reportFailure("Visible WordPress/PHP error text found.");
  } else {
    reportPass("No visible WordPress/PHP error text found.");
  }

  checkInternalAnchors(anchors, rawHtml);

  const sitemapCheck = await checkUrl(`${SITE_URL}/sitemap.xml`);
  if (sitemapCheck.ok) {
    reportPass(`Sitemap is available: HTTP ${sitemapCheck.status}.`);
  } else {
    reportFailure(`Sitemap unavailable: HTTP ${sitemapCheck.status}.`);
  }

  const robotsCheck = await checkUrl(`${SITE_URL}/robots.txt`);
  if (robotsCheck.ok) {
    reportPass(`robots.txt is available: HTTP ${robotsCheck.status}.`);
  } else {
    reportFailure(`robots.txt unavailable: HTTP ${robotsCheck.status}.`);
  }

  const uniqueLinks = Array.from(new Set(anchors.map((anchor) => anchor.href)))
    .filter((href) => href && !shouldSkipLink(href))
    .map((href) => resolveLink(href))
    .filter(Boolean);

  for (const link of uniqueLinks) {
    const url = new URL(link);
    const result = await checkUrl(link);

    if (result.ok) {
      continue;
    }

    if (url.origin === SITE_URL || !isSoftThirdPartyFailure(link, result.status)) {
      reportFailure(`Broken link: ${link} (${result.status})`);
    } else {
      reportWarning(`External link check warning: ${link} (${result.status})`);
    }
  }

  console.log("");
  console.log("Passed checks:");
  for (const message of passed) {
    console.log(`PASS: ${message}`);
  }

  if (warnings.length > 0) {
    console.log("");
    console.log("Warnings:");
    for (const message of warnings) {
      console.log(`WARN: ${message}`);
    }
  }

  if (failures.length > 0) {
    console.log("");
    console.log("Critical failures:");
    for (const message of failures) {
      console.log(`FAIL: ${message}`);
    }
    process.exit(1);
  }

  console.log("");
  console.log("Audit completed without critical failures.");
}

await main().catch((error) => {
  console.error("Audit crashed:");
  console.error(error);
  process.exit(1);
});
