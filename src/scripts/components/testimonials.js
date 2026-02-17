

document.addEventListener('DOMContentLoaded', function () {
  const testimonialSlider = new Swiper(".testimonials-swiper", {
    slidesPerView: 3,
    slidesPerGroup: 1,
    spaceBetween: 30,
    loop: true,
    loopFillGroupWithBlank: true,
    autoplay: {
      delay: 2500,
      disableOnInteraction: false,
    },
    breakpoints: {
      320: {
        slidesPerView: 1,
        spaceBetween: 10,
      },
      640: {   // tablet
        slidesPerView: 2,
        spaceBetween: 20,
      },
      1100: {  // desktop
        slidesPerView: 3,
        spaceBetween: 30,
      },
      1400: {  // desktop
        slidesPerView: 3,
        spaceBetween: 30,
      }
    },
    pagination: {
      el: ".testimonials-slider .swiper-pagination",
      clickable: true,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  });
});



