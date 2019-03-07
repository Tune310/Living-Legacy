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
?>
<?php get_header(); ?>
	<div id="content" class="col_content">
        <div class="single-contibution">
            
            <div class="header-gradient"><h2><?php echo get_the_title($post->ID);?><br><span class="created-by">
Created by <?php echo get_author_fullname( $author_id); ?></span></h2></div>
			
		<div class="white-gradient add-top-borders">	
            <div class="container">
            <?php
			$img_conatiner = 'none;';
			$video_conatiner = 'none;'; 
			if(!empty($media_files[0]['thumbnail']) and $media_files[0]['type']=='image'){
				$img_conatiner = 'block;';	
			}elseif(!empty($media_files[0]['thumbnail']) and ($media_files[0]['type']=='video' or $media_files['type']=='audio')){
				$video_conatiner = 'block;';
			}
				?>
            <p id="img-container" style="display:<?php echo $img_conatiner;?>"><img id="media_src_ele"  src="<?php echo $media_files[0]['thumbnail'];?>" class="single-img-video"></p>
           
            <p id="video-container" style="display:<?php echo $video_conatiner;?>">
             <video width="650" height="340" controls>
              <source id="media_src_ele" src="<?php $media_files[0]['url'];?>" type="video/mp4">
             
            Your browser does not support the video tag.
            </video>
            </p>
            
			
            <p id="media-desc"><?php echo !empty($media_files[0]['desc']) ? $media_files[0]['desc'] : '';?></p> 
            
            </div>
		</div>	
			
			
			
	<div class="media-bin">
		<h2>Media Bin</h2>
		<p>all your media is stored here.</p>

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
                            <a data-desc="<?php echo (!empty($media['desc'])) ? $media['desc'] : '';?>" data-src="<?php echo $media['thumbnail'];?>" class="media-src" data-type="image" href="javascript:void(0);">
                            <div class="media-img">
                                <img src="<?php echo $media['thumbnail'];?>">
                            </div>
                            </a>
                            <?php }elseif($media['type']=='video' or $media['type']=='audio') {
								$video_thumb = $media['thumbnail'];
								if(stripos($media['thumbnail'], 'amazonaws.com')===false){
									
									$video_thumb = get_template_directory_uri().'/images/recorded_video_icon.png';
								}								
								?> 
                            <a data-desc="<?php echo (!empty($media['desc'])) ? $media['desc'] : '';?>" data-src="<?php echo $media['url'];?>" class="media-src" data-type="video" href="javascript:void(0);" data-width="640" data-height="360">
                             <div class="video-thumbnail">
                             <?php
							 if(stripos($media['thumbnail'], 'amazonaws.com')!==false){
                             ?>
                              <span></span>
                              <?php }?>
                                <img src="<?php echo $video_thumb;?>">
                            </div>
                            </a>
                            <?php } else{?>
                            <a data-desc="<?php echo (!empty($media['desc'])) ? $media['desc'] : '';?>" data-src="<?php echo $media['url'];?>" class="media-src" data-type="image" href="javascript:void(0);">
                            <div class="media-img">
                                <img src="<?php echo $media['thumbnail'];?>">
                            </div>
                            </a>
                            <?php }?>
						
					</div><p><?php echo (!empty($media['name'])) ? $media['name'] : '';?></p>
                    <p><?php echo (!empty($media['desc'])) ? $media['desc'] : '';?></p>
				</li>
			<?php }
				}
			}?>
			</ul>
            
		</div>        
	</div><!-- End media-bin-wrapper -->
    <?php
      $notes = get_post_meta($post->ID, '_notes', true);
	 if(!empty($notes)){					
	?>
        <div class="notes history">
            <div class="history-notes">
            <h2>Notes</h2>
                <ul id="myUL" class="ll-notes-checklist"> 
                  <?php 
				  foreach($notes as $note){?>
                  <li><?php echo $note['note'];?></li>
                 <?php }?>
                 </ul>
            </div>
         </div>
         <?php }?>
         <?php 
			if(current_user_can( 'edit_others_posts', $post->ID ) || ($post->post_author == $current_user->ID))  { 
				
				
				echo '<div class="edit-sec"><p>Above is your completed page layout.</p>';
				echo '<a class="btn-gradient red-gradient" href="'.site_url('/tributes/').'?id='.$post->ID.'&edit=true">Edit</a>';
				echo '<p>Below is your opportunity to invite contributors to this page. </p></div>';
							
		?>
       
        <div class="share-form invite-peoples invite-v2">
            <form action="" id="tribute_share_form" method="post">   
			
			<div class="invite-left">
				<img src="<?php bloginfo('template_directory'); ?>/images/share-icon.png" alt="" />
				<label>Invite people to contribute to this page.</label>
				<input type="hidden" name="post_id" id="post_id" value="<?php echo $post->ID;?>">            
				<input type="text" id="emails" name="emails" placeholder="email address"> 
				<p>To invite multiple people to contribute to this page, <br>please separate email addresses with a comma.</p>
				<div class="sample">
					<p>sample: </p>
					<div>jsmith@abc.com, mwilson@xyz.com, rajesh.patel@itcrop.com</div>
				</div>
			</div>
			
			<div class="invite-right">
			
				<p class="right-txt">No one but you will be able  to  <br>edit or delete content.</p>
			
				<textarea id="share_comment" name="share_comment" placeholder="Write something.." style="height:200px"></textarea>
				<input type="submit" value="Send Email" name="share_btn">
				
				<p>Invite people to contribute to this page through social media</p>
				<ul class="invite-social">
					<li>
						<a href="<?php echo $fb_share_url;?>" class="fb-share" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/share-fb.png" alt="" /></a>
					</li>
				</ul>
				<img class="share-logo" src="<?php bloginfo('template_directory'); ?>/images/logo-white.png" alt="" />
			</div>
		 
		 
          </form>
           <p id="ajax_response" class="success-msg">Successfully sent!</p>
        </div>

          <?php
          }
		  ?>
            
		</div>
	</div><!-- /content -->
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        $('[data-fancybox="gallery"]').fancybox({
				// Options will go here
		});
		
		var placeholder = 'Add Comment \n\n\n\n\nHint: Encourge people to record their favorite stories, add pictures, home movies, documents and more!';
		$('textarea').attr('value', placeholder);
		
		$('#share_comment').focus(function(){
			if($(this).val() === placeholder){
				$(this).attr('value', '');
			}
		});
		
		$('#share_comment').blur(function(){
			if($(this).val() ===''){
				$(this).attr('value', placeholder);
			}    
		});

	$('.fb-share').click(function(e) {
        e.preventDefault();
        window.open($(this).attr('href'), 'fbShareWindow', 'height=450, width=550, top=' + ($(window).height() / 2 - 275) + ', left=' + ($(window).width() / 2 - 225) + ', toolbar=0, location=0, menubar=0, directories=0, scrollbars=0');
        return false;
    });
    });
    </script>
<?php get_footer(); ?>