<?php
 
$wordpress_upload_dir = wp_upload_dir();
// $wordpress_upload_dir['path'] is the full server path to wp-content/uploads/2017/05, for multisite works good as well
// $wordpress_upload_dir['url'] the absolute URL to the same folder, actually we do not need it, just to show the link to file
$i = 1; // number of tries when the file with the same name is already exists
 
$the_new_image = $_FILES['newpicture'];
$new_file_path = $wordpress_upload_dir['path'] . '/' . $the_new_image['name'];
$new_file_mime = mime_content_type( $the_new_image['tmp_name'] );
 
if( empty( $the_new_image ) )
	die( 'File is not selected.' );
 
if( $the_new_image['error'] )
	die( $the_new_image['error'] );
 
if( $the_new_image['size'] > wp_max_upload_size() )
	die( 'It is too large than expected.' );
 
if( !in_array( $new_file_mime, get_allowed_mime_types() ) )
	die( 'WordPress doesn\'t allow this type of uploads.' );
 
while( file_exists( $new_file_path ) ) {
	$i++;
	$new_file_path = $wordpress_upload_dir['path'] . '/' . $i . '_' . $the_new_image['name'];
}
 
// looks like everything is OK
if( move_uploaded_file( $the_new_image['tmp_name'], $new_file_path ) ) {
 
 
	$upload_id = wp_insert_attachment( array(
		'guid'           => $new_file_path, 
		'post_mime_type' => $new_file_mime,
		'post_title'     => preg_replace( '/\.[^.]+$/', '', $the_new_image['name'] ),
		'post_content'   => '',
		'post_status'    => 'inherit'
	), $new_file_path );
 
	// wp_generate_attachment_metadata() won't work if you do not include this file
	require_once( ABSPATH . 'wp-admin/includes/image.php' );
 
	// Generate and save the attachment metas into the database
	wp_update_attachment_metadata( $upload_id, wp_generate_attachment_metadata( $upload_id, $new_file_path ) );
	
	
	$attachment_metadata=wp_get_attachment_metadata($upload_id);
	//print_r($attachment_metadata);
	$array_formats_new=array();
	foreach($attachment_metadata['sizes'] as $format=>$array_info):
			$array_formats_new[]=array($format,$wordpress_upload_dir['url'] . '/' . basename( $array_info['file'] ));
			//echo $format.":".$wordpress_upload_dir['url'] . '/' . basename( $array_info['file'] )  .'<br>';	
	endforeach;
	$array_formats_new[]=array('original',$wordpress_upload_dir['url'] . '/' . basename( $attachment_metadata['file']  ));
	
	echo json_encode($array_formats_new);
 
}else echo "File upload ERROR";