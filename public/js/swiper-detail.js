    import Swiper from 'https://unpkg.com/swiper/swiper-bundle.esm.browser.min.js'

    var swiper = new Swiper('.swiper-container', {
      slidesPerView: 1,
      spaceBetween:40,
      lazy: true,
       autoplay: {
        delay: 4000,
        disableOnInteraction: true,
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
    });