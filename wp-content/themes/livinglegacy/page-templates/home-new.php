<?php
/*
Template Name: Home New
Template Post Type: page
*/

get_header(); ?>

<div class="header-banner have-pics-bottom">
	<div class="container row">
		<div class="col-6">  
			<h1><span>Record <svg viewBox="0 0 16 15"><path class="cls-1" d="M-0.009,14.993L2.86,7.5-0.009.007,16.009,7.5Z"/></svg> Save <svg viewBox="0 0 16 15"><path class="cls-1" d="M-0.009,14.993L2.86,7.5-0.009.007,16.009,7.5Z"/></svg> Share</span> <br>your greatest memories forever</h1>
			<a class="btn btn-white" href="<?php bloginfo('url'); ?>/my-account/membership-levels/">Sign Me Up!</a>
			<a class="btn btn-gradient" href="<?php bloginfo('url'); ?>/my-account/plan-checkout/?level=4">Try It Free!</a>
			<h3>Archive your life!</h3>
			<a class="green-btn" data-fancybox data-src="#ll-invite-popup" href="javascript:;">Invite</a>
			<div class="btn-tagline">Invite someone to experience this site</div>
		</div>
		<div class="col-6">
			<img src="<?php bloginfo('template_directory'); ?>/images/contributor-header-img-single-screen.png" alt=""/>
		</div>
	</div>
	
	<div class="pictures-bottom">
		<img src="<?php bloginfo('template_directory'); ?>/images/pictures-bottom.png" alt=""/>
	</div>
</div>



<div class="record-section text-img-section">
	<div class="container row">
		<div class="col-6">
			<img src="<?php bloginfo('template_directory'); ?>/images/img-1.png" alt="" />
		</div>
		<div class="col-6">
			<h2><span>Record</span> your personal history!</h2>
			<h5>Stay connected to your family for generations to come. </h5>
			<p>Choose from 100’s of  thoughtful questions that range from your basic biography to deeper insights. You can also create and answer your own. Tell your story!</p>
			
			<div class="green-btn-txt multiple-btns">
				<span>personal history sample</span>
				<a class="green-btn" href="<?php bloginfo('template_directory'); ?>/images/ll-sample-history-post.jpg" data-fancybox="ll-sample-history-post" data-width="1000" data-height="1714">sample</a>
				<a class="green-btn" href="/question-list/">questions</a>				
				<span>over 100 thoughtful questions</span>
			</div>
		</div>
	</div>
</div>


<div class="special-events v2">
	<div class="container row">
		
		<h2><span>Collaborate</span> with your family and friends!</h2>
		<img class="img-center" src="<?php bloginfo('template_directory'); ?>/images/img-5-2.png" alt="" />
			
		<div class="col-6">
			<h3>Celebrate the life of a loved one.</h3>
			<p> Create a web page for your loved one and invite their friends and family to contribute to their legacy!</p>
			<ul>
				<li>Record video and audio tributes</li>
				<li>Write or record memorable stories</li>
				<li>Add pictures, home videos, letters, ANYTHING!</li>
				<li>Share and celebrate their life for generations to come!</li>
			</ul>
			<a class="green-btn" href="<?php bloginfo('template_directory'); ?>/images/ll-sample-contributor-post.jpg" data-fancybox="ll-sample-contributor-post" data-width="1000" data-height="1523">Sample</a>			
		</div>
		<div class="col-1">
			<span class="divider white"></span>
			<a class="learn-more" href="<?php bloginfo('url'); ?>/how-it-works-tributes/">learn more</a>
				<div class="social-share on-page">
                <?php
					global $post;
						$fb_share_url = 'https://www.facebook.com/sharer.php?u='.home_url();												
						$pin_share_url = 'http://pinterest.com/pin/create/link/?url='.home_url();
						$tw_share_url = 'https://twitter.com/intent/tweet?url='.home_url();
						$google_share_url = 'https://plus.google.com/share?url='.home_url();
						$in_share_url = 'http://www.linkedin.com/shareArticle?url='.home_url();
						$tumb_share_url = 'http://www.tumblr.com/share/link?url='.home_url();
						$insta_share_url = '#'.home_url();
						$whatsapp_share_url = '#'.home_url();

					?>
					<ul>
						<li>
							<a href="<?php echo $fb_share_url ;?>" target="_blank">
								<img src="<?php bloginfo('template_directory'); ?>/images/social-fb.png" alt="" />
							</a>
						</li>						
						<li>
							<a href="<?php echo $insta_share_url ;?>" target="_blank">
								<img src="<?php bloginfo('template_directory'); ?>/images/social-insta.png" alt="" />
							</a>
						</li>						
						<li>
							<a href="<?php echo $tw_share_url;?>" target="_blank">
								<img src="<?php bloginfo('template_directory'); ?>/images/social-twitter.png" alt="" />
							</a>
						</li>
						<li>
							<a href="<?php echo $pin_share_url;?>" target="_blank">
								<img src="<?php bloginfo('template_directory'); ?>/images/social-pin.png" alt="" />
							</a>
						</li>
						<li>
							<a href="<?php echo $whatsapp_share_url;?>" target="_blank">
								<img src="<?php bloginfo('template_directory'); ?>/images/social-whatsapp.png" alt="" />
							</a>
						</li>
						<li>
							<a href="<?php echo $google_share_url;?>" target="_blank">
								<img src="<?php bloginfo('template_directory'); ?>/images/social-google.png" alt="" />
							</a>
						</li>
						<li>
							<a href="<?php echo $in_share_url;?>" target="_blank">
								<img src="<?php bloginfo('template_directory'); ?>/images/social-in.png" alt="" />
							</a>
						</li>
						<li>
							<a href="<?php echo $tumb_share_url;?>" target="_blank">
								<img src="<?php bloginfo('template_directory'); ?>/images/social-tumb.png" alt="" />
							</a>
						</li>
					</ul>
					<p>Share This Site</p>
				</div>
		</div>
		<div class="col-6">
			<h3>Celebrate a special event.</h3>
			<p>Create a web page for your special event and invite your friends and family to contribute to it’s legacy!</p>
			<ul>
				<li>Weddings, birthdays, family vacations, graduations and more!</li>
				<li>Write or record memorable stories about the event.</li>
				<li>Add pictures, home videos, letters, ANYTHING!</li>
				<li>Store and share your special events for generations to come!</li>
			</ul>
			<a class="green-btn" href="<?php bloginfo('template_directory'); ?>/images/ll-sample-wedding-post.jpg" data-fancybox="ll-sample-wedding-post" data-width="1000" data-height="1523">Sample</a>			
		</div>
	</div>
	
	
	<div class="events-bottom">
		<img src="<?php bloginfo('template_directory'); ?>/images/pictures-bottom-2.png" alt=""/>
	</div>
	
</div>


<div class="say-section text-img-section img-right">
	<div class="container row">
		<div class="col-6">
			<img src="<?php bloginfo('template_directory'); ?>/images/img-2.png" alt="" />
		</div>
		<div class="col-6">
			<h2><span>Say</span> cheese!</h2>
			<h5>Record video or audio online with our <br>built-in, easy-to-use tools.</h5>
			<p>You can use your camera from your desktop, laptop, tablet or phone.  When you’re satified with your recording, the file will be securely  and automatically uploaded to our website. </p>
			
			<span class="divider"></span>
			<a class="learn-more" href="<?php bloginfo('url'); ?>/how-it-works-history/">learn more</a>
		</div>
	</div>
</div>


<div class="stuff-section text-img-section">
	<div class="container row">
		<div class="col-6">
			<img src="<?php bloginfo('template_directory'); ?>/images/img-3.png" alt="" />
			<div class="img-desc">Permanently store your entire digital life!</div>
		</div>
		<div class="col-6">
			<h2><span>All</span> your stuff!</h2>
			<h5>Every picture, home movie, letter or document has a story. Tell it.</h5>
			<p>Enhance every story with pictures, home movies,  love letters, diplomas, music, maps, birth certificates and more. We’ve created a Memory Vault  for you to fill with everything you. </p>
			
			<div class="green-btn-txt">
				<span>Check out</span>
				<a class="green-btn" href="<?php bloginfo('template_directory'); ?>/images/ll-sample-memory-vault.jpg" data-fancybox="ll-sample-memory-vault" data-width="1000" data-height="1121">memory vault</a>
				<span>the Memory Vault</span>
				
			</div>
		</div>
	</div>
</div>


<div class="personal-section text-img-section img-right">
	<div class="container row">
		<div class="col-6">
			<img src="<?php bloginfo('template_directory'); ?>/images/img-4.png" alt="" />
			<div class="img-desc">Create messages to be opened now or far into the future!</div>
		</div>
		<div class="col-6">
			<h2><div>New</div>Create personal messages!</h2>
			<h5>Write or record a personal message to a loved one. </h5>
			<p>Can you imagine creating a future message to your granddaughter on her wedding day. Tell her you love her and even give her some sound advice. Then, in the future when your granddaughter opens your message on her wedding day, she’ll have an unforgettable moment with you. </p>
			
			<span class="divider"></span>
			<a class="learn-more" href="<?php bloginfo('url'); ?>/how-it-works-messages/">learn more</a>
		</div>
	</div>
</div>




<div class="testimonials">
	<div class="container">
		<ul id="testimonial">
			<li>
				<img src="<?php bloginfo('template_directory'); ?>/images/testimonial.png" alt="" />
				<p>It was so simple. I signed in, wrote and recorded a life-changing story about  joining the Peace Corps in VIetnam. I know this memory will be of great use to my current and future family. I’m not going to be around forever, but my message will be. Thanks, Living Legacies.</p>
				<span>- Mary B.</span>
			</li>
			<li>
				<img src="<?php bloginfo('template_directory'); ?>/images/testimonial.png" alt="" />
				<p>It was so simple. I signed in, wrote and recorded a life-changing story about  joining the Peace Corps in VIetnam. I know this memory will be of great use to my current and future family. I’m not going to be around forever, but my message will be. Thanks, Living Legacies.</p>
				<span>- Mary B.</span>
			</li>
			<li>
				<img src="<?php bloginfo('template_directory'); ?>/images/testimonial.png" alt="" />
				<p>It was so simple. I signed in, wrote and recorded a life-changing story about  joining the Peace Corps in VIetnam. I know this memory will be of great use to my current and future family. I’m not going to be around forever, </p>
				<span>- Mary B.</span>
			</li>
		</ul>
		
				<div class="social-share on-page">
                <?php
					global $post;
						$fb_share_url = 'https://www.facebook.com/sharer.php?u='.home_url();												
						$pin_share_url = 'http://pinterest.com/pin/create/link/?url='.home_url();
						$tw_share_url = 'https://twitter.com/intent/tweet?url='.home_url();
						$google_share_url = 'https://plus.google.com/share?url='.home_url();
						$in_share_url = 'http://www.linkedin.com/shareArticle?url='.home_url();
						$tumb_share_url = 'http://www.tumblr.com/share/link?url='.home_url();
						$insta_share_url = '#'.home_url();
						$whatsapp_share_url = '#'.home_url();
					?>
					<ul>
						<li>
							<a href="<?php echo $fb_share_url ;?>" target="_blank">
								<img src="<?php bloginfo('template_directory'); ?>/images/social-fb.png" alt="" />
							</a>
						</li>						
						<li>
							<a href="<?php echo $insta_share_url ;?>" target="_blank">
								<img src="<?php bloginfo('template_directory'); ?>/images/social-insta.png" alt="" />
							</a>
						</li>						
						<li>
							<a href="<?php echo $tw_share_url;?>" target="_blank">
								<img src="<?php bloginfo('template_directory'); ?>/images/social-twitter.png" alt="" />
							</a>
						</li>
						<li>
							<a href="<?php echo $pin_share_url;?>" target="_blank">
								<img src="<?php bloginfo('template_directory'); ?>/images/social-pin.png" alt="" />
							</a>
						</li>
						<li>
							<a href="<?php echo $whatsapp_share_url;?>" target="_blank">
								<img src="<?php bloginfo('template_directory'); ?>/images/social-whatsapp.png" alt="" />
							</a>
						</li>
						<li>
							<a href="<?php echo $google_share_url;?>" target="_blank">
								<img src="<?php bloginfo('template_directory'); ?>/images/social-google.png" alt="" />
							</a>
						</li>
						<li>
							<a href="<?php echo $in_share_url;?>" target="_blank">
								<img src="<?php bloginfo('template_directory'); ?>/images/social-in.png" alt="" />
							</a>
						</li>
						<li>
							<a href="<?php echo $tumb_share_url;?>" target="_blank">
								<img src="<?php bloginfo('template_directory'); ?>/images/social-tumb.png" alt="" />
							</a>
						</li>
					</ul>
					<p>Share This Site</p>
				</div>
		
	</div>
</div>

<div class="pricing-plans v2" id="pricing-plan">
	<div class="container">
		<h2><span>Start</span> your journey today!</h2>
		<span class="divider"></span>
		<p>Record and store endless amounts of HD video + more!</p>
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
	
		<div class="plans-btns">
			<a class="btn btn-light-blue" href="<?php bloginfo('url'); ?>/my-account/membership-levels/">Sign Me Up!</a>
			<a class="btn btn-dark-blue" href="<?php bloginfo('url'); ?>/my-account/plan-checkout/?level=4">Try It Free!</a>
			
			<img class="pricing-lock" src="<?php bloginfo('template_directory'); ?>/images/lock-v2-colored.png" alt="" />

			<p>We use the highest level of security to protect your content.  
			<strong>Everything is backed up!</strong> </p>
			
		</div>
		
	</div><!-- End container -->
</div><!-- End pricing plans -->


<div class="full-width-img">
	<img src="<?php bloginfo('template_directory'); ?>/images/pictures-bottom.png" alt=""/>
</div>


<div class="join-community v2">
	<div class="container">		
		<div class="join">
			<h2>Join the Living Legacies Community</h2>
			<p>Connect with us on social media and <br>share memories, get story telling tips or make a new friend.</p>
		</div>
	</div>
</div>

<?php get_footer(); ?>