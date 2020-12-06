/**
 * Main js file
 */
jQuery(document).ready(function () {

    //guestbook custom captcha
    jQuery('input[name="custom_captcha"]').val('Ё');

    //guest book add form slider
    jQuery(".js-guestbook-add-button").click(function () {
        jQuery(".js-guestbook-add-form").removeClass('hide');
        jQuery(".js-guestbook-add-button").remove();
    });

    //guest book reply button
    jQuery(".js-guestbook-reply-button").click(function () {
        var postId = jQuery(this).attr('post-id');
        jQuery('#parent_id').val(postId);
        jQuery('.js-guestbook-add-button').trigger('click');
    });

    //jPlayer on audio page
    (function () {

        var currentTrackId;

        function stopAllTracks() {
            jQuery('.js-audio-item-stop').hide();
            jQuery('.js-audio-item-play').show();
        }

        function playTrack(li) {
            li.find('.js-audio-item-stop').show();
            li.find('.js-audio-item-play').hide();
        }

        //jPlayer init
        jQuery("#jquery_jplayer_audio").jPlayer({

            //ready play tracks
            ready: function () {
                var player = jQuery(this);

                //play buttons
                jQuery('.js-audio-item-play').click(function () {
                    var li = jQuery(this).parents('.js-track:first');
                    currentTrackId = li.attr('track-id');

                    stopAllTracks();
                    playTrack(li);

                    player.jPlayer("setMedia", {mp3: li.attr('media-link')});
                    player.jPlayer("play");
                });

                //stop buttons
                jQuery('.js-audio-item-stop').click(function () {
                    stopAllTracks();
                    player.jPlayer("clearMedia");
                });
            },

            //if ended - play next audio
            ended: function () {
                stopAllTracks();

                var nextTrack = jQuery('.js-track[track-id=' + currentTrackId + ']').nextAll('.js-track:first');
                if (nextTrack.length > 0) {
                    nextTrack.find('.js-audio-item-play').trigger('click');
                }
            },

            volume: 1.0,
            swfPath: "/js/jPlayer/",
            supplied: "mp3"
        });
    })();


    //jPlayer on index page
    (function () {

        function hideTitle() {
            jQuery('.js-audio-song-name').hide();
        };

        jQuery("#jquery_jplayer_index").jPlayer({

            ready: function (e) {
                jQuery(this).jPlayer("setMedia", {
                    mp3: jQuery("#jquery_jplayer_index").attr('track-src')
                });
            },

            play: function (e) {
                jQuery('.js-audio-song-name').show();
            },

            pause: function (e) {
                hideTitle();
            },

            ended: function (e) {
                hideTitle();

                var player = jQuery(this);
                jQuery.getJSON(
                    jQuery("#jquery_jplayer_index").attr('get-next-url'),
                    function (data) {
                        if (typeof data.track !== 'undefined') {
                            jQuery('.js-audio-song-name').text(data.track['title']);
                            player.jPlayer("setMedia", {mp3: data.track['audio_link']});
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
    if (typeof jQuery().ckeditor !== 'undefined') {

        //cke-editor on news moderation page
        jQuery('.js-editor-news').ckeditor();

        //cke-editor on album moderation page
        jQuery('.js-editor-album').ckeditor();
    }


    //check avaliable datepickr
    //@TODO replace to jquery UI datepicker
    if (typeof datepickr !== 'undefined') {

        //datepickr on concert admin interface
        if (jQuery('#datepick').length > 0) {

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


    //playlist admin interface
    (function () {

        var ajaxErrorLog = null;

        function displayAjaxError(message) {
            var errorBlock = jQuery('.js-ajax-error');
            errorBlock.text(message);
            errorBlock.fadeIn(100);

            window.clearTimeout(ajaxErrorLog);
            ajaxErrorLog = window.setTimeout(function () {
                errorBlock.fadeOut(1000);
            }, 2100);
        }

        if (typeof jQuery().sortable !== 'undefined') {

            //delete track if remove button clicked
            jQuery('.js-playlist-editable').on('click', '.js-playlist-remove-button', function () {

                if (!confirm("Вы уверены, что хотите удалить данный трек?")) {
                    return false;
                }

                var elem = jQuery(this).parents('li:first');
                jQuery.post(
                    jQuery(".js-playlist-editable").attr('data-remove-url'),
                    {
                        idTrack: elem.attr('track-id'),
                        csrfToken: jQuery('input[name=csrf]').val()
                    },
                    function (data) {
                        if (typeof data.status !== 'undefined' && data.status === 'success') {
                            elem.remove();
                        } else {
                            var err = 'неизвестная ошибка';
                            if (typeof data.error !== 'undefined') {
                                err = data.error;
                            }
                            displayAjaxError(err);
                        }
                    },
                    'json'
                );
            });

            //sort playlist and save order
            jQuery(".js-playlist-editable").sortable({
                placeholder: "ui-state-highlight",
                update: function (event, ui) {

                    var list = [];
                    ui.item.parents('.js-playlist-editable').find('li').each(function (key, li) {
                        list[key] = jQuery(li).attr('track-id');
                    });

                    jQuery.post(
                        jQuery(".js-playlist-editable").attr('data-sort-url'),
                        {
                            list: list,
                            csrfToken: jQuery('input[name=csrf]').val()
                        },
                        function (data) {
                            if (typeof data.status === 'undefined' || data.status !== 'success') {
                                var err = 'неизвестная ошибка';
                                if (typeof data.error !== 'undefined') {
                                    err = data.error;
                                }
                                displayAjaxError(err);
                            }
                        },
                        'json'
                    );
                }
            });
            jQuery(".js-playlist-editable").disableSelection();

            //handler for add button
            jQuery('.js-playlist-add-button').on('click', function () {

                var inputForm = jQuery(this).prev('.js-playlist-add-title:first');
                var ulElem = jQuery(this).parent().prev(".js-playlist-editable:first");

                jQuery.post(
                    ulElem.attr('data-add-url'),
                    {
                        albumId: ulElem.attr('data-album-id'),
                        title: inputForm.val(),
                        csrfToken: jQuery('input[name=csrf]').val()
                    },
                    function (data) {
                        if (typeof data.status !== 'undefined' &&
                            data.status === 'success' &&
                            typeof data.track_id !== 'undefined'
                        ) {
                            var elem = jQuery('.js-playlist-item-template li:first').clone(true);
                            elem.html(function (i, oldHTML) {
                                return oldHTML.replace('REPLACE_ID', data.track_id).replace('REPLACE_TITLE', inputForm.val());
                            });
                            elem.attr('track-id', data.track_id);

                            inputForm.val('');

                            ulElem.append(elem);
                        } else {
                            var err = 'неизвестная ошибка';
                            if (typeof data.error !== 'undefined') {
                                err = data.error;
                            }
                            displayAjaxError(err);
                        }
                    },
                    'json'
                );
            });

        }
    })();

});