/*! Nire Dialog (Library) - v2.0.0 - 9/04/2022
 * Author: Erin Jesús Pupo Silva
 * Copyright (c) 2022 */

document.addEventListener('DOMContentLoaded',function() {  
	
	var displays = document.querySelectorAll("[nire-dialog]");
	var titles = document.querySelectorAll("[nire-dialog-title]");
	var contents = document.querySelectorAll("[nire-dialog-content]");
	const body = document.querySelector("body");
	
	[].slice.call(displays).forEach( function(display) {
		
		display.onclick = function() {
			 
			let modalTitle, modalContent;
			const modalID = display.getAttribute("nire-dialog");
			
			[].slice.call(titles).forEach( function(title) {
				if (title.getAttribute("nire-dialog-title") == modalID){
					modalTitle = title;
					return;
				}
			});
			
			[].slice.call(contents).forEach( function(content) {
				if (content.getAttribute("nire-dialog-content") == modalID){
					modalContent = content;
					return;
				}
			});
						
			const modal = document.createElement('div');	
			modal.id = 'nire-dialog';
				
			modal.innerHTML = 
			'<div class="nire-dialog-container">' +
				'<div class="nire-dialog-header">' +
					'<button class="nire-dialog-close"></button>' +
					'<div class="nire-dialog-title">' +
						modalTitle.outerHTML +
					'</div> ' +
				'</div>' +
				'<div class="nire-dialog-body">' +
					'<div class="nire-dialog-content">' +
						modalContent.outerHTML +
					'</div>' +
				'</div>' +
			'</div>'; +	 
				
			body.appendChild(modal);
			
			const close = modal.querySelector(".nire-dialog-close");
			close.onclick = function() {
				body.removeChild(modal);
			}
			
		}
		
	});	
	
	
});




