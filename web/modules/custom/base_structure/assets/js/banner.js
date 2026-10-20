(function ($, Drupal){
    
    $(document).ready(function() { 
        
        let slider = $('#banner-slider');

        slider.owlCarousel({
            items: 1,
            autoplay: true,
            autoplaySpeed: 300,
            loop: true,
            margin: 0,
            dots: false,
            nav: true,
            navClass: ["owl-prev","owl-next"],
            navText: ["<span> < </span>","<span> > </span>"],
            responsiveClass: true,
            autoplayHoverPause: false,
            navigation: true,
            singleItem: true,
            transitionStyle: "fade"
        });	
                 
     });
     
 })(jQuery, Drupal);