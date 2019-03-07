<?php
global $wpdb, $pmpro_msg, $pmpro_msgt, $pmpro_levels, $current_user, $levels;

// $atts    ::= array of attributes
// $content ::= text within enclosing form of shortcode element
// $code    ::= the shortcode found, when == callback name
// examples: [pmpro_account] [pmpro_account sections="membership,profile"/]

extract(shortcode_atts(array(
        'section' => '',
        'sections' => 'membership,profile,invoices,links'		
), $atts));

//did they use 'section' instead of 'sections'?
if(!empty($section))
        $sections = $section;

//Extract the user-defined sections for the shortcode
$sections = array_map('trim',explode(",",$sections));	
ob_start();

//if a member is logged in, show them some info here (1. past invoices. 2. billing information with button to update.)
if(pmpro_hasMembershipLevel())
{
        $ssorder = new MemberOrder();
        $ssorder->getLastMemberOrder();
        $mylevels = pmpro_getMembershipLevelsForUser();
        $pmpro_levels = pmpro_getAllLevels(false, true); // just to be sure - include only the ones that allow signups
        $invoices = $wpdb->get_results("SELECT *, UNIX_TIMESTAMP(timestamp) as timestamp FROM $wpdb->pmpro_membership_orders WHERE user_id = '$current_user->ID' AND status NOT IN('refunded', 'review', 'token', 'error') ORDER BY timestamp DESC LIMIT 6");
        $total_used = get_user_used_space($current_user->ID);
		?>	
	
<div id="pmpro_account">	
<img src="https://livinglegacy.kinsta.com/wp-content/uploads/2019/02/collage.png" class="collage_pic_1">

        <?php if(in_array('membership', $sections) || in_array('memberships', $sections)) { ?>
                <div id="pmpro_account-membership" class="pmpro_box">

                        <h3><?php _e("My Membership", 'paid-memberships-pro' );?></h3>
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <thead>
                                        <tr>
                                                <th><?php _e("Level", 'paid-memberships-pro' );?></th>
                                                <th><?php _e("Billing", 'paid-memberships-pro' ); ?></th>
                                                <th style="display:none;"><?php _e("Expiration", 'paid-memberships-pro' ); ?></th>
                                        </tr>
                                </thead>
                                <tbody>
                                        <?php
                                                foreach($mylevels as $level) {
                                        ?>
                                        <tr>
                                                <td class="pmpro_account-membership-levelname">
                                                        <?php echo $level->name?>
                                                        <div style="display:none;" class="pmpro_actionlinks">
                                                                <?php do_action("pmpro_member_action_links_before"); ?>

                                                                <?php if( array_key_exists($level->id, $pmpro_levels) && pmpro_isLevelExpiringSoon( $level ) ) { ?>
                                                                        <a href="<?php echo pmpro_url("checkout", "?level=" . $level->id, "https")?>"><?php _e("Renew", 'paid-memberships-pro' );?></a>
                                                                <?php } ?>

                                                                <?php if((isset($ssorder->status) && $ssorder->status == "success") && (isset($ssorder->gateway) && in_array($ssorder->gateway, array("authorizenet", "paypal", "stripe", "braintree", "payflow", "cybersource"))) && pmpro_isLevelRecurring($level)) { ?>
                                                                        <a href="<?php echo pmpro_url("billing", "", "https")?>"><?php _e("Update Billing Info", 'paid-memberships-pro' ); ?></a>
                                                                <?php } ?>

                                                                <?php 
                                                                        //To do: Only show CHANGE link if this level is in a group that has upgrade/downgrade rules
                                                                        if(count($pmpro_levels) > 1 && !defined("PMPRO_DEFAULT_LEVEL")) { ?>
                                                                        <a href="<?php echo pmpro_url("levels")?>" id="pmpro_account-change"><?php _e("Change", 'paid-memberships-pro' );?></a>
                                                                <?php } ?>
                                                                <a href="<?php echo pmpro_url("cancel", "?levelstocancel=" . $level->id)?>" id="pmpro_account-cancel"><?php _e("Cancel", 'paid-memberships-pro' );?></a>
                                                                <?php do_action("pmpro_member_action_links_after"); ?>
                                                        </div> <!-- end pmpro_actionlinks -->
                                                </td>
                                                <td class="pmpro_account-membership-levelfee">
                                                        <p><?php echo pmpro_getLevelCost($level, true, true);?></p>
                                                </td>
                                                <td style="display:none;" class="pmpro_account-membership-expiration">
                                                <?php 
                                                        if($level->enddate)
                                                                $expiration_text = date(get_option('date_format'), $level->enddate);
                                                        else
                                                                $expiration_text = "---";

                                                        echo apply_filters( 'pmpro_account_membership_expiration_text', $expiration_text, $level );
                                                ?>
                                                </td>
                                        </tr>
										<tr>
											<td>Total Usage</td>
											<td> <?php echo $total_used; ?> MB<?php /*  out of <?php echo get_user_package_space($current_user->ID); ?> MB (<?php echo get_user_package_space($current_user->ID) / 1000; ?> GB)*/ ?></td>
										</tr>
                                        <?php } ?>
                                </tbody>
                        </table>
						<?php /*
						<div class="more-storage-upgrade">
							Need more storage? &nbsp; &nbsp; Upgrade to a new plan!
						</div>
						*/ ?>
						
                        <?php //Todo: If there are multiple levels defined that aren't all in the same group defined as upgrades/downgrades ?>
                        <div class="pmpro_actionlinks">
                                <a href="<?php echo pmpro_url("levels")?>"><?php _e("Upgrade Membership", 'paid-memberships-pro' );?></a>
                        </div>

                </div> <!-- end pmpro_account-membership -->
        <?php } ?>

        <?php if(in_array('profile', $sections)) { ?>
                <div id="pmpro_account-profile" class="pmpro_box">	
                        <?php wp_get_current_user(); ?> 
                        <h3><?php _e("My Account", 'paid-memberships-pro' );?></h3>
                        <p>Account Usage</p>                        
                        <?php
						//$total_used = calculate_user_usages($current_user->ID);
						
						?>
                        <ul>
                        	<li><strong><?php _e("Total Usage", 'paid-memberships-pro' );?>:</strong> <?php echo $total_used;?> MB  <!--out of <?php //echo get_user_package_space($current_user->ID); ?> MB (<?php //echo get_user_package_space($current_user->ID) / 1000; ?> GB)--></li>
                        </ul>
                        
                        <?php if($current_user->user_firstname) { ?>
                                <p><?php echo $current_user->user_firstname?> <?php echo $current_user->user_lastname?></p>
                        <?php }
//                        var_dump($current_user->ID, '<pre>',get_user_meta($current_user->ID),'</pre>');
                        $aa_firstname  = get_user_meta( $current_user->ID, "pmpro_aa_firstname", true );
                        $aa_lastname   = get_user_meta( $current_user->ID, "pmpro_aa_lastname", true );
                        $aa_address1   = get_user_meta( $current_user->ID, "pmpro_aa_address1", true );
                        $aa_city       = get_user_meta( $current_user->ID, "pmpro_aa_city", true );
                        $aa_state      = get_user_meta( $current_user->ID, "pmpro_aa_state", true );
                        $aa_zipcode    = get_user_meta( $current_user->ID, "pmpro_aa_zipcode", true );
                        $aa_country    = get_user_meta( $current_user->ID, "pmpro_aa_country", true );
                        $aa_phonenumber = get_user_meta( $current_user->ID, "pmpro_aa_phonenumber", true );
                        $aa_emailaddress = get_user_meta( $current_user->ID, "pmpro_aa_emailaddress", true );
                        ?>
                        <ul>
                                <?php do_action('pmpro_account_bullets_top');?>
                                <li><strong><?php _e("Username", 'paid-memberships-pro' );?>:</strong> <?php echo $current_user->user_login?></li>
                                <li><strong><?php _e("Email", 'paid-memberships-pro' );?>:</strong> <?php echo $current_user->user_email?></li>
                                <?php do_action('pmpro_account_bullets_bottom');?>
                        </ul>
                        <p><?php _e("Administrator Details", 'paid-memberships-pro' );?></p>
                        <ul>
                                <?php do_action('pmpro_account_bullets_top');?>
                                <?php if(!empty($aa_firstname)){?>
                                <li><strong><?php _e("First Name", 'paid-memberships-pro' );?>:</strong> <?php echo $aa_firstname?></li>
                                <?php }if(!empty($aa_lastname)){?>
                                <li><strong><?php _e("Last Name", 'paid-memberships-pro' );?>:</strong> <?php echo $aa_lastname?></li>
                   
                                <?php }if(!empty($aa_address1)){?>
                                <li><strong><?php _e("Address", 'paid-memberships-pro' );?>:</strong> <?php echo $aa_address1?></li>
                                <?php }if(!empty($aa_city)){?>
                                <li><strong><?php _e("City", 'paid-memberships-pro' );?>:</strong> <?php echo $aa_city?></li>
                                 <?php }if(!empty($aa_state)){?>
                                <li><strong><?php _e("State", 'paid-memberships-pro' );?>:</strong> <?php echo $aa_state?></li>
                                 <?php }if(!empty($aa_zipcode)){?>
                                <li><strong><?php _e("Zipcode", 'paid-memberships-pro' );?>:</strong> <?php echo $aa_zipcode?></li>
                                 <?php }if(!empty($aa_country)){?>
                                <li><strong><?php _e("Country", 'paid-memberships-pro' );?>:</strong> <?php echo $aa_country?></li>
                                 <?php }if(!empty($aa_phonenumber)){?>
                                <li><strong><?php _e("Phone Number", 'paid-memberships-pro' );?>:</strong> <?php echo $aa_phonenumber?></li>
                                 <?php }if(!empty($aa_emailaddress)){?>
                                <li><strong><?php _e("Email address", 'paid-memberships-pro' );?>:</strong> <?php echo $aa_emailaddress?></li>
                                 <?php }?>
                                <?php do_action('pmpro_account_bullets_bottom');?>
                        </ul>
                        <div class="pmpro_actionlinks">
                                <a href="<?php echo esc_url( get_permalink( get_page_by_title( 'Edit Profile' ) ) )?>" id="pmpro_account-edit-profile"><?php _e("Edit Profile", 'paid-memberships-pro' );?></a>
                                <!--<a href="<?php // echo admin_url('profile.php')?>" id="pmpro_account-change-password"><?php // _e('Change Password', 'paid-memberships-pro' );?></a>-->
                        </div>
                </div> <!-- end pmpro_account-profile -->
        <?php } ?>
		
		
		
		<div class="cancel-membership">
			
			<div class="cancel-btns">
				<a href="<?php echo get_permalink('47');?>">Edit Profile</a>
			</div>
			
			<!-- div class="cancel-btns">
				<a href="<?php echo site_url('/my-account/membership-cancel/');?>">Cancel ONLY</a>
				<a href="<?php echo site_url('/my-account/membership-cancel/');?>">Cancel and <br>DOWNLOAD</a>
			</div -->
			<p>Cancel membership</p>
			<p>Cancel + Download all your media for only $59.99</p>
		</div>
		
		<?php /*

        <?php if(in_array('invoices', $sections) && !empty($invoices)) { ?>		
        <div id="pmpro_account-invoices" class="pmpro_box">
                <h3><?php _e("Past Invoices", 'paid-memberships-pro' );?></h3>
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <thead>
                                <tr>
                                        <th><?php _e("Date", 'paid-memberships-pro' ); ?></th>
                                        <th><?php _e("Level", 'paid-memberships-pro' ); ?></th>
                                        <th><?php _e("Amount", 'paid-memberships-pro' ); ?></th>
                                </tr>
                        </thead>
                        <tbody>
                        <?php 
                                $count = 0;
                                foreach($invoices as $invoice) 
                                { 
                                        if($count++ > 4)
                                                break;

                                        //get an member order object
                                        $invoice_id = $invoice->id;
                                        $invoice = new MemberOrder;
                                        $invoice->getMemberOrderByID($invoice_id);
                                        $invoice->getMembershipLevel();						
                                        ?>
                                        <tr id="pmpro_account-invoice-<?php echo $invoice->code; ?>">
                                                <td><a href="<?php echo pmpro_url("invoice", "?invoice=" . $invoice->code)?>"><?php echo date_i18n(get_option("date_format"), $invoice->timestamp)?></td>
                                                <td><?php if(!empty($invoice->membership_level)) echo $invoice->membership_level->name; else echo __("N/A", 'paid-memberships-pro' );?></td>
                                                <td><?php echo pmpro_formatPrice($invoice->total)?></td>
                                        </tr>
                                        <?php 
                                }
                        ?>
                        </tbody>
                </table>						
                <?php if($count == 6) { ?>
                        <div class="pmpro_actionlinks"><a href="<?php echo pmpro_url("invoice"); ?>"><?php _e("View All Invoices", 'paid-memberships-pro' );?></a></div>
                <?php } ?>
        </div> <!-- end pmpro_account-invoices -->
        <?php } ?>
		
		
		*/ ?>
		

        <?php if(in_array('links', $sections) && (has_filter('pmpro_member_links_top') || has_filter('pmpro_member_links_bottom'))) { ?>
        <div id="pmpro_account-links" class="pmpro_box">
                <h3><?php _e("Member Links", 'paid-memberships-pro' );?></h3>
                <ul>
                        <?php 
                                do_action("pmpro_member_links_top");
                        ?>

                        <?php 
                                do_action("pmpro_member_links_bottom");
                        ?>
                </ul>
        </div> <!-- end pmpro_account-links -->		
        <?php } ?>
</div> <!-- end pmpro_account -->		
<?php
}

$content = ob_get_contents();
ob_end_clean();

echo $content;
?>