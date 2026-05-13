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
})();
