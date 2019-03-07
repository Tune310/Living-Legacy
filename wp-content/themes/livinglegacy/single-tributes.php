<?php global  $post;?>
<?php

$current_user =  get_currentuserinfo();	
 $author_id = $post->post_author;
// check for shared token
$shared_token = get_post_meta( intval($_GET['id']), '_share_token', true );
if(!empty($_GET['stoken']) and !empty($_GET['id'])){
	if($shared_token==$_GET['stoken']){
		$contribute_page_url = site_url('tribute-shared-page/').'?id='.$post->ID.'&stoken='.$shared_token;
		wp_redirect( $contribute_page_url ); exit; 	
	}
	
}

 /*$shared_email = get_post_meta( $post->ID, 'shared_emails' );
  echo '<pre>';
  print_r($shared_email);
  die;*/
 $share_url = get_the_permalink($post->ID).'?id='.$post->ID.'&stoken='.get_post_meta($post->ID, '_share_token', true);
$fb_share_url = 'https://www.facebook.com/sharer.php?u='.urlencode($share_url);  
$media_files = get_post_meta($post->ID, '_media', true);
$img_conatiner = 'none;';
$video_conatiner = 'none;'; 
$default_video_url_s3 = '';
$thmbimg_url = '';
$mdia_desc = '';
 if(!empty($media_files)){
	foreach($media_files as $media_check)
	{
		if(!empty($media_check)){
			if(!empty($media_check['thumbnail']) and $media_check['type']=='image'){
				 $uploaded_url = $media_check['url'];
				 $file_type = check_is_video_image($uploaded_url);
				 $file_url = get_cloud_front_url($uploaded_url);
				 if( $file_type =='video'){
					 $default_video_url_s3 = $file_url;
					 $video_conatiner = 'block;';
				}else{
					$thmbimg_url = $file_url;
					$img_conatiner = 'block;';
				}
			}elseif($media_check['type']=='video' OR $media_check['type']=='audio'){
				$default_video = ll_get_addpipe_video_details($media_check['id']);
				
				if($default_video){
					$default_video_url_s3 =  'https://'.$default_video['videos'][0]['pipeS3Link'];						
				}
									
				$video_conatiner = 'block;';
			}
			$mdia_desc = !empty($media_check['desc']) ? $media_check['desc'] : ''; 
			break;
		}	
	}
 }
 
?>
<?php if ( is_user_logged_in() ) {?>
<?php get_header(); ?>
<?php }else{?>
<?php get_header('guest'); ?>
<?php }?>
	<div id="content" class="col_content">
        <div class="single-contibution">
            
            <div class="header-gradient"><h2><?php echo get_the_title($post->ID);?><span class="created-by">
Created by <?php echo get_author_fullname( $author_id); ?></span></h2></div>
			
		<div class="white-gradient add-top-borders">	
            <div class="container">
            <p id="img-container" style="display:<?php echo $img_conatiner;?>"><img id="media_src_ele"  src="<?php echo $thmbimg_url;?>" class="single-img-video"></p>
           
            <p id="video-container" style="display:<?php echo $video_conatiner;?>">
             <video width="650" height="340" controls id="video_palyer" controlsList="nodownload">
              <source id="media_src_ele" src="<?php echo $default_video_url_s3;?>" type="video/mp4">
             
            Your browser does not support the video tag.
            </video>
            </p>
            
			
          <!--  <p id="media-desc"><?php echo $mdia_desc;?></p>--> 
            
            </div>
		</div>	
        
        <div class="notes-list-view">	
                    <div class="container">
                       <?php
                      $notes = get_post_meta($post->ID, '_notes', true);
                     if(!empty($notes)){					
                    ?>
                        <div class="notes history">
                            <div class="history-notes">
                           <h2>Click on the text below to view</h2>
                                <ul id="myUL" class="ll-notes-checklist"> 
                                  <?php 
                                  foreach($notes as $note){?>
                                  <li class="note-full-view" data-notes="<?php echo $note['note'];?>" data-fancybox data-src="#note-content"><?php echo (strlen($note['note']) > 70) ? substr($note['note'],0, 70).'..':$note['note'];?></li>
                                 <?php }?>
                                 </ul>
                            </div>
                         </div>
                         <?php }?>
                    
                    </div>
     </div>
			
	<div class="media-bin">
		<h2>Media Bin</h2>
		<p class="media-view-above">Click on a file to view above.</p>

	<div class="media-bin-wrapper">
		<div class="container">
			<ul id="media-bin" class="history-list">
				<?php
                
				if(!empty($media_files)){
					foreach($media_files as $media)
					{
						if(!empty($media['url'])){
						?>
				<li>
					<div class="history-media-thumb">
						<?php if($media['type']=='image'){?>
                            <?php
							 $uploaded_url = $media['url'];
                             $file_type = check_is_video_image($uploaded_url);							 
							 $file_url = get_cloud_front_url($uploaded_url);
							 if( $file_type =='video' OR $file_type =='audio'){
								 
								 $video_thumb = get_template_directory_uri().'/images/recorded_video_icon.png';
								 ?>
                                 <a data-desc="<?php echo (!empty($media['desc'])) ? $media['desc'] : '';?>" data-src="<?php echo $file_url;?>" class="media-src" data-type="video" href="javascript:void(0);">
                                <div class="media-img video-thumbnail upload-file-icons">
                                <?php if( $file_type =='audio'){?>
                                 <img src="<?php echo get_template_directory_uri().'/images/audio-icon.png';?>">
                                
                                <?php }else{?>
                                <video width="150" height="100" class="video-preview" controlsList="nodownload">
                                  <source src="<?php echo $file_url;?>" type="video/mp4">                                 
                                	Your browser does not support the video tag.
                                </video>
                                    <!--<img src="<?php //echo  $video_thumb;?>">-->
                                    <span></span>
                                    <?php }?>
                                </div>
                                </a>
                            <?php }else{
									$thmbimg_url = !empty($file_url) ? $file_url : $media['thumbnail'];
								   if($file_type =='image'){
									$thumb_url = get_create_thumbnail_url($thmbimg_url);
									?>
                                    <a data-desc="<?php echo (!empty($media['desc'])) ? $media['desc'] : '';?>" data-src="<?php echo $thmbimg_url;?>" class="media-src" data-type="image" href="javascript:void(0);">
									<div class="media-img">                                    
										<img class="thumb-img" src="<?php echo $thumb_url;?>">
									</div>
									</a>
                                   
									<?php }else{?>
									 <a download   href="<?php echo $thmbimg_url;?>">
									<div class="media-img  upload-file-icons download-media">
										<img src="<?php echo get_template_directory_uri().'/images/png/'.$file_type.'.png';?>">                                       
									</div>
									</a>
								<?php }
								}?>
                            <?php }elseif($media['type']=='video' or $media['type']=='audio') {
								$v_details = ll_get_addpipe_video_details($media['id']);
								if($v_details){
           				    		$ll_video_url_s3 =  $v_details['videos'][0]['pipeS3Link'];
									$ll_video_details_snapshot =  $v_details['videos'][0]['snapshotURL'];								

									$img_found = false;
									if (@getimagesize('https://'.$ll_video_details_snapshot)) {
										$img_found = true;
										$video_thumb = 'https://'.$ll_video_details_snapshot;
									} else {
										$video_thumb = get_template_directory_uri().'/images/recorded_video_icon.png';
									}							
								?> 
                            <a data-desc="<?php echo (!empty($media['desc'])) ? $media['desc'] : '';?>" data-src="<?php echo 'https://'.$ll_video_url_s3;?>" class="media-src" data-type="video" href="javascript:void(0);" data-width="640" data-height="360">
                             <div class="video-thumbnail">
                             <?php
							 if($img_found){ ?>
                              <span></span>
                              <?php }?>
                                <img class="thumb-img" src="<?php echo $video_thumb;?>">
                            </div>
                            </a>
                            <?php }
							} else{?>
                            <a data-desc="<?php echo (!empty($media['desc'])) ? $media['desc'] : '';?>" data-src="<?php echo $media['url'];?>" class="media-src" data-type="image" href="javascript:void(0);">
                            <div class="media-img">
                                <img class="thumb-img" src="<?php echo $media['thumbnail'];?>">
                            </div>
                            </a>
                            <?php }?>
						
					</div><p><?php echo (!empty($media['name'])) ? $media['name'] : '';?></p>
                    <p class="media-desc-txt"><?php echo (!empty($media['desc'])) ? $media['desc'] : '';?></p>
				</li>
			<?php }
				}
			}?>
			</ul>
            
		</div>        
	</div><!-- End media-bin-wrapper -->
 
         <?php 
			if(current_user_can( 'edit_others_posts', $post->ID ) || ($post->post_author == $current_user->ID))  { 
				
				
				echo '<div class="edit-sec"><p>Above is your completed page layout.</p>';
				echo '<a class="btn-gradient red-gradient" href="'.site_url('/tributes/').'?id='.$post->ID.'&edit=true">Edit</a>';
				echo '<p>Below is your opportunity to invite contributors to this page. </p></div>';
          }
		  ?>
            
		</div>
	</div><!-- /content -->
    <div style="display: none;" id="note-content">	
	<div id="popup-full-note">Loading...</div>
</div>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        $('[data-fancybox="gallery"]').fancybox({
				// Options will go here
		});
		$('.note-full-view').on('click', function(){
			$('#popup-full-note').html($(this).data('notes'));
		});
		
		var placeholder = 'Add Comment \n\n\n\n\nHint: Encourge people to record their favorite stories, add pictures, home movies, documents and more!';
		$('textarea').attr('value', placeholder);
		
		$('.share_comment').focus(function(){
			if($(this).val() === placeholder){
				$(this).attr('value', '');
			}
		});
		
		$('.share_comment').blur(function(){
			if($(this).val() ===''){
				$(this).attr('value', placeholder);
			}    
		});
		
	$('.tribute-fb-token').attr('href', '<?php echo $fb_share_url;?>');	
	$('.post-fb-share').attr('href', '<?php echo 'https://www.facebook.com/sharer.php?u='.get_the_permalink($post->ID);?>');	

	$('.fb-share').click(function(e) {
        e.preventDefault();
        window.open($(this).attr('href'), 'fbShareWindow', 'height=450, width=550, top=' + ($(window).height() / 2 - 275) + ', left=' + ($(window).width() / 2 - 225) + ', toolbar=0, location=0, menubar=0, directories=0, scrollbars=0');
        return false;
    });
    });
    </script>
	
<?php if(current_user_can( 'edit_others_posts', $post->ID ) || ($post->post_author == $current_user->ID))  { ?>
<div class="share-page">
	<img class="invite-icon" src="<?php bloginfo('template_directory'); ?>/images/popup-invite-icon.png" alt="" />
	<ul>
		<li>
			<a class="blue-btn-v2"  data-fancybox data-src="#ll-share-popup" href="javascript:;">share</a>
			<p>Share this page <br>with family and friends</p>
		</li>
		<li>
			<a class="blue-btn-v2"  data-fancybox data-src="#ll-invite-contribute-popup" href="javascript:;">invite</a>
			<p>Invite people to <br>contribute to this page</p>
		</li>
	</ul>
	<img class="share-logo" src="<?php bloginfo('template_directory'); ?>/images/logo-white.png" alt="" />
</div>
<?php }?>
<?php if ( is_user_logged_in() ) { get_footer(); ?>
<?php }else{?>
<?php get_footer('guest'); }?>