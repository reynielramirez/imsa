(function ($, Drupal){
    
    $(document).ready(function() { 
        
        let slider = $('#colaboradores-slider');

        slider.owlCarousel({
            items: 2,
            autoplay: true,
            autoplaySpeed: 300,
            loop: true,
            margin: 0,
            dots: false,
            nav: false,
            responsiveClass: true,
            autoplayHoverPause: false,
            navigation: false,
            singleItem: true,
            transitionStyle: "fade"
        });	
                 
     });
     
 })(jQuery, Drupal);