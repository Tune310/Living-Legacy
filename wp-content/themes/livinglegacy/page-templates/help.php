<?php
/*
Template Name: Help
Template Post Type: page
*/


get_header(); ?>

<div class="help-header">
	<div class="container">
		<h1>welcome to customer care</h1>
		<p>Hopefully you’ll find everything you need here to help you create amazing content</p>
		<img src="<?php bloginfo('template_directory'); ?>/images/white-color-logo.png" alt="" />
		
		
		<ul>
			<li>
				<a href="#helpful-articles">
					<img src="<?php bloginfo('template_directory'); ?>/images/help-icon-1.png" alt="" />
					<div>FAQ</div>
				</a>
			</li>
			<li>
				<a href="#video-tutorials">
				<img src="<?php bloginfo('template_directory'); ?>/images/help-icon-2.png" alt="" />
				<div>VIDEO TUTORIALS</div>
				</a>
			</li>
			<li>
				<a href="#support">
				<img src="<?php bloginfo('template_directory'); ?>/images/help-icon-3.png" alt="" />
				<div>SUPPORT</div>
				</a>
			</li>
		</ul>
		
	</div>
</div>




<div class="faq-helpful" id="helpful-articles">
	<div class="container">
		<h2>frequently asked questions</h2>
		<div class="add-blue-divider"></div>
		<div class="sec-sub-heading">Get all your answers on one place</div>
		
		<div class="faq-tabs-wrapper">
			<div class="tabs-header">
				<div class="active"><span>?</span> FREQUENTLY ASKED QUESTIONS</div>
			</div><!-- End Tabs Header -->
			
			<div class="tabs-content">
				<div>
					<ul>
						<li>
							<a href="/how-it-works-tributes/">What are the features of Living Legacies?</a>
						</li>
						<li>
							<a data-fancybox data-src="#faq-popup-2" href="javascript:;">How does it all work?</a>
						</li>
						<li>
							<a data-fancybox data-src="#faq-popup-3" href="javascript:;">How much does it cost?</a>
						</li>
						<li>
							<a data-fancybox data-src="#faq-popup-4" href="javascript:;">I’m having technical questions.</a>
						</li>
						<li>
							<a data-fancybox data-src="#faq-popup-5" href="javascript:;">How do I add more storage?</a>
						</li>
					</ul>
					
					<!-- Popups -->
					<div style="display: none;" id="faq-popup-1">
						<div class="faq-popup">
							<img src="<?php bloginfo('template_directory'); ?>/images/popup-logo.png" alt="" />
							<p class="shade">What are the features of Living Legacies?</p>
							<p>Living Legacies is packed with amazing features. <br>Click below to explore.</p>
							<a class="btn btn-white" href="/feature-selection/">features</a>
							<div class="no-thanks" data-fancybox-close>X</div>
						</div>
					</div>
										
					<div style="display: none;" id="faq-popup-2">
						<div class="faq-popup">
							<img src="<?php bloginfo('template_directory'); ?>/images/popup-logo.png" alt="" />
							<p class="shade">How does it all work?</p>
							<p>Living Legacies is incredibly easy to use. <br>Click below to find out.</p>
							<a class="btn btn-white small-btn" href="/how-it-works-tributes/">how it works</a>
							<a class="btn btn-white small-btn" data-fancybox href="https://www.youtube.com/watch?v=Wj7_O_l94vE">watch video</a>
							<div class="no-thanks" data-fancybox-close>X</div>
						</div>
					</div>
										
					<div style="display: none;" id="faq-popup-3">
						<div class="faq-popup">
							<img src="<?php bloginfo('template_directory'); ?>/images/popup-logo.png" alt="" />
							<p class="shade">How much does it cost?</p>
							<p>Living Legacies is based on a monthly subscription. <br>Click below to view our pricing plans.</p>
							<a class="btn btn-white" href="/my-account/membership-levels/">pricing plans</a>
							<div class="no-thanks" data-fancybox-close>X</div>
						</div>
					</div>
										
					<div style="display: none;" id="faq-popup-4">
						<div class="faq-popup">
							<img src="<?php bloginfo('template_directory'); ?>/images/popup-logo.png" alt="" />
							<p class="shade">I’m having technical problems</p>
							<p>Living Legacies has excellent customer care. <br>Click below to get the help you need.</p>
							<a class="btn btn-white small-btn" href="/how-it-works-tributes/">how it works</a>
							<a class="btn btn-white small-btn" data-fancybox href="https://www.youtube.com/watch?v=Wj7_O_l94vE">watch video</a>
							<div class="no-thanks" data-fancybox-close>X</div>
						</div>
					</div>
														
					<div style="display: none;" id="faq-popup-5">
						<div class="faq-popup">
							<img src="<?php bloginfo('template_directory'); ?>/images/popup-logo.png" alt="" />
							<p class="shade">How do I add more storage?</p>
							<p>Living Legacies has all the storage you want. <br>You can add more on your account page.</p>
							<a class="btn btn-white" href="/my-account/">account page</a>
							<div class="no-thanks" data-fancybox-close>X</div>
						</div>
					</div>
					<!-- End Popups -->
					
					
				</div><!-- End Tab Content 1 -->
			
			</div><!-- End Tabs Content -->
		</div><!-- End Tabs Wrapper -->
	</div>
</div>




<div class="video-tutorials" id="video-tutorials">
	<div class="container">
		<h2>video tutorials</h2>
		<div class="add-blue-divider"></div>
		<div class="sec-sub-heading">Check out our helpful videos</div>
		
		<div class="videos-wrapper">
			<div class="video-player">
				<div><a data-fancybox href="https://www.youtube.com/watch?v=YKqbZIyC5cU"><img src="<?php bloginfo('template_directory'); ?>/images/Take-our-video-tour.jpg" alt="" /></a></div>
				<div><a data-fancybox href="https://www.youtube.com/watch?v=c_et3NeP_TI"><img src="<?php bloginfo('template_directory'); ?>/images/How-to-create-the-perfect-shot.jpg" alt="" /></a></div>
				<div><a data-fancybox href="https://www.youtube.com/watch?v=H5sm02NsYGs"><img src="<?php bloginfo('template_directory'); ?>/images/How-to-tell-a-great-story.jpg" alt="" /></a></div>
				<div><a data-fancybox href="https://www.youtube.com/watch?v=Wj7_O_l94vE"><img src="<?php bloginfo('template_directory'); ?>/images/how-it-works-video-thumb.jpg" alt="" /></a></div>			
			</div>
			<div class="videos-list">
				<ul>
					<li class="active">Take our video tour <i></i></li>
					<li>How to create the perfect shot <i></i></li>
					<li>How to tell a great story  <i></i></li>
					<li>How it works   <i></i></li>
				</ul>
			</div>
		</div>
		
		<!-- <a class="btn-sky" href="#">All Videos</a>-->
	</div>
</div>



<div class="contact-info" id="support">
	<div class="container">
		<div class="form-sec">
			<h2>drop us a line</h2>
			<div class="add-blue-divider"></div>
			<?php echo do_shortcode('[gravityform id="1" title="false" description="false" ajax="true"]'); ?>
		</div>
		<div class="info-sec">
			<h2>info</h2>
			<div class="add-blue-divider"></div>
			
			<ul>
				<li>
					<img src="<?php bloginfo('template_directory'); ?>/images/help-icon-pin.png" alt="" />
					<strong>Address</strong>
					<p>59 Silver Saddle Lane</p>
					<p>Rolling Hills Estates, CA 90274</p>
				</li>
				<li>
					<img src="<?php bloginfo('template_directory'); ?>/images/help-icon-headphone.png" alt="" />
					<strong>Phone</strong>
					<p>323-707-7868</p>
				</li>
				<li>
					<img src="<?php bloginfo('template_directory'); ?>/images/help-icon-email.png" alt="" />
					<strong>Email</strong>
					<p>help@livinglegacies.com</p>
				</li>
			</ul>
		</div>
	</div>
</div>

<?php get_footer(); ?>