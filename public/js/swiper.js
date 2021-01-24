import Swiper from 'https://unpkg.com/swiper/swiper-bundle.esm.browser.min.js'

        var elem = document.querySelector('.swip');
if (elem.clientWidth > 768) {
    var mySwiper = new Swiper('.swiper-container', {

        // If we need pagination
        slidesPerView: 4,
        spaceBetween: 15,
        slidesPerGroup: 2,
        lazy: true,
        pagination: {
            el: '.swiper-pagination',
        },

        // Navigation arrows
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },

    })
} else if (elem.clientWidth > 480 && elem.clientWidth <= 768) {
    var mySwiper = new Swiper('.swiper-container', {

        // If we need pagination
        slidesPerView: 3,
        spaceBetween: 15,
        slidesPerGroup: 2,
        lazy: true,
        pagination: {
            el: '.swiper-pagination',
        },

        // Navigation arrows
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },

    })

} else {
    var mySwiper = new Swiper('.swiper-container', {

        // If we need pagination
        slidesPerView: 2,
        spaceBetween: 15,
        slidesPerGroup: 2,
        lazy: true,
        pagination: {
            el: '.swiper-pagination',
        },

        // Navigation arrows
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },

    })
}
    