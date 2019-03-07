<?php
/*
  Template Name: Page profile update
 */
?>
<?php
get_header();
global $gateway, $pmpro_review, $skip_account_fields, $pmpro_paypal_token, $wpdb, $current_user, $pmpro_msg, $pmpro_msgt, $pmpro_requirebilling, $pmpro_level, $pmpro_levels, $tospage, $pmpro_show_discount_code, $pmpro_error_fields, $wpdb;
global $discount_code, $username, $password, $password2, $bfirstname, $blastname, $baddress1, $baddress2, $bcity, $bstate, $bzipcode, $bcountry, $bphone, $bemail, $bconfirmemail, $CardType, $AccountNumber, $ExpirationMonth, $ExpirationYear, $pmpro_countries;
?>
<main id="main" role="main">

    <div class="pmpro-edit-profile">
        <div class="container alt content-area">
            <div class="profile-section">
                <?php
                $user_id = $current_user->ID;
                $first_name = get_user_meta($user_id, 'first_name', true);
                $last_name = get_user_meta($user_id, "last_name", true);
                $email = $current_user->user_email;
                $pmpro_baddress1 = get_user_meta($user_id, "pmpro_baddress1", true);
                $pmpro_baddress2 = get_user_meta($user_id, "pmpro_baddress2", true);
                $pmpro_bcity = get_user_meta($user_id, "pmpro_bcity", true);
                $pmpro_bstate = get_user_meta($user_id, "pmpro_bstate", true);
                $pmpro_bzipcode = get_user_meta($user_id, "pmpro_bzipcode", true);
                $pmpro_bcountry = get_user_meta($user_id, "pmpro_bcountry", true);
                $pmpro_bphone = get_user_meta($user_id, "pmpro_bphone", true);

                $pmpro_aa_firstname = get_user_meta($user_id, 'pmpro_aa_firstname', true);
                $pmpro_aa_lastname = get_user_meta($user_id, 'pmpro_aa_lastname', true);
                $pmpro_aa_emailaddress = get_user_meta($user_id, 'pmpro_aa_emailaddress', true);
                $pmpro_aa_phonenumber = get_user_meta($user_id, 'pmpro_aa_phonenumber', true);
                $pmpro_aa_address1 = get_user_meta($user_id, 'pmpro_aa_address1', true);
                $pmpro_aa_city = get_user_meta($user_id, 'pmpro_aa_city', true);
                $pmpro_aa_state = get_user_meta($user_id, 'pmpro_aa_state', true);
                $pmpro_aa_zipcode = get_user_meta($user_id, 'pmpro_aa_zipcode', true);
                ?>
                <div class="col" style="padding-right: 0px; margin: 0 auto;">                
                    <form action="#" class="register-form" id="am_update_profile_form" method="post">
                        <label class="ajax_message" style="display: none;"></label>
                        <input id="user_id" name="user_id" type="hidden" class="input" size="30" value="<?php echo $user_id; ?>" />
                        <input type="hidden" name="action" value="am_update_user_profile" />
                        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('ajax-nonce'); ?>" />
                        <div class="col-holder col-holder-v2">
                            <div class="edit-profile-cols bb-edit-profile-cols">
                                <div class="open-close active">
                                    <a class="opener" href="#">Personal Details</a>
                                    <div class="slide">
                                        <div class="form-row valid-field half-col">
                                            <label for="first_name"><?php _e('First Name', 'pmpro'); ?>*</label>
                                            <input id="first_name" name="first_name" type="text" class="input" size="30" value="<?php echo esc_attr($first_name) ?>" />
                                        </div>
                                        <div class="form-row valid-field half-col last">
                                            <label for="last_name"><?php _e('Last Name', 'pmpro'); ?>*</label>
                                            <input id="last_name" name="last_name" type="text" class="input" size="30" value="<?php echo esc_attr($last_name) ?>" />
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-row valid-field">
                                            <label for="email"><?php _e('Email Address', 'pmpro'); ?>*</label>
                                            <input id="email" name="email" type="text" class="input"  value="<?php echo esc_attr($email) ?>" />
                                        </div>                                    
                                        <div class="form-row valid-field">
                                            <label for="password"><?php _e('New Password', 'pmpro'); ?></label>
                                            <input id="password" name="password" type="password" class="input"  value="" />
                                        </div>

                                        <div class="form-row valid-field">
                                            <label for="password2"><?php _e('Confirm Password', 'pmpro'); ?></label>
                                            <input id="password2" name="password2" type="password" class="input"  value="" />
                                        </div>                                    
                                    </div>
                                </div>

                                <div class="open-close active">
                                    <a class="opener" href="#">Address</a>
                                    <div class="slide">                                    
                                        <div class="form-row valid-field half-col">
                                            <label for="pmpro_baddress1">Address 1&nbsp;*</label>
                                            <input id="pmpro_baddress1" name="pmpro_baddress1" class="input" size="30" placeholder="Address 1" value="<?php echo esc_attr($pmpro_baddress1); ?>" type="text">
                                        </div>
                                        <div class="form-row valid-field half-col last">
                                            <label for="pmpro_baddress2">Address 2&nbsp;</label>
                                            <input id="pmpro_baddress2" name="pmpro_baddress2" class="input" size="30" placeholder="Address 2" value="<?php echo esc_attr($pmpro_baddress2); ?>" type="text">
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-row valid-field half-col">
                                            <label for="pmpro_bcity">City&nbsp;*</label>
                                            <input id="pmpro_bcity" name="pmpro_bcity" class="input" size="30" placeholder="City" value="<?php echo esc_attr($pmpro_bcity); ?>" type="text">
                                        </div>
                                        <div class="form-row valid-field half-col last">
                                            <label for="pmpro_bstate">State&nbsp;*</label>
                                            <input id="pmpro_bstate" name="pmpro_bstate" class="input" size="30" placeholder="State" value="<?php echo esc_attr($pmpro_bstate); ?>" type="text">
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-row valid-field half-col">
                                            <label for="pmpro_bzipcode">Postal Code&nbsp;*</label>
                                            <input id="pmpro_bzipcode" name="pmpro_bzipcode" class="input" size="30" placeholder="Postal Code" value="<?php echo esc_attr($pmpro_bzipcode); ?>" type="text">
                                        </div>
                                        <div class="form-row valid-field half-col last">
                                            <label for="pmpro_bcountry">Country&nbsp;*</label>
                                            <select name="pmpro_bcountry" id="pmpro_bcountry">
                                                <?php $options = array("" => "Select Country", "AF" => "Afghanistan", "AL" => "Albania", "DZ" => "Algeria", "AS" => "American Samoa", "AD" => "Andorra", "AO" => "Angola", "AI" => "Anguilla", "AQ" => "Antarctica", "AG" => "Antigua and Barbuda", "AR" => "Argentina", "AM" => "Armenia", "AW" => "Aruba", "AU" => "Australia", "AT" => "Austria", "AZ" => "Azerbaijan", "BS" => "Bahamas", "BH" => "Bahrain", "BD" => "Bangladesh", "BB" => "Barbados", "BY" => "Belarus", "BE" => "Belgium", "BZ" => "Belize", "BJ" => "Benin", "BM" => "Bermuda", "BT" => "Bhutan", "BO" => "Bolivia", "BA" => "Bosnia and Herzegovina", "BW" => "Botswana", "BV" => "Bouvet Island", "BR" => "Brazil", "BQ" => "British Antarctic Territory", "IO" => "British Indian Ocean Territory", "VG" => "British Virgin Islands", "BN" => "Brunei", "BG" => "Bulgaria", "BF" => "Burkina Faso", "BI" => "Burundi", "KH" => "Cambodia", "CM" => "Cameroon", "CA" => "Canada", "CT" => "Canton and Enderbury Islands", "CV" => "Cape Verde", "KY" => "Cayman Islands", "CF" => "Central African Republic", "TD" => "Chad", "CL" => "Chile", "CN" => "China", "CX" => "Christmas Island", "CC" => "Cocos [Keeling] Islands", "CO" => "Colombia", "KM" => "Comoros", "CG" => "Congo - Brazzaville", "CD" => "Congo - Kinshasa", "CK" => "Cook Islands", "CR" => "Costa Rica", "HR" => "Croatia", "CU" => "Cuba", "CY" => "Cyprus", "CZ" => "Czech Republic", "CI" => "Côte d’Ivoire", "DK" => "Denmark", "DJ" => "Djibouti", "DM" => "Dominica", "DO" => "Dominican Republic", "NQ" => "Dronning Maud Land", "DD" => "East Germany", "EC" => "Ecuador", "EG" => "Egypt", "SV" => "El Salvador", "GQ" => "Equatorial Guinea", "ER" => "Eritrea", "EE" => "Estonia", "ET" => "Ethiopia", "FK" => "Falkland Islands", "FO" => "Faroe Islands", "FJ" => "Fiji", "FI" => "Finland", "FR" => "France", "GF" => "French Guiana", "PF" => "French Polynesia", "TF" => "French Southern Territories", "FQ" => "French Southern and Antarctic Territories", "GA" => "Gabon", "GM" => "Gambia", "GE" => "Georgia", "DE" => "Germany", "GH" => "Ghana", "GI" => "Gibraltar", "GR" => "Greece", "GL" => "Greenland", "GD" => "Grenada", "GP" => "Guadeloupe", "GU" => "Guam", "GT" => "Guatemala", "GG" => "Guernsey", "GN" => "Guinea", "GW" => "Guinea-Bissau", "GY" => "Guyana", "HT" => "Haiti", "HM" => "Heard Island and McDonald Islands", "HN" => "Honduras", "HK" => "Hong Kong SAR China", "HU" => "Hungary", "IS" => "Iceland", "IN" => "India", "ID" => "Indonesia", "IR" => "Iran", "IQ" => "Iraq", "IE" => "Ireland", "IM" => "Isle of Man", "IL" => "Israel", "IT" => "Italy", "JM" => "Jamaica", "JP" => "Japan", "JE" => "Jersey", "JT" => "Johnston Island", "JO" => "Jordan", "KZ" => "Kazakhstan", "KE" => "Kenya", "KI" => "Kiribati", "KW" => "Kuwait", "KG" => "Kyrgyzstan", "LA" => "Laos", "LV" => "Latvia", "LB" => "Lebanon", "LS" => "Lesotho", "LR" => "Liberia", "LY" => "Libya", "LI" => "Liechtenstein", "LT" => "Lithuania", "LU" => "Luxembourg", "MO" => "Macau SAR China", "MK" => "Macedonia", "MG" => "Madagascar", "MW" => "Malawi", "MY" => "Malaysia", "MV" => "Maldives", "ML" => "Mali", "MT" => "Malta", "MH" => "Marshall Islands", "MQ" => "Martinique", "MR" => "Mauritania", "MU" => "Mauritius", "YT" => "Mayotte", "FX" => "Metropolitan France", "MX" => "Mexico", "FM" => "Micronesia", "MI" => "Midway Islands", "MD" => "Moldova", "MC" => "Monaco", "MN" => "Mongolia", "ME" => "Montenegro", "MS" => "Montserrat", "MA" => "Morocco", "MZ" => "Mozambique", "MM" => "Myanmar [Burma]", "NA" => "Namibia", "NR" => "Nauru", "NP" => "Nepal", "NL" => "Netherlands", "AN" => "Netherlands Antilles", "NT" => "Neutral Zone", "NC" => "New Caledonia", "NZ" => "New Zealand", "NI" => "Nicaragua", "NE" => "Niger", "NG" => "Nigeria", "NU" => "Niue", "NF" => "Norfolk Island", "KP" => "North Korea", "VD" => "North Vietnam", "MP" => "Northern Mariana Islands", "NO" => "Norway", "OM" => "Oman", "PC" => "Pacific Islands Trust Territory", "PK" => "Pakistan", "PW" => "Palau", "PS" => "Palestinian Territories", "PA" => "Panama", "PZ" => "Panama Canal Zone", "PG" => "Papua New Guinea", "PY" => "Paraguay", "YD" => "People's Democratic Republic of Yemen", "PE" => "Peru", "PH" => "Philippines", "PN" => "Pitcairn Islands", "PL" => "Poland", "PT" => "Portugal", "PR" => "Puerto Rico", "QA" => "Qatar", "RO" => "Romania", "RU" => "Russia", "RW" => "Rwanda", "RE" => "Réunion", "BL" => "Saint Barthélemy", "SH" => "Saint Helena", "KN" => "Saint Kitts and Nevis", "LC" => "Saint Lucia", "MF" => "Saint Martin", "PM" => "Saint Pierre and Miquelon", "VC" => "Saint Vincent and the Grenadines", "WS" => "Samoa", "SM" => "San Marino", "SA" => "Saudi Arabia", "SN" => "Senegal", "RS" => "Serbia", "CS" => "Serbia and Montenegro", "SC" => "Seychelles", "SL" => "Sierra Leone", "SG" => "Singapore", "SK" => "Slovakia", "SI" => "Slovenia", "SB" => "Solomon Islands", "SO" => "Somalia", "ZA" => "South Africa", "GS" => "South Georgia and the South Sandwich Islands", "KR" => "South Korea", "ES" => "Spain", "LK" => "Sri Lanka", "SD" => "Sudan", "SR" => "Suriname", "SJ" => "Svalbard and Jan Mayen", "SZ" => "Swaziland", "SE" => "Sweden", "CH" => "Switzerland", "SY" => "Syria", "ST" => "São Tomé and Príncipe", "TW" => "Taiwan", "TJ" => "Tajikistan", "TZ" => "Tanzania", "TH" => "Thailand", "TL" => "Timor-Leste", "TG" => "Togo", "TK" => "Tokelau", "TO" => "Tonga", "TT" => "Trinidad and Tobago", "TN" => "Tunisia", "TR" => "Turkey", "TM" => "Turkmenistan", "TC" => "Turks and Caicos Islands", "TV" => "Tuvalu", "UM" => "U.S. Minor Outlying Islands", "PU" => "U.S. Miscellaneous Pacific Islands", "VI" => "U.S. Virgin Islands", "UG" => "Uganda", "UA" => "Ukraine", "SU" => "Union of Soviet Socialist Republics", "AE" => "United Arab Emirates", "GB" => "United Kingdom", "US" => "United States", "ZZ" => "Unknown or Invalid Region", "UY" => "Uruguay", "UZ" => "Uzbekistan", "VU" => "Vanuatu", "VA" => "Vatican City", "VE" => "Venezuela", "VN" => "Vietnam", "WK" => "Wake Island", "WF" => "Wallis and Futuna", "EH" => "Western Sahara", "YE" => "Yemen", "ZM" => "Zambia", "ZW" => "Zimbabwe", "AX" => "Åland Islands"); ?>
                                                <?php foreach ($options as $key => $option) { ?>
                                                    <option value="<?php echo esc_attr($key); ?>" <?php selected($pmpro_bcountry, $key, true); ?>><?php echo $option; ?></option>
                                                <?php } ?>                            
                                            </select>                     
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-row valid-field">
                                            <label for="pmpro_bphone">Phone&nbsp;*</label>
                                            <input id="pmpro_bphone" name="pmpro_bphone" class="input" size="30" placeholder="Phone" value="<?php echo esc_attr($pmpro_bphone); ?>" type="text">
                                        </div>
                                    </div>
                                    <?php if ($pmpro_level->id == 4) { ?>
                                        <button type="submit" id="update_profile" class="btn btn-alt">Update Profile</button>
                                    <?php } ?>        
                                </div>
                            </div>
                            <h2>Administrator Details</h2>
                            <p class="details-paragraph">Please provide us with a trusted person to gain administrative control of your account if you are no longer able to be the administrator.</p>
                            <?php //if ($pmpro_level->id != 4) { ?>
                                <div class="edit-profile-cols aa-edit-profile-cols">
                                    <div class="open-close active">
                                        <a class="opener" href="#">Administrator Details</a>
                                        <div class="slide">
                                            <div class="form-row valid-field half-col">
                                                <label for="pmpro_aa_firstname"><?php _e('First Name', 'pmpro'); ?></label>
                                                <input id="pmpro_aa_firstname" name="pmpro_aa_firstname" type="text" class="input" size="30" value="<?php echo esc_attr($pmpro_aa_firstname) ?>" />
                                            </div>
                                            <div class="form-row valid-field half-col last">
                                                <label for="pmpro_aa_lastname"><?php _e('Last Name', 'pmpro'); ?></label>
                                                <input id="pmpro_aa_lastname" name="pmpro_aa_lastname" type="text" class="input" size="30" value="<?php echo esc_attr($pmpro_aa_lastname) ?>" />
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="form-row valid-field">
                                                <label for="pmpro_aa_emailaddress"><?php _e('Email Address', 'pmpro'); ?></label>
                                                <input id="pmpro_aa_emailaddress" name="pmpro_aa_emailaddress" type="text" class="input"  value="<?php echo esc_attr($pmpro_aa_emailaddress) ?>" />
                                            </div>                                    
                                            <div class="form-row valid-field">
                                                <label for="pmpro_aa_phonenumber"><?php _e('Phone Number', 'pmpro'); ?></label>
                                                <input id="pmpro_aa_phonenumber" name="pmpro_aa_phonenumber" type="text" class="input"  value="<?php echo esc_attr($pmpro_aa_phonenumber) ?>" />
                                            </div>                                           
                                        </div>
                                    </div>

                                    <div class="open-close active">
                                        <a class="opener" href="#">Administrator Address</a>
                                        <div class="slide">                                    
                                            <div class="form-row valid-field half-col">
                                                <label for="pmpro_aa_address1">Address 1&nbsp;</label>
                                                <input id="pmpro_aa_address1" name="pmpro_aa_address1" class="input" size="30" placeholder="Address 1" value="<?php echo esc_attr($pmpro_aa_address1); ?>" type="text">
                                            </div>
                                            <div class="form-row valid-field half-col last">
                                                <label for="pmpro_baddress2">Address 2&nbsp;</label>
                                                <input id="pmpro_baddress2" name="pmpro_baddress2" class="input" size="30" placeholder="Address 2" value="<?php echo esc_attr($pmpro_baddress2); ?>" type="text">
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="form-row valid-field half-col">
                                                <label for="pmpro_aa_city">City&nbsp;</label>
                                                <input id="pmpro_aa_city" name="pmpro_aa_city" class="input" size="30" placeholder="City" value="<?php echo esc_attr($pmpro_aa_city); ?>" type="text">
                                            </div>
                                            <div class="form-row valid-field half-col last">
                                                <label for="pmpro_aa_state">State&nbsp;</label>
                                                <input id="pmpro_aa_state" name="pmpro_aa_state" class="input" size="30" placeholder="State" value="<?php echo esc_attr($pmpro_aa_state); ?>" type="text">
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="form-row valid-field half-col">
                                                <label for="pmpro_aa_zipcode">Zip Code&nbsp;</label>
                                                <input id="pmpro_aa_zipcode" name="pmpro_aa_zipcode" class="input" size="30" placeholder="Postal Code" value="<?php echo esc_attr($pmpro_aa_zipcode); ?>" type="text">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <button type="submit" id="update_profile" class="btn btn-alt">Update Profile</button>
                                    </div>
                                </div>
                            <?php //} ?>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <?php get_footer(); ?>