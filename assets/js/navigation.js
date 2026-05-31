(function () {
  var toggle = document.querySelector(".menu-toggle");
  var navigation = document.querySelector(".primary-navigation");

  if (!toggle || !navigation) {
    return;
  }

  toggle.addEventListener("click", function () {
    var isOpen = navigation.classList.toggle("is-open");
    toggle.setAttribute("aria-expanded", isOpen ? "true" : "false");
  });

  navigation.addEventListener("click", function (event) {
    if (event.target.tagName !== "A") {
      return;
    }

    navigation.classList.remove("is-open");
    toggle.setAttribute("aria-expanded", "false");
  });

  document.addEventListener("click", function (event) {
    var link = event.target.closest('a[data-track="outbound-link"]');

    if (!link || typeof window.gtag !== "function") {
      return;
    }

    window.gtag("event", "outbound_click", {
      link_category: link.getAttribute("data-link-category") || "external",
      link_label: link.getAttribute("data-link-label") || link.textContent.trim(),
      link_url: link.getAttribute("data-link-url") || link.href
    });
  });
})();
