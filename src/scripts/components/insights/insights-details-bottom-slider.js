document.addEventListener("DOMContentLoaded", function () {
  const swiperEl = document.querySelector(
    ".insights-details-bottom-slider .swiper",
  );
  if (!swiperEl) return;

  // const totalSlides = swiperEl.querySelectorAll('.swiper-slide');

  const insightsSwiper = new Swiper(swiperEl, {
    slidesPerView: 1,
    spaceBetween: 30,
    loop: true,
    autoplay: {
      delay: 2500,
      disableOnInteraction: false,
    },
    breakpoints: {
      320: { slidesPerView: 1, spaceBetween: 10 },
      640: { slidesPerView: 2, spaceBetween: 10 },
      1024: { slidesPerView: 3, spaceBetween: 20 },
      1400: { slidesPerView: 4, spaceBetween: 20 },
    },
    navigation: {
      nextEl: ".insights-slider-buttons .swiper-button-next",
      prevEl: ".insights-slider-buttons .swiper-button-prev",
    },
    pagination: {
      el: ".insights-details-bottom-slider .swiper-pagination",
      clickable: true,
    },
    grabCursor: true,
    observer: true,
    observeParents: true,
  });
});
