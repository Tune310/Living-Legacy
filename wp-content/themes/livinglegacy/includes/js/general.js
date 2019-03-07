(function ($) {
    $(document).on('ready', function (e) {
        $('#testimonial').slick({
            adaptiveHeight: true,
            autoplay: false,
            autoplaySpeed: 3000,
        });

        $('header nav ul').slicknav({
            label: '',
            prependTo: 'header .container'
        });


        // update profile form submit
        $('#am_update_profile_form').submit(function (e) {
            e.preventDefault();
            $('.ajax_message').hide();
            var $this = $(this);
            var button_text = $this.find("button[type='submit']").text();
            $this.find("button[type='submit']").text("Updating...").attr("disabled", "disabled");
            var params = $this.serialize();
            var request = $.ajax({
                url: script_parameter.ajaxurl,
                method: "POST",
                data: params,
                dataType: "json",
                beforeSend: function (  ) {

                }
            });

            request.done(function (response) {
                $this.find("button[type='submit']").text(button_text).removeAttr("disabled");
                if (response.status === 'success')
                {
                    $('.ajax_message').removeClass('error-msg').addClass('success-msg').show().html(response.message);
                } else {
                    $('.ajax_message').removeClass('success-msg').addClass('error-msg').show().html(response.message);
                }
                $("body, html").animate({
                    scrollTop: $("#am_update_profile_form").parent().offset().top
                }, 1500);
            });

        });

        // tribute form submit
        $('#tribute_share_form').submit(function (e) {
            e.preventDefault();
            $('#ajax_response').hide();
            var $this = jQuery(this);
            var button_text = $this.find("input[type='submit']").val();
            $this.find("input[type='submit']").val("Processing..").attr("disabled", "disabled");
            var params = $this.serialize();
            var request = $.ajax({
                url: script_parameter.ajaxurl,
                method: "POST",
                data: {
                    action: 'share_post_with_people',
                    params: params
                },
                dataType: "json",
                beforeSend: function (  ) {

                }
            });

            request.done(function (response) {
                $this.find("input[type='submit']").val(button_text).removeAttr("disabled");
                if (response.status === 'success')
                {
                    $('#tribute_share_form').hide();
                    $('#ajax_response').show().html(response.message);
                } else {
                    $('#ajax_response').show().html(response.message);
                }

            });
            request.fail(function (jqXHR, textStatus) {

                console.log("Request failed: " + textStatus);
            });

        });

        // tribute form submit
        $('#history_share_form').submit(function (e) {
            e.preventDefault();
            $('#history-ajax_response').hide();
            var $this = jQuery(this);
            var button_text = $this.find("input[type='submit']").val();
            $this.find("input[type='submit']").val("Processing..").attr("disabled", "disabled");
            var params = $this.serialize();
            var request = $.ajax({
                url: script_parameter.ajaxurl,
                method: "POST",
                data: {
                    action: 'share_history_with_people',
                    params: params
                },
                dataType: "json",
                beforeSend: function (  ) {

                }
            });

            request.done(function (response) {
                $this.find("input[type='submit']").val(button_text).removeAttr("disabled");
                if (response.status === 'success')
                {
                    $('#history_share_form').hide();
                    $('#history-ajax_response').show().html(response.message);
                } else {
                    $('#history-ajax_response').show().html(response.message);
                }

            });
            request.fail(function (jqXHR, textStatus) {

                console.log("Request failed: " + textStatus);
            });

        });
		
		// tribute form submit
        $('#invite_share_site').submit(function (e) {
            e.preventDefault();
            $('#history-ajax_response').hide();
            var $this = jQuery(this);
            var button_text = $this.find("input[type='submit']").val();
            $this.find("input[type='submit']").val("Processing..").attr("disabled", "disabled");
            var params = $this.serialize();
            var request = $.ajax({
                url: script_parameter.ajaxurl,
                method: "POST",
                data: {
                    action: 'share_site_with_people',
                    params: params
                },
                dataType: "json",
                beforeSend: function (  ) {

                }
            });

            request.done(function (response) {
                $this.find("input[type='submit']").val(button_text).removeAttr("disabled");
                if (response.status === 'success')
                {
                    $('#invite_share_site').hide();
                    $('#invite_share_site_ajax_response').show().html(response.message);
                } else {
                    $('#invite_share_site_ajax_response').show().html(response.message);
                }

            });
            request.fail(function (jqXHR, textStatus) {

                console.log("Request failed: " + textStatus);
            });

        });
		
		// tribute form submit
        $('#invite_question_list').submit(function (e) {
            e.preventDefault();
            $('#invite_question_ajax_response').hide();
            var $this = jQuery(this);
            var button_text = $this.find("input[type='submit']").val();
            $this.find("input[type='submit']").val("Processing..").attr("disabled", "disabled");
            var params = $this.serialize();
            var request = $.ajax({
                url: script_parameter.ajaxurl,
                method: "POST",
                data: {
                    action: 'invite_question_people',
                    params: params
                },
                dataType: "json",
                beforeSend: function (  ) {

                }
            });

            request.done(function (response) {
                $this.find("input[type='submit']").val(button_text).removeAttr("disabled");
                if (response.status === 'success')
                {
                    $('#invite_question_list').hide();
                    $('#invite_question_ajax_response').show().html(response.message);
                } else {
                    $('#invite_question_ajax_response').show().html(response.message);
                }

            });
            request.fail(function (jqXHR, textStatus) {

                console.log("Request failed: " + textStatus);
            });

        });
		
        $('.media-src').on('click', function () {
            var media_src = $(this).data('src');
            var media_type = $(this).data('type');
            if (media_type === 'image') {
                $('#video-container').hide();
                $('#media_src_ele').attr('src', media_src);
                $('#img-container').show();
            } else if (media_type === 'video') {
                $('#img-container').hide();
                //$('#media_src_ele').attr('src', media_src);	
                $('#video-container').html('<video width="600" height="340" controls id="video_palyer" controlsList="nodownload">' +
                        '<source id="media_src_ele" src="' + media_src + '" type="video/mp4"></video>');

                $('#video-container').show();

            }
            var media_desc = $(this).data('desc') || '';

            //if(media_desc!==''){
            $('#media-desc').html(media_desc);
            //}
            $("html, body").animate({scrollTop: 200}, "slow");
        });


    });





})(jQuery);




(function ($) {

    $.fn.equalHeights = function () {
        var maxHeight = 0,
                $this = $(this);

        $this.each(function () {
            var height = $(this).innerHeight();

            if (height > maxHeight) {
                maxHeight = height;
            }
        });

        return $this.css('height', maxHeight);
    };

    // auto-initialize plugin
    $('[data-equal]').each(function () {
        var $this = $(this),
                target = $this.data('equal');
        $this.find(target).equalHeights();
    });


    //$('.pmpro-levels .pricing-plans ul').equalHeights();
    $('.story-type ul li > div span').equalHeights();







// Select all links with hashes
    $('a[href*="#"]')
            // Remove links that don't actually link to anything
            .not('[href="#"]')
            .not('[href="#0"]')
            .not('.video-player a[href*="#"]')
            .click(function (event) {
                // On-page links
                if (
                        location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '')
                        &&
                        location.hostname == this.hostname
                        ) {
                    // Figure out element to scroll to
                    var target = $(this.hash);
                    target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                    // Does a scroll target exist?
                    if (target.length) {
                        // Only prevent default if animation is actually gonna happen
                        event.preventDefault();
                        $('html, body').animate({
                            scrollTop: target.offset().top
                        }, 1000, function () {

                        });
                    }
                }
            });




    $(document).ready(function () {

        $(".faq-tabs-wrapper .tabs-header > div").click(function () {
            $(".faq-tabs-wrapper .tabs-header > div").removeClass("active");
            $(this).addClass("active");
        });

        $(".faq-tabs-wrapper .tabs-header > div:first-child").click(function () {
            $(".faq-tabs-wrapper .tabs-content > div").hide();
            $(".faq-tabs-wrapper .tabs-content > div:first-child").show();
        });

        $(".faq-tabs-wrapper .tabs-header > div:last-child").click(function () {
            $(".faq-tabs-wrapper .tabs-content > div").hide();
            $(".faq-tabs-wrapper .tabs-content > div:last-child").show();
        });


        $(".videos-list ul li").click(function () {
            $(".videos-list ul li").removeClass("active");
            $(this).addClass("active");
        });


        $(".videos-list ul li:first-child").click(function () {
            $(".videos-wrapper .video-player div").hide();
            $(".videos-wrapper .video-player div:first-child").show();
        });

        $(".videos-list ul li:nth-child(2)").click(function () {
            $(".videos-wrapper .video-player div").hide();
            $(".videos-wrapper .video-player div:nth-child(2)").show();
        });

        $(".videos-list ul li:nth-child(3)").click(function () {
            $(".videos-wrapper .video-player div").hide();
            $(".videos-wrapper .video-player div:nth-child(3)").show();
        });

        $(".videos-list ul li:nth-child(4)").click(function () {
            $(".videos-wrapper .video-player div").hide();
            $(".videos-wrapper .video-player div:nth-child(4)").show();
        });

        $(".videos-list ul li:nth-child(5)").click(function () {
            $(".videos-wrapper .video-player div").hide();
            $(".videos-wrapper .video-player div:nth-child(5)").show();
        });

        $(".videos-list ul li:nth-child(6)").click(function () {
            $(".videos-wrapper .video-player div").hide();
            $(".videos-wrapper .video-player div:nth-child(6)").show();
        });

    });




    $(document).ready(function () {
        $('.press ul').slick({
            arrows: false,
            dots: true,
            slidesToShow: 4,
            responsive: [
                {
                    breakpoint: 1150,
                    settings: {
                        arrows: false,
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 860,
                    settings: {
                        arrows: false,
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 580,
                    settings: {
                        arrows: false,
                        slidesToShow: 1
                    }
                }
            ]
        });
    });



})(jQuery);