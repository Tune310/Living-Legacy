<?php get_header(); ?>

	<div id="content" class="col_content">
	
		<?php breadcrumb_trail('echo=1&separator=/'); ?>

		<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>
		
			<?php get_template_part( 'templates/content', 'post' ); ?>
			
			<?php
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			?>
			
		<?php endwhile; ?>
		
	<?php else : ?>
		<?php get_template_part( 'templates/content', 'none' ); ?>
	<?php endif; ?>

	</div><!-- /content -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>