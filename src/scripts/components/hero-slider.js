
document.addEventListener('DOMContentLoaded', function () {
  const swiper = new Swiper('.hero-swiper', {
    direction: 'horizontal',
    loop: true,

    autoplay: {
      delay: 3000,
    },

    pagination: {
      el: '.swiper-pagination',
      clickable: true
    },
  });
});

