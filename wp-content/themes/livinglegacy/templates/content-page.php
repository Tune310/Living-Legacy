<div <?php post_class('post') ?> id="post-<?php the_ID(); ?>">
		
	<div class="title">
		<!--<div class="header-link">
			<div class="container">
				<a href="/feature-selection/">Start Creating</a>
			</div>
		</div>-->
		<h1>
		<?php 
			if(is_page('my-account')):
				$current_user = wp_get_current_user();
				echo 'Welcome <br>';
				echo $current_user->user_firstname.' ';
				echo $current_user->user_lastname;
				
			else :
				$title = get_field('custom_title'); 
				if(!empty($title)) : 
					echo $title; 
					else : 
					the_title(); 
				endif;
			endif;
		?>
		</h1>

		
	</div><!-- /title -->
		
		<div class="creating"><a href="/feature-selection/">Continue Creating</a></div>
		
			
	<div class="entry">
		<?php the_content(__('Read more', 'am')); ?>
		<div class="clear clearfix"></div>
		<?php wp_link_pages( array( 'before' => '<div class="page-link"><p><span>' . __( 'Pages:', 'am' ) . '</span>', 'after' => '</p></div>' ) ); ?>
		<?php edit_post_link(__('Edit', 'am'), '<br /><p>', '</p>'); ?>
	</div><!-- /entry -->
	
</div><!-- /post -->