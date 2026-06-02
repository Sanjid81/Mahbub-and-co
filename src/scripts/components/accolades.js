document.addEventListener("DOMContentLoaded", function () {
  const autoSwiper = new Swiper(".company-swiper", {
    loop: true,
    spaceBetween: 20,
    slidesPerView: "auto",
    allowTouchMove: true,
    grabCursor: true,
    simulateTouch: true,
    speed: 10000,
    autoplay: {
      delay: 1,
      disableOnInteraction: false,
      reverseDirection: true,
    },
    freeMode: true,
    freeModeMomentum: false,

    breakpoints: {
      0: {
        enabled: false, // ← disable on mobile
        spaceBetween: 10,
      },
      801: {
        enabled: false, // ← re-enable on tablet/desktop
        spaceBetween: 10,
      },
      1024: {
        enabled: false,
        spaceBetween: 20,
      },
    },
  });

  autoSwiper.slides.forEach((slide) => {
    slide.addEventListener("click", () => {
      autoSwiper.slideNext();
    });
  });

  autoSwiper.on("slidesLengthChange", () => {
    autoSwiper.slides.forEach((slide) => {
      slide.addEventListener("click", () => {
        autoSwiper.slideNext();
      });
    });
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const autoSwiper_two = new Swiper(".company-swiper-two", {
    loop: true,
    spaceBetween: 20,
    slidesPerView: "auto",
    allowTouchMove: true,
    grabCursor: true,
    simulateTouch: true,
    speed: 10000,
    autoplay: {
      delay: 0,
      disableOnInteraction: false,
      reverseDirection: false,
    },
    freeMode: true,
    freeModeMomentum: false,

    breakpoints: {
      0: {
        enabled: false, // ← disable on mobile
        spaceBetween: 10,
      },
      801: {
        enabled: true, // ← re-enable on tablet/desktop
        spaceBetween: 10,
      },
      1024: {
        enabled: true,
        spaceBetween: 20,
      },
    },
  });

  autoSwiper_two.slides.forEach((slide) => {
    slide.addEventListener("click", () => {
      autoSwiper_two.slideNext();
    });
  });

  autoSwiper_two.on("slidesLengthChange", () => {
    autoSwiper_two.slides.forEach((slide) => {
      slide.addEventListener("click", () => {
        autoSwiper_two.slideNext();
      });
    });
  });
});
