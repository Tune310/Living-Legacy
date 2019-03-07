<?php
/*
Template Name: Login
Template Post Type: page
*/

?>
<?php get_header(); ?>
<div id="content" class="container">
<?php if ( is_user_logged_in () ) {
            $user = wp_get_current_user();
            
    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <header class="entry-header">
                                <?php // the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                                <?php // twentyseventeen_edit_link( get_the_ID() ); ?>
                        </header><!-- .entry-header -->
                        <div class="user-toolbar">
                                <div id="user-hover">
                                        <?php
                                        $current_user = wp_get_current_user();
                                        $current_user_data = get_userdata($current_user->ID);
                                        $display_name = $current_user_data->display_name;
                                        $gravtar = get_avatar( $current_user->ID, 32 );
                                        $class = '';
                                        if ( !$gravtar ) {
                                                $class = 'avatar';
                                        }
                                        ?>
                                        <span class="<?php echo $class; ?>">
                                        <?php
                                        if ( $gravtar ) {
                                                echo $gravtar;
                                        }
                                        else {
                                                echo ucfirst( substr( $display_name, 0, 1 ) );
                                        }
                                        ?></span>
                                        <span class="name"><?php echo ucfirst($display_name);?></span>
                                        <div id="user-menu">
                                                <?php if ( is_user_logged_in() ) : ?>
                                                <ul>
                                                        <?php $current_user = wp_get_current_user(); ?>
                                                        <li><span><?php echo $current_user->user_email; ?></span></li>
                                                        <a id="legacy-user-logout" href="#!">
                                                            <span class="text">Logout</span>
                                                        </a><br/>
                                                        <a id="" href="<?php echo get_permalink(get_page_by_title('Video Details')) ?>">
                                                            <span class="text">View Recorded Videos</span>
                                                        </a><br/>
<!--                                                        <a id="" href="<?php // echo get_permalink(get_page_by_title('Video Details All')) ?>">
                                                            <span class="text">View All Recorded Videos</span>
                                                        </a>-->
                                                </ul>
                                                <?php endif; ?>
                                        </div>
                                </div>
                        </div>
                    </article><!-- #post-## -->
                    
<?php }else { ?>
                    <header class="entry-header">
                            <?php // the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                    </header><!-- .entry-header -->
                    <div class="entry row">
                        <h2>Login</h2>
                        <div class="col-2">
                            <form class="legacy-login-account" action="#" method="post">
                                    <div class='ajax-message'></div>
                                    <div class="holder-fields">
                                        <label for="account_username">Username</label>
                                        <input type="text" class="" name="account_username" id="account_username" autofocus required>
                                        <label for="account_password">Password</label>
                                        <input type="password" class="" name="account_password" id="account_password" required>
                                    </div>
                                    <p class="form-submit">
                                            <input type="submit" class="btn " name="login_account_details" value="LOGIN">
                                            <input type="hidden" name="action" value="login_account_details">
                                            <input type="hidden" name="redirect" value="">
                                    </p>
                            </form>
                            <div class="form-submit">
                                    <a class="legacy-forgot-password" href="#">Forgot Password?</a>
                            </div>
                            <form class="legacy-forgot-password-form" action="#" method="post" style="display: none;">
                                    <div class='ajax-message'></div>
                                    <p class="">
                                            <label for="forget_account_email">Email</label>
                                            <input type="email" class="" name="account_email" id="forget_account_email" required>
                                    </p>
                                    <p class="form-submit">
                                            <input type="submit" class="btn" name="login_account_details" value="RESET PASSWORD">
                                            <input type="hidden" name="action" value="forgot-password">
                                    </p>
                            </form>
                        </div>
                        <div class="col-2 hidden">
                        <form action="#" class="register-form" id="legacy_registration_form" method="post">
                            <h2>Become a Member</h2>
                            <div class="col-holder">
                                    <div class="form-col">
                                        <div class="open-close active">
                                            <a class="opener" href="#">Personal Details</a>
                                            <div class="slide">
                                                <div class="form-row valid-field">
                                                    <label for="username"><?php _e('Your Name', 'pmpro'); ?>*</label>
                                                    <input id="username" name="username" type="text" class="input <?php echo pmpro_getClassForField("username"); ?>" size="30" value="<?php echo esc_attr($username) ?>" />

                                                </div>
                                                <div class="form-row valid-field">
                                                    <label for="bemail"><?php _e('E-mail Address', 'pmpro'); ?>*</label>
                                                    <input id="bemail" name="bemail" type="email" class="input <?php echo pmpro_getClassForField("bemail"); ?>"  value="<?php echo esc_attr($bemail) ?>" />
                                                </div>
                                                <div class="form-row valid-field">
                                                    <label for="password"><?php _e('Password', 'pmpro'); ?>*</label>
                                                    <input id="password" name="password" type="password" class="input <?php echo pmpro_getClassForField("password"); ?>"  value="<?php echo esc_attr($password) ?>" />
                                                </div>
                                                <div class="form-row valid-field">
                                                    <label for="password2"><?php _e('Confirm Password', 'pmpro'); ?>*</label>
                                                    <input id="password2" name="password2" type="password" class="input <?php echo pmpro_getClassForField("password2"); ?>"  value="<?php echo esc_attr($password2) ?>" />

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php // } ?>

                                <div class="form-col last">
                                    <?php if(!$membership_level) { ?>
                                    <div class="benefits-block">
                                        <!--<div class="note-text"><span>View<br>Benefits</span></div>-->

                                        <?php
                                        $pmpro_levels = pmpro_getAllLevels(false, true);

                                        if (isset($selected_level) && $selected_level != '') {
                                            $selected_level = $selected_level;
                                        }
                                        foreach ($pmpro_levels as $key => $pmpro_level) {
                                            if ($selected_level == $pmpro_level->id) {
                                                $checked = 'checked';
                                            } else {
                                                $checked = '';
                                            }
                                            ?>
                                            <div class="radio-box valid-field">
                                                <label for="<?php echo $pmpro_level->id; ?>">
                                                    <input id="<?php echo $pmpro_level->id; ?>" name="level" type="radio" value="<?php echo $pmpro_level->id; ?>" <?php echo $checked; ?>>
                                                    <span class="fake-input"></span>
                                                    <span class="fake-label">
                                                        <?php echo $pmpro_level->name; ?> 
                                                        <?php
                                                        if(! pmpro_isLevelFree($pmpro_level)) {
                                                            echo '$' . $pmpro_level->initial_payment;
                                                        }
                                                        ?>
                                                        <?php if ($pmpro_level->description) { ?>
                                                            <span>
                                                                (<?php echo $pmpro_level->description; ?>)
                                                            </span>
                                                        <?php } ?>
                                                    </span>
                                                </label>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <?php } else { ?>
                                        <input type="hidden" name="level" value="<?php echo esc_attr($membership_level); ?>" />
                                    <?php } ?>
                                    <div class="open-close alt billing-information-wrapper">
                                        <a class="opener" href="#">Billing Information</a>
                                        <div class="slide">
                                            <div class="form-row valid-field">
                                                <label for="fullname">Cardholder Name *</label>
                                                <input type="text" id="fullname" name='fullname' placeholder="" />
                                            </div>
                                            <div class="form-row valid-field">
                                                <label for="baddress1">Billing Address *</label>
                                                <input type="text" id="baddress1" name='baddress1' placeholder="" />
                                            </div>
                                            <div class="form-row valid-field">
                                                <label for="bcity">City *</label>
                                                <input type="text" id="bcity" name='bcity' placeholder="" />
                                            </div>
                                            <div class="form-row valid-field">
                                                <label for="bcountry">Country *</label>
                                                <select id="bcountry" name='bcountry' class="country">
                                                    <option value=''>- choose one -</option>
                                                    <?php
                                                    foreach ($pmpro_countries as $key => $value) {
                                                        echo '<option value="' . $key . '">' . $value . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-row valid-field">
                                                <label for="AccountNumber">Card Number *</label>
                                                <input id="AccountNumber" name="AccountNumber" class="input <?php echo pmpro_getClassForField("AccountNumber"); ?>" type="text" size="25" value="<?php echo esc_attr($AccountNumber) ?>" data-encrypted-name="number" autocomplete="off" />
                                            </div>
                                            <div class="form-row form-row-3 valid-field">
                                                <label for="expiration_date">Expiry Date (MM/YYYY) *</label>
                                                <input type="text" id="expiration_date" name='expiration_date' placeholder="" />
                                            </div>
                                            <div class="form-row form-row-3 valid-field">
                                                <?php
                                                $pmpro_show_cvv = apply_filters("pmpro_show_cvv", true);
                                                if ($pmpro_show_cvv) {
                                                    ?>
                                                    <label for="CVV"><?php _e('Security Code', 'pmpro'); ?>*</label>
                                                    <input class="input" id="CVV" name="CVV" type="text" size="4" value="<?php
                                                    if (!empty($_REQUEST['CVV'])) {
                                                        echo esc_attr($_REQUEST['CVV']);
                                                    }
                                                    ?>" class="<?php echo pmpro_getClassForField("CVV"); ?>" />  <small>(<a href="javascript:void(0);" onclick="javascript:window.open('<?php echo pmpro_https_filter(PMPRO_URL) ?>/pages/popup-cvv.html', 'cvv', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=600, height=475');"><?php _e("what's this?", 'pmpro'); ?></a>)</small>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <div class="footer-form">
                                <div class="check-box valid-field">
                                    <label for="check-1">
                                        <input id="check-1" type="checkbox">
                                        <span class="fake-input"></span>
                                        <span class="fake-label">I agree to the terms of service, refund policy and privacy policy</span>
                                    </label>
                                </div>
                                <input type="hidden" name="confirm" value="1" />
                                <input type="hidden" name="token" value="<?php echo esc_attr($pmpro_paypal_token) ?>" />
                                <input type="hidden" name="gateway" value="<?php echo esc_attr($gateway); ?>" />
                                <input type="hidden" name="submit-checkout" value="1" />
                                <button type="submit" class="btn btn-alt">Place Order</button>
                                <span id="pmpro_processing_message" style="visibility: hidden;">
                                    <?php
//                                    $processing_message = apply_filters("pmpro_processing_message", __("<img src='" . get_template_directory_uri() . "/images/ring.gif'>", "pmpro"));
//                                    echo $processing_message;
                                    ?>
                                </span>
                            </div>
                        </form>

                    </div>
                    </div>
           </div><!-- /entry -->
<?php } ?>
<?php get_footer(); ?>
