

document.addEventListener("DOMContentLoaded", () => {
  // Hamburger menu toggle (mobile)
  const hamburger = document.getElementById("hamburger");
  const smallNavWrapper = document.querySelector(".small-nav-wraper");

  if (hamburger && smallNavWrapper) {
    hamburger.addEventListener("click", () => {
      hamburger.classList.toggle("active");
      smallNavWrapper.classList.toggle("active");

      // Disable body scroll when menu is active
      document.body.style.overflow = smallNavWrapper.classList.contains("active") ? "hidden" : "auto";
    });
  }


  // Submenu toggle: only icon/button toggles; link goes to page; hover shows submenu (desktop)
  const menuItems = document.querySelectorAll(".menu-item-has-children");

  menuItems.forEach((item) => {
    const link = item.querySelector("a");
    const submenu = item.querySelector(".sub-menu");
    const toggleBtn = item.querySelector(".nav-submenu-toggle");
    const toggleIcon = toggleBtn ? toggleBtn.querySelector("svg") : null;

    // Link click → navigate to page (no preventDefault)
    // Icon/toggle button click → open/close submenu
    if (toggleBtn && submenu) {
      toggleBtn.addEventListener("click", (e) => {
        e.preventDefault();
        e.stopPropagation();

        const isActive = item.classList.contains("active");

        // Close all other menus
        menuItems.forEach((other) => {
          if (other !== item) {
            other.classList.remove("active");
            const otherSub = other.querySelector(".sub-menu");
            const otherBtn = other.querySelector(".nav-submenu-toggle");
            if (otherSub) otherSub.style.maxHeight = null;
            if (otherBtn) {
              otherBtn.setAttribute("aria-expanded", "false");
              const oIcon = otherBtn.querySelector("svg");
              if (oIcon) {
                oIcon.style.transform = "rotate(0deg)";
                oIcon.style.stroke = "";
              }
            }
          }
        });

        if (!isActive) {
          item.classList.remove("submenu-just-closed"); // so submenu can show again
          item.classList.add("active");
          submenu.style.maxHeight = submenu.scrollHeight + "px";
          toggleBtn.setAttribute("aria-expanded", "true");
          if (toggleIcon) {
            toggleIcon.style.transform = "rotate(180deg)";
            toggleIcon.style.stroke = "#FF6600";
          }
        } else {
          item.classList.remove("active");
          submenu.style.maxHeight = null;
          toggleBtn.setAttribute("aria-expanded", "false");
          if (toggleIcon) {
            toggleIcon.style.transform = "rotate(0deg)";
            toggleIcon.style.stroke = "";
          }
          // Desktop: prevent hover from reopening submenu until mouse leaves
          item.classList.add("submenu-just-closed");
        }
      });

      // Remove "just closed" state when mouse leaves so hover can open again
      item.addEventListener("mouseleave", () => {
        item.classList.remove("submenu-just-closed");
      });
    }
  });
  // Scroll hide/show navbar (Disabled to keep header permanently fixed)
  /*
  let lastScrollTop = 0;
  const navbar = document.querySelector(".navbar");
  if (navbar) {
    window.addEventListener("scroll", () => {
      let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
      
      // If at top of the page, show navbar
      if (scrollTop <= 50) {
        navbar.classList.remove("scroll-down");
        navbar.classList.remove("scroll-up");
        lastScrollTop = scrollTop;
        return;
      }
      
      if (scrollTop > lastScrollTop) {
        // Scrolling down - hide navbar
        navbar.classList.add("scroll-down");
        navbar.classList.remove("scroll-up");
      } else {
        // Scrolling up - show navbar
        navbar.classList.add("scroll-up");
        navbar.classList.remove("scroll-down");
      }
      lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
    }, { passive: true });
  }
  */
});



