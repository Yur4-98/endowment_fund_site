(function () {
  var toggle = document.querySelector(".nav-toggle");
  var nav = document.querySelector(".site-nav");
  if (toggle && nav) {
    toggle.addEventListener("click", function () {
      var open = nav.classList.toggle("is-open");
      toggle.setAttribute("aria-expanded", open ? "true" : "false");
    });
  }

  var rotator = document.querySelector("[data-hero-rotator]");
  var lines = window.efmsunTheme && efmsunTheme.heroLines ? efmsunTheme.heroLines : [];
  if (rotator && lines.length > 1) {
    var index = 0;
    setInterval(function () {
      index = (index + 1) % lines.length;
      rotator.classList.add("is-swap");
      window.setTimeout(function () {
        rotator.textContent = lines[index];
        rotator.classList.remove("is-swap");
      }, 280);
    }, 5200);
  }

  var grid = document.querySelector("[data-amounts]");
  var input = document.querySelector("[data-amount-input]");
  if (grid && input) {
    grid.addEventListener("click", function (event) {
      var button = event.target.closest("[data-amount]");
      if (!button) {
        return;
      }
      grid.querySelectorAll(".amount-btn").forEach(function (item) {
        item.classList.remove("is-active");
      });
      button.classList.add("is-active");
      input.value = button.getAttribute("data-amount");
    });
  }

  if (!window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
    var targets = document.querySelectorAll(
      ".hero-copy, .hero-aside, .section-head, .card, .news-lead, .news-mini, .report-row, .donate-form, .donate-layout > aside, .contact-grid > .card, .page-hero .container"
    );
    targets.forEach(function (el) {
      el.classList.add("reveal");
    });
    document.querySelectorAll(".card-grid, .news-layout, .news-side, .contact-grid, .donate-layout, .report-list").forEach(function (group) {
      Array.prototype.forEach.call(group.querySelectorAll(":scope > .reveal"), function (el, i) {
        el.style.transitionDelay = i * 90 + "ms";
      });
    });
    if (targets.length) {
      var markVisible = function (el) {
        if (el.getBoundingClientRect().top < window.innerHeight - 24) {
          el.classList.add("is-in");
        }
      };
      var observer = new IntersectionObserver(
        function (entries) {
          entries.forEach(function (entry) {
            if (!entry.isIntersecting) {
              return;
            }
            entry.target.classList.add("is-in");
            observer.unobserve(entry.target);
          });
        },
        { threshold: 0.08, rootMargin: "0px 0px -40px 0px" }
      );
      targets.forEach(function (el) {
        observer.observe(el);
        markVisible(el);
      });
      window.addEventListener(
        "scroll",
        function () {
          targets.forEach(markVisible);
        },
        { passive: true }
      );
    }
  }
})();
