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


	//jPlayer on index page
	(function(){

		function hideTitle(){
			jQuery('.js-audio-song-name').hide();
		};

		jQuery("#jquery_jplayer_index").jPlayer({

			ready: function(e){
				jQuery(this).jPlayer("setMedia", {
					mp3: jQuery("#jquery_jplayer_index").attr('track-src')
				});
			},

			play: function(e){
				jQuery('.js-audio-song-name').show();
			},

			pause: function(e){
				hideTitle();
			},

			ended: function(e){
				hideTitle();

				var player = jQuery(this);
				jQuery.getJSON(
					jQuery("#jquery_jplayer_index").attr('get-next-url'),
					function(data){
						if( typeof data.track !== 'undefined' ){
							jQuery('.js-audio-song-name').text(data.track['title']);
							player.jPlayer("setMedia", { mp3: data.track['audio_link'] });
							player.jPlayer("play");
						}
					}
				);
			},

			volume: 1.0,
			swfPath: "/js/jPlayer/",
			supplied: "mp3"
		});
	})();


	//check avaliable ckeeditor
	if( typeof jQuery().ckeditor !== 'undefined' ){

		//cke-editor on news moderation page
		jQuery('.js-editor-news').ckeditor();

		//cke-editor on album moderation page
		jQuery('.js-editor-album').ckeditor();
	}


	//check avaliable datepickr
	if( typeof datepickr !== 'undefined' ){

		//datepickr on concert admin interface
		if( jQuery('#datepick').length > 0 ){

			var opt = {
				fullCurrentMonth: true,
				dateFormat: 'd.m.y',
				weekdays: ['Вск', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
				months: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь']
			};

			//@TODO select current month and year by default

			new datepickr('datepick', opt);
		}
	}

});