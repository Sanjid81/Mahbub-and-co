document.addEventListener('DOMContentLoaded', function () {
  const autoSwiper = new Swiper('.company-swiper', {
    loop: true,
    spaceBetween: 20,
    slidesPerView: 'auto',
    allowTouchMove: true,
    grabCursor: true,
    simulateTouch: true,
    speed: 10000,
    autoplay: {
      delay: 0,
      disableOnInteraction: false,
      reverseDirection: true,
    },
    freeMode: true,
    freeModeMomentum: false,

    breakpoints: {

      0: {
        spaceBetween: 10,
      },
      768: {
        spaceBetween: 10,
      },
      1024: {
        spaceBetween: 20,
      },
    },
  });

  autoSwiper.slides.forEach(slide => {
    slide.addEventListener('click', () => {
      autoSwiper.slideNext();
    });
  });

  autoSwiper.on('slidesLengthChange', () => {
    autoSwiper.slides.forEach(slide => {
      slide.addEventListener('click', () => {
        autoSwiper.slideNext();
      });
    });
  });


});






document.addEventListener('DOMContentLoaded', function () {
  // -------- Desktop Swiper --------
  const autoSwiper_two = new Swiper('.company-swiper-two', {
    loop: true,
    spaceBetween: 20,
    slidesPerView: 'auto',
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
        spaceBetween: 10,
      },
      768: {
        spaceBetween: 10,
      },
      1024: {
        spaceBetween: 20,
      },
    },
  });

  // Slide click listener (desktop)
  autoSwiper_two.slides.forEach(slide => {
    slide.addEventListener('click', () => {
      autoSwiper_two.slideNext();
    });
  });

  autoSwiper_two.on('slidesLengthChange', () => {
    autoSwiper_two.slides.forEach(slide => {
      slide.addEventListener('click', () => {
        autoSwiper_two.slideNext();
      });
    });
  });


});







