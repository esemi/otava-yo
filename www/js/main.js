/**
 * Main js file
 */

$(document).ready(function(){

	/**
	 * jPlayer on main template
	 */
	console.log($("#jquery_jplayer_1"));
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