<?php
global $post;
$fb_share_url = '#';
$pin_share_url = '#';
$tw_share_url = '#';
if(is_singular( array( 'legacy-contributions', 'tributes'))){
	
	$fb_share_url = 'https://www.facebook.com/sharer.php?u='.get_the_permalink($post->ID);
	$pin_share_url = 'http://pinterest.com/pin/create/link/?url='.get_the_permalink($post->ID);
	$tw_share_url = 'https://twitter.com/intent/tweet?url='.get_the_permalink($post->ID);
}
?>
<footer id="footer" class="guest-footer">
		<div class="container">
			<a class="green-btn" href="<?php bloginfo('url'); ?>/question-list/">questions</a>
			<p>View over 100 thoughtful questions and <br>Invite the sender to contribute more content</p>
		</div>
	</footer>
</div>

<div style="display: none;" id="ll-invite-contribute-popup"><!-- Single Tributes popup - INVITE PEOPLE TO CONTRIBUTE -->
	<div class="ll-invite-popup">
		<img src="<?php bloginfo('template_directory'); ?>/images/popup-logo.png" alt="" />
		<img class="invite-icon" src="<?php bloginfo('template_directory'); ?>/images/popup-invite-icon.png" alt="" />
		<div class="invite-highlight">INVITE PEOPLE TO CONTRIBUTE</div>
		
		<form>
			<p>No one but you will be able  to edit or delete content.</p>
			<input type="email" name="" placeholder="email address" />
			<p>To share with multiple people ,<br>please separate email addresses with a comma.</p>
			<textarea placeholder="add comment"></textarea>
			<input type="submit" name="submit" value="send email"/>
		</form>
		
		<div class="social-share on-page">
		<p>Invite people to contribute to this page through social media</p>
		<ul class="share-creation">
			<li>
				<a href="#">
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
		
		<form>
			<p>No one but you will be able  to edit or delete content.</p>
			<input type="email" name="" placeholder="email address" />
			<p>To share with multiple people ,<br>please separate email addresses with a comma.</p>
			<textarea placeholder="add comment"></textarea>
			<input type="submit" name="submit" value="send email"/>
		</form>
		
		<div class="social-share on-page">
		<p>Share your creation through social media</p>
		<ul class="share-creation">
			<li>
				<a href="#">
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
		
		<form>
			<input type="email" name="" placeholder="email address" />
			<p>To share with multiple people ,<br>please separate email addresses with a comma.</p>
			<textarea placeholder="add comment"></textarea>
			<input type="submit" name="submit" value="send email"/>
		</form>
		
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
</body>
</html>