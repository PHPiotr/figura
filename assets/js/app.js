import $ from 'jquery'
import 'bootstrap'
import 'bootstrap/dist/css/bootstrap.css'

import AOS from 'aos';
import 'aos/dist/aos.css';
import 'open-iconic/font/css/open-iconic-bootstrap.css';
import 'animate.css/animate.css';
import 'ionicons';
import '@fortawesome/fontawesome-free/js/all';

import 'owl.carousel/dist/assets/owl.carousel.css';
import 'owl.carousel';

import '../css/style.css';

AOS.init({
    duration: 800,
    easing: 'slide',
});

const loader = function() {
    setTimeout(function() {
        if($('#ftco-loader').length > 0) {
            $('#ftco-loader').removeClass('show');
        }
    }, 1);
};
loader();

const carousel = function() {
    $('.home-slider').owlCarousel({
        loop:true,
        autoplay: true,
        margin:0,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        nav:false,
        autoplayHoverPause: false,
        items: 1,
        navText : ["<span class='ion-md-arrow-back'></span>","<span class='ion-chevron-right'></span>"],
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:1
            }
        }
    });

};
carousel();
