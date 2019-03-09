<?php
/*
Template Name: Feature Selection
Template Post Type: page
*/

if ( !is_user_logged_in () ) {
	 wp_redirect( site_url('/login/') );
	exit;
}
get_header(); 

$user_account_level = ll_getMembershipLevelForUser(get_current_user_id());

?>

<div class="header-banner feature-selection-header have-pics-bottom fs-v2">
	<div class="container row">
		<div class="col-v2">
        <?php if(!empty($user_account_level->ID) and $user_account_level->ID==4){?>
        	<h1><span>Let’s get started with your free trial!</span></h1>
			<p>Enjoy your free trial!.<br>
            Your content will be stored for 30 days.<br>If you would like to keep it, please purchase from our <a href="<?php bloginfo('url'); ?>/membership-levels/">pricing plan</a>.</p>
            <p><small>Choose below and start creating your content.</small></p>
        <?php }else{?>  
			<h1><span>Let’s get started!</span></h1>
			<p>Everything you create will be stored in your <a href="<?php bloginfo('url'); ?>/memory-vault/">Memory Vault.</a><img src="/wp-content/themes/livinglegacy/images/ll-lock-graphic.png" id="ll-graphic-lock" alt=""></p>
			<p><small>Choose below and  start creating your content.</small></p>
			
			<?php }?>
			
			<a class="text-btn color2" data-fancybox="" href="https://www.youtube.com/watch?v=Wj7_O_l94vE">
				<span>Learn</span>
				<img src="https://livinglegacy.kinsta.com/wp-content/themes/livinglegacy/images/how-it-works-btn.png" alt="">
				<span>how it works</span>
			</a>
		</div>
	</div>
	
	<div class="pictures-bg">

	</div>
	
</div>



<div class="container">
	<ul class="feature-selection-options">
		<li>
			<div><span>Tell stories <br>about your life</span> <a class="btn btn-gradient green-gradient" href="<?php bloginfo('url'); ?>/personal-history-questions/">Select</a></div>
			<strong> over 100 thoughtful questions</strong>
			<p>Let us help you to create meaningful content. You’ll be guided through a series of questions to help organize your thoughts.</p>
			<p>Choose from 100’s of questions that range from your basic biography to deeper insights. You can also create and answer your own!</p>
		</li>
		<li>
			<div><span>Create a tribute <br>to someone or a <br>special event</span> <a class="btn btn-gradient green-gradient" href="<?php bloginfo('url'); ?>/contributor-history/">Select</a></div>
			<strong>collaborate with family + friends</strong>
			<p>Create a page for your loved one or celebrate a special event that will last for generations.</p>
			<p>Invite friends and family to contribute by recording videos, adding home movies, pictures, documents and more!</p>
		</li>
		<li>
			<div><span>Create a <br>personal message <br>to someone</span> <a class="btn btn-gradient green-gradient" href="<?php bloginfo('url'); ?>/tributes/">Select</a></div>
			<strong>record video, add pics + more</strong>
			<p>This feature is great for sending that special message for someone’s wedding, graduation, birthday or anniversary. </p>
			<p>You can even store messages for future use. <br>Lets say you create a message for your granddaughter to read on her wedding day. That may be 30 years from now, but she’ll have your message at her wedding. Pretty cool, huh?  </p>

		</li>
	</ul>
</div>


<?php get_footer(); ?>