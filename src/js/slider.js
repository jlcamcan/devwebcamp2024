import Swiper from 'swiper';
import { Navigation, Pagination } from 'swiper/modules';

import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';



document.addEventListener('DOMContentLoaded', function() {
    if (document.querySelector('.slider')) {
        const opciones = {
                modules: [Navigation, Pagination],

                slidesPerView: 1,
                spaceBetween: 15,
                freeMode: true,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    768: {
                        slidesPerView: 2
                    },
                    1024: {
                        slidesPerView: 3
                    },
                    1200: {
                        slidesPerView: 4
                    }
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                    renderBullet: function(index, className) {
                        return '<span class="' + className + '">' + (index + 1) + "</span>";
                    },
                },
            }
            //  Swiper.use([Navigation])
        new Swiper('.slider', opciones)
    }
});