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

<?php if(get_field('body_class')){
	$body_class = get_field('body_class');
}else{
	$body_class = '';
} ?>

<body <?php body_class($body_class); ?>>
	<div class="site-wrapper guest-only">
		<header class="guest-header">
				<div class="logo">
					<a id="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<img src="<?php bloginfo('template_directory'); ?>/images/logo.png" alt="" />
					</a>
				</div>

		</header>