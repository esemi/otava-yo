/**
 * Main js file
 */

jQuery(document).ready(function(){

	//guest book add form slider
	jQuery(".js-guestbook-add-button").click(function(){
		jQuery(".js-guestbook-add-form").removeClass('hide');
		jQuery(".js-guestbook-add-button").remove();
	});


	//jPlayer on index page
	$("#jquery_jplayer_1").jPlayer({
		ready: function(){
			$(this).jPlayer("setMedia", {
				mp3: "/media/d464efc8a6963167a66667e27875ff2c_1377176502.mp3"
			});
		},
		swfPath: "/js/jPlayer.2.4.0/",
		supplied: "mp3"
	});
});