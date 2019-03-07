<?php
/* Plugin Name: CSS Hero
Plugin URI: https://www.csshero.org
Description: A live WordPress Theme editor that works without modifying any of your theme files. Very low performance footprint: only generates and adds a single static  CSS file to your site.
Version: 3.42
Author: The CSS Hero Team
Author URI: https://www.csshero.org
License: Commercial
*/ 

require_once ("storage_engine.php");

//enable css uploads 
add_filter('upload_mimes', 'csshero_enable_extended_upload');
function csshero_enable_extended_upload ( $mime_types =array() ) {  $mime_types['css']  = 'text/css'; return $mime_types;}

//add launch trigger/icon styles
add_action( 'admin_head', 'csshero_print_launch_icon_styles' ); // on backend area
add_action( 'wp_head', 'csshero_print_launch_icon_styles' ); // on frontend area
function csshero_print_launch_icon_styles(){
	if(!is_user_logged_in() OR !current_user_can('edit_theme_options')) return;
	?>
	<style>
		#csshero-icon-launch-editing:before { content: '\f464'; top: 5px; position: relative; font: 400 20px/1 dashicons; speak: none; padding: 0 0; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; background-image: none!important; margin-right: 5px; }
	</style>
	<?php
}

// Place in admin menu a launch/trigger link
add_action('admin_bar_menu', 'csshero_add_toolbar_items', 100);
function csshero_add_toolbar_items($admin_bar){
	if ( !current_user_can('edit_theme_options') OR !wpcss_check_license()  	) return;
	
	$admin_bar->add_menu( array(
								'id'    => 'wpcss-css-hero-go',
								'title' => '<span id="csshero-icon-launch-editing"> </span>'.'Customize with CSS Hero',
								'href'  => csshero_get_trigger_url() 
							));
}

function csshero_get_trigger_url() {
	$the_url=get_bloginfo('wpurl');
	if(is_admin() && isset($_GET['post']) && is_numeric($_GET['post'])) $the_url=get_permalink($_GET['post']);
	if(!is_admin()) { global $wp; $the_url = home_url(add_query_arg(array(),$wp->request)); } //v3 //if (is_singular() ) { global $wp_query; $the_url=get_permalink($wp_query->post->ID); } //v2 //if (is_singular() && isset($_GET['p']) )	$the_url=get_permalink($_GET['p']); //old v1
	return esc_url(add_query_arg(array( 'csshero_action'=>'edit_page', 'rand'=> (rand(0,1024)) ), $the_url ) );
}

function csshero_get_active_theme_slug(){ $theme_name = wp_get_theme(); return sanitize_title($theme_name);}

//////////// SAVE CURRENT STATE /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_csshero_save_state', 'csshero_ajax_save_state_func' );
function csshero_ajax_save_state_func() {
	
	if (!current_user_can("edit_pages")) return;
	if ( empty($_POST)  or  !wp_verify_nonce($_POST['csshero_saving_nonce_field'],'csshero_saving_nonce') )  { print 'Sorry, your nonce did not verify.';  exit; }
			
	//GET FROM $_POST CURRENT SETTINGS   
	$csshero_livearray_jsondata = wp_unslash ($_POST['csshero-livearray-saving-field']); 
	
	//DETERMINE A STEP NAME
	if (strlen($csshero_livearray_jsondata)<5 ) $step_name="Theme Reset ".date('h:i:s a m/d/Y', time()); else $step_name=date('h:i:s a m/d/Y', time());
	
	//SAVE TO STORAGE AS  A NEW STEP
	$inserted_step_id=csshero_storage_save_new_step($step_name, $csshero_livearray_jsondata,'frontend-css-step');
	
	//DELETE old static CSS file
	$last_uploaded_css_data=get_option('csshero_static_css_data_'.csshero_get_active_theme_slug());
	if (is_array($last_uploaded_css_data) && isset($last_uploaded_css_data['file']) ) unlink($last_uploaded_css_data['file']);
	
	//SAVE THE CSS  static file. Special note: add $inserted_step_id to CSS file name to invalidate cache violently. Not necessarily recommended
	$uploaded= wp_upload_bits( "csshero-static-style-".csshero_get_active_theme_slug().".css", FALSE, wp_unslash( $_POST['csshero-css-saving-field']) );
	
	if ($uploaded['error']==FALSE) {
		 //echo "<h3>Uploaded ok</h3> File URL : ".$uploaded['url'];
		 $uploaded['relative_upload_path'] = _wp_relative_upload_path( $uploaded['file'] );
		 $uploaded['version']=$inserted_step_id;
		 update_option('csshero_static_css_data_'.csshero_get_active_theme_slug(),$uploaded);
		 echo "Saved";
	 } else {  die ("Error saving CSS file to your uploads directory. ".$uploaded['error']);	}
			
	wp_die();
	 
}


////////////  SAVE AS PRESET /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_csshero_save_preset', 'csshero_ajax_save_preset_func' );
function csshero_ajax_save_preset_func() {
	 
	if (!current_user_can("edit_pages")) return;
	if ( empty($_POST)  or  !wp_verify_nonce($_POST['csshero_saving_nonce_field'],'csshero_saving_nonce') )  { print 'Sorry, your nonce did not verify.';  exit; }

	//GET FROM $_POST CURRENT SETTINGS   
	$csshero_livearray_jsondata = wp_unslash ($_POST['csshero-livearray-saving-field']); 
	//print_r($csshero_livearray_jsondata); //useful for debug
	$the_saving_action=csshero_storage_save_new_step($_POST['csshero_preset_name'], $csshero_livearray_jsondata,'frontend-css-step','preset-step');
	//CONFIRM
	if($the_saving_action) echo "Saved"; else echo "Saving error";
	wp_die();
}




function csshero_handle_actions(){		 		
		
		//HISTORY OR PRESET LIST AJAX LOADING RESULT CASE
		if (  (  current_user_can('edit_theme_options') or   function_exists('chpr_roller_is_allowed_to_all') ) && isset($_GET['csshero_action']) && $_GET['csshero_action']=='list_saved_snapshots' && isset($_GET['snapshot_type']) ) 
		
		{
		  $csshero_steps_array=csshero_get_saved_steps('frontend-css-step',$_GET['snapshot_type']);
		  
		  if ($csshero_steps_array)
			{ //list is not empty
			echo '<div id="csshero-old-history-wrap">';
			foreach($csshero_steps_array as $step_element):
				 if ($step_element->step_active_flag=='yes' ) { $activeflag="csshero-active-history-element";     } else {$activeflag="csshero-non-active-history-element";}
				 ?>
				 <div class='csshero-step csshero-step-type-old <?php echo $activeflag; ?>' id='csshero-step-id-<?php echo $step_element->step_id ?>' data-csshero-step-id='<?php echo $step_element->step_id ?>'  data-json-load-url='?csshero_action=get_snapshot&step_id=<?php echo $step_element->step_id ?>'>
					<span class="timestamp">
						<?php
						//print the name, if is a preset
						if (  $step_element->step_type=='preset-step') echo "<b>".$step_element->step_name."</b> ";
						//print the timestamp, formatted
						echo  date("d.m - H:i:s", strtotime($step_element->step_time));
						?>
				 
					</span>
				 </div>
			<?php
			endforeach;
		  
			echo '</div>';
			}
		  else echo "<p style='padding:10px';>None yet.</p>"; //list  is empty
		  
		  die;
		} //END CASE
		
		
		//EDITOR   LOADING FOR DEMO CASE //can be killed in your local install
		if (function_exists('csshero_demo_plugin_is_active')):
			    if (isset($_GET['csshero_action']) && $_GET['csshero_action']=='edit_page')  {require_once('edit-page.php'); exit; }			   
		endif; //END CASE
		
		/////////////////////////ALLOW THE FOLLOWING ACTIONS ONLY FOR LOGGED IN USERS THAT  can edit_theme_options //////////////////////////////////////////////////////////////
		if (!is_user_logged_in() OR !current_user_can('edit_theme_options')  ) return; //quit function if user cannot edit_theme_options
		 
		//IN ADMIN:  reset cookie if gone to wp-admin, forcing stop editing
		if ( is_admin() && csshero_is_editing_page()  ) setcookie('csshero_is_on', 0, time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);

		//DELETE LICENSE
		if ( isset($_GET['wpcss_action']) && $_GET['wpcss_action']=='delete_license') {delete_option('csshero-license');wp_redirect(admin_url()); }
		
		//CHECK LICENSE DEBUG
		if ( isset($_GET['wpcss_action']) && $_GET['wpcss_action']=='check_license') { echo wpcss_check_license(); die; }
		
		///// WRITE CASES //////////
		//IMAGE UPLOAD CASE
		if (isset($_GET['csshero_action']) && $_GET['csshero_action']=='upload_image') {include('image_upload.php');die;}
		/*
		//MAIN SAVE CSSHERO DATA case//////////////////////////////	//////////////////////	//////////////////////																
		if (isset($_POST['wpcss_submit_form'])  && $_POST['wpcss_submit_form']==1  &&  isset($_POST['csshero-livearray-saving-field']))
		  {	
			//SECURITY FIRST
			if ( empty($_POST)  or  !wp_verify_nonce($_POST['csshero_saving_nonce_field'],'csshero_saving_nonce') )  { print '<h1>Sorry, your nonce did not verify.</h1>';  exit; }
					
			//GET FROM $_POST CURRENT SETTINGS   
			$csshero_livearray_jsondata = wp_unslash ($_POST['csshero-livearray-saving-field']); 
			
			//DETERMINE A STEP NAME
			if (strlen($csshero_livearray_jsondata)<5 ) $step_name="Theme Reset ".date('h:i:s a m/d/Y', time()); else $step_name=date('h:i:s a m/d/Y', time());
			
			//SAVE TO STORAGE AS  A NEW STEP
			$inserted_step_id=csshero_storage_save_new_step($step_name, $csshero_livearray_jsondata,'frontend-css-step');
			
			//DELETE old static CSS file
			$last_uploaded_css_data=get_option('csshero_static_css_data_'.csshero_get_active_theme_slug());
			if (is_array($last_uploaded_css_data) && isset($last_uploaded_css_data['file']) ) unlink($last_uploaded_css_data['file']);
			
			//SAVE THE CSS  static file
			$uploaded= wp_upload_bits( "csshero-static-style-".csshero_get_active_theme_slug().".css", FALSE, wp_unslash( $_POST['csshero-css-saving-field']) );
			
			if ($uploaded['error']==FALSE) {
				 //echo "<h3>Uploaded ok</h3> File URL : ".$uploaded['url'];
				 $uploaded['relative_upload_path'] = _wp_relative_upload_path( $uploaded['file'] );
				 $uploaded['version']=$inserted_step_id;
				 update_option('csshero_static_css_data_'.csshero_get_active_theme_slug(),$uploaded);
			 } else {  die ("Error saving CSS file to your uploads directory. ".$uploaded['error']);	}
			 
			//ALL IS SAVED, PRINT STATE
			if ($csshero_livearray_jsondata==csshero_get_data()) die("Saved"); else die("Save JSON Problems");

		  } ///end SAVE CSSHERO DATA case
		*/
		
		//GET A LOCAL PRESET / HISTORY STEP data
		if (isset($_GET['csshero_action']) && $_GET['csshero_action']=='get_snapshot')
		  {
			$step_id=$_GET['step_id'];
			if (!is_numeric($step_id)) die ("<h1>Invalid step id, not numeric!");
			
			echo csshero_get_data($step_id);
			die;
			
		  } //end case

		//DELETE LOCAL PRESET CASE
		if (isset($_GET['csshero_action']) && $_GET['csshero_action']=='delete_snapshot')
		  {
			if (!is_numeric($_GET['step_id'])) die ("<h1>Invalid step id, not numeric!");
			csshero_storage_delete_step($_GET['step_id']);
			die(" &nbsp; Snapshot  deleted.");
		  } //end delete case
				
		//DELETE ALL HISTORY CASE
		if (isset($_GET['csshero_action']) && $_GET['csshero_action']=='delete_history_snapshots')
		  {
			$csshero_history_steps_array=csshero_get_saved_steps('frontend-css-step','history');
			if ($csshero_history_steps_array)
			  foreach($csshero_history_steps_array as $history_element):
					 if ($history_element->step_active_flag!='yes' ) csshero_storage_delete_step($history_element->step_id); 
			  endforeach;
			   
			die("History Snapshots deleted.");
		  }
		/*    
		//SAVE current settings AS PRESET case
		if ( isset($_GET['csshero_action']) && $_GET['csshero_action']=='save_as_snapshot')  {
			
			//GET FROM $_POST CURRENT SETTINGS   
			$csshero_livearray_jsondata = wp_unslash ($_POST['csshero-livearray-saving-field']); 
			//print_r($csshero_livearray_jsondata); //useful for debug
			$the_saving_action=csshero_storage_save_new_step($_POST['csshero_preset_name'], $csshero_livearray_jsondata,'frontend-css-step','preset-step');
			//CONFIRM
			if ($the_saving_action) echo "Preset Saved as ".$_POST['csshero_preset_name'];
			die;
		} //end case
		*/ 
		
		//EDIT PAGE: the editing interface LOADING case
		if (isset($_GET['csshero_action']) && $_GET['csshero_action']=='edit_page')  {require_once('edit-page.php'); exit;}
						
		//CSSHERO SHUTDOWN case	
		if (isset($_GET['csshero_action']) && $_GET['csshero_action'] =="shutdown") {
			setcookie('csshero_is_on', 0, time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			wp_redirect(add_query_arg( array('csshero_action' => false ) ));die;
		}
		
		//WHEN CSSHERO IS ON ELIMINATE WP ADMIN BAR WHEN PERFORMING EDITING ACTIONS
		if (csshero_is_editing_page() ) { add_filter('show_admin_bar', '__return_false'); add_filter( 'edit_post_link', '__return_false' ); }
		
		//VIEW LOGIN PAGE CASE
		if (isset($_GET['csshero_style_wp_login_page'])) {
			$response = wp_remote_get( wp_login_url());
			if ( is_array( $response ) )   echo $response['body'];  else echo "<h1>No response from server</h1>";
			die();
		} //end case
		
		//VIEW PAGE AS UNLOGGED: USEFUL FOR SPECIAL EDITING
		if (isset($_GET['csshero_view_as_unlogged'])) {
			//global $wp;$current_url = home_url( add_query_arg( array(), $wp->request ) ); 
			$current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			//echo $current_url;die;
			$current_url_without_parameter= add_query_arg(array( 'csshero_view_as_unlogged'=>FALSE, 'rand'=> (rand(0,1024)) ), $current_url );
			//fetch the URL
			$response = wp_remote_get( $current_url_without_parameter);
			if ( is_array( $response ) )   echo $response['body'];  else echo "<h1>No response from server</h1>";
			die();
		} //end case
		
	 } //end handle actions func
	 
	 
add_action ('wp_loaded','csshero_handle_actions');
 
 
 
 

function csshero_admin_actions(){
  
		//CHECK IF PRODUCT ACTIVATED, OR SHOW NOTICE
		if (!wpcss_check_license()) add_action( 'admin_notices', 'csshero_activation_notice' );
		
		//GET REMOTE LICENSE
		if ( isset($_GET['wpcss_action']) && $_GET['wpcss_action']=='get_license'&& get_option('wpcss_accept_license')=='yes' && is_user_logged_in()&& current_user_can('edit_theme_options'))
					{ 
									csshero_update_option('csshero-license',$_GET['license_key']);
			
									delete_option('wpcss_accept_license');
															
									$license=wpcss_check_license();
									if ($license!=FALSE) { ?>
													  <body style="padding: 0; margin: 0; background: #f0f4f3;">
													  <div style="margin: 0; padding:10px 100px; ">	 
															
																<img src="https://www.csshero.org/production-v3/activation-img/new_courtesy_page.png" alt="CSS Hero Activated" style="display:block; margin: 0 auto; max-width:600px" />														
																
																<a href="<?php echo esc_url(admin_url()) ?>">
																<img src="https://www.csshero.org/production-v3/activation-img/new_courtesy_btn.png" alt="CSS Hero Activated" style="display:block; margin: 20px auto 0; max-width:190px" />
															</a>			
													  </div>
													</body>	
														<?php die;
							}
									
									else {
												$redirect_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
												$redirect_url_array=explode('?',$redirect_url);
												$redirect_url=$redirect_url_array[0];
												wp_redirect($redirect_url.'/?wpcss_message=activation_invalid');
										  }
									
										die;
										
					}
									
		 
		 
} //end func
 
add_action( 'admin_init', 'csshero_admin_actions', 1 );
 
   

function csshero_activation_notice() {
	csshero_update_option('wpcss_accept_license','yes');
 	$data=array( 'admin_url'=>admin_url(), 'url' => get_bloginfo('wpurl'), 'email' => get_bloginfo('admin_email'),'product'=>'CSSHEROv3');
	$encoded_data= rawurlencode( base64_encode( serialize($data)));
    ?>
    <div class="updated">
			<h1> Welcome to CSS Hero!</h1>
			<p> Let's activate your product. It's fast and easy. </p>
			<p> Click the button below and let's go.</p>
			<p> <a id="csshero-get-license-button" class="button button-primary button-hero " href="#">Proceed to Product Activation</a></p>
    </div>
	<script>
		var remote_activation_url = "https://www.csshero.org/request-license/?v=2&data=<?php echo $encoded_data ?>&admin_url_js_btoa=" + encodeURIComponent(btoa(window.location));
		document.getElementById('csshero-get-license-button').setAttribute("href",remote_activation_url);
	</script>
    <?php
}
 
function csshero_get_style_url() {
	$wp_upload_dir=wp_upload_dir();
	$last_uploaded_css_data=get_option('csshero_static_css_data_'.csshero_get_active_theme_slug());
	if (is_array($last_uploaded_css_data) && isset($last_uploaded_css_data['relative_upload_path']) ) {
		return $wp_upload_dir['baseurl'] .'/'.$last_uploaded_css_data['relative_upload_path'];
		//classic alernative: return ($last_uploaded_css_data['url']);
		}
	else return $wp_upload_dir['baseurl'] .'/no-css-saved-yet.css';
}

function csshero_get_style_version() {
	$last_uploaded_css_data=get_option('csshero_static_css_data_'.csshero_get_active_theme_slug());
	if (is_array($last_uploaded_css_data) && isset($last_uploaded_css_data['version']) )  return $last_uploaded_css_data['version']; else return FALSE;
}

function csshero_is_editing_page() {
	if(!is_user_logged_in() OR !current_user_can('edit_theme_options')) return FALSE;
	return (isset($_COOKIE['csshero_is_on']) && $_COOKIE['csshero_is_on']==1);
}

function csshero_animations_are_currently_used(){
	$csshero_status_object = json_decode(csshero_get_data());
	if (!isset($csshero_status_object->animations)) return FALSE;
	$csshero_animations_object=$csshero_status_object->animations;
	return (count((array)$csshero_animations_object,COUNT_RECURSIVE)>0);
}

///ADD HEADER SCRIPTS
//add_action('wp_enqueue_scripts', 'csshero_add_scripts');  
add_action('wp_print_styles', 'csshero_add_scripts'); //load'em later
function csshero_add_scripts() {
	
	wp_register_style( 'csshero-main-stylesheet', csshero_get_style_url(), array(), csshero_get_style_version());
	wp_enqueue_style( 'csshero-main-stylesheet' );
	
	// ANIMATIONS LIB
	if ( csshero_is_editing_page() OR csshero_animations_are_currently_used() ):
		wp_enqueue_script('csshero_aos', plugins_url('/js/aos.js', __FILE__));
		wp_register_style('csshero-aos-stylesheet', plugins_url('/styles/aos.css',__FILE__), array(),444);
		wp_enqueue_style('csshero-aos-stylesheet' );
		wp_enqueue_script('csshero_aos-trigger', plugins_url('/js/aos-trigger.js', __FILE__));
	endif;
}

//ADD INLINE ANIMATOR DATA
add_action('wp_head', 'csshero_add_header_code');
function csshero_add_header_code(){
	if (!csshero_animations_are_currently_used()) return; //only if we have data
	?>
	<script>
			csshero_animations_json='<?php
			$csshero_status_object= json_decode(csshero_get_data());
			$csshero_animations_object=$csshero_status_object->animations;
			echo json_encode($csshero_animations_object);
			?>';
	</script>
	<?php
};


///ADD THE CSS TO THE LOGIN PAGE
function csshero_add_login_page_css() {
	wp_register_style( 'csshero-main-stylesheet', csshero_get_style_url(), array(), csshero_get_style_version()); 
    wp_enqueue_style( 'csshero-main-stylesheet');//, get_template_directory_uri() . '/css/admin.css', array(), filemtime( get_template_directory() . '/css/admin.css' ) );
}
add_action( 'login_enqueue_scripts', 'csshero_add_login_page_css', 10 );


  
function wpcss_check_license(){
	$license= get_option('csshero-license');
	if ($license !=FALSE && strlen($license)>10) return $license; else return FALSE;
}

//  STYLE THE upload ADMIN AREA
function csshero_custom_upload_style() {
      echo '<style type="text/css">
       							.ml-submit, .theme-layouts-post-layout, tr.post_title , tr.align , tr.image_alt, tr.post_excerpt, tr.post_content ,tr.url{display:none}
						  		td.savesend{text-align: right;}
						  		tr.submit .savesend input:hover,
						  		tr.submit .savesend input {background: url(http://www.csshero.org/csshero-nano-service/assets/img/esprit.png) no-repeat 0px -862px; height: 70px !important; z-index:999;border: 0px;padding:0px;width: 208px;border-radius: 0px;-moz-border-radius: 0px;-webkit-border-radius: 0px; text-indent: -9999px;}
						  		#media-upload a.del-link:active,
						  		tr.submit .savesend input:active{position: relative; top: 1px;}
								
								#media-upload a.del-link:hover,
								#media-upload a.del-link{height: 70px; width: 101px; background: url(http://www.csshero.org/csshero-nano-service/assets/img/esprit.png) no-repeat -208px -862px; display: inline-block; float: right; margin: 0px 2px 0px 10px; text-indent: 999px;}
								
								
								tr.submit{border-top: 1px solid #dfdfdf;}
								tr.submit .savesend{padding-top: 15px;}
								
								div#media-upload-header{padding: 0px; border: 0px; background: #222; position: fixed; top: 0px; left: 0px; width: 100%; height: 48px; z-index: 9999;}
								#sidemenu a.current {padding-left: 20px; padding-right: 20px; font-weight: normal; text-decoration: none; background: #3e7cff; color: white;-webkit-border-top-left-radius: 0px;-webkit-border-top-right-radius: 0px;border-top-left-radius: 0px;border-top-right-radius: 0px;border-width: 0px;}
								#sidemenu a{padding: 10px 20px; border: 0px; background: transparent; color: white; font-size: 10px; text-transform: uppercase;}
								body#media-upload{padding-top: 50px; background: #f5f5f5; height: 100%;}
								body#media-upload ul#sidemenu{bottom: 0; margin: 0px; padding: 0px;}
								#sidemenu a:hover{background:#222;}
								h3.media-title{font-family: sans-serif; font-size: 10px; font-weight: bold; text-transform: uppercase;}
								h3.media-title,.upload-flash-bypass,.max-upload-size{display: block;text-align: center;}
								.upload-flash-bypass{margin-top: 20px;}
								.max-upload-size{margin-bottom: 20px;}
								#sidemenu li#tab-type_url,
								#sidemenu li#tab-grabber{display: none;}
         </style>';
}

if (isset($_GET['csshero_upload']) && $_GET['csshero_upload']==1) add_action('admin_head', 'csshero_custom_upload_style');

function csshero_get_active_site_plugins() {
	$out="";
	$the_plugs = get_option('active_plugins'); 
	
    if ($the_plugs) foreach($the_plugs as $key => $value) {
        $string = explode('/',$value); // Folder name will be displayed
        $out.=$string[0] .',';
    }
	
	 $the_network_plugs=get_site_option('active_sitewide_plugins');
 
	 if ($the_network_plugs)  foreach($the_network_plugs as $key => $value) {
        $string = explode('/',$key); // Folder name will be displayed
        $out.=$string[0] .',';
    }
    return $out;
}

 
function csshero_update_option($option_name,$new_value)
{
		  if ( get_option( $option_name ) !== false ) {		  
			  // The option already exists, so we just update it.
			  update_option( $option_name, $new_value );
		  
		  } else {
			  // The option hasn't been added yet. We'll add it with $autoload set to 'no'.
			  $deprecated = null;
			  $autoload = 'no';
			  add_option( $option_name, $new_value, $deprecated, $autoload );
		  }
}
 

//////////////////////////////RSS FEED UPDATES BOX ///////////////////
function csshero_register_widgets() {
	global $wp_meta_boxes;
	if (get_option('wpcss_hidedashnews')!=1)
	    wp_add_dashboard_widget('widget_cssheronews', __('From  the  CSS Hero world', 'csshero'), 'csshero_create_rss_box');
}
add_action('wp_dashboard_setup', 'csshero_register_widgets');

function csshero_make_url_https ($string) { return str_replace('http://','https://',$string); }
function csshero_create_rss_box() {
	
	// Get RSS Feed(s)
	include_once(ABSPATH . WPINC . '/feed.php');
	$rss = fetch_feed( 'https://www.csshero.org/feed/' );
	if (!is_wp_error( $rss ) ) : // Checks that the object is created correctly 
		// Figure out how many total items there are, and choose a limit 
		$maxitems = $rss->get_item_quantity( 3 ); 
		// Build an array of all the items, starting with element 0 (first element).
		$rss_items = $rss->get_items( 0, $maxitems ); 
		$rss_title = '<a href="'.$rss->get_permalink().'" target="_blank">'.strtoupper( $rss->get_title() ).'</a>'; 
	endif;
	?>
	<style>
		#csshero-blog-feed img { margin: 0 auto;display: block; } #csshero-blog-feed li {border-bottom: 1px solid #ccc;} #csshero-blog-feed li p:nth-of-type(2) {display: none;}
	</style>
	<?php 
	echo '<div class="rss-widget" id="csshero-blog-feed">';
	//echo '<strong>'.$rss_title.'</strong>';
	echo "<img style='float:left; margin:0 5px' src='https://www.csshero.org/wp-content/uploads/2015/05/diamond.jpg' width='64' height='64' /> <strong>Start earning now! Become a CSS Hero affiliate</strong><br />Earn 40% on each sale right now. Spread the CSS Hero word and share the wealth with us! </p>
		<a target='_blank' href='https://www.csshero.org/affiliate/' style='float:right' class='button button-primary'>Start Earning</a>
		<div style='clear:both'></div>
		<hr style='border: 0; background-color: #DFDFDF; height: 1px;'>
		<strong>Latest News</strong>
		<ul>";
	if ( $maxitems == 0 ) {
		echo '<li>'.__( 'No item', 'rc_mdm').'.</li>';
	} else { 
		foreach ( $rss_items as $item ) :
			$item_date = human_time_diff( $item->get_date('U'), current_time('timestamp')).' '.__( 'ago', 'rc_mdm' );
			echo '<li> <a href="'.esc_url( $item->get_permalink() ).'" title="'.$item_date.'">'. esc_html( $item->get_title() ). '</a>  <span class="rss-date">'.$item_date.'</span><br />'.csshero_make_url_https( $item->get_content()).'</li>';
		endforeach;
	}
	echo '</ul> </div>';

	
}


///NEXTGEN GALLERY FIX
add_filter('run_ngg_resource_manager',  'wpcss_check_csshero_editpage' );
function wpcss_check_csshero_editpage($valid_request) {    if (!empty($_GET['csshero_action'])) $valid_request = FALSE; return $valid_request; }



//end main csshero file, never close php :)