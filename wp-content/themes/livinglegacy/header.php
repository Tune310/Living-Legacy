<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
	<meta name="format-detection" content="telephone=no">
    <script>
	var contributor_data = new Array();
    var is_contributor = false;
    var stripePublicKey = '<?php echo (pmpro_getOption("stripe_publishablekey")) ? pmpro_getOption("stripe_publishablekey"): 'pk_test_Prqay0GufT6dUyH3cNnHtGPn
'; ?>';
    </script>
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">    
	<?php endif; ?>
	<?php /*<link rel="shortcut icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/images/favicon.png">*/ ?>
	<?php wp_head(); ?>
</head>

<?php 

if(get_field('body_class')){
	$body_class = get_field('body_class');
}else{
	$body_class = '';
} 

?>

<body <?php body_class($body_class); ?>>
	<div class="site-wrapper">
		<header>
			<div class="container">
				<div class="logo">
					<a id="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<img src="<?php bloginfo('template_directory'); ?>/images/living-legacies-logo.png" alt="" />
					</a>
				</div>
				<?php if ( has_nav_menu( 'mainmenu' ) ) : ?>
					<?php wp_nav_menu( array( 'theme_location' => 'mainmenu', 'menu_class' => 'sf-menu', 'menu_id'=>'sf-menu', 'container'=>'nav', 'depth'=>0) ); ?>
				<?php endif; ?>
				<div class="social-share">
                <?php
					global $post;
						$fb_share_url = 'https://www.facebook.com/sharer.php?u='.home_url();												
						$pin_share_url = 'http://pinterest.com/pin/create/link/?url='.home_url();
						$tw_share_url = 'https://twitter.com/intent/tweet?url='.home_url();
						$in_share_url = 'http://www.linkedin.com/shareArticle?url='.home_url();
						$tumb_share_url = 'http://www.tumblr.com/share/link?url='.home_url();
					if(is_singular( array( 'legacy-contributions', 'tributes') )){
						
						$fb_share_url = 'https://www.facebook.com/sharer.php?u='.get_the_permalink($post->ID);												
						$pin_share_url = 'http://pinterest.com/pin/create/link/?url='.get_the_permalink($post->ID);
						$tw_share_url = 'https://twitter.com/intent/tweet?url='.get_the_permalink($post->ID);
						$in_share_url = 'http://www.linkedin.com/shareArticle?url='.get_the_permalink($post->ID);
						$tumb_share_url = 'http://www.tumblr.com/share/link?url='.get_the_permalink($post->ID);
						$insta_share_url = '#'.get_the_permalink($post->ID);
						$whatsapp_share_url = '#'.get_the_permalink($post->ID);
					}
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
							<a href="<?php echo $tumb_share_url;?>" target="_blank">
								<img src="<?php bloginfo('template_directory'); ?>/images/social-tumb.png" alt="" />
							</a>
						</li>
                        <li>
                        <center><a class="green-btn-hero" data-fancybox data-src="#ll-invite-popup" href="javascript:;">email<br />this site</a></center>
                        </li>
					</ul>
					<p>Share This Site</p>
                    
				</div>
			</div>
		</header>