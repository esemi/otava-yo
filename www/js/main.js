/**
 * Main js file
 */

jQuery(document).ready(function(){

	//guest book add form slider
	jQuery(".js-guestbook-add-button").click(function(){
		jQuery(".js-guestbook-add-form").removeClass('hide');
		jQuery(".js-guestbook-add-button").remove();
	});


});
