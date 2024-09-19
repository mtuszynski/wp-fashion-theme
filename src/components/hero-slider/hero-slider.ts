const $ = require('jquery');
import Swiper from 'swiper/bundle';

/* functions */
function heroslider() {

    const swiper = new Swiper('.hero-slider__start', {
        loop: true,
        autoplay: {
            delay: 10000,
            disableOnInteraction: false,
          },
          
        pagination: {
            el: ".swiper-pagination",
            dynamicBullets: true,
            clickable: true,
          },
    });
    $(".wpcf7 .form-control").focus(function(){
        $(this).parent().parent().addClass('active');
    }).blur(function(){
        var cval = $(this).val()
        if(cval.length < 1) {$(this).parent().parent().removeClass('active');}
    })
}

export default heroslider;