<?php
/*
  Template Name: Memory Vault
  Template Post Type: page
 */
if ( !is_user_logged_in () ) {
	 wp_redirect( site_url('/login/') );
	exit();
}
$user_id = get_current_user_id();
$is_expired = check_subscription_expired($user_id);
get_header(); ?>



<div class="memory-vault-header">
	<div class="container">
		<div class="col-6">
			<h2>Welcome to your Memory Vault!
			<img src="<?php bloginfo('template_directory'); ?>/images/vaulat-header-lock.png" alt="" />
			</h2>
			<p>Below are all your responses securely stored <br>
			here in your Memory Vault.<br>
			Select a response to view, edit or share.</p>
		</div>
		<div class="col-6">
			<img src="<?php bloginfo('template_directory'); ?>/images/contributor-header-img.png" alt="" />
		</div>
	</div>
</div>

<div class="container">
	<a class="continue-reading" href="<?php bloginfo('url'); ?>/feature-selection/">Continue Creating</a>
</div>

<?php
if (have_posts()) :
    while (have_posts()) : the_post();
        $contribution_title = '';
        $contribution_id = 0;       
            $user_id = get_current_user_id();
            $cnt = 0;
?>

<div id="content" class="col_content">
    <div class="">
        <!-- /content -->
        <div class="personal-history">
        <?php
            $contributions_args = array(
				'post_type' => array('legacy-contributions'),
                'post_status' => array('publish', 'pending'),
                'posts_per_page' => -1,
                'author' => $user_id,
                );
            $contributions_query = new WP_Query($contributions_args);
            if ($contributions_query->have_posts()) {
                ?>
        <div class="container">
			<h2>Personal History</h2>
		</div>
		
                <table cellspacing="0">
                <?php
                while ($contributions_query->have_posts()) {
                    $contributions_query->the_post();
                    $cnt++;
                    ?>
                    <tr>
                        <td>
                            <?php echo $cnt; ?>
                        </td>
                        <td>
                           <?php the_title(); ?>
                        </td>
                       
                        <td>
							<img src="<?php bloginfo('template_directory'); ?>/images/view-share-lock.png" alt="" />
                           <a class="view-btn" href="<?php echo get_permalink();?>">View/Share</a>
						   <a class="edit-btn" href="<?php echo site_url('/contributor-history/');?>?id=<?php echo get_the_ID();?>&edit=true">Edit</a>
                        </td>
                    </tr>
                    <?php
                }
				wp_reset_query();
                ?>
                </table>                
                <?php
            }
			?>
            </div>
            <div class="personal-tibutes">
            <?php
            $tributes_args = array('post_type' => array('tributes'),
                                                'post_status' => array('publish', 'pending'),
                                                'posts_per_page' => -1,
                                                'author' => $user_id,
                                            );
            $tributess_query = new WP_Query($tributes_args);
            if ($tributess_query->have_posts()) {
                ?>
        	<div class="container">
				<h2>Special events + Tributes</h2>
			</div>
            
                <table cellspacing="0">
                <?php
				 $trib = 0;
                while ($tributess_query->have_posts()) {
                    $tributess_query->the_post();
                    $trib++;
                    ?>
                    <tr>
                        <td>
                            <?php echo $trib; ?>
                        </td>
                        <td>
                            <?php the_title(); ?>
                        </td>
                       
                        <td>
							<img src="<?php bloginfo('template_directory'); ?>/images/view-share-lock.png" alt="" />



							<a class="view-btn" href="<?php echo get_permalink();?>">View/Share</a>
                            <a class="edit-btn" href="<?php echo site_url('/tributes/');?>?id=<?php echo get_the_ID();?>&edit=true">Edit</a>
                        </td>
                    </tr>
                    <?php }
					wp_reset_query();
                ?>
                </table>
                
       <?php } ?>
       </div>
      <?php 
    endwhile;
endif;

?>
 <script>
   jQuery(document).ready(function(e) {
    <?php if($is_expired){?>
	jQuery('#trial-over-user').trigger('click');
	<?php }?>
});
</script> 

<?php get_footer(); ?>