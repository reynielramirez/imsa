/*! Nire Accordion (Library) - v2.1.0 - 14/12/2023
 * Author: Erin Jesús Pupo Silva
 * Copyright (c) 2023 */
 
$(document).on('click',function(event){
	
	if(false){
		$(this).find('.nire-accordion-item').removeClass('active');
		$(this).find('.nire-accordion-content').slideUp();
	}
});

$('.nire-accordion').on('click','.nire-accordion-item',function(){
	
	var selected_item = $(this);
	
	if(selected_item.hasClass('active')){
		selected_item.removeClass('active');
	}else {
		selected_item.addClass('active');
	}
	
	selected_item.find('.nire-accordion-content').slideToggle();
	
	var unselected_items = selected_item.siblings();
	unselected_items.removeClass('active');
	unselected_items.find('.nire-accordion-content').slideUp();
	
});