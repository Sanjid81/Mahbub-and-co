document.addEventListener('DOMContentLoaded', function () {
    const swiperEl = document.querySelector('.insights-slider .swiper');
    if (!swiperEl) return;

    // const totalSlides = swiperEl.querySelectorAll('.swiper-slide');

    const insightsSwiper = new Swiper(swiperEl, {
        slidesPerView: 3,
        spaceBetween: 30,
        loop: true,                      
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        breakpoints: {
            320: { slidesPerView: 1, spaceBetween: 10 },
            640: { slidesPerView: 2, spaceBetween: 10 },
            1024: { slidesPerView: 2, spaceBetween: 30 },
            1400: { slidesPerView: 2.5, spaceBetween: 40 },
        },
        navigation: {
            nextEl: '.insights-slider-buttons .swiper-button-next',
            prevEl: '.insights-slider-buttons .swiper-button-prev',
        },
        pagination: {
            el: '.insights-slider .swiper-pagination',
            clickable: true,
        },
        grabCursor: true,
        observer: true,
        observeParents: true,
    });
});