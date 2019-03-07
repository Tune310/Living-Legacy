//<script>

$(window).on('load hashchange',function(){
	
	$('.enable-navigation .enable-nav .select').trigger('click')
	
	
	var body = $('#csshero-body')
    if (location.hash.slice(1) == 'tour'){
	    body.append('<div id="csshero-tour-canvas"></div>')
		body.append('<div id="csshero-tour-shas"></div>')
		body.append('<div id="csshero-tour-bubbler"></div>')
	    
	    $('.tour-start').trigger('click')
	    
	    load_tour_item(0,'Getting Started')
	    body.attr('data-tour-group','Getting Started')
	    
	    
	  
    }
	
})

$(document).keydown(function(e){
	
	
	if ($('#csshero-tour-canvas').length > 0){
	    if (e.keyCode == 39) { 
	       $('#csshero-body:not(.tour-allow-click) .bubble-nav .n').trigger('click');
	    //   $('.bubble-nav .n').trigger('click');
	    }
	    if (e.keyCode == 37) { 
	       $('.bubble-nav .p').trigger('click');
	       
	    }
    }
});


var helpers = {
	'CMD-H':'Hide Interface',
	'CMD-S':'Save',
	'CMD-Z':'Undo',
	'CMD-X':'Redo',
	'Space Bar':'Triggers click on editable element',
	
}

function show_tour_splash(){
	$('#csshero-tour-canvas').remove();
	$('#csshero-tour-shas').remove();
	$('#csshero-tour-bubbler').remove();
	$('#csshero-tour-splash').fadeIn(300);
}

var helpers_render = '';

for (var h in helpers){
	helpers_render += '<span class="helper"><span class="key">'+h+'</span> '+helpers[h]+'</span>';
}
	
	var helpers = helpers_render;
	
function go_to_next_step(){
	var active = $('#csshero-tour-bubbler nav .active');
	var next = active.next('span:not(.close-tour)');
	var num = next.attr('data-nav')
	
	
	if (num){
		load_tour_item(num)
	} else {
		//show_tour_splash();
		$('.close-tour-step').trigger('click')
	}

	
	
	
}

function go_to_prev_step(){
	var active = $('#csshero-tour-bubbler nav .active');
	var next = active.prev('span');
	var num = next.attr('data-nav')
	if (num){
		load_tour_item(num)
	} else {
		show_tour_splash();
	}


}



	var tour = {
		'Getting Started':{
			'desc':'Get familiar with the new CSS Hero interface with this quick tour.',
			'els':[
		
			{
				elem:['#csshero-body'],
				title:'WWWelcome',
				desc:'Hey there, welcome to this quick getting started tour of CSS Hero 3, many things have changed since Hero v2, we hope you will like it!',
				pos:'center',
				actions:function(){
					
				}
				
			},
			
			
			{
				elem:['#csshero-inner-frame-wrap'],
				title:'This is your website',
				desc:'CSS Hero has loaded and now your website appears here',
				pos:'left',
				
				actions:function(){
					
				}
				
			},
			{
				elem:['.csshero-editor-container','.csshero-super-top-bar','.csshero-selectors-bar','#csshero-frame-nav'],
				title:'The CSS Hero interface!',
				desc:'This is the the new CSS Hero 3 interface and where all your edits will happen',
				pos:'right',
				
				actions:function(){
									
				}
				
			},
			{
				elem:['#csshero-inner-frame-wrap'],
				title:'Point and click!',
				desc:'Simply hover with your mouse and click an element here to start editing',
				pos:'left',
				allow_click: true,
				actions:function(){
									
				}
				
			},
			{
				elem:['.csshero-editor-container'],
				title:'Your selected element',
				desc:'Now that you\'ve choosen an element you can start editing it\'s appearence',
				pos:'right',
				
				actions:function(){
									
				}
				
			},
			{
				elem:['.csshero-selector-bar','.csshero-editor-container'],
				title:'Counter',
				desc:'This number indicates the how many of the selected element are available on the current page',
				pos:'right',
				focus:'.csshero-selector-bar .atom-sugg .count-els-in-page > span',
				actions:function(){
									
				}
				
			},
			
			
			
			
			{
				elem:['.csshero-props-actions','.csshero-editor-container','.csshero-selectors-bar'],
				title:'Editing Properties',
				desc:'Here you can choose which property group to edit',
				pos:'right',
				
				actions:function(){
									
				}
				
			},
			
			{
				elem:['.csshero-props-actions','.csshero-editor-container','.csshero-selectors-bar'],
				title:'Review Edited Props',
				desc:'Here you can choose which property group to edit',
				pos:'right',
				
				actions:function(){
					$('.actions-expander').addClass('open')				
				}
				
			},
			
			
			{
				elem:['.csshero-editor-block-sub-title:first','.csshero-editor-container','.csshero-selector-bar'],
				title:'Browse editable properties',
				desc:'Here\'s the background properties',
				pos:'right',
				actions:function(){
					$('.actions-expander').removeClass('open')		
					$('#csshero-body').addClass('hide-code')
					$('.csshero-editor-block-sub-title:first').trigger('click')
				}
			},
			{
				elem:['.csshero-bottom-interface-actions','.csshero-code-wrap'],
				title:'Code Editor',
				desc:'Here you can manage and eventually refine your edits directly with the output code',
				pos:'right',
				actions:function(){
					
					$('#csshero-body').removeClass('hide-code')
				}
			},
		
		]},
		'The New Navbar':{
			'desc':'The CSS Hero Navbar introduces some very cool features, learn more about them.',
			'els':[
		
			{
				elem:['#csshero-frame-nav'],
				title:'The CSS Hero Navbar',
				desc:'This is the Navbar, some important browsing and editing features sit here.',
				pos:'bottom',
				actions:function(){
					csshero_clear_interface();
				}
			},
			{
				elem:['#csshero-frame-nav input','#csshero-frame-nav'],
				title:'Navbar URL input',
				desc:'If you need to check a different page on the fly while not loosing the context you can paste the URL here and navigate, CSS Hero will store all your current edits.',
				pos:'bottom',
				actions:function(){
					
				}
			},
			{
				elem:['#csshero-frame-nav .enable-nav','#csshero-frame-nav'],
				title:'Edit\\Navigate Mode',
				desc:'With this you can toggle between editing and navigation mode.',
				pos:'bottom',
				actions:function(){
					
				}
			},
			{
				elem:['#csshero-frame-nav .csshero-mq-mode-item','#csshero-frame-nav'],
				title:'Media Queries',
				desc:'Switch Media Query on the fly and check how your website looks on handheld devices.',
				pos:'bottom',
				actions:function(){
					
				}
			},
			
			
			
			
		
		]},
		'Media Queries':{
			'desc':'Media Queries can be a big pain, learn how CSS Hero can help you manage easily.',
			'els':[
		
			{
				elem:['.mq-mode-expander','#csshero-frame-nav'],
				title:'Media Queries Panel',
				desc:'From here you can switch editing mode, by doing so you provide customizations per specific device.',
				pos:'left',
				actions:function(){
					csshero_clear_interface();
					$('.csshero-mq-mode-item').trigger('click')
				}
			},
			{
				elem:['.csshero-service-bar-item[data-mq="mobile-portrait"]','.mq-mode-expander','#csshero-frame-nav'],
				title:'Live Media Query Preview',
				desc:'CSS Hero provides live media query rendering on the fly',
				pos:'left',
				actions:function(){
					$('.csshero-service-bar-item[data-mq="mobile-portrait"]').trigger('click')
				}
			},
			{
				elem:['#csshero-inner-frame-wrap .a','#csshero-frame-wrap'],
				title:'Apply Media Query Edits',
				desc:'Here you will see all your media query edits go live.',
				pos:'left',
				actions:function(){
					
				}
			},
			{
				elem:['.mq-mode-expander .csshero-service-actions','.mq-mode-expander','#csshero-frame-nav'],
				title:'Media Query Manager',
				desc:'From here you can Add\\Remove custom Media Queries',
				pos:'left',
				actions:function(){
					
				}
			},
			
			
			
			
		
		]}
	}
	
	
function load_tour_item(item,group){
	var number = item;
	var body = $('body');
	if (!group) var group = body.attr('data-tour-group')
	var tour_canvas = $('#csshero-tour-canvas').show()
	var tour_shas = $('#csshero-tour-shas').show()
	var tour_bubbler = $('#csshero-tour-bubbler').show();
	var tour_item_num = item;
	var item = tour[group]['els'][item];
	
	
	
	var bubble_w = 290;
	
	
	$('.tour-focuses').remove();
	$('#csshero-tour-splash').fadeOut(300);
	
	
	var pos = item.pos;
	
	var focus = item.focus;
	
	if (focus){
		
		var f = $(focus);
		
		console.log(focus)
		
		var f_t = f.offset().top;
		var f_l = f.offset().left;
		var f_w = f.outerWidth() +20;
		var f_h = f.outerHeight() +20;
		
		var f_el = '<div class="tour-focuses" style="position:absolute;top:'+f_t+'px;left:'+f_l+'px;height:'+f_h+'px;width:'+f_w+'px;border:2px solid yellow;margin:-10px;border-radius:50%;"></div>';
		
		
		$('#csshero-tour-bubbler').append(f_el)
		
	}
	
	// RESETS
	
	
	if (item.actions) item.actions();
	
	
	if(item.allow_click){
		body.addClass('tour-allow-click');
	//	var bubble_nav = '<div class="bubble-nav"><span>Interact with the page</span><span class="p">Prev</span></div>';
	} else {
		body.removeClass('tour-allow-click');
	//	var bubble_nav = '<div class="bubble-nav"><span class="p">Prev</span><span class="n">Next</span></div>';
	}
	
	
	
	
	
	if (number == 0){
		var bubble_nav = '<div class="bubble-nav"><span class="n">Next</span></div>';
	} else {
		var bubble_nav = '<div class="bubble-nav"><span class="p">Prev</span><span class="n">Next</span></div>';
	}
	
	
	
	body.find('.tour-light, .tour-bubble').remove();
	
	
	
	for (var i in item['elem']){
		
		if ($(item['elem'][i]).is('body')){
			var e = $('body')
		} else {
			var e = body.find(item['elem'][i])
		}
		
		
		
		
		
		
		
		if (e && e.length){
			var e_w = parseFloat(e.outerWidth());
			var e_h = parseFloat(e.outerHeight());
			var e_l = parseFloat(e.offset().left);
			var e_t = parseFloat(e.offset().top);
			var w_h = parseFloat($(window).outerHeight())
			
		
			
			if (i == 0){
			
					
				if (pos == 'right') var style = 'left:'+(e_l + e_w)+'px;top:'+e_t+'px;margin:10px;';
				if (pos == 'left') var style = 'left:'+(e_l - bubble_w)+'px;top:'+e_t+'px;margin:10px -10px;';
				if (pos == 'bottom') var style= 'left:'+(e_l + e_w/2)+'px;margin-left:-'+bubble_w/2+'px;top:'+(e_t + e_h)+'px;margin-top:10px;';
				if (pos == 'top') var style= 'left:'+(e_l + e_w/2)+'px;margin-left:-'+bubble_w/2+'px;top:auto;bottom:'+(w_h - e_t)+'px;margin-bottom:10px;';
				
				if (pos == 'center'){
					var bubble_w = 450
					var style = 'left:50%;top:30%;margin-left:-'+bubble_w/2+'px;width:'+bubble_w+'px;';
				}
				
				tour_bubbler.append('<div class="tour-bubble bubble-pos-'+pos+'" style="'+style+'"><span class="close-tour-step"></span><h4>'+item.title+'</h4><div class="bubble-desc">'+item.desc+'</div>'+bubble_nav+'</div>');
				
				$('.tour-bubble').hide().fadeIn(300)
				
			}
			var light = '<div class="tour-light" style="width:'+e_w+'px;height:'+e_h+'px;top:'+e_t+'px;left:'+e_l+'px;"></div>';
			tour_shas.append(light)
			tour_canvas.append(light)
		}
		
	}
		
	
	
	
	var tour_count = '';
	var tour_count_n = 0;
	for (var n in tour[group]['els']){
		tour_count_n++;
		tour_count+= '<span class="tour-step" data-nav="'+n+'"></span>';
	}
	tour_bubbler.find('nav').remove();
	tour_bubbler.append('<nav><span class="hero-tour-group">'+group+'</span><span class="hero-tour-totals"><span>1</span>/'+tour_count_n+'</span>'+tour_count+'<span class="close-tour-step"></span></nav>')
	tour_bubbler.find('nav').addClass('visible')

	
	tour_bubbler.find('.active').removeClass('active')
	tour_bubbler.find('nav span[data-nav="'+tour_item_num+'"]').addClass('active');

	
	$('.hero-tour-totals > span').html(parseInt(number)+1);
	
}


$(window).on('load',function(){
	var body = $('#csshero-body');
	var frame = window.frames['csshero-iframe-main-page'].document;


	
	$(cssheroframe).on('mouseup','.editable',function(e){
		
		
		if ($('#csshero-body').hasClass('tour-allow-click')){
			//var cur = $('#csshero-tour-bubbler nav .active').attr('data-nav')
			//var cur = parseInt(cur)+1;
			//load_tour_item(tour[cur])
			e.stopPropagation();
			go_to_next_step()
		}
		
	})
	
	var herodesc ='\
		<h3>The Interface</h3>\
		<p>The whole CSS Hero interface has been redesigned with a focus on providing a powerful yet immediate and easy experience.</p>\
		<p>The editor now sits on the left side of the page while the rendered website displays on the right.</p>\
		<p>The editor can now run in 3 different modes:\
		<ul>\
			<li><b>Default</b> - same as it was in CSS Hero 2.x, the WYSIWYG interface is displayed 100%</li>\
			<li><b>Splitted</b> - with the live code editor under the WYSIWYG interface</li>\
			<li><b>Full Code</b> - yes you guessed right.</li>\
		</ul>\
		<img src="https://i.imgur.com/wqiSS5j.png" />\
		<h4>The Selector Bar</h4>\
		<img src="https://i.imgur.com/HAuphob.png" />\
		<p>This is where the description of the element you clicked is displayed. The small counter on the right indicates the number of instances of that specific element on the current page.</p>\
		<p>By clicking the dropdown arrow you can browse alternative selectors and eventually rename the CSS selector you’re working on.</p>\
		<img src="https://i.imgur.com/6q07xTj.png" />\
		\
		<h4>The editor actions</h4>\
		\
		<p>This bar features an input field to lookup a particular editable property or eventually check only edited properties (simply type: ‘edited’).</p>\
		<p>On the right side you will find some more actions including also:</p>\
		<ul>\
			<li><b>Reset</b> - Resets all the properties for the selected element</li>\
			<li><b>Save as Snippet</b> - Will store all the provided edits into a snippet, extremely useful if you’re willing to re-apply the same asset of edits on other elements.</li>\
		</ul>\
		<h4>The WYSIWYG interface</h4>\
		<p>Very similar to how it was on CSS Hero 2.x, this is where you can customise the aspect of the edited element without coding.</p>\
		<h4>WYSIWYG Widget Options</h4>\
		<img src="https://i.imgur.com/dhktwRt.png" />\
		<p>When providing an edit you’ll notice that 3 dots will show up on the top right corner of each widget, by hovering them you can open the property options panel which include:</p>\
		<ul>\
			<li><b>Reset This Property</b> - Resets only this property to the original value.</li>\
			<li><b>Make important</b> - toggles an !important statement in CSS in order to force the property to show if it doesn’t</li>\
			<li><b>Large Screens Only</b> - will apply that specific edit only on screens wider than 1050px</li>\
		</ul>\
		<h4>Code Editor</h4>\
		<p>Here is where the magic happens, all your generated edits will show here.</p>\
		<p>CSS Hero now runs on <a href="//lesscss.org/" target="_blank">LESS</a> hence in the Code Editor you can write both plain CSS and LESS.</p>\
		<p>On the top right corner of the Code Editor you can trigger the show original style panel which will display all the element styles inherited from the original theme style.</p>\
		\
		<h3>Tools</h3>\
		<h4>Font Manager</h4>\
		<p>The Font Manager allows you to easily add new fonts to your projects, both Google Fonts and Typekit fonts.</p>\
		<h5>Google Fonts</h4>\
		<p>To add an additional Google font to your collection simply choose one from the list and click Add.</p>\
		<p>Once it has been added to your Fonts Collection you can hit the Add To Project button in order to load it in your current CSS Hero project.</p>\
		<h5>Typekit Fonts</h4>\
		<p>In order to sync a Typekit fonts collection simply paste the Typekit project ID you want CSS Hero to load.</p>\
		<p>Please mind that in order this to work you need to add the current project URL in your Typekit font settings.</p>\
		<p>Once you\'re ok with your Font Collection simply hit Update Font Collection in the bottom left corner of the Font Manager panel.</p>\
		<h3>Variables</h3>\
		<p>Variables are one of the major updates in CSS Hero 3, the variable is one of the core concepts in programming and it basically allows you to associate a value to a label.</p>\
		\
		';
	
	
	$(document).on('click','.tour-start',function(e){

		if ($('#csshero-tour-canvas').length == 0){
			body.append('<div id="csshero-tour-splash">\
							<div class="tour-left tour-col">\
								<h2>CSS Hero 3, what\'s new:</h2>\
								<section class="help">'+herodesc+'</section>\
							</div>\
							<div class="tour-right tour-col">\
								<div class="close-tour"></div>\
								<section class="welcome-nav"><ul></ul></section>\
								<h2>Guided Tours</h2>\
								<section class="guided"></section>\
								<h2>Keyboard Shortcuts</h2>\
								<section class="helpers">'+helpers+'</section>\
							</div>\
						</div>')
			body.append('<div id="csshero-tour-canvas"></div>')
			body.append('<div id="csshero-tour-shas"></div>')
			body.append('<div id="csshero-tour-bubbler"></div>')
			$('.tour-col').perfectScrollbar();
			
			var cnt = 0;
			$('.help h3, .help h4, .help h5').each(function(){
				cnt++;
				var t = $(this);
				t.attr('id','help-'+cnt);
				
				var txt = t.text();
				
				var depth = 'd-0';
				
				if (t.is('h4')){
					var depth = 'd-1';
					var txt = '&mdash; '+txt;
				}
				
				if (t.is('h5')){
					var depth = 'd-2';
					var txt = '&mdash; '+txt;
				}
				
				$('.welcome-nav ul').append('<li class="'+depth+'" data-nav-to="help-'+cnt+'">'+txt+'</li>');
			})
			
		}
		$('#csshero-tour-bubbler').hide();
		$('#csshero-tour-shas').hide();
		$('#csshero-tour-canvas').hide();
		$('#csshero-tour-splash').hide().fadeIn(300);

		
		var guided = $('#csshero-tour-splash .guided').empty();
		
		
		for (var t in tour){
			var desc = tour[t]['desc'];
			var a = '<div data-tour-group="'+t+'" class="tour-box start-tour-here"><h3>'+t+'</h3><p>'+desc+'</p></div>'
			guided.append(a)
			
		}
	}).on('click','.welcome-nav li',function(){
		var el = $(this).attr('data-nav-to');
		console.log(el)
		var el = $('#'+el)
		csshero_scrollto(el)	
	}).on('click','.start-tour-here',function(){
		
		var group = $(this).attr('data-tour-group');
		body.attr('data-tour-group',group)
		load_tour_item(0,group)
	
	}).on('click','#csshero-tour-bubbler nav .tour-step',function(){
		var num = $(this).attr('data-nav')
		load_tour_item(num)
		
	}).on('click','#csshero-tour-bubbler .close-tour-step',function(){
		show_tour_splash();
		window.location.hash = '';
	}).on('click','#csshero-tour-splash .close-tour',function(){
		
		$('#csshero-tour-canvas').remove();
		$('#csshero-tour-bubbler').remove();
		$('#csshero-tour-shas').remove();
		$('#csshero-tour-splash').remove();
		csshero_clear_interface()
	}).on('click','.bubble-nav span',function(){
		if ($(this).is('.p')){
			go_to_prev_step();
		} else {
			go_to_next_step()
		}
	})
	

})
