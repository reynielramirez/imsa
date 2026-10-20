(function ($, Drupal){
    
    $(document).ready(function() { 
         
        var products_slider = $('#products-slider');
        var services_slider = $('#services-slider');
         
        products_slider.owlCarousel({
            autoplay: true,
            loop: true,
            autoplaySpeed: 300,
            navigation: false,
            singleItem: false,
            margin: 10,
            dots: false,
            mouseDrag: true,
            responsiveClass: true,
            transitionStyle: "fade",
            responsive: {
                0: {items:1},
                768: {items:2},
                1050: {items:3},
            }
        });	

        services_slider.owlCarousel({
            autoplay: true,
            loop: true,
            autoplaySpeed: 300,
            navigation: false,
            singleItem: false,
            margin: 10,
            dots: false,
            mouseDrag: true,
            responsiveClass: true,
            transitionStyle: "fade",
            responsive: {
                0: {items:1},
                768: {items:2},
                1050: {items:3},
            }
        });	
  
    });
     
})(jQuery, Drupal);