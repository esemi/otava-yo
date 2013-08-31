/**
 * Main js file
 */

jQuery(document).ready(function(){

	//guest book add form slider
	jQuery(".js-guestbook-add-button").click(function(){
		jQuery(".js-guestbook-add-form").removeClass('hide');
		jQuery(".js-guestbook-add-button").remove();
	});


	//jPlayer on audio page
	(function(){

		function stopAllTracks(){
			jQuery('.js-audio-item-stop').hide();
			jQuery('.js-audio-item-play').show();
		}

		function playTrack(elem){
			var li = jQuery(elem).parents('li:first');
			li.find('.js-audio-item-stop').show();
			li.find('.js-audio-item-play').hide();
		}

		//jPlayer init
		jQuery("#jquery_jplayer_audio").jPlayer({
			ready: function(){
				var player = jQuery(this);

				//play buttons
				jQuery('.js-audio-item-play').click(function(){
					stopAllTracks();
					playTrack(this);
					player.jPlayer("setMedia", { mp3: jQuery(this).parents('li:first').attr('media-link') });
					player.jPlayer("play");
				});

				//stop buttons
				jQuery('.js-audio-item-stop').click(function(){
					stopAllTracks();
					player.jPlayer("clearMedia");
				});
			},

			//@TODO when ended - play next audio

			volume: 1.0,
			swfPath: "/js/jPlayer/",
			supplied: "mp3"
		});
	})();


});