<?php
/*
  Template Name: Contributor Page (History/Tributes)
  Template Post Type: page
 */
if ( !is_user_logged_in () ) {	
	 wp_redirect( site_url('/login/') );
	exit;
}
//calculate_total_users_used_space();
$user_id = get_current_user_id();
/*$user_allocated_space = get_user_package_space();
$user_total_used_space = 0;
$user_used_space = get_user_used_space($user_id);
if($user_used_space){
	$user_total_used_space = $user_used_space;
}*/
$is_expired = check_subscription_expired($user_id);
get_header();
?>
<?php

            $contribution_title = !empty($_GET['qid']) ? get_question_with_id($_GET['qid']) : '';
			if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                $contribution_id = intval($_GET['id']);
                $contribution_title = get_the_title($contribution_id);
                $media = get_post_meta( $contribution_id, '_media', true);
                $notes = get_post_meta( $contribution_id, '_notes', true);
				$filter_media = make_media_array_filter($media);
				/*echo '<pre>';
				print_r($filter_media);*/

                echo '<script>const llContMedia = ' . json_encode($filter_media) . '; const llContNotes = ' . json_encode($notes) . ';</script>';
            }
        ?>
        <div class="header-banner user-header user-history have-pics-bottom">
            <div class="container row">
                <div class="col-6"> 
                <?php if(!empty($_GET['qid'])){?>
                 <h1><span>Welcome to Personal History</span></h1>
				 <p>Here you’ll be guided through the steps<br>to create incredible content</p>
                <?php }else{?> 
                    <h1><span>Create Personal Messages</span></h1>
		<p>Here you’ll be guided through the steps<br>to create incredible content</p>
                    <?php }?>
		<p><small>Follow the instructions below</small></p>
                </div>
                <div class="col-6">
                    <img class="final-creation" src="<?php bloginfo('template_directory'); ?>/images/final-creation.png" alt=""/>
                    <img src="<?php bloginfo('template_directory'); ?>/images/contributor-header-img-single-screen.png" alt=""/>
                </div>
            </div>
			
			<div class="pictures-bottom">
				<img src="<?php bloginfo('template_directory'); ?>/images/pictures-bottom.png" alt=""/>
			</div>
			
        </div>
        <div class="header-bottom header-bottom-v2">
            <div class="container">
                <p>need inspiration? &nbsp;&nbsp;&nbsp; Check out these videos. <a data-fancybox href="https://www.youtube.com/watch?v=H5sm02NsYGs">Tell a great story</a> and <a data-fancybox href="https://www.youtube.com/watch?v=c_et3NeP_TI">Create the perfect shot.</a></p>
            </div>
        </div>
        <div class="story-title">
            <div class="container">
                <div class="edit-title row">
                    <div class="title-left"><span>This will be the title to this page</span><small>You can edit this at anytime.</small></div>
                    <div class="title-right">
                        <input type="text" class="ll-contributor-title" value="<?php echo $contribution_title; ?>" placeholder="Add Title Here " />
                        <!--<input class="red-gradient" type="button" name="" value="edit" />-->
                    </div>
                     <!--<div class="title-hint"><span>HINT:</span> Write the name of person. ex. "Tribute to Mary Smith" or the name of the special event. ex. "The  Parker's Wedding"</div>-->
                </div>
            </div>
        </div>
        <div class="ways-to-tell">
            <div class="ways-gray">
				<div class="container">
					<h4>3 ways to tell your story</h4>
					<p>All your recorded or uploaded content will appear in your Media Bin below.</p>
				</div>
            </div>
            <div class="story-type ll-contribution-action-container">
                <div class="container">
                    <ul class="style-v2">
                        <li>
                            <span class="story-type-title">Record your story</span>
                            <div>
								<span>
									<img src="<?php bloginfo('template_directory'); ?>/images/input-history-img-1.png" alt="" />
									<strong>Use your computer’s camera or your phone’s camera to create unforgettable videos.</strong>
								  <a data-fancybox data-src="#helpfull-popup" href="javascript:;">Click here for helpful story starters</a>
								</span>
								  <?php if($is_expired){?>
								   <a class="btn-gradient green-gradient" data-fancybox data-src="#storage-popup" href="javascript:;">record</a>
								  <?php }else{?>
								  <a class="btn-gradient green-gradient ll-contribution-action ll-record-toggle" data-totoggle="video" data-bypid="<?php echo get_the_ID(); ?>" href="#">record</a>
								  <?php }?>
							  </div>
                        </li>
                        <li>
                            <span class="story-type-title">Enhance your story</span>
                            <div>
								<span>
									<img src="<?php bloginfo('template_directory'); ?>/images/input-history-img-2.png" alt="" />
									<strong>Upload pictures, home movies, love letters, documents, music or ANYTHING!</strong>
								</span>
									<?php if($is_expired){?>
								   <a class="btn-gradient blue-gradient"  data-fancybox data-src="#storage-popup" href="javascript:;">add</a>
								  <?php }else{?>
									<a class="btn-gradient blue-gradient ll-contribution-action ll-camera-toggle" data-totoggle="media" href="#">add</a><?php }?>
							</div>
                        </li>
                        <li>
                            <span class="story-type-title">Write your story</span>
                            <div>
								<span>
                                <img src="<?php bloginfo('template_directory'); ?>/images/input-history-img-3.png" alt="" />
                                <strong>Let your words do the talking.</strong>
								</span>
                                <a class="btn-gradient blue-gradient ll-contribution-action ll-notes-toggle" data-totoggle="notes" href="#">write</a>
							</div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="notes style-v2" style="display: none;">
            <div class="container row">
				<div class="content-create-txt" id="scroll_to_ele">
					<h2>Create or add content below</h2>
					<p><span>All your recorded or uploaded content will appear in your Media Bin below.</span></p>
					<p>If your browser is Safari, please expect a slower  loading time. <br>Use Chrome or Firefox for a faster experience.</p>
				</div>
                <div class="notes-left">
                    <img src="<?php bloginfo('template_directory'); ?>/images/coffee-cup.png" alt="" />
                </div>
                <div class="notes-right ll-notes">
                    <div id="myDIV" class="notes-header">
                        <textarea class="ll-note-checklist-textarea" placeholder="Sometimes it's easier to just write things down. Start typing here."></textarea>
                        <span class="addBtn btn-gradient blue-gradient ll-save-note-checklist">save</span>
						<p class="save-txt">all your writings are stored in the media bin below.</p>
                    </div>
                   
                </div>
                <div class="notes-right ll-video">
					<?php echo apply_filters('the_content', '[video-recorder]'); ?>
                </div>
                <div class="notes-right ll-media">
					<?php echo apply_filters('the_content', '[file-uploader]'); ?>
                </div>
            </div>
			<div class="container" id="welcome-message-video">
				<p class="txt-hint">Press wait for your video recorder to load. <br>This may take up to 30 seconds. </p>
			</div>
			
        </div>
        <div class="media-bin">
            <h2>Media Bin</h2>
            <p>all your media is stored here.</p>
            <div class="media-bin-wrapper wrapper-v2">
                <div class="container">
                <?php if(empty($media)){?>
		          	<h5 class="sub-heading">Videos + Pictures</h5>
                	<p class="empty-text" style="text-align:center;">Empty</p>
                    <?php }?>
                    <ul id="media-bin">
                   
                    </ul>
                </div>
            </div><!-- End media-bin-wrapper -->            
             
        </div><!-- End media-bin -->
        <div id="notes-list">
             <h5 class="sub-heading">Writings</h5>
             <div class="container">
             <?php if(empty( $notes)){?>
                	<p class="empty-notes" style="text-align:center;">Empty</p>
                  <?php }?>
             	<ul id="myUL" class="ll-notes-checklist"></ul>
             </div>
        </div>
             
        <div class="save-view">
            <div class="container">
                <?php
                $type = get_field('contributor_type') ? 'tribute' : 'history';
                ?>
                <?php if($is_expired){?>
                 <a class="rounded-button-link"  data-fancybox data-src="#storage-popup" href="javascript:;">Save + View</a>
                <?php }else{?>
                <button data-contid="<?php echo $contribution_id; ?>" data-posttype="legacy-contributions" data-type="<?php echo $type; ?>" class="rounded-button ll-contribution-submit" type="submit">Save + View <i class="icon-lock"></i></button>
                <?php }?>
                <p id="ajax_response" class="success-msg">Contribution submitted successfully!</p>
                <p>Click "Save and View" above to securely save everything to your MEMORY VAULT.</p>
            </div>
        </div>
 <script>
   jQuery(document).ready(function(e) {
	  // console.log('log media:'+JSON.stringify(llContMedia));
    <?php if($is_expired){?>
	jQuery('#trial-over-user').trigger('click');
	<?php }?>
	jQuery('.ll-contribution-action.ll-record-toggle').trigger('click');
	jQuery('.ll-contribution-action.ll-camera-toggle, .ll-contribution-action.ll-notes-toggle').on('click', function(){
		jQuery('#welcome-message-video').hide();		
		jQuery('html, body').animate({
			scrollTop: jQuery("#scroll_to_ele").offset().top
		}, 1000);
	});
	jQuery('.ll-contribution-action.ll-record-toggle').on('click', function(){
		jQuery('#welcome-message-video').show();
		jQuery('html, body').animate({
			scrollTop: jQuery("#scroll_to_ele").offset().top
		}, 1000);
	});
	
});
</script>
    <?php get_footer(); ?>
	