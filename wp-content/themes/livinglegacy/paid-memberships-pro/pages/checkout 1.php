<style>
.pmpro-checkout .entry {
    padding-top: 0;
    max-width: 100%;
}
.container {
    padding-left: 0;
    padding-right: 0;
}
.cus_2 img {
    width: 400px;
    margin-top: 0px;
}

.pmpro_checkout {
    width: 800px;
    margin: auto;
    clear: both;
}
.cus_2 {
    background: #fff !important;
    padding: 0;
    margin: 0;
    float: left;
    width: 100%;
    text-align: center;
    max-width: 100%;
    padding-bottom: 32px;
}
.cus_2 h3 {
  display:none;
}
.cus_2 p {
    color: #000;
}
.shadow {
    float: left;
    width: 100%;
    box-shadow: 0 0 6px #000;
    margin: 5% 0;
}
.cus_3_4 h3 {
    margin-top: 0px;
}
img.collage_pic {
    margin-top: -26px;
}
.collage_pic {
  
    display: none;

}
@media only screen and (max-width: 600px) {
.pmpro_checkout {
    width: auto;
    margin: auto;
    clear: both;
    padding: 28px;
}
p.privacy-terms {
    padding: 21px;
}
.cus_2 {
    padding: 20px;
}
.cus_2 img {
    width: 400px;
    margin-top: 0;
}
}
.gradient_01 {
    background-image: linear-gradient(to right, #5a92cb , #3b598d)!important;
    box-shadow: 1px 2px 10px #3b5a8e;
    padding: 10px 0px;
}
</style>
<?php
	global $gateway, $pmpro_review, $skip_account_fields, $pmpro_paypal_token, $wpdb, $current_user, $pmpro_msg, $pmpro_msgt, $pmpro_requirebilling, $pmpro_level, $pmpro_levels, $tospage, $pmpro_show_discount_code, $pmpro_error_fields;
	global $discount_code, $username, $password, $password2, $bfirstname, $blastname, $baddress1, $baddress2, $bcity, $bstate, $bzipcode, $bcountry, $bphone, $bemail, $bconfirmemail, $CardType, $AccountNumber, $ExpirationMonth,$ExpirationYear;

	/**
	 * Filter to set if PMPro uses email or text as the type for email field inputs.
	 *
	 * @since 1.8.4.5
	 *
	 * @param bool $use_email_type, true to use email type, false to use text type
	 */
	$pmpro_email_field_type = apply_filters('pmpro_email_field_type', true);
?>
<div id="pmpro_level-<?php echo $pmpro_level->id; ?>">
<form id="legacy_registration_form" class="pmpro_form_checkout <?php echo ($pmpro_level->id==4) ? 'sub-member-form' : ''; ?>" action="<?php if(!empty($_REQUEST['review'])) echo pmpro_url("checkout", "?level=" . $pmpro_level->id); ?>" method="post">

	<input type="hidden" id="level" name="level" value="<?php echo esc_attr($pmpro_level->id) ?>" />
	<input type="hidden" id="checkjavascript" name="checkjavascript" value="1" />
	<?php if ($discount_code && $pmpro_review) { ?>
		<input class="input <?php echo pmpro_getClassForField("discount_code");?>" id="discount_code" name="discount_code" type="hidden" size="20" value="<?php echo esc_attr($discount_code) ?>" />
	<?php } ?>

	<?php if($pmpro_msg) { ?>
		<div id="pmpro_message" class="pmpro_message <?php echo $pmpro_msgt?>"><?php echo $pmpro_msg?></div>
	<?php } else { ?>
		<div id="pmpro_message" class="pmpro_message" style="display: none;"></div>
	<?php } ?>

	<?php if($pmpro_review) { ?>
		<p><?php _e('Almost done. Review the membership information and pricing below then <strong>click the "Complete Payment" button</strong> to finish your order.', 'paid-memberships-pro' );?></p>
	<?php } ?>
	<div id="pmpro_pricing_fields" class="pmpro_checkout cus_2">
	
	<img src="http://livinglegacy.kinsta.com/wp-content/uploads/2019/02/membershiplogo.jpg"/>
	
		<h3>
        <?php 
			$membership_plan = get_plan_heading($pmpro_level->id);
		?>
			<span class="pmpro_checkout-h3-name"><?php _e($membership_plan, 'paid-memberships-pro' );?></span>
			<?php if(count($pmpro_levels) > 1 AND $pmpro_level->id!=4) { ?><span class="pmpro_checkout-h3-msg"><a href="<?php echo pmpro_url("levels"); ?>"><?php _e('change', 'paid-memberships-pro' );?></a></span><?php } ?>
		</h3>
		<div class="pmpro_checkout-fields">
			

			<?php
				/**
				 * All devs to filter the level description at checkout.
				 * We also have a function in includes/filters.php that applies the the_content filters to this description.
				 * @param string $description The level description.
				 * @param object $pmpro_level The PMPro Level object.
				 */
				$membership_plan_desc = get_plan_description($pmpro_level->id);
				if(!empty($membership_plan_desc)){
					echo $membership_plan_desc;
				}else{?>
                	<p>
						<?php printf(__('You have selected the <strong>%s</strong> membership plan.', 'paid-memberships-pro' ), $pmpro_level->name);?>
                    </p>
					<?php $level_description = apply_filters('pmpro_level_description', $pmpro_level->description, $pmpro_level);
					if(!empty($level_description)){
						echo $level_description;
					}
				}	
			?>

			<div id="pmpro_level_cost">
				<?php if($discount_code && pmpro_checkDiscountCode($discount_code)) { ?>
					<?php printf(__('<p class="pmpro_level_discount_applied">The <strong>%s</strong> code has been applied to your order.</p>', 'paid-memberships-pro' ), $discount_code);?>
				<?php } ?>
                <?php if(empty($membership_plan_desc)){?>
				<?php echo wpautop(pmpro_getLevelCost($pmpro_level)); ?>
				<?php echo wpautop(pmpro_getLevelExpiration($pmpro_level)); ?>
                <?php }?>
			</div>

			<?php do_action("pmpro_checkout_after_level_cost"); ?>

			<?php if($pmpro_show_discount_code) { ?>
				<?php if($discount_code && !$pmpro_review) { ?>
					<p id="other_discount_code_p" class="pmpro_small"><a id="other_discount_code_a" href="#discount_code"><?php _e('Click here to change your discount code', 'paid-memberships-pro' );?></a>.</p>
				<?php } elseif(!$pmpro_review) { ?>
					<p id="other_discount_code_p" class="pmpro_small"><?php _e('Do you have a discount code?', 'paid-memberships-pro' );?> <a id="other_discount_code_a" href="#discount_code"><?php _e('Click here to enter your discount code', 'paid-memberships-pro' );?></a>.</p>
				<?php } elseif($pmpro_review && $discount_code) { ?>
					<p><strong><?php _e('Discount Code', 'paid-memberships-pro' );?>:</strong> <?php echo $discount_code?></p>
				<?php } ?>
			<?php } ?>

			<?php if($pmpro_show_discount_code) { ?>
			<div id="other_discount_code_tr" style="display: none;">
				<label for="other_discount_code"><?php _e('Discount Code', 'paid-memberships-pro' );?></label>
				<input id="other_discount_code" name="other_discount_code" type="text" class="input <?php echo pmpro_getClassForField("other_discount_code");?>" size="20" value="<?php echo esc_attr($discount_code); ?>" />
				<input type="button" name="other_discount_code_button" id="other_discount_code_button" value="<?php _e('Apply', 'paid-memberships-pro' );?>" />
			</div>
			<?php } ?>
		</div> <!-- end pmpro_checkout-fields -->
	</div> <!-- end pmpro_pricing_fields -->

	<?php if($pmpro_show_discount_code) { ?>
	<script>
		<!--
		//update discount code link to show field at top of form
		jQuery('#other_discount_code_a').attr('href', 'javascript:void(0);');
		jQuery('#other_discount_code_a').click(function() {
			jQuery('#other_discount_code_tr').show();
			jQuery('#other_discount_code_p').hide();
			jQuery('#other_discount_code').focus();
		});

		//update real discount code field as the other discount code field is updated
		jQuery('#other_discount_code').keyup(function() {
			jQuery('#discount_code').val(jQuery('#other_discount_code').val());
		});
		jQuery('#other_discount_code').blur(function() {
			jQuery('#discount_code').val(jQuery('#other_discount_code').val());
		});

		//update other discount code field as the real discount code field is updated
		jQuery('#discount_code').keyup(function() {
			jQuery('#other_discount_code').val(jQuery('#discount_code').val());
		});
		jQuery('#discount_code').blur(function() {
			jQuery('#other_discount_code').val(jQuery('#discount_code').val());
		});

		//applying a discount code
		jQuery('#other_discount_code_button').click(function() {
			var code = jQuery('#other_discount_code').val();
			var level_id = jQuery('#level').val();

			if(code)
			{
				//hide any previous message
				jQuery('.pmpro_discount_code_msg').hide();

				//disable the apply button
				jQuery('#other_discount_code_button').attr('disabled', 'disabled');

				jQuery.ajax({
					url: '<?php echo admin_url('admin-ajax.php'); ?>',type:'GET',timeout:<?php echo apply_filters("pmpro_ajax_timeout", 5000, "applydiscountcode");?>,
					dataType: 'html',
					data: "action=applydiscountcode&code=" + code + "&level=" + level_id + "&msgfield=pmpro_message",
					error: function(xml){
						alert('Error applying discount code [1]');

						//enable apply button
						jQuery('#other_discount_code_button').removeAttr('disabled');
					},
					success: function(responseHTML){
						if (responseHTML == 'error')
						{
							alert('Error applying discount code [2]');
						}
						else
						{
							jQuery('#pmpro_message').html(responseHTML);
						}

						//enable invite button
						jQuery('#other_discount_code_button').removeAttr('disabled');
					}
				});
			}
		});
		-->
	</script>
	<?php } ?>

	<?php
		do_action('pmpro_checkout_after_pricing_fields');
	?>

	<?php if(!$skip_account_fields && !$pmpro_review) { ?>
	<hr />
	<img class="collage_pic" src="http://livinglegacy.kinsta.com/wp-content/uploads/2019/02/collage.png">
<div class="gradient_01">	
	<div id="pmpro_user_fields" class="pmpro_checkout cus_level_3">
	
		<h3>
			<span class="pmpro_checkout-h3-name"><?php _e('Account Information', 'paid-memberships-pro' );?></span>
			<span class="pmpro_checkout-h3-msg"><?php _e('Already have an account?', 'paid-memberships-pro' );?> <a href="<?php echo get_permalink(get_page_by_title('Login Page')); ?>"><?php _e('Log in here', 'paid-memberships-pro' );?></a></span>
		</h3>
		<div class="pmpro_checkout-fields">
		
			<div class="req-fields">* This are required fields.</div>
		
			<div class="pmpro_checkout-field pmpro_checkout-field-username">
				<label for="username"><?php _e('Username', 'paid-memberships-pro' );?> *</label>
				<input id="username" name="username" type="text" class="input <?php echo pmpro_getClassForField("username");?>" size="30" value="<?php echo esc_attr($username); ?>" />
			</div> <!-- end pmpro_checkout-field-username -->

			<?php
				do_action('pmpro_checkout_after_username');
			?>

			<div class="pmpro_checkout-field pmpro_checkout-field-password">
				<label for="password"><?php _e('Password', 'paid-memberships-pro' );?> *</label>
				<input id="password" name="password" type="password" class="input <?php echo pmpro_getClassForField("password");?>" size="30" value="<?php echo esc_attr($password); ?>" />
			</div> <!-- end pmpro_checkout-field-password -->

			<?php
				$pmpro_checkout_confirm_password = apply_filters("pmpro_checkout_confirm_password", true);
				if($pmpro_checkout_confirm_password) { ?>
					<div class="pmpro_checkout-field pmpro_checkout-field-password2">
						<label for="password2"><?php _e('Confirm Password', 'paid-memberships-pro' );?> *</label>
						<input id="password2" name="password2" type="password" class="input <?php echo pmpro_getClassForField("password2");?>" size="30" value="<?php echo esc_attr($password2); ?>" />
					</div> <!-- end pmpro_checkout-field-password2 -->
				<?php } else { ?>
					<input type="hidden" name="password2_copy" value="1" />
				<?php } 
			?>

			<?php
				do_action('pmpro_checkout_after_password');
			?>

			<div class="pmpro_checkout-field pmpro_checkout-field-bemail">
				<label for="bemail"><?php _e('E-mail Address', 'paid-memberships-pro' );?> *</label>
				<input id="bemail" name="bemail" type="<?php echo ($pmpro_email_field_type ? 'email' : 'text'); ?>" class="input <?php echo pmpro_getClassForField("bemail");?>" size="30" value="<?php echo esc_attr($bemail); ?>" />
			</div> <!-- end pmpro_checkout-field-bemail -->

			<?php
				do_action('pmpro_checkout_after_email');
			?>

			<div class="pmpro_hidden">
				<label for="fullname"><?php _e('Full Name', 'paid-memberships-pro' );?></label>
				<input id="fullname" name="fullname" type="text" class="input <?php echo pmpro_getClassForField("fullname");?>" size="30" value="" /> <strong><?php _e('LEAVE THIS BLANK', 'paid-memberships-pro' );?></strong>
			</div> <!-- end pmpro_hidden -->

			<div class="pmpro_checkout-field pmpro_captcha">
			<?php
				global $recaptcha, $recaptcha_publickey;
				if($recaptcha == 2 || ($recaptcha == 1 && pmpro_isLevelFree($pmpro_level))) {
					echo pmpro_recaptcha_get_html($recaptcha_publickey, NULL, true);
				}
			?>
			</div> <!-- end pmpro_captcha -->

			<?php
				do_action('pmpro_checkout_after_captcha');
			?>
		</div>  <!-- end pmpro_checkout-fields -->
	</div> <!-- end pmpro_user_fields -->
	<?php } elseif($current_user->ID && !$pmpro_review) { ?>
		<div id="pmpro_account_loggedin" class="pmpro_message pmpro_alert">
			<?php printf(__('You are logged in as <strong>%s</strong>. If you would like to use a different account for this membership, <a href="%s">log out now</a>.', 'paid-memberships-pro' ), $current_user->user_login, wp_logout_url($_SERVER['REQUEST_URI'])); ?>
		</div> <!-- end pmpro_account_loggedin -->
	<?php } ?>

	<?php
		do_action('pmpro_checkout_after_user_fields');
	?>

	<?php
		do_action('pmpro_checkout_boxes');
	?>

	<?php if(pmpro_getGateway() == "paypal" && empty($pmpro_review) && true == apply_filters('pmpro_include_payment_option_for_paypal', true ) ) { ?>
	<div id="pmpro_payment_method" class="pmpro_checkout cus_3" <?php if(!$pmpro_requirebilling) { ?>style="display: none;"<?php } ?>>
		<hr />
		<h3>
			<span class="pmpro_checkout-h3-name"><?php _e('Choose your Payment Method', 'paid-memberships-pro' ); ?></span>
		</h3>
		<div class="pmpro_checkout-fields">
			<span class="gateway_paypal">
				<input type="radio" name="gateway" value="paypal" <?php if(!$gateway || $gateway == "paypal") { ?>checked="checked"<?php } ?> />
				<a href="javascript:void(0);" class="pmpro_radio"><?php _e('Check Out with a Credit Card Here', 'paid-memberships-pro' );?></a>
			</span>
			<span class="gateway_paypalexpress">
				<input type="radio" name="gateway" value="paypalexpress" <?php if($gateway == "paypalexpress") { ?>checked="checked"<?php } ?> />
				<a href="javascript:void(0);" class="pmpro_radio"><?php _e('Check Out with PayPal', 'paid-memberships-pro' );?></a>
			</span>
		</div> <!-- end pmpro_checkout-fields -->
	</div> <!-- end pmpro_payment_method -->
	<?php } ?>
    <div id="show_hide_administrative_form" class="pmpro_checkout">
    <div class="pmpro_checkout-fields">
    <?php if($pmpro_level->id!=4){?>
    <?php if(!get_user_meta($current_user->ID, "pmpro_aa_firstname", true )) { ?>
			<p class="p-text-checkout">Please provide us with a trusted person to gain administrative control of your account if you are no longer able to be the administrator.</p>
			<span class="gateway_paypal">
				<input type="checkbox" class="" name="add_admin_contact" id="add_admin_contact"/> <label for="add_admin_contact"><?php _e('Add Administrative Contact', 'paid-memberships-pro' );?></label>
			</span>
            <?php } }?>
			
		</div> <!-- end pmpro_checkout-fields -->
</div>
</div>
<!-- end gradient 01 -->
    </div>
	
	
        <div id="pmpro_administrative_fields" class="pmpro_checkout" style="display:none;">
            <h3>
                <span class="pmpro_checkout-h3-name"><?php _e('Account Administrator', 'paid-memberships-pro' );?></span>
            </h3>
            <div class="pmpro_checkout-fields">
                <div class="pmpro_checkout-field">
                    <label for="aa_firstname"><?php _e('First Name', 'paid-memberships-pro' );?> </label>
                    <input id="aa_firstname" name="aa_firstname" type="text" class="input " size="30" value="" />
                </div>
                <div class="pmpro_checkout-field">
                    <label for="aa_emailaddress"><?php _e('Email Address', 'paid-memberships-pro' );?> </label>
                    <input id="aa_emailaddress" name="aa_emailaddress" type="<?php echo ($pmpro_email_field_type ? 'email' : 'text'); ?>" class="input " size="50" value="" />
                </div>
                <div class="pmpro_checkout-field">
                    <label for="aa_lastname"><?php _e('Last Name', 'paid-memberships-pro' );?> </label>
                    <input id="aa_lastname" name="aa_lastname" type="text" class="input " size="30" value="" />
                </div>
                <div class="pmpro_checkout-field">
                    <label for="aa_phonenumber"><?php _e('Phone Number', 'paid-memberships-pro' );?> </label>
                    <input id="aa_phonenumber" name="aa_phonenumber" type="text" class="input " size="10" value="" />
                </div>
                <div class="pmpro_checkout-field">
                    <label for="aa_address1"><?php _e('Street Address', 'paid-memberships-pro' );?> </label>
                    <input id="aa_address1" name="aa_address1" type="text" class="input " size="30" value="" />
                </div>
                <div class="pmpro_checkout-field">
                    <label for="aa_city"><?php _e('City', 'paid-memberships-pro' );?> </label>
                    <input id="aa_city" name="aa_city" type="text" class="input" size="30" value="" />
                </div>
                <div class="pmpro_checkout-field">
                    <label for="aa_state"><?php _e('State', 'paid-memberships-pro' );?> </label>
                    <input id="aa_state" name="aa_state" type="text" class="input " size="30" value="" />
                </div>
                <div class="pmpro_checkout-field">
                    <label for="aa_zipcode"><?php _e('Zip Code', 'paid-memberships-pro' );?> </label>
                    <input id="aa_zipcode" name="aa_zipcode" type="text" class="input" size="30" value="" />
                </div>
                
            </div>
        </div>
	
		<div class="shadow">
<div class="gradient_01">			
	<?php
		$pmpro_include_billing_address_fields = apply_filters('pmpro_include_billing_address_fields', true);
		if($pmpro_include_billing_address_fields) { ?>
	<div id="pmpro_billing_address_fields" class="pmpro_checkout cus_3_4" <?php if(!$pmpro_requirebilling || apply_filters("pmpro_hide_billing_address_fields", false) ){ ?>style="display: none;"<?php } ?>>
		<hr />		
		<h3>
			<span class="pmpro_checkout-h3-name"><?php _e('Billing Address', 'paid-memberships-pro' );?></span>
		</h3>
		<div class="pmpro_checkout-fields">
			<div class="pmpro_checkout-field pmpro_checkout-field-bfirstname">
				<label for="bfirstname"><?php _e('First Name', 'paid-memberships-pro' );?> *</label>
				<input id="bfirstname" name="bfirstname" type="text" class="input <?php echo pmpro_getClassForField("bfirstname");?>" size="30" value="<?php echo esc_attr($bfirstname); ?>" />
			</div> <!-- end pmpro_checkout-field-bfirstname -->
			<div class="pmpro_checkout-field pmpro_checkout-field-blastname">
				<label for="blastname"><?php _e('Last Name', 'paid-memberships-pro' );?> *</label>
				<input id="blastname" name="blastname" type="text" class="input <?php echo pmpro_getClassForField("blastname");?>" size="30" value="<?php echo esc_attr($blastname); ?>" />
			</div> <!-- end pmpro_checkout-field-blastname -->
			<div class="pmpro_checkout-field pmpro_checkout-field-baddress1">
				<label for="baddress1"><?php _e('Address 1', 'paid-memberships-pro' );?> *</label>
				<input id="baddress1" name="baddress1" type="text" class="input <?php echo pmpro_getClassForField("baddress1");?>" size="30" value="<?php echo esc_attr($baddress1); ?>" />
			</div> <!-- end pmpro_checkout-field-baddress1 -->
			<div class="pmpro_checkout-field pmpro_checkout-field-baddress2">
				<label for="baddress2"><?php _e('Address 2', 'paid-memberships-pro' );?></label>
				<input id="baddress2" name="baddress2" type="text" class="input <?php echo pmpro_getClassForField("baddress2");?>" size="30" value="<?php echo esc_attr($baddress2); ?>" />
			</div> <!-- end pmpro_checkout-field-baddress2 -->
			<?php
				$longform_address = apply_filters("pmpro_longform_address", true);
				if($longform_address) { ?>
					<div class="pmpro_checkout-field pmpro_checkout-field-bcity">
						<label for="bcity"><?php _e('City', 'paid-memberships-pro' );?> *</label>
						<input id="bcity" name="bcity" type="text" class="input <?php echo pmpro_getClassForField("bcity");?>" size="30" value="<?php echo esc_attr($bcity); ?>" />
					</div> <!-- end pmpro_checkout-field-bcity -->
					<div class="pmpro_checkout-field pmpro_checkout-field-bstate">
						<label for="bstate"><?php _e('State', 'paid-memberships-pro' );?> *</label>
						<input id="bstate" name="bstate" type="text" class="input <?php echo pmpro_getClassForField("bstate");?>" size="30" value="<?php echo esc_attr($bstate); ?>" />
					</div> <!-- end pmpro_checkout-field-bstate -->
					<div class="pmpro_checkout-field pmpro_checkout-field-bzipcode">
						<label for="bzipcode"><?php _e('Postal Code', 'paid-memberships-pro' );?> *</label>
						<input id="bzipcode" name="bzipcode" type="text" class="input <?php echo pmpro_getClassForField("bzipcode");?>" size="30" value="<?php echo esc_attr($bzipcode); ?>" />
					</div> <!-- end pmpro_checkout-field-bzipcode -->
				<?php } else { ?>
					<div class="pmpro_checkout-field pmpro_checkout-field-bcity_state_zip">
						<label for="bcity_state_zip"><?php _e('City, State Zip', 'paid-memberships-pro' );?> *</label>
						<input id="bcity" name="bcity" type="text" class="input <?php echo pmpro_getClassForField("bcity");?>" size="14" value="<?php echo esc_attr($bcity); ?>" />,
						<?php
							$state_dropdowns = apply_filters("pmpro_state_dropdowns", false);
							if($state_dropdowns === true || $state_dropdowns == "names") {
								global $pmpro_states;
								?>
								<select name="bstate" class="<?php echo pmpro_getClassForField("bstate");?>">
									<option value="">--</option>
									<?php
										foreach($pmpro_states as $ab => $st) { ?>
											<option value="<?php echo esc_attr($ab);?>" <?php if($ab == $bstate) { ?>selected="selected"<?php } ?>><?php echo $st;?></option>
									<?php } ?>
								</select>
							<?php } elseif($state_dropdowns == "abbreviations") {
								global $pmpro_states_abbreviations;
								?>
								<select name="bstate" class="<?php echo pmpro_getClassForField("bstate");?>">
									<option value="">--</option>
									<?php
										foreach($pmpro_states_abbreviations as $ab)
										{
									?>
										<option value="<?php echo esc_attr($ab);?>" <?php if($ab == $bstate) { ?>selected="selected"<?php } ?>><?php echo $ab;?></option>
									<?php } ?>
								</select>
							<?php } else { ?>
								<input id="bstate" name="bstate" type="text" class="input <?php echo pmpro_getClassForField("bstate");?>" size="2" value="<?php echo esc_attr($bstate); ?>" />
						<?php } ?>
						<input id="bzipcode" name="bzipcode" type="text" class="input <?php echo pmpro_getClassForField("bzipcode");?>" size="5" value="<?php echo esc_attr($bzipcode); ?>" />
					</div> <!-- end pmpro_checkout-field-bcity_state_zip -->
			<?php } ?>

			<?php
				$show_country = apply_filters("pmpro_international_addresses", true);
				if($show_country) { ?>
					<div class="pmpro_checkout-field pmpro_checkout-field-bcountry">
						<label for="bcountry"><?php _e('Country', 'paid-memberships-pro' );?> *</label>
						<select name="bcountry" id="bcountry" class="<?php echo pmpro_getClassForField("bcountry");?>">
						<?php
							global $pmpro_countries, $pmpro_default_country;
							if(!$bcountry) {
								$bcountry = $pmpro_default_country;
							}
							foreach($pmpro_countries as $abbr => $country) { ?>
								<option value="<?php echo $abbr?>" <?php if($abbr == $bcountry) { ?>selected="selected"<?php } ?>><?php echo $country?></option>
							<?php } ?>
						</select>
					</div> <!-- end pmpro_checkout-field-bcountry -->
				<?php } else { ?>
					<input type="hidden" name="bcountry" value="US" />
				<?php } ?>
			<div class="pmpro_checkout-field pmpro_checkout-field-bphone">
				<label for="bphone"><?php _e('Phone', 'paid-memberships-pro' );?> *</label>
				<input id="bphone" name="bphone" type="text" class="input <?php echo pmpro_getClassForField("bphone");?>" size="30" value="<?php echo esc_attr(formatPhone($bphone)); ?>" />
			</div> <!-- end pmpro_checkout-field-bphone -->
			<?php if($skip_account_fields) { ?>
			<?php
				if($current_user->ID) {
					if(!$bemail && $current_user->user_email) {
						$bemail = $current_user->user_email;
					}
					if(!$bconfirmemail && $current_user->user_email) {
						$bconfirmemail = $current_user->user_email;
					}
				}
			?>
			
			<div class="pmpro_checkout-field pmpro_checkout-field-bemail">
				<label for="bemail"><?php _e('E-mail Address', 'paid-memberships-pro' );?> *</label>
				<input id="bemail" name="bemail" type="<?php echo ($pmpro_email_field_type ? 'email' : 'text'); ?>" class="input <?php echo pmpro_getClassForField("bemail");?>" size="30" value="<?php echo esc_attr($bemail); ?>" />
			</div> <!-- end pmpro_checkout-field-bemail -->
			<?php
				$pmpro_checkout_confirm_email = apply_filters("pmpro_checkout_confirm_email", true);
				if($pmpro_checkout_confirm_email) { ?>
					<div class="pmpro_checkout-field pmpro_checkout-field-bconfirmemail">
						<label for="bconfirmemail"><?php _e('Confirm E-mail', 'paid-memberships-pro' );?></label>
						<input id="bconfirmemail" name="bconfirmemail" type="<?php echo ($pmpro_email_field_type ? 'email' : 'text'); ?>" class="input <?php echo pmpro_getClassForField("bconfirmemail");?>" size="30" value="<?php echo esc_attr($bconfirmemail); ?>" />
					</div> <!-- end pmpro_checkout-field-bconfirmemail -->
				<?php } else { ?>
					<input type="hidden" name="bconfirmemail_copy" value="1" />
				<?php } ?>
			<?php } ?>
		</div> <!-- end pmpro_checkout-fields -->
	</div> <!--end pmpro_billing_address_fields -->
</div>	


	<?php } ?>

	<?php do_action("pmpro_checkout_after_billing_fields"); ?>

	<?php
		$pmpro_accepted_credit_cards = pmpro_getOption("accepted_credit_cards");
		$pmpro_accepted_credit_cards = explode(",", $pmpro_accepted_credit_cards);
		$pmpro_accepted_credit_cards_string = pmpro_implodeToEnglish($pmpro_accepted_credit_cards);
	?>

	<?php
		$pmpro_include_payment_information_fields = apply_filters("pmpro_include_payment_information_fields", true);
		if($pmpro_include_payment_information_fields) { ?>
<div class="gradient_01">				
		<div id="pmpro_payment_information_fields" class="pmpro_checkout cus_3_4" <?php if(!$pmpro_requirebilling || apply_filters("pmpro_hide_payment_information_fields", false) ) { ?>style="display: none;"<?php } ?>>
			<hr />
			<h3>
				<span class="pmpro_checkout-h3-name"><?php _e('Payment Information', 'paid-memberships-pro' );?></span>
				<span class="pmpro_checkout-h3-msg"><?php printf(__('We Accept %s', 'paid-memberships-pro' ), $pmpro_accepted_credit_cards_string);?></span>
			</h3>
			<?php $sslseal = pmpro_getOption("sslseal"); ?>
			<?php if(!empty($sslseal)) { ?>
				<div class="pmpro_checkout-fields-display-seal">
			<?php } ?>
			<div class="pmpro_checkout-fields">
				<?php
					$pmpro_include_cardtype_field = apply_filters('pmpro_include_cardtype_field', false);
					if($pmpro_include_cardtype_field) { ?>
						<div class="pmpro_checkout-field pmpro_payment-card-type">
							<label for="CardType"><?php _e('Card Type', 'paid-memberships-pro' );?> *</label>
							<select id="CardType" name="CardType" class=" <?php echo pmpro_getClassForField("CardType");?>">
								<?php foreach($pmpro_accepted_credit_cards as $cc) { ?>
									<option value="<?php echo $cc; ?>" <?php if($CardType == $cc) { ?>selected="selected"<?php } ?>><?php echo $cc; ?></option>
								<?php } ?>
							</select>
						</div>
					<?php } else { ?>
						<input type="hidden" id="CardType" name="CardType" value="<?php echo esc_attr($CardType);?>" />
						<script>
							<!--
							jQuery(document).ready(function() {
									jQuery('#AccountNumber').validateCreditCard(function(result) {
										var cardtypenames = {
											"amex"                      : "American Express",
											"diners_club_carte_blanche" : "Diners Club Carte Blanche",
											"diners_club_international" : "Diners Club International",
											"discover"                  : "Discover",
											"jcb"                       : "JCB",
											"laser"                     : "Laser",
											"maestro"                   : "Maestro",
											"mastercard"                : "Mastercard",
											"visa"                      : "Visa",
											"visa_electron"             : "Visa Electron"
										};

										if(result.card_type)
											jQuery('#CardType').val(cardtypenames[result.card_type.name]);
										else
											jQuery('#CardType').val('Unknown Card Type');
									});
							});
							-->
						</script>
					<?php } ?>
				<div class="pmpro_checkout-field pmpro_payment-account-number">
					<label for="AccountNumber"><?php _e('Card Number', 'paid-memberships-pro' );?> *</label>
					<input id="AccountNumber" name="AccountNumber" class="input <?php echo pmpro_getClassForField("AccountNumber");?>" type="text" size="30" value="<?php echo esc_attr($AccountNumber); ?>" data-encrypted-name="number" autocomplete="off" />
				</div>
				<div class="pmpro_checkout-field pmpro_payment-expiration">
					<label for="ExpirationMonth"><?php _e('Expiration Date', 'paid-memberships-pro' );?> *</label>
					<select id="ExpirationMonth" name="ExpirationMonth" class=" <?php echo pmpro_getClassForField("ExpirationMonth");?>">
						<option value="01" <?php if($ExpirationMonth == "01") { ?>selected="selected"<?php } ?>>01</option>
						<option value="02" <?php if($ExpirationMonth == "02") { ?>selected="selected"<?php } ?>>02</option>
						<option value="03" <?php if($ExpirationMonth == "03") { ?>selected="selected"<?php } ?>>03</option>
						<option value="04" <?php if($ExpirationMonth == "04") { ?>selected="selected"<?php } ?>>04</option>
						<option value="05" <?php if($ExpirationMonth == "05") { ?>selected="selected"<?php } ?>>05</option>
						<option value="06" <?php if($ExpirationMonth == "06") { ?>selected="selected"<?php } ?>>06</option>
						<option value="07" <?php if($ExpirationMonth == "07") { ?>selected="selected"<?php } ?>>07</option>
						<option value="08" <?php if($ExpirationMonth == "08") { ?>selected="selected"<?php } ?>>08</option>
						<option value="09" <?php if($ExpirationMonth == "09") { ?>selected="selected"<?php } ?>>09</option>
						<option value="10" <?php if($ExpirationMonth == "10") { ?>selected="selected"<?php } ?>>10</option>
						<option value="11" <?php if($ExpirationMonth == "11") { ?>selected="selected"<?php } ?>>11</option>
						<option value="12" <?php if($ExpirationMonth == "12") { ?>selected="selected"<?php } ?>>12</option>
					</select>/<select id="ExpirationYear" name="ExpirationYear" class=" <?php echo pmpro_getClassForField("ExpirationYear");?>">
						<?php
							for($i = date_i18n("Y"); $i < intval( date_i18n("Y") ) + 10; $i++)
							{
						?>
							<option value="<?php echo $i?>" <?php if($ExpirationYear == $i) { ?>selected="selected"<?php } ?>><?php echo $i?></option>
						<?php
							}
						?>
					</select>
				</div>
				<?php
					$pmpro_show_cvv = apply_filters("pmpro_show_cvv", true);
					if($pmpro_show_cvv) { ?>
					<div class="pmpro_checkout-field pmpro_payment-cvv">
						<label for="CVV"><?php _e('Security Code (CVC)', 'paid-memberships-pro' );?></label>
						<input id="CVV" name="CVV" type="text" size="4" value="<?php if(!empty($_REQUEST['CVV'])) { echo esc_attr($_REQUEST['CVV']); }?>" class="input <?php echo pmpro_getClassForField("CVV");?>" />  <small>(<a href="javascript:void(0);" onclick="javascript:window.open('<?php echo pmpro_https_filter(PMPRO_URL); ?>/pages/popup-cvv.html','cvv','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=600, height=475');"><?php _e("what's this?", 'paid-memberships-pro' );?></a>)</small>
					</div>
				<?php } ?>
</div>			
				<?php if($pmpro_show_discount_code) { ?>
					<div class="pmpro_checkout-field pmpro_payment-discount-code">
						<label for="discount_code"><?php _e('Discount Code', 'paid-memberships-pro' );?></label>
						<input class="input <?php echo pmpro_getClassForField("discount_code");?>" id="discount_code" name="discount_code" type="text" size="10" value="<?php echo esc_attr($discount_code); ?>" />
						<input type="button" id="discount_code_button" name="discount_code_button" value="<?php _e('Apply', 'paid-memberships-pro' );?>" />
						<p id="discount_code_message" class="pmpro_message" style="display: none;"></p>
					</div>
				<?php } ?>
			</div> <!-- end pmpro_checkout-fields -->
			<?php if(!empty($sslseal)) { ?>
				<div class="pmpro_checkout-fields-rightcol pmpro_sslseal"><?php echo stripslashes($sslseal); ?></div>
			</div> <!-- end pmpro_checkout-fields-display-seal -->
			<?php } ?>
		</div> <!-- end pmpro_payment_information_fields -->
	
	<?php } ?>
		<p class="privacy-terms">By clicking “Let’s get started”, you agree to our <a data-fancybox data-src="#terms-content" href="javascript:;">terms of service</a> and <a data-fancybox data-src="#privacy-content" href="javascript:;">privacy policy</a>. </p>
	<script>
		<!--
		//checking a discount code
		jQuery('#discount_code_button').click(function() {
			var code = jQuery('#discount_code').val();
			var level_id = jQuery('#level').val();

			if(code)
			{
				//hide any previous message
				jQuery('.pmpro_discount_code_msg').hide();

				//disable the apply button
				jQuery('#discount_code_button').attr('disabled', 'disabled');

				jQuery.ajax({
					url: '<?php echo admin_url('admin-ajax.php'); ?>',type:'GET',timeout:<?php echo apply_filters("pmpro_ajax_timeout", 5000, "applydiscountcode");?>,
					dataType: 'html',
					data: "action=applydiscountcode&code=" + code + "&level=" + level_id + "&msgfield=discount_code_message",
					error: function(xml){
						alert('Error applying discount code [1]');

						//enable apply button
						jQuery('#discount_code_button').removeAttr('disabled');
					},
					success: function(responseHTML){
						if (responseHTML == 'error')
						{
							alert('Error applying discount code [2]');
						}
						else
						{
							jQuery('#discount_code_message').html(responseHTML);
						}

						//enable invite button
						jQuery('#discount_code_button').removeAttr('disabled');
					}
				});
			}
		});
		-->
	</script>
</div>
	<?php do_action('pmpro_checkout_after_payment_information_fields'); ?>

	<?php if($tospage && !$pmpro_review) { ?>
		<div id="pmpro_tos_fields" class="pmpro_checkout">
			<hr />
			<h3>
				<span class="pmpro_checkout-h3-name"><?php echo $tospage->post_title?></span>
			</h3>
			<div class="pmpro_checkout-fields">
				<div id="pmpro_license" class="pmpro_checkout-field">
<?php echo wpautop(do_shortcode($tospage->post_content));?>
				</div> <!-- end pmpro_license -->
				<input type="checkbox" name="tos" value="1" id="tos" /> <label class="pmpro_label-inline pmpro_clickable" for="tos"><?php printf(__('I agree to the %s', 'paid-memberships-pro' ), $tospage->post_title);?></label>
			</div> <!-- end pmpro_checkout-fields -->
		</div> <!-- end pmpro_tos_fields -->
		<?php
		}
	?>

	<?php do_action("pmpro_checkout_after_tos_fields"); ?>

	<?php do_action("pmpro_checkout_before_submit_button"); ?>

	<div class="pmpro_submit">
		<hr />
		<?php if($pmpro_review) { ?>

			<span id="pmpro_submit_span">
				<input type="hidden" name="confirm" value="1" />
				<input type="hidden" name="token" value="<?php echo esc_attr($pmpro_paypal_token); ?>" />
				<input type="hidden" name="gateway" value="<?php echo esc_attr($gateway); ?>" />
				<input type="submit" class="pmpro_btn pmpro_btn-submit-checkout" value="<?php _e('Complete Payment', 'paid-memberships-pro' );?> &raquo;" />
			</span>

		<?php } else { ?>

			<?php
				$pmpro_checkout_default_submit_button = apply_filters('pmpro_checkout_default_submit_button', true);
				if($pmpro_checkout_default_submit_button)
				{
				?>
				<span id="pmpro_submit_span">
					<input type="hidden" name="submit-checkout" value="1" />
					<input type="submit" class="pmpro_btn pmpro_btn-submit-checkout" value="<?php if($pmpro_requirebilling) { _e("Let's Get Started", 'paid-memberships-pro' ); } else { _e("Let's Get Started", 'paid-memberships-pro' );}?> &raquo;" />
				</span>
				<?php
				}
			?>

		<?php } ?>

		<span id="pmpro_processing_message" style="visibility: hidden;">
			<?php
				$processing_message = apply_filters("pmpro_processing_message", __("Processing...", 'paid-memberships-pro' ));
				echo $processing_message;
			?>
		</span>
	</div>
</form>

<?php do_action('pmpro_checkout_after_form'); ?>

</div> <!-- end pmpro_level-ID -->

<script>
<!--
	// Find ALL <form> tags on your page
	// On submit disable its submit button
	/*jQuery('form').submit(function(){
		
		jQuery('input[type=submit]', this).attr('disabled', 'disabled');
		jQuery('input[type=image]', this).attr('disabled', 'disabled');
		jQuery('#pmpro_processing_message').css('visibility', 'visible');
	});*/

	//iOS Safari fix (see: http://stackoverflow.com/questions/20210093/stop-safari-on-ios7-prompting-to-save-card-data)
	var userAgent = window.navigator.userAgent;
	if(userAgent.match(/iPad/i) || userAgent.match(/iPhone/i)) {
		jQuery('input[type=submit]').click(function() {
			try{
				jQuery("input[type=password]").attr("type", "hidden");
			} catch(ex){
				try {
					jQuery("input[type=password]").prop("type", "hidden");
				} catch(ex) {}
			}
		});
	}

	//add required to required fields
	//jQuery('.pmpro_required').after('<span class="pmpro_asterisk"> <abbr title="Required Field">*</abbr></span>');

	//unhighlight error fields when the user edits them
	jQuery('.pmpro_error').bind("change keyup input", function() {
		jQuery(this).removeClass('pmpro_error');
	});

	//click apply button on enter in discount code box
	jQuery('#discount_code').keydown(function (e){
	    if(e.keyCode == 13){
		   e.preventDefault();
		   jQuery('#discount_code_button').click();
	    }
	});

	//hide apply button if a discount code was passed in
	<?php if(!empty($_REQUEST['discount_code'])) {?>
		jQuery('#discount_code_button').hide();
		jQuery('#discount_code').bind('change keyup', function() {
			jQuery('#discount_code_button').show();
		});
	<?php } ?>

	//click apply button on enter in *other* discount code box
	jQuery('#other_discount_code').keydown(function (e){
	    if(e.keyCode == 13){
		   e.preventDefault();
		   jQuery('#other_discount_code_button').click();
	    }
	});
	jQuery('#add_admin_contact').on('click',function (e){
	    jQuery('#pmpro_administrative_fields').toggle();
	});
	
-->
</script>
<script>
<!--
//add javascriptok hidden field to checkout
jQuery("input[name=submit-checkout]").after('<input type="hidden" name="javascriptok" value="1" />');
-->
</script>




<div style="display: none;" id="privacy-content">
	<h3>Privacy Policy</h3>
	<p>Welcome to Living Legacies privacy policy page. We have developed this policy because we would like to tell how much we respect and value your privacy. At Living Legacies, safe guarding your privacy means so much to us. So, we tell you how we gather your information, how we use them and your rights regarding your information. </p>
	<p>Because we do not want to bore you with extensive legal terminology we shall state in simple terms everything you need to know about your personal information that we gather.</p>
	<p>Our privacy policy is in compliance with the General Data Protection Regulation for EEA users. </p>
	<h4>Our Privacy Policy</h4>
	<p>We thought it is necessary to tell you a little about the meaning of privacy policy. Privacy policy is a legal statement from us to you which explains why we collect your information, how we process it and how it is being stored.</p>
	<h4>Information We Collect</h4>
	<p>We collect certain types of information from you when you access our services. When you sign up for a user account or sign up for our newsletters or fill our contact form or pay for our services you provide us with the following information:</p>
	<p>Name(first and last) <br>Address <br>Phone number <br>Email Address <br>Billing information <br>Photograph </p>
	<p>There are other types of information which you do not provide to us, but we collect mechanically when you visit our site as a subscriber to our services or as a visitor. These information aregeneral technical information such as IP address of the device, location data, log file information,  browser information, unique mobile I D, device characteristics, operating system,  cookies, language preferences, referring URLs, information or actions taken on our site, dates and times of site visits, the pages accessed and other statistics (“data log”) to give you a better user experience. </p>
	<p>This Technical information that is gathered by our systems, or third-party systems, automatically may be used for operation, optimization, analytics, content promotion and enhancement of user experience. For more information on cookie, please read our cookie policy. </p>
	<h4>Information sharing</h4>
	<p>Living Legacies only shares personal information with third parties in the following limited circumstances:</p>
	<ul>
		<li>We have your consent. We require opt-in consent for the sharing of any sensitive personal information</li>
		<li>We provide such information to our subsidiaries, affiliated companies or other trusted businesses or persons for the purpose of processing personal information on our behalf. We require that these parties agree to process such information based on our instructions and in compliance with this Privacy Policy and any other appropriate confidentiality and security measures.</li>
		<li>We have a good faith belief that access, use, preservation or disclosure of such information is reasonably necessary to:
			<ul>
				<li>satisfy any applicable law, regulation, legal process or enforceable governmental request;</li>
				<li>enforce applicable Terms of Service, including investigation of potential violations thereof;</li>
				<li>detect, prevent, or otherwise address fraud, security or technical issues, or;</li>
				<li>protect against imminent harm to the rights, property or safety of Living Legacies, its users or the public as required or permitted by law.</li>
			</ul>
		</li>
	</ul>
	<h4>How Living Legacies Use Your Information</h4>
	<p>We use your information in the following ways:</p>
	<ul>
		<li>To provide our Services to you. </li>
		<li>To send emails to you or respond to your inquiries about our services. </li>
		<li>To provide customer support services to you</li>
		<li>To tailor the content and information that we may send or display to you, to offer location customization (where permitted by applicable law), personalized help and instructions and to improve the services we provide to you.</li>
	</ul>
	<h4>Storing and Processing Your Information</h4>
	<p>Any personal information we collect through our website is stored and processed in the United States.  We may transfer information that we collect about you, including personal information, to affiliated entities, or to other third parties across borders and from your country or jurisdiction to other countries or jurisdictions around the world. As a result, we may transfer information, including personal information, to a country and jurisdiction that does not have the same data protection laws as your jurisdiction, and you consent to the transfer of information to the United States or any other country in which Living Legacies or its subsidiaries or service providers maintain facilities and the use and disclosure of information about you as described in this Privacy Policy.</p>
	<h4>Retention of your information</h4>
	<p>Generally, we will only retain  your personal information for as long as we need it to provide our services to you and in compliance with the law.</p>
	<h4>Living Legacies protect your information across borders (FOR EEA USERS ONLY )</h4>
	<p>Living Legacies may transmit your personal information outside of the country, state, or province in which you are located. If you are located in the EEA and believe that your Personal Information has been used in a manner that is not consistent with the relevant privacy policies listed above, please contact us using by sending us an email at <a href="mailto:help@livinglegacies.com">help@livinglegacies.com</a></p>
	<h4>Controlling your personal information</h4>
	<p>You may choose to restrict the collection or use of your personal information in the following ways:</p>
	<ul>
		<li>If you have previously agreed to us using your personal information for direct marketing purposes, you may change your mind at any time by writing to or emailing at help@livinglegacies.com</li>
		<li>Whenever you are asked to fill in a form on the website, look for the box that you can click to indicate that you do not want the information to be used by anybody for direct marketing purposes.</li>
	</ul>
	<h4>Your Rights to your information</h4>
	<p>You may request details of personal information which we hold about you. You make request that we erase your personal information or correct any inaccuracies in your personal information. You may also make a request that we transfer your personal information to a third party. You may also request for information on whether your personal data is being processed and for what purpose is being used. The requested information will be sent to you in an electronic format. If we cannot carry out your request due to a legitimate reason we shall promptly inform you. </p>
	<h4>Security</h4>
	<p>We affirm that the security of your personal data is key and as a result we shall ensure we provide adequate measures to keep your personal data secure. But the internet is not overly secure and we cannot warrant the safety of your personal data. Consequently, where there is a breach of the security of your personal data we shall inform you this breach and commence the necessary steps to investigate the breach.  </p>
	<h4>Links to other websites</h4>
	<p>Our site may have links to third-party websites. Once you click on these links you leave our website. Third party sites are not governed by this privacy policy and we do not take liability for the presence or absence of privacy protection. You should read the privacy policy of the third-partywebsite in question.</p>
	<h4>Children Privacy Protection</h4>
	<p>We do not intentionally contact or collect personal information from children under 13. If you believe we have unintentionally collected such information, please contact us so we can promptly obtain parental consent or delete the information</p>
	<h4>Changes</h4>
	<p>We may update our Privacy Policy from time to time. You shall be told of any changes to the privacy policy by a pop up box on our site or by email where the law permits it. </p>
	<h4>Need to ask questions?</h4>
	<p>If you have any questions, explanations concerning this policy contact us via email at <a href="mailto:help@livinglegacies.com">help@livinglegacies.com</a> and we shall reply promptly.</p>
</div>

<div style="display: none;" id="terms-content">
	<h3>TERMS AND CONDITIONS – LIVING LEGACIES</h3>
	<h4>Acceptance of Our Terms</h4>
	<p>Hey!</p>
	<p>Its good to have you on livinglegacies.com(site) by opening, reading or using the services provided on this site you consent to be bound by these Terms and Conditions of Service (Terms) laid out herein.</p>
	<p>If you disapprove and disagree withthese Terms and Conditions you should promptly exit the website and terminate your use of our services.  These Terms creates a legally binding relationship between you and Living Legacies (“us” “we” “our”).  We ask that you create time to thoroughly read these Terms and Conditions which will govern our relationship.</p>
	<h4>Service</h4>
	<p>These Terms apply to all users of the Service, including users who are also contributors of Content on the Service. “Content” includes the text, software, scripts, graphics, photos, sounds, music, audio, videos, audiovisual combinations, interactive features and other materials you may view on, access through, or contribute to the Service.</p>
	<h4>Barred Uses</h4>
	<p>There are certain uses of livinglegacies.com highlighted below which we expressly prohibit and condemn and which we have classified as “Barred Uses”.  Although this list is not exhaustive, but it should serve as a guide as to the conducts, actions and manners which we frown at. </p>
	<p>Thus, you shall not use Living Legacies for: </p>
	<ul>
		<li>Illegality </li>
		<li>Fraudulent activities </li>
		<li>Immorality including pornography </li>
		<li>Private trading purposes</li>
		<li>Acts contrary to applicable laws and regulations </li>
		<li>To impair the performance of the site</li>
		<li>Corrupt the content or otherwise reduce the overall functionality of the website. </li>
		<li>Compromise the security of the website or attempt to gain access to secured areas or sensitive information.</li>
		<li>Lewd or offensive </li>
		<li>Defamatory </li>
	</ul>
	<h4>Indemnity</h4>
	<p>You agree to be fully responsible for any claim, expense, liability, losses, costs including legal fees incurred by us arising from any infringement of the terms and conditions set out in this agreement.</p>
	<h4>Intellectual Property </h4>
	<p>Living Legacies ’s name, logo, content, features and functionality and other Living Legacies   service marks, trademarks, graphics, design rights, patents and other intellectual property rights used in connection with livinglegacies.com are the trademarks of Living Legacies and its exclusive property.  Living Legacies’s trademarks and copyrights may not be copied, imitated or used, in whole or in part in connection with any trade or services without the express written approval of Living Legacies. The content featured in livinglegacies.com save for third party content are protected by copyright, trademark, patent and other intellectual property and proprietary rights which are reserved to Living Legacies and its licensors. All other third-party content are the intellectual property of the respective owners and are protected by intellectual property laws. </p>
	<h4>Videos and Audios You Upload</h4>
	<p>You agree not to upload videos or audios that are : </p>
	<ul>
		<li>factually inaccurate or misleading;</li>
		<li>harmful, threatening, abusive, vulgar or hateful;</li>
		<li>harm minors in any way;</li>
		<li>that would cause us, to the extent that we use the Content as permitted under this Agreement, to violate any United states  or foreign law or regulation;</li>
		<li>violates any person’s privacy right;</li>
		<li>obscene or derogatory or contains any adult-oriented content, like sexual material;</li>
		<li>promotes violence, firearms, ammunition or weapons designed to inflict serious bodily harm;</li>
		<li>constitute or contribute to a crime or tort;</li>
		<li>create a risk of harm, loss, physical or mental injury, emotional distress, death, disability, disfigurement, or physical or mental illness to you, to any other person, or to any animal;</li>
		<li>create a risk of any other loss or damage to any person or property.</li>
	</ul>
	<h4>Rights on Videos and Audios You Upload </h4>
	<p>By uploading materials including videos and audios on our site you agree that those materials are non-proprietary and non-confidential information.  Except indicated otherwise, you grant Living Legacies and its affiliates exclusive, royalty-free, perpetual, irrevocable, and fully sublicensable right to use, reproduce, modify, adapt, publish, translate, create derivative works from, distribute, and display such material throughout the world in any media. You grant Living Legacies and its affiliates the right to use the name you submit in connection with such material, if they so choose. All personal information provided via this Site will be handled in accordance with the Site’s online privacy policy. You further represent that you own or otherwise control all the rights to the content you post. </p>
	<h4>Third Party Content</h4>
	<p>By the nature of the services we provide, videos, audios and pictorial content is posted by members of the community. As such, weare not liable for any alleged intellectual property rights infringement and will only take down the content when it is established that there has been an infringement of intellectual property rights of third-parties. Due to the vast materials   posted on site, we find it practically impossible to compare contents to ascertain authenticity and will only take down or act on a takedown notice alleging intellectual property rights infringement. </p>
	<h4>Links To Other Web Sites </h4>
	<p>Living Legacies website might contain links to other websites, by clicking on those links you have effectively left the website of Living Legacies.  These Terms does not govern third party websites and Living Legacies shall not be liable for any third party websites that you link to. You should read and agreeing (or disagree) with the Terms and Conditions of these third party websites.</p>
	<h4>Limitation of Liability</h4>
	<p>Living Legacies will under no circumstance be liable for indirect, special, or consequential damages including any loss of business, revenue, profits, or data in relation to your use of the Website.</p>
	<h4>Virus Disclaimer</h4>
	<p>Although reasonable steps have been taken to guard this website by anti-virus software but all visitors and users are advised to take all necessary steps to ensure that no virus contamination occurs. No responsibility can be accepted for any loss or damage sustained as a consequence of any virus transmission.</p>
	<h4>Disclaimers</h4>
	<p>The information contained in the website is provided on an "as is" basis with no warranties expressed or otherwise implied relating to the accuracy, fitness for purpose, compatibility or security of any components of the Website or its subscribers or Members.</p>
	<p>We do not guarantee uninterrupted availability of the website and cannot provide any representation that using the website will be error free.</p>
	<p>YOU AGREE THAT YOUR USE OF THE SERVICES SHALL BE AT YOUR SOLE RISK. TO THE FULLEST EXTENT PERMITTED BY LAW.LIVING LEGACIES, ITS OFFICERS, DIRECTORS, EMPLOYEES, AND AGENTS DISCLAIM ALL WARRANTIES, EXPRESS OR IMPLIED, IN CONNECTION WITH THE SERVICES AND YOUR USE THEREOF. LIVING LEGACIES MAKES NO WARRANTIES OR REPRESENTATIONS ABOUT THE ACCURACY OR COMPLETENESS OF THIS SITE'S CONTENT OR THE CONTENT OF ANY SITES LINKED TO THIS SITE AND ASSUMES NO LIABILITY OR RESPONSIBILITY FOR ANY (I) ERRORS, MISTAKES, OR INACCURACIES OF CONTENT, (II) PERSONAL INJURY OR PROPERTY DAMAGE, OF ANY NATURE WHATSOEVER, RESULTING FROM YOUR ACCESS TO AND USE OF OUR SERVICES, (III) ANY UNAUTHORIZED ACCESS TO OR USE OF OUR SECURE SERVERS AND/OR ANY AND ALL PERSONAL INFORMATION AND/OR FINANCIAL INFORMATION STORED THEREIN, (IV) ANY INTERRUPTION OR CESSATION OF TRANSMISSION TO OR FROM OUR SERVICES, (IV) ANY BUGS, VIRUSES, TROJAN HORSES, OR THE LIKE WHICH MAY BE TRANSMITTED TO OR THROUGH OUR SERVICES BY ANY THIRD PARTY, AND/OR (V) ANY ERRORS OR OMISSIONS IN ANY CONTENT OR FOR ANY LOSS OR DAMAGE OF ANY KIND INCURRED AS A RESULT OF THE USE OF ANY CONTENT POSTED, EMAILED, TRANSMITTED, OR OTHERWISE MADE AVAILABLE VIA THE SERVICES. LIVING LEGACIES DOES NOT WARRANT, ENDORSE, GUARANTEE, OR ASSUME RESPONSIBILITY FOR ANY PRODUCT OR SERVICE ADVERTISED OR OFFERED BY A THIRD PARTY THROUGH THE SERVICES OR ANY HYPERLINKED SERVICES OR FEATURED IN ANY BANNER OR OTHER ADVERTISING, AND LIVING LEGACIES  WILL NOT BE A PARTY TO OR IN ANY WAY BE RESPONSIBLE FOR MONITORING ANY TRANSACTION BETWEEN YOU AND THIRD-PARTY PROVIDERS OF PRODUCTS OR SERVICES. AS WITH THE PURCHASE OF A PRODUCT OR SERVICE THROUGH ANY MEDIUM OR IN ANY ENVIRONMENT, YOU SHOULD USE YOUR BEST JUDGMENT AND EXERCISE CAUTION WHERE APPROPRIATE.</p>
	<h4>Living Legacies Account</h4>
	<p>In order to access some features of our Service, such as uploading and storing videos, audios and pictures you will have to sign -up for our services by creating an account. You must never use a third party's account without his or her consent. When creating your account, you must provide precise and complete information. You must keep your account password secure and you are solely responsible for the activity that occurs on your account. Should they be a breach of security or unauthorized use of your account you must notify Living Legacies immediately. </p>
	<p>You may be liable for the losses of Living Legacies or others due to unauthorized use of your account. However, Living Legacies shall not be liable for your losses resulting from the unauthorized use of your account. </p>
	<h4>Account Termination Policy</h4>
	<p>Living Legacies will terminate a user's access to the Service if, under appropriate circumstances, the user is determined to be a repeat infringer.</p>
	<p>Living Legacies reserve the exclusive right to decide whether Content violates these Terms and Conditions of Service for reasons other than copyright infringement, such as, but not limited to, pornography or obscenity. Living Legacies may at any time, without prior notice and in its sole discretion, remove such Content and/or terminate a user's account for submitting such material in violation of these Terms.</p>
	<h4>Cancellation of Services</h4>
	<p>Users also have the right to cancel or terminate these services at any time. However, cancellation of the services does not attract a refund. </p>
	<h4>Other Terms</h4>
	<ol>
		<li>Our Site is accessible without charge, although subscription to our services attract a fee. We cannot and do not guarantee that livinglegacies.com will always be functional.  There are times when it might be necessary for us to suspend or limit accessibility to any or all parts of the site for operational or any other reasons. We shall endeavour to notify you prior to any planned suspension or limitation of accessibility of our site.</li>
		<li>You must ensure that all persons who access our site through your system or internet connection are in the know of these Terms  and other applicable policies.</li>
	</ol>
	<h4>Governing Law</h4>
	<p>This Terms and Conditions is governed by the laws of the United States without regard to the conflict of laws principles.</p>
	<h4>Reach out to us</h4>
	<p>Should you have any queries or questions pertaining to these Terms, why not send us an email at <a href="mailto:help@livinglegacies.com">help@livinglegacies.com</a> or give us a call on +323-707-7868.</p>
	<h4>Cookies Policy</h4>
	<p>Living Legacies uses cookies.  These are miniaturefiles (about 4kb) that are downloaded to your computer, to improve your experience. Cookies are quite important because it helps to identify your activities on our site, it tells us the pages you visited and the actions you took. It also helps you to recall your details when next you visit our site.</p>
	<p>This cookie policy explains the information we gather and why need to store these cookies.</p>
	<p>We will also tell you how you can prevent these cookies from being stored however this may relegate certain elements of the sites functionality.</p>
	<p>Many of the cookies placed through our Site are session cookies, while others are persistent cookies, and some are “first-party” cookies, while others are “third-party” cookies.</p>
	<p>Some of the cookies placed through our site on your browser are: </p>
	<ul>
		<li><strong>First-party cookies</strong> are those set by our site when you visit our site at the time. </li>
		<li><strong>Third-party cookies</strong> are cookies that are set by a domain other than  our site. If a user visits a Site and another entity sets a cookie through that Site, this would be a third-party cookie.</li>
		<li><strong>Persistent cookies</strong> are cookies that remain on a user’s device for the period of time specified in the cookie. They are activated each time that the user visits the Site that created that particular cookie.</li>
		<li><strong>Session cookies</strong> are cookies that allow Site operators to link the actions of a user during a browser session. A browser session starts when a user opens the browser window and finishes when they close the browser window. Session cookies are created temporarily. Once you close the browser, all session cookies are deleted.</li>
		<li><strong>Functionality cookies:</strong> To ensure we provide you with a fantastic experience on this site we provide the functionality cookie to set your preferences for how this site runs when you use it. In order to recall your preferences, we need to set cookies so that this information can be called whenever you interact with a page that is affected by your preferences.</li>
	</ul>
	<h4>Withdrawyour consent</h4>
	<p>If you do not wish to accept cookies in connection with your use of our Site, you will need to disable cookies via your browser settings. Although disabling cookies will likely affect the functionality of our Site.</p>
	<h4>How to Manage and Delete Your Cookies</h4>
	<p>Most internet browsers are initially setup to automatically accept cookies. Unless you have adjusted your browser settings to refuse cookies, our system will issue cookies when you direct your browser to our site. You can refuse to receive cookies by activating the appropriate setting on your browser. Be aware that restricting the use of cookies will impact the functionality of our site. As a result, you may be unable to enter certain parts of our siteor use some of our services.</p>
	<h4>Web Beacons and Analytics Services</h4>
	<p>Living Legacies may contain electronic images known as web beacons (or single-pixel gifs) that we use to help deliver cookies on our site, count users who have visited the Site, and deliver content and advertising. We also include web beacons in our promotional email messages and newsletters to determine whether you open and act on them.</p>
</div>