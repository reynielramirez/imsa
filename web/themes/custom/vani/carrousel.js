(function ($, Drupal){
    
	alert('CARROUSEL');
	
	
	
/*	function wait(time){
		return new Promise(function(resolve,reject){
				setTimeout(resolve,time);
		});
	}

	var data = document.querySelectorAll('#carousel-example-generic .data-sources');

	data.forEach( function( item, i ) {

		var src = item.querySelector('local-image').getAttribute('src');
		if(src !== null && src !== '' && src !== '/'){
			item.innerHTML = '<img class="carousel_image img-responsive" src="'+src+'" alt="">';
		}else {

			src = item.querySelector('local-video').getAttribute('src');
			if(src !== null && src !== '' && src !== '/'){
				item.innerHTML = '<video class="carousel_image img-responsive" src="'+src+'" alt="" muted></video>';
			}
		}

	} ); 
		
	var carrusel = $('#carousel-example-generic');
		 
	carrusel.owlCarousel({
		items: 1,
		autoplay: false,
		autoplayHoverPause: false,
		autoplaySpeed: 400,
		navigation: true,
		singleItem: true,
		transitionStyle: "fade"
	});

	carrusel.trigger('stop.owl.autoplay');
	
	var data = $('.owl-carousel').data('owl.carousel');
	data.options.autoplay = true;
	
	var owl = $('.owl-carousel');
	owl.trigger('refresh.owl.carousel');
  
	var video_running = false;
	var current_video = null;
	var force_stop = false;
	var lock = false;
	var last_video = null;
	
	function playItem(e) { 
//            alert('Update');
		if(!lock){

			var stop = current_video !== null;

			if(stop){
//                    alert('Stop Video');
				force_stop = true;
				current_video.get(0).pause();
				current_video.get(0).currentTime = 0;
				current_video = null;
				video_running = false;
				lock = true;
				data.options.autoplay = true;
				owl.trigger('refresh.owl.carousel');
			}

			if(!video_running){
//                    alert('Running');
				var elemento = $('#carousel-example-generic .item');
				var index = e.item.index;
				
				if(index !== null){
					var video = $(elemento[index]).find('video');

					if(video.prop("tagName") === "VIDEO"){
						video_running = true;

//                            alert('Video Detected and Play');

						data.options.autoplay = false;
						lock = true;
						owl.trigger('refresh.owl.carousel');
						video.get(0).play();
						current_video = video;

						video.on('ended', function(){ 
						   if(!force_stop && current_video.get(0).paused){
								last_video = current_video;
								current_video = null;
//                                    alert('Video Ended');
								video_running = false;
								data.options.autoplay = true; 
								lock = true;
								// Next Item
								if(index === (e.item.count - 1)){
									carrusel.trigger("to.owl.carousel", 0); 
								}else {
									owl.trigger('next.owl.carousel',[300]);
								}
								
								owl.trigger('refresh.owl.carousel');
								last_video.get(0).currentTime = 0;
//                                    alert('Refresh finish');
							}else {
							  force_stop = false;
							}
					   }); 
					}
				}    
			}
		}else {
//                alert('LOCK');
			lock = false;
		}
		if(index === (e.item.count - 1) && current_video === null){
			wait(4000).then(function(){
				carrusel.trigger("to.owl.carousel", 0); 
			});      
		}
	}
	
	
	carrusel.on('changed.owl.carousel', playItem);
	carrusel.trigger("to.owl.carousel", 0); 
	owl.trigger('refresh.owl.carousel');		
*/
  
})(jQuery, Drupal);