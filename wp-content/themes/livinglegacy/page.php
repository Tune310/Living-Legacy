<?php get_header(); ?>

	<div id="content" class="container">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php get_template_part( 'templates/content', 'page' ); ?>
		<?php endwhile; endif; ?>

	</div><!-- /content -->

<?php get_footer(); ?>