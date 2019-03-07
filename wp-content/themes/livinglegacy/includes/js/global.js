let llMedia = [];
let llnotes = [];
let llVideos = [];
let llFetchVideosCall = false;
let allowEditTribue = true;
let ll_cont_media = [];
let llcontnotes = [];

(function ($) {
    //User
    {
        //Login
        $('.legacy-login-account').on('submit', function (e) {
            e.preventDefault();
            var $this = jQuery(this);
            $this.find('.ajax-message').removeClass('error').html('');
            var button_text = $this.find("input[type='submit']").val();
            $this.find("input[type='submit']").val("Processing..").attr("disabled", "disabled");
            var params = $this.serialize();
            $.ajax({
                type: 'POST',
                url: script_parameter.ajaxurl,
                data: {
                    action: 'front_end_login',
                    params: params,
                    nonce: script_parameter.nonce
                },
                cache: false,
                dataType: 'json',
                success: function (data) {
                    if (!(data.flag)) {
                        $this.find('.ajax-message').addClass('error').html(data.response);
                        $this.find("input[type='submit']").val(button_text).removeAttr("disabled");
                    } else {
                       // location.reload();
						window.location = data.redirect_to;
                    }
                }
            });
            return false;
        });
        jQuery("#expiration_date").keypress(function (event) {
            var date = this.value;
            var len = date.length;
            var charCode = event.keyCode || event.which;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            if (len >= 7) {
                return false;
            }
        });
        jQuery("#expiration_date").keyup(function (event) {
            var date = this.value;
            var str = date.replace("/", "");
            var len = str.length;
            var charCode = event.keyCode || event.which;
            if (charCode == 37 || charCode == 8) {
                return false;
            } else {
                if (len == 6) {

                    var array = str.split("");

                    if (len >= '2') {
                        array.splice(2, 0, "/");
                    }
                    var result = array.toString();
                    var str1 = result.replace(/\,/g, "");
                    jQuery("#expiration_date").val(str1);
                }
            }
        });
       // Stripe.setPublishableKey('pk_test_mKHdoX4QShLMGuzbJzdzhqtr');
        pmpro_require_billing = true;
        var tokenNum = 0;
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/

        //registration membership
        jQuery("#legacy_registration_form .benefits-block input:radio").click(function () {
            var promo_code = jQuery('#legacy_registration_form .promo_discount_code').val();
            if (jQuery(this).val() == 3) {
                jQuery('#legacy_registration_form .billing-information-wrapper').hide();
                jQuery('#legacy_registration_form .promo_discount_code input:text').val('').attr("disabled", "disabled");
                ;
            } else {
                jQuery('#legacy_registration_form .billing-information-wrapper').show();
                jQuery('#legacy_registration_form .promo_discount_code input:text').val(promo_code).removeAttr("disabled");
            }
        });

        jQuery('form#legacy_registration_form').on('submit', function (e) {
            e.preventDefault();
            var cnt = 0;
            var pmpro_require_billing = true;
            if (jQuery(this).hasClass('sub-member-form')) {
                pmpro_require_billing = false;
            }
            if (jQuery("#legacy_registration_form .benefits-block input:radio").val() == 3) {
                pmpro_require_billing = false;
            }
            jQuery('#pmpro_processing_message').css('visibility', 'visible').removeClass('error-message').find('img').show();
            jQuery(this).find('button[type=submit]').attr('disabled', 'disabled');

            var exp_month = jQuery('#ExpirationMonth').val();
            var exp_year = jQuery('#ExpirationYear').val();

            jQuery(this).find('.valid-field:visible').each(function () {
                if (jQuery(this).find('input,select').val() === '') {
                    if (jQuery(this).find('.error-message').length <= 0) {
                        jQuery(this).append('<div class=error-message>This field is required</div>');
                    }
                    cnt++;
                } else {
                    jQuery(this).find('.error-message').remove();
                    var email = jQuery("#bemail").val();
                    var password = jQuery("#password").val();
                    var password2 = jQuery("#password2").val();
                    if (password !== password2) {
                        jQuery("#password2").parent('.valid-field').find('.error-message').remove();
                        jQuery("#password2").parent('.valid-field').append('<div class=error-message>Your passwords do not match.</div>');
                        cnt++;
                    } else {
                        jQuery(this).find('.error-message').remove();
                    }
                    if (email != undefined && !email.match(re)) {

                        jQuery("#bemail").parent('.valid-field').find('.error-message').remove();
                        jQuery("#bemail").parent('.valid-field').append('<div class=error-message>Email is invalid.</div>');
                        cnt++;

                    } else {
                        jQuery(this).find('.error-message').remove();
                    }
                    if (jQuery("#legacy_registration_form .benefits-block input:radio").val() != 3) {
                        if (!Stripe.card.validateCardNumber(jQuery('#AccountNumber').val())) {
                            jQuery('#AccountNumber').parent('.valid-field').find('.error-message').remove();
                            jQuery('#AccountNumber').parent('.valid-field').append('<div class=error-message>Card number is invalid</div>');
                            cnt++;
                        } else {
                            jQuery('#AccountNumber').find('.error-message').remove();
                        }

                        if (!Stripe.card.validateExpiry(exp_month, exp_year)) {
                            jQuery('#expiration_date').parent('.valid-field').find('.error-message').remove();
                            jQuery('#expiration_date').parent('.valid-field').append('<div class=error-message>Card expiry month/year is invalid</div>');
                            cnt++;
                        } else {
                            jQuery('#expiration_date').find('.error-message').remove();
                        }

                        if (!Stripe.card.validateCVC(jQuery('#CVV').val())) {
                            jQuery('#CVV').parent('.valid-field').find('.error-message').remove();
                            jQuery('#CVV').parent('.valid-field').append('<div class=error-message>CVC is invalid</div>');
                            cnt++;
                        } else {
                            jQuery('#CVV').find('.error-message').remove();
                        }
                    }
                }
            });

            jQuery(".check-box").find('.error-message').remove();
            jQuery(".benefits-block").find('.error-message').remove();
            if (jQuery("#check-1").is(':checked')) {
                jQuery(".check-box").find('.error-message').remove();
            } else {
                jQuery(".check-box").append('<div class=error-message> This field is required.</div>');
                cnt++;
            }
            var checkCount = jQuery("input[name='level']:checked").length;
            if (checkCount <= 0) {
                jQuery(".benefits-block").append('<div class=error-message>This field is required.</div>');
                cnt++;
            } else {
                jQuery(".benefits-block").find('.error-message').remove();
            }

            if (jQuery(".error-message:visible").length) {
                jQuery('body,html').animate({
                    scrollTop: jQuery(".error-message:visible").offset().top - 100},
                        'slow');
                jQuery(this).find('button[type=submit]', this).attr('disabled', false);
                jQuery('#pmpro_processing_message').css('visibility', 'hidden');
                return false;
            } else {
                cnt = 0;
            }

            if (cnt == 0) {
                if (pmpro_require_billing) {
					Stripe.setPublishableKey(stripePublicKey);
                    //build array for creating token
                    var args = {
                        number: jQuery(this).find('#AccountNumber').val(),
                        exp_month: exp_month,
                        exp_year: exp_year
                    };
                    //add CVC if not blank
                    if (jQuery(this).find('#CVV').length)
                        args['cvc'] = jQuery('#CVV').val();

                    //add first and last name if not blank
                    if (jQuery(this).find('#card_holder_name').length)
                        args['name'] = jQuery.trim(jQuery('#card_holder_name').val());

                    //create token(s)
                    if (jQuery(this).find('#level').length) {
                        var levelnums = jQuery(this).find("#level").val().split(",");
                        for (var cnt = 0, len = levelnums.length; cnt < len; cnt++) {
                            Stripe.createToken(args, stripeResponseHandler);
                        }
                    } else {
                        Stripe.createToken(args, stripeResponseHandler);
                    }
                    return false;
                } else {
                    var params = jQuery('form#legacy_registration_form').serialize();
                    ajaxRegisterMember(params);
                    //                this.submit();
                    return false;	//not using Stripe anymore
                }
            }

        });
        function stripeResponseHandler(status, response) {
            if (response.error) {
                // re-enable the submit button
                // show the errors on the form
                jQuery('#pmpro_processing_message').css('visibility', 'hidden');
                jQuery('#legacy_registration_form').find('button[type=submit]').removeAttr("disabled");
                alert(response.error.message);
                jQuery(".payment-errors").text(response.error.message);
            } else {
                var form = jQuery("#legacy_registration_form, .register-form");
                // token contains id, last4, and card type
                var token = response['id'];
                // insert the token into the form so it gets submitted to the server
                form.append("<input type='hidden' name='stripeToken" + tokenNum + "' value='" + token + "'/>");
                tokenNum++;

                //insert fields for other card fields
                if (jQuery('#CardType[name=CardType]').length)
                    jQuery('#CardType').val(response['card']['brand']);
                else
                    form.append("<input type='hidden' name='CardType' value='" + response['card']['brand'] + "'/>");
                /*form.append("<input type='hidden' name='AccountNumber' value='XXXXXXXXXXXX" + response['card']['last4'] + "'/>");
                form.append("<input type='hidden' name='ExpirationMonth' value='" + ("0" + response['card']['exp_month']).slice(-2) + "'/>");
                form.append("<input type='hidden' name='ExpirationYear' value='" + response['card']['exp_year'] + "'/>");*/

                // and submit
                //            form$.get(0).submit();
                var params = jQuery('form#legacy_registration_form').serialize();
                ajaxRegisterMember(params);
            }
        }

        function ajaxRegisterMember(params) {
            jQuery.ajax({
                type: 'POST',
                url: script_parameter.ajaxurl,
                data: {
                    action: 'membership_form_submission',
                    params: params
                },
                cache: false,
                dataType: 'json',
                success: function (data) {
                    if (data) {
                        if (data.response == 'true') {
                            window.location.href = data.redirect_url;
                        } else {
                            jQuery('#pmpro_processing_message').css('visibility', 'hidden');
                            alert(data.message);
                            jQuery('#legacy_registration_form').find('button[type=submit]', this).attr('disabled', false);
                        }
                    }

                }
            });
        }

        //Forgot Password Toggle
        $('.legacy-forgot-password').on('click', function (e) {
            e.preventDefault();
            $('form.legacy-login-account').slideToggle();
            $('.legacy-forgot-password-form').slideToggle();
        });
        //Forgot Password Form submission
        $('.legacy-forgot-password-form').on('submit', function (e) {
            e.preventDefault();
            var $this = jQuery(this);
            $this.find('.ajax-message').removeClass('error').html('');
            var button_text = $this.find("input[type='submit']").val();
            $this.find("input[type='submit']").val("Processing..").attr("disabled", "disabled");
            var params = $this.serialize();
            $.ajax({
                type: 'POST',
                url: script_parameter.ajaxurl,
                data: {
                    action: 'front_end_forgot_password',
                    params: params,
                    nonce: script_parameter.nonce
                },
                cache: false,
                dataType: 'json',
                success: function (data) {
                    if (!(data.flag)) {
                        $this.find('.ajax-message').addClass('error').html(data.response);
                        $this.find("input[type='submit']").val(button_text).removeAttr("disabled");
                    } else {
                        $this.find('.ajax-message').addClass('error').html(data.response);
                        $this.find("input[type='submit']").val(button_text).removeAttr("disabled");
                    }
                }
            });
            return false;
        });

        $('#legacy-user-logout').on('click', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: script_parameter.ajaxurl,
                data: {
                    action: 'front_end_logout',
                    nonce: script_parameter.nonce
                },
                cache: false,
                dataType: 'json',
                success: function () {
                    location.reload();
                }
            });
        });
    }
    // Contribution Page    
    {
        llDoSlick();
        llContributionInit();
        $('.ll-contribution-submit').on('click', function (e) {
            e.preventDefault();
			jQuery('#ajax_response').hide();
            const title = $('.ll-contributor-title').val();
            const type = $(this).data('type');
			const post_type = $(this).data('posttype');
            const contid = $(this).data('contid');			
			const post_author_id = $('#post_author_id').val() || '';
			var cont_email = $('#contributor_email').val() || '';
            if (jQuery.trim(title) == '') {
				 jQuery('.ll-contributor-title').focus();
                alert('Please add a title for the page.');
				return false;
			}
                jQuery(this).after('<img id="loader-contribution-submit" src="' + script_parameter.loader + '" width="75" height="75" />');
                jQuery(this).attr('disabled', 'disabled');
                $.ajax({
                    type: 'POST',
                    url: script_parameter.ajaxurl,
                    data: {
                        action: 'll_submit_contribution',
                        title: title,
                        type: type,
						post_type:post_type,
                        media: llMedia,
                        notes: llnotes,
						cont_media:ll_cont_media,
                        contid: contid,
						post_author_id:post_author_id,
						cont_email:cont_email,
						cont_notes:llcontnotes,
                        nonce: script_parameter.nonce
                    },
                    cache: false,
                    dataType: 'json',
                    success: function (data) {						
                        jQuery('#loader-contribution-submit').remove();
                        jQuery('.ll-contribution-submit').removeAttr('disabled');
						if(data.status==='success'){
							jQuery('#ajax_response').show();
							//alert('Contribution submitted successfully!');
							llMedia = [];
							llnotes = [];
							$('.ll-notes-checklist').html('');
							jQuery('#media-bin li').map(function () {
								jQuery('#media-bin').slick('slickRemove', 0);
							});
							window.location.href = data.location;
						}else{
							alert(data.message);
						}
                    },
                    error: function () {
                        jQuery('#loader-contribution-submit').remove();
                        alert('Failed to Upload Details!');
                        jQuery('.ll-contribution-submit').removeAttr('disabled');
                    }
                });
           
        });

        $('.ll-contribution-action-container').on('click', '.ll-contribution-action', function (e) {
            e.preventDefault();
            const clicked = $(this).data('totoggle');
            if (clicked === 'video' && !llFetchVideosCall) {				
                llFetchVideosCall = true;
                const pageId = $(this).data('bypid');
                llFetchVideos(pageId);
            }
            $('.notes').show();
            $('.notes-right').hide();
            $('.ll-' + clicked).show();
        });

        $('.ll-save-note-checklist').on('click', function (e) {
            e.preventDefault();
			 var user_id =  jQuery('#post_author_id').val() || '';
            const noteText = $('.ll-note-checklist-textarea').val();
            if (noteText != '') {
				jQuery('.empty-notes').hide();
                const newNote = {note: noteText, checked: false};
                llnotes.push(newNote);
				if(user_id!=''){ // contributor notes					
                	llcontnotes.push(newNote);
				}
                $('.ll-notes-checklist').append(`<li data-checklistid="${llnotes.length}">${noteText}<span class="close">\u00D7</span></li>`);
                $('.ll-note-checklist-textarea').val('');
				jQuery('#notes-list').show();
            }
        });

        $('.ll-notes-checklist').on('click', 'li span.close', function (e) {
            e.preventDefault();
            const noteKey = parseInt(jQuery(this).parent().data('checklistid'));
            llnotes[noteKey - 1] = null;
            jQuery(this).parent().remove();
            return false;
        });

//        $('.ll-notes-checklist').on('click', 'li', function (e) {
//            e.preventDefault();
//            const noteKey = parseInt(jQuery(this).data('checklistid'));
//            const existingNote = llnotes[noteKey - 1];
//            if (existingNote !== null) {
//                existingNote.checked = !existingNote.checked;
//                llnotes[noteKey - 1] = existingNote;
//                jQuery(this).toggleClass('checked');
//            }
//        });

        $('#media-bin').on('click', 'a.ll-media-remove', function (e) {
            e.preventDefault();
            const mediaKey = parseInt(jQuery(this).data('mediapos'));
            llMedia[mediaKey - 1] = null;
            jQuery('#media-bin').slick('unslick');
            jQuery(this).parent().parent().remove();
            llDoSlick();
        });
        
        $('#media-bin').on('change', '.ll-media-input', function (e) {
            e.preventDefault();
            const mediaKey = parseInt(jQuery(this).data('mediapos'));
            let key = 'name';
            if (jQuery(this).hasClass('ll-media-description')) {
                key = 'desc';
            }
            const existingMedia = llMedia[mediaKey - 1];
            existingMedia[key] = jQuery(this).val();
            llMedia[mediaKey - 1] = existingMedia;
        });
		// phone number only number allowed
		$('#aa_phonenumber, #bphone').keyup(function(e) {
		  if ((e.keyCode > 47 && e.keyCode < 58) || (e.keyCode < 106 && e.keyCode > 95)) {
			this.value = this.value.replace(/^(\d{3})(\d{3})(\d)+$/, "($1)$2-$3");
			
			return true;
		  }
		  
		  //remove all chars, except dash and digits
		  this.value = this.value.replace(/[^\-0-9]/g, '');
		});
			// Credit Card Number
		$('#AccountNumber').on('input', function (event) { 
			this.value = this.value.replace(/[^0-9]/g, '');
		});
		
		$("#AccountNumber").attr("maxlength", "16");
    }

})(jQuery);

function llAddMedia(media) {
    const newMedia = {id: media.id, type: 'image', url: media.url, name: '', desc: '', thumbnail: media.url};
	var user_id =  jQuery('#post_author_id').val() || '';
	if(user_id!=''){ // contributor media
		const contMedia = {id: media.id, type: 'image', url:media.url};
		ll_cont_media.push(contMedia);
		contributor_data.push(media.id);
	}
    llMedia.push(newMedia);
    llMediaHandler(newMedia);
}

function llFetchVideos(pageId) {
	// update this line for contribute user
    var user_id =  jQuery('#post_author_id').val() || '';
	jQuery.ajax({
        type: 'POST',
        url: script_parameter.ajaxurl,
        data: {
            action: 'll_fetch_recent_videos',
            pageId: pageId,
			user_id:user_id,
            nonce: script_parameter.nonce
        },
        cache: false,
        dataType: 'json',
        success: function (data) {
            if (data.length > 0) {
				//console.log('find');
				jQuery('.empty-text').hide();
                data.map(video => {
                    if (jQuery.inArray(video.id, llVideos) === -1) {
                        llVideos.push(video.id);
						if(user_id!=''){ // contributor video
							const contMedia = {id: video.id, type: 'video'};
							ll_cont_media.push(contMedia);
							contributor_data.push(video.id);
						}
                        const newMedia = {id: video.id, type: 'video', thumbnail: video.thumbnail, url: video.url, name: '', desc: ''};
                        llMedia.push(newMedia);
                        llMediaHandler(newMedia);
                    }
                });
            }
            setTimeout(function () {
                llFetchVideos(pageId);
            }, 2000);
        },
        error: function () {
            setTimeout(function () {
                llFetchVideos(pageId);
            }, 2000);
        }
    });
}

function llDoSlick() {
    jQuery('#media-bin').slick({
        adaptiveHeight: true,
        autoplaySpeed: 3000,
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 1,
        prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-angle-left"></i></button>',
        nextArrow: '<button type="button" class="slick-next"><i class="fas fa-angle-right"></i></button>',
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 900,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 700,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });
}

function llContributionInit () {
	console.log('init fn');
    if (typeof llContMedia !== "undefined" && typeof llContNotes !==  "undefined" && llContMedia!= null) {
        if (llContMedia.length > 0) {
			if(is_contributor){ // is contributor
				if(contributor_data.length > 0){ //  contributor has media
					jQuery('.empty-text').hide();
				}
				
			}else{
				jQuery('.empty-text').hide();
			}
            llContMedia.map(newMedia => {
                if (newMedia != "") {
                    llVideos.push(newMedia.id);
                    llMedia.push(newMedia);
                    llMediaHandler(newMedia);
                }
            });
        }
        if (llContNotes!= null && llContNotes.length > 0) {
            llContNotes.map(newNote => {
                if (newNote != "") {
                    newNote.checked = newNote.checked === "true" ? true : false;
                    llnotes.push(newNote);
//                    const classChecked = newNote.checked ? ' class="checked"' : '';
                    const classChecked = '';
					if(!is_contributor){
                    	jQuery('.ll-notes-checklist').append(`<li data-checklistid="${llnotes.length}"${classChecked}>${newNote.note}<span class="close">\u00D7</span></li>`);
					}
                }
            });
			console.log('notes show');
            jQuery('.notes').show();
            jQuery('.notes-right').hide();
            jQuery('.ll-notes').show();
			// outside notes container
			if(!is_contributor){
				jQuery('#notes-list').show();
			}
			//jQuery('.ll-notes-checklist').show();
        }
    }else{
		console.log('not find media');
		
	}
}

function llMediaHandler (newMedia) {
	
     //console.log('ID:'+newMedia.id);
	 
	 if(is_contributor){ // only if ocntributor is contributing
	 //console.log('contrbutor');
	 
	 
		 if(jQuery.inArray(newMedia.id, contributor_data)!=-1){	 
		 // console.log( 'Index : ' + jQuery.inArray(newMedia.id, contributor_data) );
			const mediaHtml = ` <li class="media-info">
									<div class="media-thumb">
										<a data-mediapos="${llMedia.length}" class="ll-media-remove remove-media" href="#">
												<span>delete</span>
												<i class="fas fa-times-circle"></i>
										</a>
										${check_amazon_thumbnail(newMedia.thumbnail, newMedia.type, newMedia.url)}
										
									</div>
									<div class="media-desc">
											<input value="${newMedia.name}" data-mediapos="${llMedia.length}" class="ll-media-input ll-media-name" type="text" placeholder="Add Title Here" />
											<textarea data-mediapos="${llMedia.length}" class="ll-media-input ll-media-description" placeholder="Add description">${newMedia.desc}</textarea>
									</div>
								</li>`;
			jQuery('.empty-text').hide();
			jQuery('.media-bin').show();
			jQuery('#media-bin').slick('slickAdd', mediaHtml);
		 }
	 }else{
		  console.log('urLLLL:'+newMedia.thumbnail);
		 jQuery('.empty-text').hide();
		 const mediaHtml = ` <li class="media-info">
								<div class="media-thumb">
									<a data-mediapos="${llMedia.length}" class="ll-media-remove remove-media" href="#">
											<span>delete</span>
											<i class="fas fa-times-circle"></i>
									</a>
									${check_amazon_thumbnail(newMedia.thumbnail, newMedia.type, newMedia.url)}
									
								</div>
								<div class="media-desc">
										<input value="${newMedia.name}" data-mediapos="${llMedia.length}" class="ll-media-input ll-media-name" type="text" placeholder="Add Title Here" />
										<textarea data-mediapos="${llMedia.length}" class="ll-media-input ll-media-description" placeholder="Add description">${newMedia.desc}</textarea>
								</div>
							</li>`;
		jQuery('.media-bin').show();
		jQuery('#media-bin').slick('slickAdd', mediaHtml);
	}
	
}

function check_amazon_thumbnail(thumb_url, media_type, url){
	console.log('media URl:'+thumb_url);
	console.log('media TYPE:'+media_type);
	/*if (thumb_url.toLowerCase().indexOf("amazonaws.com") >= 0)
	{*/		
		var file_type = isFileVideo(thumb_url);
		console.log('type:'+file_type);
		if(file_type=='video' && media_type=='image'){
			//return `<img src="${script_parameter.images_dir}recorded_video_icon.png" />`;
			return `<video width="150" height="100" controlsList="nodownload" class="video-preview" controls="controls" preload="metadata">
                                  <source src="${thumb_url}" type="video/mp4"> 
                                </video>`;
		}else if(file_type=='audio' && media_type=='image'){
			//return `<img src="${script_parameter.images_dir}recorded_video_icon.png" />`;
			return `<div class="media-img  upload-file-icons download-media">
			<img class="thumb-img" src="${script_parameter.images_dir}audio-icon.png" />
			</div>`;
		}else if( media_type=='image' && file_type=='image'){
			  return `<img class="thumb-img" src="${thumb_url}" />`;
			
		}else if(media_type=='video'){
			return `<video width="150" height="100" class="video-preview" controlsList="nodownload" controls="controls" preload="metadata">
                                  <source src="${url}" type="video/mp4"> 
                                </video>`;
		}else{
			//return `<img class="thumb-img" src="${thumb_url}" />`;
			return `<div class="media-img  upload-file-icons download-media"><img class="thumb-img" src="${script_parameter.images_dir}png/${file_type}.png" /></div>`;
		}
	/*}else{
		return `<video width="180" class="video-preview" controls="controls" preload="metadata">
                                  <source src="${url}" type="video/mp4"> 
                                </video>`;
	}*/
}
function isFileVideo(filename) {
	file_type = '';
    var ext = getFileExtension(filename);
    switch (ext.toLowerCase()) {
    case 'm4v':
    case 'avi':
    case 'mpg':
    case 'mp4':
	case 'mov':
        // etc
       file_type = 'video';
	   break;
	case 'jpg':
    case 'jpeg':
    case 'png':
    case 'bmp':
	case 'tiff':
	case 'gif':
        // etc
       file_type = 'image';
	   break;  
	  case 'mp3': case 'wav': case 'm4a':
	   file_type = 'audio';
	   break; 
	   default: 
	  file_type = ext; 
    }
    return file_type;
}
function getFileExtension(filename) {
    var parts = filename.split('.');
    return parts[parts.length - 1];
}


