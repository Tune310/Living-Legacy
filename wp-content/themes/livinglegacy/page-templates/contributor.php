<?php
/*
Template Name: Contributor
Template Post Type: page
*/

get_header(); ?>

<div class="header-banner user-header">
	<div class="container row">
		<div class="col-6">  
			<h1><span>Welcome to Living Legacies</span></h1>
			<p>our host has invited you to contribute stories, messages, pictures, documents and more!</p>
			<p>Here you’ll be guided through the steps to create incredible content.</p>
			<p class="small">Follow the instructions below</p>
		</div>
		<div class="col-6">
			<img class="final-creation" src="<?php bloginfo('template_directory'); ?>/images/final-creation.png" alt=""/>
			<img src="<?php bloginfo('template_directory'); ?>/images/contributor-header-img.png" alt=""/>
		</div>
	</div>
</div>

<div class="header-bottom">
	<div class="container">
		<p>need inspiration? &nbsp;&nbsp;&nbsp; Check out our <a href="#">helpful articles</a> and <a href="#">video tutorials</a></p>
	</div>
</div>

<div class="story-title">
	<div class="container">
		
		<div class="saved-title">
			A Tribute to John Parker
		</div>
		
	</div>
</div>

<div class="ways-to-tell">
	<div class="container">
		<h4>3 ways to tell your story</h4>
		<p>All your recorded or uploaded content will appear in your Media Bin below.</p>
	</div>
	<div class="story-type">
		<div class="container">
			<ul>
				<li>
					<span class="story-type-title">Record your story</span>
					<div>
					<span>
						<img src="<?php bloginfo('template_directory'); ?>/images/story-icon-1.png" alt="" />
						<strong>You can use your computer's camera or your phone's camera.</strong>
						<p>Record unforgettable stories using video or audio from our built-in tools. You can create multiple videos to tell your story.</p>
						<a class="btn-gradient green-gradient" href="#">record</a>
					</span>
					</div>
				</li>
				<li>
					<span class="story-type-title">Enhance your story</span>
					<div>
					<span>
						<img src="<?php bloginfo('template_directory'); ?>/images/story-icon-2.png" alt="" />
						<strong>Upload pictures and documents to enhance your story.</strong>
						<p>Choose from pictures, home movies, love letters, diplomas, birth certificates, maps, music, artwork, ANYTHING!</p>
						<a class="btn-gradient blue-gradient" href="#">add</a>
					</span>
					</div>
				</li>
				<li>
					<span class="story-type-title">Write your story</span>
					<div>
					<span>
						<img src="<?php bloginfo('template_directory'); ?>/images/story-icon-3.png" alt="" />
						<strong>Let your words do the talking.</strong>
						<p>Write from the heart with as much detail as possible. When your're done writing you can read it using our audio or video recorder for a more personal effect.</p>
						<a class="btn-gradient blue-gradient" href="#">write</a>
					</span>
					</div>
				</li>
			</ul>
		</div>
	</div>
</div>



<div class="notes">
	<div class="container row">
		<div class="notes-left">
			<img src="<?php bloginfo('template_directory'); ?>/images/coffee-cup.png" alt="" />
		</div>
		<div class="notes-right">
			<div id="myDIV" class="notes-header">
			  <textarea id="myInput" placeholder="Sometimes it’s easier to just write things down. Start typing here."></textarea>
			  <span onclick="newElement()" class="addBtn btn-gradient blue-gradient">save</span>
			</div>

			<ul id="myUL">
			  <li>Hit the gym</li>
			  <li class="checked">Pay bills</li>
			  <li>Meet George</li>
			  <li>Buy eggs</li>
			  <li>Read a book</li>
			  <li>Organize office</li>
			</ul>
		</div>
	</div>
</div>


<div class="media-bin">
	<h2>Media Bin</h2>
	<p>all your media is stored here.</p>

	<div class="media-bin-wrapper">
		<div class="container">
			<ul id="media-bin">
				<li>
					<div class="media-thumb">
						<a href="#">
							<span>delete</span>
							<i class="fas fa-times-circle"></i>
						</a>
						<img src="<?php bloginfo('template_directory'); ?>/images/155.png" alt="" />
					</div>
					<div class="media-desc">
						<input type="text" name="" placeholder="ADD VIDEO NAME" />
						<textarea>Add description   description, description Description, description, description Description, description, descriptionDescription, description, description</textarea>
					</div>
				</li>
				<li>
					<div class="media-thumb rounded">
						<a href="#">
							<span>delete</span>
							<i class="fas fa-times-circle"></i>
						</a>
						<img src="<?php bloginfo('template_directory'); ?>/images/media-2.png" alt="" />
					</div>
					<div class="media-desc">
						<input type="text" name="" placeholder="ADD VIDEO NAME" />
						<textarea>Add description   description, description Description, description, description Description, description, descriptionDescription, description, description</textarea>
					</div>
				</li>
				<li>
					<div class="media-thumb">
						<a href="#">
							<span>delete</span>
							<i class="fas fa-times-circle"></i>
						</a>
						<img src="<?php bloginfo('template_directory'); ?>/images/155.png" alt="" />
					</div>
					<div class="media-desc">
						<input type="text" name="" placeholder="ADD VIDEO NAME" />
						<textarea>Add description   description, description Description, description, description Description, description, descriptionDescription, description, description</textarea>
					</div>
				</li>
				<li>
					<div class="media-thumb rounded">
						<a href="#">
							<span>delete</span>
							<i class="fas fa-times-circle"></i>
						</a>
						<img src="<?php bloginfo('template_directory'); ?>/images/media-2.png" alt="" />
					</div>
					<div class="media-desc">
						<input type="text" name="" placeholder="ADD VIDEO NAME" />
						<textarea>Add description   description, description Description, description, description Description, description, descriptionDescription, description, description</textarea>
					</div>
				</li>
				<li>
					<div class="media-thumb rounded">
						<a href="#">
							<span>delete</span>
							<i class="fas fa-times-circle"></i>
						</a>
						<img src="<?php bloginfo('template_directory'); ?>/images/100.png" alt="" />
					</div>
					<div class="media-desc">
						<input type="text" name="" placeholder="ADD VIDEO NAME" />
						<textarea>Add description   description, description Description, description, description Description, description, descriptionDescription, description, description</textarea>
					</div>
				</li>
				<li>
					<div class="media-thumb rounded">
						<a href="#">
							<span>delete</span>
							<i class="fas fa-times-circle"></i>
						</a>
						<img src="<?php bloginfo('template_directory'); ?>/images/100.png" alt="" />
					</div>
					<div class="media-desc">
						<input type="text" name="" placeholder="ADD VIDEO NAME" />
						<textarea>Add description   description, description Description, description, description Description, description, descriptionDescription, description, description</textarea>
					</div>
				</li>
				<li>
					<div class="media-thumb">
						<a href="#">
							<span>delete</span>
							<i class="fas fa-times-circle"></i>
						</a>
						<img src="<?php bloginfo('template_directory'); ?>/images/155.png" alt="" />
					</div>
					<div class="media-desc">
						<input type="text" name="" placeholder="ADD VIDEO NAME" />
						<textarea>Add description   description, description Description, description, description Description, description, descriptionDescription, description, description</textarea>
					</div>
				</li>
				<li>
					<div class="media-thumb">
						<a href="#">
							<span>delete</span>
							<i class="fas fa-times-circle"></i>
						</a>
						<img src="<?php bloginfo('template_directory'); ?>/images/155.png" alt="" />
					</div>
					<div class="media-desc">
						<input type="text" name="" placeholder="ADD VIDEO NAME" />
						<textarea>Add description   description, description Description, description, description Description, description, descriptionDescription, description, description</textarea>
					</div>
				</li>
			</ul>
		</div>
	</div><!-- End media-bin-wrapper -->
</div><!-- End media-bin -->

<div class="submit-media">
	<div class="container">
		<button class="gradient-button" type="submit">Submit</button>
		<p>Your host will collect all content and contact you  to share other contributors content.</p>
	</div>
</div>



<?php get_footer(); ?>