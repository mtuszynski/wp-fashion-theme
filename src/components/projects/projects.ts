const $ = require('jquery');
import Swiper from 'swiper/bundle';


/* functions */
function projectslider() {

    const swiper = new Swiper('.projects__slider', {

        slidesPerView: 1,
        spaceBetween: 40,
        loop: true,
        autoHeight: true,

        // Navigation arrows
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },

    });
}

export default projectslider;