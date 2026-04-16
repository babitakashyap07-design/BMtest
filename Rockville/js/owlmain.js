$(document).ready(function(){

$('.owl-general .owl-carousel').owlCarousel({

    loop: true,
	dots:true,
	autoplay:true,
    margin: 10,
    nav: true,
	 autoWidth:true,
	 items: 2,
    navText: [
        '<img src="./img/slider-arrow.svg">',
        '<img src="./img/slider-arrow.svg">'
    ],
    navContainer: '.owl-general .custom-nav',
    /*responsive:{
        0:{
            items: 1
        },
        600:{
            items: 1
        },
        1000:{
            items: 1,
			    stagePadding: 200
        }
    }*/
});

$('.slider_area  .owl-carousel').owlCarousel({

    loop: true,
	dots:true,
	autoplay:false,
    margin: 10,
    nav: false,
	items: 3,
    navText: [
        '<img src="/img/arrow-back-red.svg">',
        '<img src="/img/arrow-back-red.svg">'
    ],
    navContainer: '.LatestNews    .nav-custom',
  responsive:{
        0:{
            items: 1
        },
        600:{
            items: 2
        },
        1000:{
            items: 3,
			 
        }
    }
});
	
	
	$('.logo_slider  .owl-carousel').owlCarousel({

    loop: true,
	dots:true,
	autoplay:false,
    margin: 10,
    nav: false,
	items: 3,
    navText: [
        '<img src="/img/arrow-back-red.svg">',
        '<img src="/img/arrow-back-red.svg">'
    ],
    navContainer: '.LatestNews    .nav-custom',
  responsive:{
        0:{
            items: 2
        },
        600:{
            items: 2
        },
        1000:{
            items: 5,
			 
        }
    }
});
	
/*************************Event Time carousel***************************/
$('.ev-time-carousel').owlCarousel({
    dots:false,
    loop:true,
    margin:0,
    nav:true,
    autoplay:true,
    navText: [
        '<img src="./img/arrow_right.svg">',
        '<img src="./img/arrow_right.svg">'
    ],
    responsive:{
        0:{
            items:1
        },
        768:{
            items:2
        }
    }
});	

});
