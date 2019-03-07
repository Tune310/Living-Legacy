<?php /*
global $wpdb, $pmpro_msg, $pmpro_msgt, $current_user;

$pmpro_levels = pmpro_getAllLevels(false, true);
$pmpro_level_order = pmpro_getOption('level_order');

if(!empty($pmpro_level_order))
{
	$order = explode(',',$pmpro_level_order);

	//reorder array
	$reordered_levels = array();
	foreach($order as $level_id) {
		foreach($pmpro_levels as $key=>$level) {
			if($level_id == $level->id)
				$reordered_levels[] = $pmpro_levels[$key];
		}
	}

	$pmpro_levels = $reordered_levels;
}

$pmpro_levels = apply_filters("pmpro_levels_array", $pmpro_levels);

if($pmpro_msg)
{
?>
<div class="pmpro_message <?php echo $pmpro_msgt?>"><?php echo $pmpro_msg?></div>
<?php
}
?>
<table id="pmpro_levels_table" class="pmpro_checkout">
<thead>
  <tr>
	<th><?php _e('Level', 'paid-memberships-pro' );?></th>
	<th><?php _e('Price', 'paid-memberships-pro' );?></th>	
	<th>&nbsp;</th>
  </tr>
</thead>
<tbody>
	<?php	
	$count = 0;
	foreach($pmpro_levels as $level)
	{
	  if(isset($current_user->membership_level->ID))
		  $current_level = ($current_user->membership_level->ID == $level->id);
	  else
		  $current_level = false;
	?>
	<tr class="<?php if($count++ % 2 == 0) { ?>odd<?php } ?><?php if($current_level == $level) { ?> active<?php } ?>">
		<td><?php echo $current_level ? "<strong>{$level->name}</strong>" : $level->name?></td>
		<td>
			<?php 
				if(pmpro_isLevelFree($level))
					$cost_text = "<strong>" . __("Free", 'paid-memberships-pro' ) . "</strong>";
				else
					$cost_text = pmpro_getLevelCost($level, true, true); 
				$expiration_text = pmpro_getLevelExpiration($level);
				if(!empty($cost_text) && !empty($expiration_text))
					echo $cost_text . "<br />" . $expiration_text;
				elseif(!empty($cost_text))
					echo $cost_text;
				elseif(!empty($expiration_text))
					echo $expiration_text;
			?>
		</td>
		<td>
		<?php if(empty($current_user->membership_level->ID)) { ?>
			<a class="pmpro_btn pmpro_btn-select" href="<?php echo pmpro_url("checkout", "?level=" . $level->id, "https")?>"><?php _e('Select', 'paid-memberships-pro' );?></a>
		<?php } elseif ( !$current_level ) { ?>                	
			<a class="pmpro_btn pmpro_btn-select" href="<?php echo pmpro_url("checkout", "?level=" . $level->id, "https")?>"><?php _e('Select', 'paid-memberships-pro' );?></a>
		<?php } elseif($current_level) { ?>      
			
			<?php
				//if it's a one-time-payment level, offer a link to renew				
				if( pmpro_isLevelExpiringSoon( $current_user->membership_level) && $current_user->membership_level->allow_signups ) {
					?>
						<a class="pmpro_btn pmpro_btn-select" href="<?php echo pmpro_url("checkout", "?level=" . $level->id, "https")?>"><?php _e('Renew', 'paid-memberships-pro' );?></a>
					<?php
				} else {
					?>
						<a class="pmpro_btn disabled" href="<?php echo pmpro_url("account")?>"><?php _e('Your&nbsp;Level', 'paid-memberships-pro' );?></a>
					<?php
				}
			?>
			
		<?php } ?>
		</td>
	</tr>
	<?php
	}
	?>
</tbody>
</table>

*/ ?>



		<div class="pricing-plans v2" id="pricing-plan">
			<div class="choose-plan">
					<h4>Please choose a plan</h4>
					<p>Already have an account? <a href="<?php echo get_permalink(get_page_by_title('Login Page')); ?>">Re-Enter</a></p>
				<div class="white-bg-row v2">
					<div class="plan-wrapper">
						<div class="plan-box v2">
							<div class="plan-price">
								<div>7</div>
								<div>
									<span>.99</span>
									<small>a month</small>
								</div>
							</div>
							<div class="plan-storage">
								<div>unlimited</div>
								<span>Storage<i></i></span>
							</div>
						</div>
					
						<ul>
							<li>Use our easy-to-use, built-in tools to record video, upload home movies, pictures, documents, music and much more!</li>
							<li>Storage security guaranteed. Everything is backed up! <i class="lock-icon-v2"></i></li>
							<li>Full customer care is included!</li>
							<li>Cancel for free at anytime!</li>
						</ul>
						
						
						<a class="btn btn-dark-blue" href="/my-account/plan-checkout/?level=3">Select</a>							
						
					</div>

					
					<?php /*
					
					
				<?php
						if ( is_user_logged_in() ) {
							$user_id = get_current_user_id();
							$level = pmpro_getMembershipLevelsForUser($user_id);
							if(!empty($level)){	
								if($level[0]->ID!=4){
                        ?>
					<div class="col-4 pricing-last">
						<div class="approx">Additional <br>Storage</div>
						<div class="plan-box">
							<div class="plan-title"></div>
							<div class="plan-price">
								<div>1</div>
								<div>
									<small>a month</small>
								</div>
								
							</div>
							<div class="plan-space"><span>5</span>Gigabytes</div>
						</div>
						<!-- End plan box -->
						
						<ul>
							<li>Add additional storage to your existing plan</li>
						</ul>
                        
						<a class="btn btn-dark-blue" href="/product/5-gigabytes-storage/">Select</a>						
                        
					</div>
                    <?php }
							}
						}?>
					<!-- End col-4 -->
					*/ ?>
					
				</div><!-- End row -->

				<div class="plans-btns">
					<p>We use the highest level of security to protect your content.<br>  
					Everything is backed up! </p>
				</div>
				
			</div><!-- End container -->
		</div><!-- End pricing plans -->




<?php /*

<nav id="nav-below" class="navigation" role="navigation">
	<div class="nav-previous alignleft">
		<?php if(!empty($current_user->membership_level->ID)) { ?>
			<a href="<?php echo pmpro_url("account")?>" id="pmpro_levels-return-account"><?php _e('&larr; Return to Your Account', 'paid-memberships-pro' );?></a>
		<?php } else { ?>
			<a href="<?php echo home_url()?>" id="pmpro_levels-return-home"><?php _e('&larr; Return to Home', 'paid-memberships-pro' );?></a>
		<?php } ?>
	</div>
</nav>
*/ ?>