
document.addEventListener('DOMContentLoaded', function () {
    const swiper = new Swiper('.about-slider-section .swiper', {
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
  
  