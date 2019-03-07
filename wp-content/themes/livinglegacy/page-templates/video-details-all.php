<?php
/**
 * Template Name: Video Details - All
 */

get_header(); ?>

<div id="content" class="col_content">

			<?php
                        if ( is_user_logged_in () ) {
			while ( have_posts() ) : the_post();
                                $currentUser = wp_get_current_user();
				global $wpdb;
                                $addpipe_video_table_name = $wpdb->prefix . 'addpipe_videos';
                                $results = $wpdb->get_results("SELECT * FROM $addpipe_video_table_name");
                                if ($results) {
                                    $popupdiv .= '<table class="">'
                                        .'<tr><th>#</th><th>Video ID</th><th>Video Recorded time</th><th>Detail</th></tr>';
                                        $count = 1;
                                        foreach ($results as $result) {
                                            $popupdiv .= '<tr>'
                                                .'<td>' . $count . '</td>'
                                                .'<td>' . $result->video_id . '</td>'
                                                . '<td>' . date('M, d Y at h:ia', strtotime($result->video_recorded)) . '</td>'
                                                . '<td>' . $result->details . '</td>';
                                            $popupdiv .= '</tr>';
                                            $count++;
                                        }
                                        $popupdiv .= '</table>';
                                }else{
                                    $popupdiv = 'No Videos to Show';
                                }
                                echo $popupdiv;

			endwhile; // End of the loop.
                        }else{
                            echo 'This page is only for logged in users.';
                        }
			?>

		</div>
<?php get_footer();
