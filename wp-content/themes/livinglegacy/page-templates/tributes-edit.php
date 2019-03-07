<?php
/*
Template Name: Tributes Shared Edit Page
Template Post Type: page
*/

$user_email = !empty($_GET['email']) ? $_GET['email'] : '';
$shared_email = get_post_meta( intval($_GET['id']), 'shared_emails' );

if($shared_email and !empty($user_email)){
	if(in_array($user_email, $shared_email)){
		$allow_access = true;
	}
}
// check for shared token
$shared_token = get_post_meta( intval($_GET['id']), '_share_token', true );
if(!empty($_GET['stoken']) and !empty($_GET['id'])){
	if($shared_token == $_GET['stoken']){
		$allow_access = true;
	}
	
}

?>
<?php if ( is_user_logged_in() ) {?>
<?php get_header(); ?>
<?php }else{?>
<?php get_header('guest'); ?>
<?php }?>
<?php
	if ((isset($_GET['id']) && is_numeric($_GET['id']) and $allow_access)) {
		$contribution_id = intval($_GET['id']);
		// get post author id
		$post_author_id = get_post_field( 'post_author',  $contribution_id );
		$filter_media = array();
		$contribution_title = get_the_title($contribution_id);
		$media = get_post_meta( $contribution_id, '_media', true);
		/*if(!empty($media)){
			$new_media = array();
			foreach($media as $md){
				$uploaded_url = $md['url'];
				$new_media['id'] = $md['id']; 
				$new_media['type'] = $md['type'];				
				if($md['type']=='video' and  strpos($uploaded_url, 'amazonaws.com') === false){
				 //$is_video = check_is_video_image($uploaded_url);
				 $file_url = get_cloud_front_url($uploaded_url);
				 $new_media['thumbnail'] = $file_url;
				 $new_media['url'] = $file_url;
				}else{
					$new_media['thumbnail'] = $md['thumbnail']; 
					$new_media['url'] = $md['url'];
				}
				$new_media['name'] = $md['name']; 
				$new_media['desc'] = $md['desc'];
				$filter_media[] = $new_media;
				
				
			}
		}*/
		$filter_media = make_media_array_filter($media);
		//echo '<pre>';
		//print_r($filter_media);
		//die;
		$notes = get_post_meta( $contribution_id, '_notes', true);
		// get contributor data
		$contributor_data = get_post_contributor_stuff($contribution_id, $user_email);
		$contributor_notes = get_post_contributor_notes($contribution_id, $user_email);
		//echo '<pre>';
		//print_r($contributor_notes);
		
		//$user_id = get_current_user_id();
		/*$user_allocated_space = get_user_package_space($post_author_id);		
		$user_total_used_space = 0;
		$user_used_space = get_user_used_space($post_author_id);
		if($user_used_space){
			$user_total_used_space = $user_used_space;
		}*/
		?>
        <script>
		is_contributor = true;        
		 <?php 
		 if(!empty($contributor_data)){
		 foreach($contributor_data as $key => $val){ ?>
			contributor_data.push('<?php echo $val; ?>');
		<?php } 
		 }?>
		 console.log('contribut:'+contributor_data);
		
		</script>
           <?php 
          echo '<script>const llContMedia = ' . json_encode($filter_media) . '; const llContNotes = ' . json_encode($notes) . ';</script>';
        ?>
        <div class="header-banner user-header have-pics-bottom">
            <div class="container row">
                <div class="col-6">  
					  <img class="header-logo" src="<?php bloginfo('template_directory'); ?>/images/header-white-logo.png" alt=""/>		
					<h1><span>Welcome to Living Legacies</span></h1>
					<p>Your host has invited you to contribute stories, <br>messages, pictures, documents and more!</p>
					<p>Here you’ll be guided through the steps <br>to create incredible content.</p>
					<p><small>Follow the instructions below</small></p>
					
					<p class="need-help">need help?</p>
					<div class="need-help-btns">
						<a class="btn btn-white" data-fancybox href="https://www.youtube.com/watch?v=H5sm02NsYGs">Tell a great story</a>
						<a class="btn btn-white" data-fancybox href="https://www.youtube.com/watch?v=c_et3NeP_TI">Create the perfect shot</a>
					</div>			
                </div>
                <div class="col-6">
                    <img src="<?php bloginfo('template_directory'); ?>/images/contributor-header-img-single-screen.png" alt=""/>
                </div>
            </div>
			
			<div class="pictures-bottom">
				<img src="<?php bloginfo('template_directory'); ?>/images/pictures-bottom.png" alt=""/>
			</div>
			
        </div>

		<div class="tribute-to">
			<div class="container">
				<?php echo get_the_title($contribution_id);?>
			</div>
		</div>
		
        <div class="ways-to-tell ways-v2">
            <div class="ways-gray">
				<div class="container">
					<h4>3 ways to tell your story</h4>
					<p>All your recorded or uploaded content will appear in your Media Bin below.</p>
				</div>
            </div>
            <div class="story-type ll-contribution-action-container">
                <div class="container">
                    <ul>
                        <li>
                            <span class="story-type-title">Record your story</span>
                            <div>
							<span>
                                <img src="<?php bloginfo('template_directory'); ?>/images/story-icon-1.png" alt="" />
                                <strong>You can use your computer's camera or your phone's camera</strong>
                                <p>Record unforgettable stories using video or audio from our built-in tools. You can create multiple videos to tell your story.</p>
                                 <a data-fancybox data-src="#helpfull-popup" href="javascript:;">Click here for helpful story starters</a>
                            </span>
                                <?php if($is_expired){?>
                               <a class="btn-gradient green-gradient" data-fancybox data-src="#storage-popup" href="javascript:;">record</a>
                              <?php }else{?>
                              <a class="btn-gradient green-gradient ll-contribution-action ll-record-toggle" data-totoggle="video" data-bypid="<?php echo $contribution_id; ?>" href="#">record</a>
                              <?php }?>
							</div>
                        </li>
                        <li>
                            <span class="story-type-title">Enhance your story</span>
                            <div>
							<span>
                                <img src="<?php bloginfo('template_directory'); ?>/images/story-icon-2.png" alt="" />
                                <strong>You can use your computer's camera or your phone's camera</strong>
                                <p>Record unforgettable stories using video or audio from our built-in tools. You can create multiple videos to tell your story.</p>
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
                                <img src="<?php bloginfo('template_directory'); ?>/images/story-icon-3.png" alt="" />
                                <strong>You can use your computer's camera or your phone's camera</strong>
                                <p>Record unforgettable stories using video or audio from our built-in tools. You can create multiple videos to tell your story.</p>
                            </span>
                                <a class="btn-gradient blue-gradient ll-contribution-action ll-notes-toggle" data-totoggle="notes" href="#">write</a>
							</div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
       <div class="notes" style="display: none;">
            <div class="container row" id="scroll_to_ele">
				<div class="content-create-txt" >
					<p>If your browser is Safari, please expect a slower  loading time.<br> Use Chrome or Firefox for a faster experience.</p>
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
					<?php echo apply_filters('the_content', '[video-recorder user_id="'.$post_author_id.'" post_id="'.$contribution_id.'"]'); ?>
                </div>
                <div class="notes-right ll-media">
					<?php echo apply_filters('the_content', '[file-uploader user_id="'.$post_author_id.'"]'); ?>
                </div>
            </div>
			
			<div class="container" id="welcome-message-video">
				<p class="txt-hint">Press "Record" and please wait for your video recorder to load. <br>This may take up to 30 seconds.</p>
			</div>
        </div>
         <div class="media-bin" id="media-bin-main">
            <h2>Media Bin</h2>
            <p>all your media is stored here.</p>
            <div class="media-bin-wrapper">
                <div class="container">
                <?php if(empty($contributor_data)){?>
                	<h5 class="sub-heading">Videos + Pictures</h5>
                    <p class="empty-text" style="text-align:center;">Empty</p>
                    <?php }?>
                    <ul id="media-bin">
                    </ul>
                </div>
            </div><!-- End media-bin-wrapper -->            
             
        </div><!-- End media-bin -->
        
        <div id="notes-list" >
             <h5 class="sub-heading">Writings</h5>
             <div class="container">
             <?php if(empty(  $contributor_notes)){?>
                	<p class="empty-notes" style="text-align:center;">Empty</p>
                  <?php }?>
            
             	<ul id="myUL" class="ll-notes-checklist">
                <?php if(count($contributor_notes) > 0 ){
						$count_note = count($notes);
						foreach($contributor_notes as $note){?>
                        <li data-checklistid="<?php echo $count_note++;?>"><?php echo $note;?><span class="close">×</span></li>
                        <?php }
				}?>
                </ul>
             </div>
        </div>
             
        <div class="save-view">
            <div class="container">
                <?php
                $type = get_field('contributor_type') ? 'tribute' : 'history';
                ?>
                <input type="hidden" name="posttitle" class="ll-contributor-title" value="<?php echo get_the_title($contribution_id);?>">
                <input type="hidden" name="contributor_email" id="contributor_email" value="<?php echo $user_email;?>">
                <input type="hidden" name="post_author_id" id="post_author_id" value="<?php echo $post_author_id;?>">
                 <?php if($is_expired){?>
                <a class="rounded-button-link"  data-fancybox data-src="#storage-popup" href="javascript:;">Submit</a>    
                <?php }else{?>
                <button data-contid="<?php echo $contribution_id; ?>" data-posttype="tributes" data-type="<?php echo $type; ?>" class="rounded-button ll-contribution-submit" type="submit">Submit<i class="icon-lock"></i></button>
               <?php }?>
                <p id="ajax_response" class="success-msg">Contribution submitted successfully!</p>
                <p>Click "Save and View" above to securely save everything to your MEMORY VAULT.</p>
            </div>
        </div>
        <?php  }else{?>
        	<p>You can not access this page. This page is not shared with you.</p>
       <?php }?>
           <script type="text/javascript">
    jQuery(document).ready(function($) {
        $('[data-fancybox="gallery"]').fancybox({
				// Options will go here
		});
		//$('.remove-media').hide();
		//$('.close').hide();
		//$('.ll-media-input').prop('disabled', true);
		//$('#media-bin-main').hide();
		//$('#media-bin').html('');		
		//$('#notes-list').hide();
		//$('#myUL').html('');
		//$('#media-bin').slick('refresh');
		
		
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
   <?php if ( is_user_logged_in() ) {?>
<?php get_footer(); ?>
<?php }else{?>
<?php get_footer('guest'); }?>