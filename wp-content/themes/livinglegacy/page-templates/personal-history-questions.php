<?php
/*
Template Name: Personal History Questions
Template Post Type: page
*/
if ( !is_user_logged_in () ) {
	 wp_redirect( site_url('/login/') );
	exit();
}
get_header(); ?>

<div class="header-banner feature-selection-header have-pics-bottom">
	<div class="container row">
		<div class="col-6">  
			<h1><span>Personal History</span></h1>
			<p>Let us help you to create meaningful content. You’ll be guided through a series of questions to help organize your thoughts.</p>
			<p>Choose from 100’s of questions that range from your basic biography to deeper insights. You can also create and answer your own!</p>
			<br><br>
			<p class="need-help">need help?</p>
			<div class="need-help-btns">
				<a class="btn btn-white" data-fancybox href="https://www.youtube.com/watch?v=Wj7_O_l94vE">How it works</a>
				<a class="btn btn-white" data-fancybox href="https://www.youtube.com/watch?v=H5sm02NsYGs">Tell a great story</a>
				<a class="btn btn-white" data-fancybox href="https://www.youtube.com/watch?v=c_et3NeP_TI">Create the perfect shot</a>
			</div>			
		</div>
		<div class="col-6">
			<img src="<?php bloginfo('template_directory'); ?>/images/personal-history-header-img.png" alt=""/>
		</div>
	</div>
	
	<div class="pictures-bottom">
		<img src="<?php bloginfo('template_directory'); ?>/images/pictures-bottom.png" alt=""/>
	</div>
	
</div>




<div class="create-own">
	<div class="container">
		<a href="<?php echo site_url('/contributor-history/');?>">Select</a>
		<p>Create your own question.</p>
	</div>
</div>

<div class="questions">
	<div class="container">
		<h2>Family Heritage</h2>
		<ol>
			<li><a href="<?php echo site_url('/contributor-history/?qid=1');?>">Select</a>Where is your family from? What was their experience coming to this country?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=2');?>">Select</a>Describe you parents. What were they like? What did they do?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=3');?>">Select</a>Describe your grandparents. What did you enjoy the most about them? </li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=4');?>">Select</a>How did your grandparents meet?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=5');?>">Select</a>What traditions did your relatives pass down to you?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=6');?>">Select</a>What are some interesting things about your relatives?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=7');?>">Select</a>More stories about my family heritage.</li>
		
		<h2>Growing Up</h2>
			<li><a href="<?php echo site_url('/contributor-history/?qid=8');?>">Select</a>Where did you grow up and what was it like there? </li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=9');?>">Select</a>What did you enjoy doing as a child?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=10');?>">Select</a>How would you describe yourself as a child? Were you happy?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=11');?>">Select</a>How would you describe a perfect day when you were young?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=12');?>">Select</a>Do you have any favorite stories from your childhood?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=13');?>">Select</a>Who were some of your friends growing up? What were they like?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=14');?>">Select</a>What kind of trouble did you get into as a child?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=15');?>">Select</a>How did you celebrate the holidays?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=16');?>">Select</a>What did you like to do in your free time?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=17');?>">Select</a>What were some of the crazy fads you or your friends went through? </li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=18');?>">Select</a>What were your family finances like growing up and how did that affect you? </li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=19');?>">Select</a>What were you like in high school? </li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=20');?>">Select</a>What did you want to be when you grew up? </li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=21');?>">Select</a>How did you celebrate your birthdays?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=22');?>">Select</a>What was the most exciting thing that happened to you as adolescence?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=23');?>">Select</a>What would people you know find surprising about you as a teen?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=24');?>">Select</a>More stories about growing up.</li>
		
		
		<h2>School</h2>
			<li><a href="<?php echo site_url('/contributor-history/?qid=25');?>">Select</a>Where and when did you go to school? Name all your schools.</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=26');?>">Select</a>What were your favorite subjects and teachers? Why?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=27');?>">Select</a>How would your classmates remember you?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=28');?>">Select</a>What are your best memories of elementary and high school? Worst memories?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=29');?>">Select</a>What did you like most about school?  Least?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=30');?>">Select</a>What are your most memorable college moments?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=31');?>">Select</a>More stories about my school days.</li>
		
		
		<h2>Relationships</h2>
			<li><a href="<?php echo site_url('/contributor-history/?qid=32');?>">Select</a>How old were you when you went on your first date? What happened?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=33');?>">Select</a>When did you first fall in love? What were the circumstances?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=34');?>">Select</a>Can you tell me about your first kiss?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=35');?>">Select</a>What was your first serious relationship?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=36');?>">Select</a>What lessons have you learned from your relationships?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=37');?>">Select</a>What are some memorable stories from early romances?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=38');?>">Select</a>Have you had your heart broken? What happened?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=39');?>">Select</a>More stories about my relationships.</li>
		
		
		<h2>Marriage & Partnerships</h2>
			<li><a href="<?php echo site_url('/contributor-history/?qid=40');?>">Select</a>How did you meet your husband/wife and what drew you to him/her? </li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=41');?>">Select</a>Do you have a favorite incident from your courtship?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=42');?>">Select</a>How did you know he/she was “the one”?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=43');?>">Select</a>How did you propose?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=44');?>">Select</a>What were the best times in your marriage? The most difficult times?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=45');?>">Select</a>Did you ever get divorced? Can you tell me about it?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=46');?>">Select</a>What was your wedding like? Describe everything.</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=47');?>">Select</a>What are some of your fondest memories with your husband/wife?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=48');?>">Select</a>More stories about my marriage and partnerships.</li>
		
		
		<h2>Children</h2>
			<li><a href="<?php echo site_url('/contributor-history/?qid=49');?>">Select</a>What are your children’s names? Describe them.</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=50');?>">Select</a>How did you feel when you found out that you were going to be a parent?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=51');?>">Select</a>Can you describe the moment when you saw your child for the first time?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=52');?>">Select</a>What were your children like as infants and toddlers?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=53');?>">Select</a>How has being a parent changed you?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=54');?>">Select</a>Do you have any favorite stories about your kids?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=55');?>">Select</a>What was the most challenging part about raising kids?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=56');?>">Select</a>What was your goal as a parent?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=57');?>">Select</a>How do you describe yourself as a parent?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=58');?>">Select</a>Do you remember when your last child left home for good? What was that like?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=59');?>">Select</a>More stories about my children.</li>
		
		
		<h2>Working</h2>
			<li><a href="<?php echo site_url('/contributor-history/?qid=60');?>">Select</a>What were some of your first jobs? How much did you make? </li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=61');?>">Select</a>Tell me something about your favorite job, what inspired you to keep working there? </li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=62');?>">Select</a>What do/did you do? Why did you choose it as a career?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=63');?>">Select</a>What are some of the things you are proudest of in your career?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=64');?>">Select</a>Describe your finances in your early career. What did things cost? Did you make enough?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=65');?>">Select</a>What lessons has your work life taught you?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=66');?>">Select</a>Do you have any favorite stories from your work life?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=67');?>">Select</a>More stories about my working life.</li>
		
		
		<h2>Military</h2>
			<li><a href="<?php echo site_url('/contributor-history/?qid=68');?>">Select</a>When and where did you serve?Why did you choose it, if you had a choice?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=69');?>">Select</a>What was the most exciting thing that happened to you in the service?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=70');?>">Select</a>What was the most frighteningthing that happened to you in the service?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=71');?>">Select</a>What was basic training like?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=72');?>">Select</a>Can you describe how you felt coming home from deployment?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=73');?>">Select</a>Did you ever learn something about a fellow service member that surprised you?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=74');?>">Select</a>How do you think your time in the military affected you?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=75');?>">Select</a>What are some of the best things about being in the service? The worst?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=76');?>">Select</a>More stories about my military life.</li>
		
		
		<h2>Adult life</h2>
			<li><a href="<?php echo site_url('/contributor-history/?qid=77');?>">Select</a>What did you do for fun outside of your job as an adult? Why?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=78');?>">Select</a>What are your hobbies? Why do you do them?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=79');?>">Select</a>What’s the most fun you've had in a single day as an adult? </li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=80');?>">Select</a>Describe a typical day in your life.</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=81');?>">Select</a>What’s the happiest thing that ever happened to you as an adult?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=82');?>">Select</a>What’s the saddest thing that ever happened to you as an adult?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=83');?>">Select</a>More stories about my adult life.</li>
		
		
		<h2>Religion</h2>
			<li><a href="<?php echo site_url('/contributor-history/?qid=84');?>">Select</a>Did you attend church or religious services as a child? What were your earliest memories?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=85');?>">Select</a>Can you tell me about your religious beliefs/spiritual beliefs? What is your religion?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=86');?>">Select</a>What do you like about your religion? Dislike?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=87');?>">Select</a>What was the most awe-inspiring thing that happened because of your religion?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=88');?>">Select</a>What do you think happens to you when you die?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=89');?>">Select</a>More stories about my religion.</li>
		
		
		<h2>Historical Moments</h2>
			<li><a href="<?php echo site_url('/contributor-history/?qid=90');?>">Select</a>What historical events have you witnessed either in person or through the media?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=91');?>">Select</a>What do you consider to be the most significant political event that has occurred during your life?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=92');?>">Select</a>Have you ever fought for a political cause? Why?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=93');?>">Select</a>Describe how you felt about President Kennedy’s assassination?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=94');?>">Select</a>Describe how you felt about the U.S. landing on the moon?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=95');?>">Select</a>Describe how you felt about the fall of the Berlin Wall?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=96');?>">Select</a>Describe how you felt about the explosion of the Challenger?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=97');?>">Select</a>Describe how you felt about the attacks on Sept.11?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=98');?>">Select</a>More stories about historical moments.</li>
		
		
		<h2>Personal Thoughts</h2>
			<li><a href="<?php echo site_url('/contributor-history/?qid=99');?>">Select</a>What famous person do you admire? What made them admirable? </li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=100');?>">Select</a>What are some favorites? ( Color, food, ice cream, book, movie, song, sport, etc.) </li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=101');?>">Select</a>Is there something you wish you could do over again?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=102');?>">Select</a>What is something that you are really proud of and why?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=103');?>">Select</a>What are the goals you are still working toward? </li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=104');?>">Select</a>When people look back at your life, how do you want to be remembered?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=105');?>">Select</a>What do you think about when you’re alone?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=106');?>">Select</a>Did you suffer because of your race, religion, ethnicity, home country, and language?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=107');?>">Select</a>Tell me about a memorable moment in your life; a time you will never forget. </li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=108');?>">Select</a>What are some of the changes in our society that you have seen in your lifetime?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=109');?>">Select</a>What is the funniest thing that has happened to you?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=110');?>">Select</a>What are you best known for? </li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=111');?>">Select</a>What’s the most interesting thing about you that few people know?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=112');?>">Select</a>What’s the biggest change in the world today from the world you knew as a child?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=113');?>">Select</a>How have you changed? </li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=114');?>">Select</a>What was the nicest act of human kindness you've performed or benefited from?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=115');?>">Select</a>Who has been the most important person in your life? Can you tell me about him or her?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=116');?>">Select</a>Who has been the biggest influence on your life? What lessons did that person teach you?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=117');?>">Select</a>What are the most important lessons you’ve learned in life?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=118');?>">Select</a>Are there any funny stories or memories or characters from your life?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=1119');?>">Select</a>What was the happiest time in your life?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=120');?>">Select</a>Describe the most challenging part of your life.</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=121');?>">Select</a>Do you have any regrets?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=122');?>">Select</a>What are your hopes for what the future holds for you?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=123');?>">Select</a>What are your hopes for what the future holds for your loved ones?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=124');?>">Select</a>What is there about you that no one knows about?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=125');?>">Select</a>What advice do you have for young couples?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=126');?>">Select</a>Do you think about dying? Are you scared?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=127');?>">Select</a>Do you have any last wishes?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=128');?>">Select</a>What have you learned from life? </li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=129');?>">Select</a>Has an illness changed you? What have you learned?	</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=130');?>">Select</a>How do you want to be remembered?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=131');?>">Select</a>If you could only keep five possessions, what would they be?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=132');?>">Select</a>What do you want your tombstone to say?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=133');?>">Select</a>What was your most embarrassing moment?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=134');?>">Select</a>What is a skill you'd like to learn and why?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=135');?>">Select</a>What does a perfect day look like to you?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=136');?>">Select</a>How would your friends describe you?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=137');?>">Select</a>What does the word “family” mean to you?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=138');?>">Select</a>What is your most memorable travel experience?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=139');?>">Select</a>What is the funniest thing that’s ever happened to you?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=140');?>">Select</a>What is your greatest hope?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=141');?>">Select</a>What are the main lessons you’ve learned in life?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=142');?>">Select</a>If you could meet any historical figure, of the past or present, who would it be and why?</li>
			<li><a href="<?php echo site_url('/contributor-history/?qid=143');?>">Select</a>More personal thoughts.</li>
		</ol>

		
		
	</div>
</div>


<?php get_footer(); ?>