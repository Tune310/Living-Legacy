<?php
if(isset($_GET['level']) && $_GET['level']=='3'){
?>
<style>
.collage_pic {
     display:none!important;
}
header{
display:none;
}
.pmpro_checkout h3 span.pmpro_checkout-h3-name{
   display:none !important;
}
.pmpro_checkout h3 span.pmpro_checkout-h3-name span{
   display:none !important;
}
div#pmpro_pricing_fields{
    padding-top:50px;
}

</style>
<?php }
?>
<?php
if(isset($_GET['level']) && $_GET['level']=='4'){
?>
<style>
.gradient_01{
box-shadow:none;
}
header{
display:none;
}
div#pmpro_pricing_fields{
padding-top:50px;
}

span.pmpro_checkout-h3-name01.cus_n{
text-transform:uppercase;
}

</style>
<?php }
?>
<footer id="footer">
		<div class="container">
			<div class="footer-social">
					<ul>
						<li>
							<a href="#" target="_blank">
								<img src="<?php bloginfo('template_directory'); ?>/images/social-fb-footer.png" alt="" />
							</a>
						</li>
						<li>
							<a href="#" target="_blank">
								<img src="<?php bloginfo('template_directory'); ?>/images/social-instagram-footer.png" alt="" />
							</a>
						</li>
						<li>
							<a href="#" target="_blank">
								<img src="<?php bloginfo('template_directory'); ?>/images/social-pin-footer.png" alt="" />
							</a>
						</li>
						<li>
							<a href="#" target="_blank">
								<img src="<?php bloginfo('template_directory'); ?>/images/social-twitter-footer.png" alt="" />
							</a>
						</li>
					</ul>
			</div>
			
			<div class="footer-links">
				<div>
					<?php wp_nav_menu( array( 'theme_location' => 'footer-menu-1' ) ); ?>
				</div>
				<div>
					<?php wp_nav_menu( array( 'theme_location' => 'footer-menu-2' ) ); ?>
				</div>
			</div>
			
			<a class="footer-logo" href="#"><img src="<?php bloginfo('template_directory'); ?>/images/footer-logo.png" alt="" /></a>
			<p class="copyrights"><?php echo date('Y'); ?> Living Legacies Inc. All Rights Reserved</p>
            <a class="footer-logo" href="#"><img src="<?php bloginfo('template_directory'); ?>/images/bottom-logo.png" alt="" /></a>
		</div>
	</footer>
</div>




<div style="display: none;" id="ll-invite-contribute-popup"><!-- Single Tributes popup - INVITE PEOPLE TO CONTRIBUTE -->
	<div class="ll-invite-popup">
		<img src="<?php bloginfo('template_directory'); ?>/images/popup-logo.png" alt="" />
		<img class="invite-icon" src="<?php bloginfo('template_directory'); ?>/images/popup-invite-icon.png" alt="" />
		<div class="invite-highlight">INVITE PEOPLE TO CONTRIBUTE</div>
		
		<form id="tribute_share_form" method="post">
        <input type="hidden" name="post_id" id="post_id" value="<?php echo $post->ID;?>">
			<p>No one but you will be able  to edit or delete content.</p>
			<input type="email" id="emails" name="emails" placeholder="email address" />
			<p>To share with multiple people ,<br>please separate email addresses with a comma.</p>
			<textarea class="share_comment" id="share_comment" name="share_comment"  placeholder="add comment"></textarea>
			<input type="submit" name="submit" value="send email"/>
		</form>
         <p id="ajax_response" class="">Successfully sent!</p>
		
		<div class="social-share on-page">
		<p>Invite people to contribute to this page through social media</p>
		<ul class="share-creation">
			<li>
				<a href="" class="fb-share tribute-fb-token" target="_blank">
					<img src="<?php bloginfo('template_directory'); ?>/images/popup-share-fb.png" alt="" />
				</a>
				<span>facebook</span>
			</li>
		</ul>
		</div>
	</div>
</div>



<div style="display: none;" id="ll-share-popup"><!-- Single Legacy Contributions popup - SHARE YOUR CREATION -->
	<div class="ll-invite-popup">
		<img src="<?php bloginfo('template_directory'); ?>/images/popup-logo.png" alt="" />
		<img class="invite-icon" src="<?php bloginfo('template_directory'); ?>/images/popup-invite-icon.png" alt="" />
		<div class="invite-highlight">SHARE YOUR CREATION</div>
		
		<form id="history_share_form" method="post">
        <input type="hidden" name="post_id" id="post_id" value="<?php echo $post->ID;?>">			
			<input type="email" id="emails" name="emails" placeholder="email address" />
			<p>To share with multiple people ,<br>please separate email addresses with a comma.</p>
			<textarea class="share_comment" id="share_comment" name="share_comment"  placeholder="add comment"></textarea>
			<input type="submit" name="submit" value="send email"/>
		</form>
        <p id="history-ajax_response" class="ajax-response">Successfully sent!</p>
		
		<div class="social-share on-page">
		<p>Share your creation through social media</p>
		<ul class="share-creation">
			<li>
				<a href="" class="post-fb-share" target="_blank">
					<img src="<?php bloginfo('template_directory'); ?>/images/popup-share-fb.png" alt="" />
				</a>
				<span>facebook</span>
			</li>
		</ul>
		</div>
	</div>
</div>


<div style="display: none;" id="ll-invite-popup"><!-- Home page Popup - INVITE PEOPLE TO EXPERIENCE THIS SITE -->
	<div class="ll-invite-popup">
		<img src="<?php bloginfo('template_directory'); ?>/images/popup-logo.png" alt="" />
		<img class="invite-icon" src="<?php bloginfo('template_directory'); ?>/images/popup-invite-icon.png" alt="" />
		<div class="invite-highlight">INVITE PEOPLE TO EXPERIENCE THIS SITE</div>
		
		<form id="invite_share_site" method="post">        
			<input type="email" id="emails" name="emails" placeholder="email address" />
			<p>To share with multiple people ,<br>please separate email addresses with a comma.</p>
			<textarea class="share_comment" id="share_comment" name="share_comment" placeholder="add comment"><?php echo wp_strip_all_tags(get_field('invitation_message', 'option')); ?></textarea>
			<input type="submit" name="submit" value="send email"/>
		</form>
		 <p id="invite_share_site_ajax_response" class="ajax-response">Successfully sent!</p>
		<div class="social-share on-page">
		<p>Share this site on social media</p>
		<?php
			global $post;
				$fb_share_url = 'https://www.facebook.com/sharer.php?u='.home_url();												
				$pin_share_url = 'http://pinterest.com/pin/create/link/?url='.home_url();
				$tw_share_url = 'https://twitter.com/intent/tweet?url='.home_url();
				$google_share_url = 'https://plus.google.com/share?url='.home_url();
				$in_share_url = 'http://www.linkedin.com/shareArticle?url='.home_url();
				$tumb_share_url = 'http://www.tumblr.com/share/link?url='.home_url();
				$insta_share_url = '#'.home_url();
				$whatsapp_share_url = '#'.home_url();

			?>
			<ul>
				<li>
					<a href="<?php echo $fb_share_url ;?>" target="_blank">
						<img src="<?php bloginfo('template_directory'); ?>/images/social-fb.png" alt="" />
					</a>
				</li>						
				<li>
					<a href="<?php echo $tw_share_url;?>" target="_blank">
						<img src="<?php bloginfo('template_directory'); ?>/images/social-twitter.png" alt="" />
					</a>
				</li>
				<li>
					<a href="<?php echo $pin_share_url;?>" target="_blank">
						<img src="<?php bloginfo('template_directory'); ?>/images/social-pin.png" alt="" />
					</a>
				</li>
				<li>
					<a href="<?php echo $in_share_url;?>" target="_blank">
						<img src="<?php bloginfo('template_directory'); ?>/images/social-in.png" alt="" />
					</a>
				</li>
				<li>
					<a href="<?php echo $google_share_url;?>" target="_blank">
						<img src="<?php bloginfo('template_directory'); ?>/images/social-google.png" alt="" />
					</a>
				</li>
				<li>
					<a href="<?php echo $insta_share_url ;?>" target="_blank">
						<img src="<?php bloginfo('template_directory'); ?>/images/social-insta.png" alt="" />
					</a>
				</li>						
			</ul>
		</div>
	</div>
</div>


<div style="display: none;" id="ll-invite-to-share-popup"><!-- Question List page Popup - INVITE SOMEONE TO SHARE THEIR LIFE -->
	<div class="ll-invite-popup">
		<img src="<?php bloginfo('template_directory'); ?>/images/popup-logo.png" alt="" />
		<img class="invite-icon" src="<?php bloginfo('template_directory'); ?>/images/popup-invite-icon.png" alt="" />
		<div class="invite-highlight">INVITE SOMEONE TO SHARE THEIR LIFE</div>
		<form id="invite_question_list" method="post">        
			<input type="email" id="emails" name="emails" placeholder="email address" />
			<p>To share with multiple people ,<br>please separate email addresses with a comma.</p>
			<textarea class="share_comment" id="share_comment" name="share_comment" placeholder="add comment"><?php echo wp_strip_all_tags(get_field('questions_page_invite_content', 'option')); ?></textarea>
			<input type="submit" name="submit" value="send email"/>
		</form>
		 <p id="invite_question_ajax_response" class="ajax-response">Successfully sent!</p>
		<div class="social-share on-page">
		<p>Share this site on social media</p>
		<?php
			global $post;
				$fb_share_url = 'https://www.facebook.com/sharer.php?u='.home_url();												
				$pin_share_url = 'http://pinterest.com/pin/create/link/?url='.home_url();
				$tw_share_url = 'https://twitter.com/intent/tweet?url='.home_url();
				$google_share_url = 'https://plus.google.com/share?url='.home_url();
				$in_share_url = 'http://www.linkedin.com/shareArticle?url='.home_url();
				$tumb_share_url = 'http://www.tumblr.com/share/link?url='.home_url();
				$insta_share_url = '#'.home_url();
				$whatsapp_share_url = '#'.home_url();

			?>
			<ul>
				<li>
					<a href="<?php echo $fb_share_url ;?>" target="_blank">
						<img src="<?php bloginfo('template_directory'); ?>/images/social-fb.png" alt="" />
					</a>
				</li>						
				<li>
					<a href="<?php echo $tw_share_url;?>" target="_blank">
						<img src="<?php bloginfo('template_directory'); ?>/images/social-twitter.png" alt="" />
					</a>
				</li>
				<li>
					<a href="<?php echo $pin_share_url;?>" target="_blank">
						<img src="<?php bloginfo('template_directory'); ?>/images/social-pin.png" alt="" />
					</a>
				</li>
				<li>
					<a href="<?php echo $in_share_url;?>" target="_blank">
						<img src="<?php bloginfo('template_directory'); ?>/images/social-in.png" alt="" />
					</a>
				</li>
				<li>
					<a href="<?php echo $google_share_url;?>" target="_blank">
						<img src="<?php bloginfo('template_directory'); ?>/images/social-google.png" alt="" />
					</a>
				</li>
				<li>
					<a href="<?php echo $insta_share_url ;?>" target="_blank">
						<img src="<?php bloginfo('template_directory'); ?>/images/social-insta.png" alt="" />
					</a>
				</li>						
			</ul>
		</div>
	</div>
</div>




<div style="display: none;" id="storage-popup">
	<div class="storage-popup">
		<img src="<?php bloginfo('template_directory'); ?>/images/popup-logo.png" alt="" />
		<p>Unfortunaltely, you are at your maximum storage capacity.<br> Visit your account page to upgrade to a new plan and buy more storage</p>
		<a class="btn btn-white" href="<?php echo site_url('/my-account');?>">my account</a>
		<div class="no-thanks" data-fancybox-close>no thanks</div>
	</div>
</div>

<div style="display: none;" id="trial-over-popup">
	<div class="storage-popup">
		<img src="<?php bloginfo('template_directory'); ?>/images/popup-logo.png" alt="" />
		<p>Unfortunately, your free trial is over. Visit your account page to choose a membership plan.</p>
		<a class="btn btn-white" href="<?php echo site_url('/my-account');?>">my account</a>
		<div class="no-thanks" data-fancybox-close>no thanks</div>
	</div>
</div>

<!--Help full story started-->
<div style="display: none;" id="helpfull-popup">
	<div class="storage-popup">
		<img src="<?php bloginfo('template_directory'); ?>/images/popup-logo.png" alt="" />
		<p class="shade">Story Starter Tips</p>
		<p>Speak from the heart<br>Include plenty of details. <br>Talk about your favorite memories and <br>what they meant to you.</p>
		<div class="no-thanks" data-fancybox-close>Close</div>
	</div>
</div>
<a data-fancybox data-src="#trial-over-popup" href="javascript:;" style="display:none;" id="trial-over-user">open trial</a>

<?php wp_footer(); ?>
<?php 

global $post;
//print_r($post);
if($post->ID=='24' || $post->ID=='27'){?>
	<style>
		#menu-item-153, #menu-item-154{
			display:none!important;
		}
	</style>
<?php } ?>

<script type='text/javascript'>
/* <![CDATA[ */
jQuery(document).ready(function(){
jQuery(".post-21 > .title").html('<h1>Welcome <br> <span><br>Howard H</span></h1>');
});

/* ]]> */
</script>
</body>
</html>