<?php
/**
 * Template Name: Video Details
 */

get_header(); ?>

<div id="content" class="col_content">
			<?php
                        if ( is_user_logged_in () ) {
			while ( have_posts() ) : the_post();
                                $currentUser = wp_get_current_user();
				global $wpdb;
                                $addpipe_video_table_name = $wpdb->prefix . 'addpipe_videos';
                                $results = $wpdb->get_results("SELECT * FROM $addpipe_video_table_name WHERE `user_id`={$currentUser->ID}");
                                if ($results) {
                                    $ll_videor_recording_list .= '<table class="">'
                                        .'<tr><th>#</th><th>Video ID</th><th>Video Recorded time</th><th>Snapshot</th></tr>';
                                        $count = 1;
                                        foreach ($results as $result) {
                                            
                                            $ll_videor_recording_list .= '<tr>'
                                                .'<td>' . $count . '</td>'
                                                .'<td>' . $result->video_id . '</td>'
                                                . '<td>' . date('M, d Y at h:ia', strtotime($result->video_recorded)) . '</td>'
                                                . '<td>';
                                            
                                            $ll_video_details = ll_get_addpipe_video_details($result->video_id);
                                            $ll_video_details_s3 =  $ll_video_details['videos'][0]['pipeS3Link'];
                                            $ll_video_details_snapshot =  $ll_video_details['videos'][0]['snapshotURL'];
                                            
                                            $ll_videor_recording_list .= '<a class="fancybox" rel="group" href="https://'.$ll_video_details_s3.'"><img src="https://'.$ll_video_details_snapshot.'" height="90" width="90"></a></td>';

//                                                . ll_get_addpipe_video_details($result->video_id);
//                                            echo'<pre>' . $result->video_id;var_dump($ll_video_details); echo'</pre>';
//                                            var_dump($ll_video_details_snapshot);
//                                            var_dump($ll_video_details_s3); 
//                                            $ll_videor_recording_list .= '</td>';
                                            $ll_videor_recording_list .= '</tr>';
                                            $count++;
                                        }
                                        $ll_videor_recording_list .= '</table>';
                                }else{
                                    $ll_videor_recording_list = 'No Videos to Show.';
                                }
                                echo $ll_videor_recording_list;

			endwhile; // End of the loop.
                        }else{
                            echo 'This page is only for logged in users.';
                        }
			?>

</div>

<?php get_footer();
