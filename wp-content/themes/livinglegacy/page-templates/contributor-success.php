<?php
/**
 * Template Name: Contributor Success
 */
global $wpdb;
get_header(); ?>

<div class="header-banner user-header have-pics-bottom">
    <div class="container row">
        <div class="col-6">
			  <img class="header-logo" src="<?php bloginfo('template_directory'); ?>/images/header-white-logo.png" alt=""/>		
            <h1><span>Your contribution was successfully sent!</span></h1>
            <p>Your host will gather all contributions and <br>share them with you at a later time.</p>
			<p>Thanks again for you contribution!</p>
            <p><small>To learn more about Living Legacies</small></p>
			<div class="need-help-btns">
				<a class="btn btn-white" href="<?php bloginfo('url'); ?>">CLICK HERE</a>
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
<div class="join-community v2">
	<div class="container">		
		<div class="join">
			<h2>Join the Living Legacies Community</h2>
			<p>Connect with us on social media and <br>share memories, get story telling tips or make a new friend.</p>
		</div>
	</div>
</div>

<?php get_footer();
