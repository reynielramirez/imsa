jQuery(document).ready(function ($) {
	
	var name = $('#edit-field-feedback-name-0-value');
	name.removeAttr('required');
	name.removeAttr('aria-required');
	
	var email = $('#edit-field-feedback-email-0-value');
	email.removeAttr('required');
	email.removeAttr('aria-required');
	
	var message = $('#edit-message-0-value');
	message.removeAttr('required');
	message.removeAttr('aria-required');
	
});	