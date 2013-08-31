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

		var currentTrackId;

		function stopAllTracks(){
			jQuery('.js-audio-item-stop').hide();
			jQuery('.js-audio-item-play').show();
		}

		function playTrack(li){
			li.find('.js-audio-item-stop').show();
			li.find('.js-audio-item-play').hide();
		}

		//jPlayer init
		jQuery("#jquery_jplayer_audio").jPlayer({

			//ready play tracks
			ready: function(){
				var player = jQuery(this);

				//play buttons
				jQuery('.js-audio-item-play').click(function(){
					var li = jQuery(this).parents('.js-track:first');
					currentTrackId = li.attr('track-id');

					stopAllTracks();
					playTrack(li);

					player.jPlayer("setMedia", { mp3: li.attr('media-link') });
					player.jPlayer("play");
				});

				//stop buttons
				jQuery('.js-audio-item-stop').click(function(){
					stopAllTracks();
					player.jPlayer("clearMedia");
				});
			},

			//if ended - play next audio
			ended: function(){
				stopAllTracks();

				var nextTrack = jQuery('.js-track[track-id=' + currentTrackId + ']').next('.js-track');
				if( nextTrack.length > 0 ){
					nextTrack.find('.js-audio-item-play').trigger('click');
				}
			},

			volume: 1.0,
			swfPath: "/js/jPlayer/",
			supplied: "mp3"
		});
	})();


});