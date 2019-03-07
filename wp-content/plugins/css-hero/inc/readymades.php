// <script>
// CSS HERO READYMADES

var demo_color = '#4289dc';



function return_label(name){
	
	var label = '&:before{content:"'+name+'";position:absolute;top:50%;left:50%;line-height:24px;width:100px;margin:-12px -50px;background:fade(black,45%);color:white;border-radius:3px;font-weight:bold;z-index:3;}'
	
	return label;
}

var system_global_classes = {
	
	// BUTTONS //////////////////////////////////////////////////
	".btn-3d(@color:#4289dc)":{
		"cla_prop":"\
			.btn-reset();\
			padding:.7vw 2vw;\
			text-transform:uppercase;\
			border:0 solid darken(@color,10%);\
			background:@color;\
			border-bottom-width:5px;\
			border-radius:5px 5px 7px 7px;\
			color:fade(contrast(@color),70%);",
		"cla_type":"system_cla",
		"cla_desc":"A classic 3d effect button with customisable color",
		"cla_cat":"Buttons",
		'render_style':'margin: 30px auto;',
	},
	
	".btn-traditional(@color:#4289dc)":{
		"cla_prop":"\
			.btn-reset();\
			@text:contrast(@color);\
			@shadow:contrast(@text);\
			background:@color;\
			.gradient(to top,@color,darken(@color,10%));\
			text-shadow:0 1px 0 fade(@shadow,30%);\
			border:1px solid darken(@color,15%);\
			color:fade(@text,70%);\
			padding:.5vw 2vw;\
			border-radius:5px;\
			box-shadow:inset 0 1px 0px fade(lighten(@color,30%),30%);",
		"cla_type":"system_cla",
		"cla_desc":"Web 2.0 button style",
		"cla_cat":"Buttons",
		'render_style':'margin: 30px auto;',
	},
	
	".btn-grad(@color:#4289dc)":{
		"cla_prop":"\
			.btn-reset();\
			@c1:spin(@color,120);\
			@c2:darken(@color,60%);\
			@c3:contrast(darken(mix(@color,@c1),30%));\
			@c4:contrast(@c3);\
			.gradient(45deg, @color 10%,@c1);\
			box-shadow:0 20px 30px fade(@c2,30%);\
			border-radius:5px;\
			padding:1.5vw 3vw;\
			color:@c3;\
			text-shadow:0 1px 0px fade(@c4,20%);\
			min-width:200px;\
			&:hover{\
				box-shadow:0 10px 20px fade(@c2,30%);\
			}",
		"cla_type":"system_cla",
		"cla_desc":"A modern, gradient styled button, choose the starting color he will do the rest",
		"cla_cat":"Buttons",
		'render_style':'margin: 30px auto;',
	},
	
	".btn-pill(@color:#4289dc)":{
		"cla_prop":"\
			.btn-reset();\
			background:transparent;\
			border:2px solid @color;\
			border-radius:150px;\
			color:@color;\
			padding: 5px 20px;\
			&:hover{\
				background:@color;\
				color:contrast(darken(@color,20%));\
			}",
		"cla_type":"system_cla",
		"cla_desc":"A very simple pill button with hover effect",
		"cla_cat":"Buttons",
		'render_style':'margin: 30px auto;',
	},
	
	".rect-button(@color:black)":{
		"cla_prop":".btn-reset();\
					text-transform:uppercase;\
					border: 1px solid @color;\
					padding: 1vw 2vw;\
					color:@color;\
					border-radius:2px;\
					background:transparent;\
					.transition();\
					&:hover{\
						background:@color;\
						color:contrast(@color);\
					}",
		"cla_type":"system_cla",
		"cla_desc":"Simple square button with fill on hover effect",
		"cla_cat":"Buttons",
		'render_style':'margin:10px;',
	},
	
	
	
	
	".btn-reset()":{
		"cla_prop":"&:before,&:after{display:none;}text-align:center;text-decoration:none;font-style:normal;text-shadow:none;display:inline-block;font-size:14px;line-height:20px;border:none;font-weight:bold;.transition();&:active{position:relative;top:1px;}",
		"cla_type":"system_cla",
		"cla_desc":"Helper",
		"cla_cat":"Buttons",
		'render_style':'display:none;',
	},
	
	".gradient(@direction:to top left;@color1:#4289dc;@color2:#b6aeff)":{
		"cla_prop":"background-image: linear-gradient(@direction,@color1,@color2);",
		"cla_type":"system_cla",
		"cla_desc":"Build background gradients in a breeze, supports direction, start and end color",
		"cla_cat":"Utils",
		'render_style':'line-height:200px;',
	},
	
	".modernList(@color:#444)":{
		"cla_prop":"list-style:none;\
					padding:0;\
					margin:0;\
					border:1px solid @color;\
					border-radius:5px;\
					margin-bottom:10px;\
					> li{\
						.transition();\
						&:hover{\
							background:fade(@color,5%);\
						}\
						padding:10px;\
						border-bottom:1px solid @color;\
						&:last-of-type{\
							border:none;\
						}}",
		"cla_type":"system_cla",
		"cla_desc":"A simple flat list, should be applied on list items such as ULs and OLs",
		"cla_cat":"Utils",
		'render_style':'margin:10px;',
		
	},
	
	
	
	
	".columns(@count:3;@gap:20px)":{
		"cla_prop":"column-count:@count;column-gap:@gap;",
		"cla_type":"system_cla",
		"cla_desc":"Splits any content into columns",
		"cla_cat":"Utils",
		'render_style':'&:after{content:"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,";position:absolute;top:0;left:0;color:#aaa;text-align:left;column-count:2;column-gap:10px;padding:10px;}',
	},
	".white-card()":{
		"cla_prop":"background:white;padding:2vw;color:#333;border-radius:5px;box-shadow:0 15px 35px rgba(50,50,93,.1), 0 5px 15px rgba(0,0,0,.07);border:none;",
		"cla_type":"system_cla",
		"cla_desc":"A modern card styled box, should be applied on containers",
		"cla_cat":"Utils",
		'render_style':'margin:10px;',
	},
		
	
	".transition(@timing:300ms)":{
		"cla_prop":"-webkit-transition: all @timing ease;-moz-transition: all @timing ease;-o-transition: all @timing ease;-ms-transition: all @timing ease;transition: all @timing ease;",
		"cla_type":"system_cla",
		"cla_desc":"using this snippet allows you to apply a transition effect to a given element, using it on links such as buttons and styling the Hover status of it will make the transition between the two statuses smoother when user will hover it.",
		"cla_cat":"Utils",
	},
	// SHADOWS
	".drop-shadow-subtle(@x: 0, @y: 1px, @blur: 2px, @spread: 0, @alpha: 0.25)":{
		"cla_prop":"box-shadow: @x @y @blur @spread rgba(0, 0, 0, @alpha);",
		"cla_desc":"Subtle drop shadow effect",
		"cla_type":"system_cla",
		"cla_cat":"Shadows",
		'render_style':'margin: 20px;background:white;line-height:50px;',
	},
	".drop-shadow-flat(@x: 0, @y: 0px, @blur: 30px, @spread: 0, @alpha: 0.5)":{
		"cla_prop":"box-shadow: @x @y @blur @spread rgba(0, 0, 0, @alpha);",
		"cla_desc":"Flat, lighter shadow effect",
		"cla_type":"system_cla",
		"cla_cat":"Shadows",
		'render_style':'margin: 20px;background:white;line-height:50px;',
	},
	".inner-shadow(@x: 0, @y: 1px, @blur: 2px, @spread: 0, @alpha: 0.25)":{
		"cla_prop":"box-shadow: inset @x @y @blur @spread rgba(0, 0, 0, @alpha);",
		"cla_desc":"Sets a small shadow inside the selected element",
		"cla_type":"system_cla",
		"cla_cat":"Shadows",
		'render_style':'margin: 20px;background:white;line-height:50px;',
	},
	
	
	
	
	// DIVIDERS
	".divider-arrow(@color:#4289dc)":{
		"cla_prop":"position:relative; overflow:hidden;padding-bottom:50px; &:after, &:before{content:''; position:absolute;bottom:-400px;left:-50%;width:200%;height:400px;background:@color;transform:rotate(5deg);transform-origin:center top; } &:after{transform:rotate(-5deg);}",
		"cla_desc":"An arrow shaped section divider",
		"cla_type":"system_cla",
		"cla_cat":"Dividers",
		'render_style':'height:100px;',
	},
	".divider-diagonal(@color:#4289dc)":{
		"cla_prop":"position:relative; overflow:hidden; padding-bottom:150px; &:before{-webkit-backface-visibility: hidden;box-shadow: inset 0 0 30px fade(black,20%);content:'';width:100%;height:50px;position:absolute;bottom:-300px;left:-50%;width:200%;height:400px;background:@color;transform:rotate(5deg);transform-origin:center top;}",
		"cla_desc":"A diagonal section divider",
		"cla_type":"system_cla",
		"cla_cat":"Dividers",
		'render_style':'height:100px',
	},
	".divider-3-dots(@color:#4289dc)":{
		"cla_prop":"position:relative; padding-bottom:50px;&:before{display:block;position:absolute;content:'';bottom: 20px;width: 10px;height: 10px;border-radius: 50%;left: 50%;transform: translateX(-50%);background: @color;box-shadow: 20px 0 @color, -20px 0 @color;}",
		"cla_desc":"Medium style 3 dots divider",
		"cla_type":"system_cla",
		"cla_cat":"Dividers",
		'render_style':'height:100px',
	},
	".divider-rounded(@color:#4289dc)":{
		"cla_prop":"overflow:hidden; position:relative; padding-bottom:100px; &:after{content:'';position:absolute;bottom:-30px;left:-5%;width:110%;height:130px;background:@color;border-radius:50% 50% 0 0;-webkit-backface-visibility: hidden;box-shadow: inset 0 0 30px fade(black,20%);}",
		"cla_desc":"A rounded section divider",
		"cla_type":"system_cla",
		"cla_cat":"Dividers",
		'render_style':'height:100px',
	},
	".divider-spike(@color:#4289dc,@height:80px)":{
		"cla_prop":"padding-bottom:@height;position:relative;&:before,&:after{content:'';position:absolute;bottom:0;width:51%;left:0;height:@height;background:@color;border-radius:0 @height*1.5 0 0;}&:after{left:auto;right:0;border-radius:@height*1.5 0 0 ;}",
		"cla_desc":"A spiked divider, @color should be the color of the following section",
		"cla_type":"system_cla",
		"cla_cat":"Dividers",
		'render_style':'height:100px',
	},
	".divider-curve-right(@color:#4289dc,@height:150px)":{
		"cla_prop":"overflow:hidden;position:relative;padding-bottom:@height;&:after{content:'';position:absolute;bottom:0;left:-10%;width:120%;height:@height/1.5;background:@color;border-top-right-radius:1500%}",
		"cla_desc":"A right oriented curved divider",
		"cla_type":"system_cla",
		"cla_cat":"Dividers",
		'render_style':'height:100px',
	},
	".divider-curve-left(@color:#4289dc,@height:150px)":{
		"cla_prop":"overflow:hidden;position:relative;padding-bottom:@height;&:after{content:'';position:absolute;bottom:0;left:-10%;width:120%;height:@height/1.5;background:@color;border-top-left-radius:1500%}",
		"cla_desc":"A left oriented curved divider",
		"cla_type":"system_cla",
		"cla_cat":"Dividers",
		'render_style':'height:100px',
	},
	".divider-fluid(@color:#4289dc,@height:90px,@scale:0.8)":{
		"cla_prop":"\
				padding-bottom:@height*1.1;\
				border-bottom:1px solid @color;\
				position:relative;\
				overflow:hidden;\
				&:after, &:before{\
					content:'';\
					background:@color;\
					position:absolute;\
					transform: scaleY(@scale);\
					transform-origin:bottom;\
					bottom:-1px;\
					left:0%;\
					width:140%;\
					height:@height;\
					mask:url(//svgshare.com/i/3cL.svg) -20% bottom;\
					-webkit-mask:url(http://svgshare.com/i/3cp.svg) -20% bottom;\
					mask-size:auto 100%;\
					-webkit-mask-size:auto 100%;\
					mask-repeat:repeat-x;\
					-webkit-mask-repeat:repeat-x;\
				}\
				&:after{\
					height:@height*1.3;\
					transform: scaleY(@scale*1.5);\
					left:-40%;\
					opacity:.3;\
				}\
		",
		"cla_desc":"Wave style divider",
		"cla_type":"system_cla",
		"cla_cat":"Dividers",
		'render_style':'height:100px;padding:0;',
	},
	
	".divider-waver(@color:#4289dc,@scale:0.5)":{
		"cla_prop":"\
					z-index: 1;\
					position: relative;\
					overflow: hidden;\
					&:before,&:after{\
						content: '';\
						background: @color;\
						position: absolute;\
						transform-origin: bottom;\
						bottom: -1px;\
						left: 0%;\
						width: 120%;\
						height: 700px;\
						mask: url(http://svgshare.com/i/3nL.svg) bottom right;\
						-webkit-mask: url(http://svgshare.com/i/3nL.svg) bottom right;\
						-webkit-mask-size: 100% , 100%;\
						-webkit-mask-size: 100% , 100%;\
						mask-repeat: no-repeat;\
						-webkit-mask-repeat: no-repeat;\
						z-index: -1;\
						transform: scaleY(@scale);\
					}\
					&:after{\
						left: -2%;\
						transform: scaleY(@scale*1.2);\
						opacity: .5;\
					}\
		",
		"cla_desc":"Suuuuperwave",
		"cla_type":"system_cla",
		"cla_cat":"Dividers",
		'render_style':'height:100px;padding:0;',
	},
	
	
 


	
	
	".striped-bg-effect()":{
		"cla_prop":"\
			position:relative;\
			z-index:0;\
			overflow:hidden;\
			&:after, &:before{\
				pointer-events:none;\
				content:'';\
				position:absolute;\
				top:10%;\
				left:0;\
				height:50%;\
				-webkit-backface-visibility:hidden;\
				backface-visibility:hidden;\
				transform:skew(0,-15deg);\
				width:70%;\
				transform-origin:top right;\
				background-color:white;\
				mix-blend-mode:overlay;\
				opacity:.3;\
				.gradient(to right,white,black);\
				z-index:-1;\
				}\
			&:after{\
				left:30%;\
				height:100%;\
			}",
		"cla_desc":"A cool striped background effect",
		"cla_type":"system_cla",
		"cla_cat":"Backgrounds",
		'render_style':'height:100px',
	},
 
 

	
	

}

// COOL BGS

var imgs = {
	'geometric':['//i.imgur.com/XTHJuL1.png','//i.imgur.com/xiz4ORU.png','//i.imgur.com/mDpwxm0.png','//i.imgur.com/lwy6shD.png','//i.imgur.com/bByGF3b.png','//i.imgur.com/AY20rH6.jpg','//i.imgur.com/hr3TBUI.jpg','//i.imgur.com/hw9Esog.jpg'],
	'artistic': ['//i.imgur.com/zkdl6q0.png','//i.imgur.com/dIb8Kn2.png','//i.imgur.com/nxejlJ3.png','//i.imgur.com/mojigtK.png','//i.imgur.com/KxQHZrU.jpg','//i.imgur.com/VOnPghD.gif','//i.imgur.com/O9GB9AT.jpg','//i.imgur.com/VRPWNhm.png','//i.imgur.com/TIQaMuA.jpg','//i.imgur.com/bTdRcUq.png','//i.imgur.com/VeAOCJ8.png'],
	'icons':['//i.imgur.com/w50C0y0.png','//i.imgur.com/kxB8uX6.png','//i.imgur.com/J3b5IwD.jpg','//i.imgur.com/2kZBWJC.jpg','//i.imgur.com/V6YtVRM.png','//i.imgur.com/kqjjSAJ.gif'],
	'3d':['//i.imgur.com/Bsn619g.png','//i.imgur.com/BaECdJ3.png','//i.imgur.com/yjG29fI.png','//i.imgur.com/VIRGH7Y.gif','//i.imgur.com/stoKKOR.jpg','//i.imgur.com/YR1lAzZ.png','//i.imgur.com/IsnEDMG.png','//i.imgur.com/PT620Cn.jpg']
}





for (var cat in imgs){
	var all = imgs[cat];
	var cnt = 0;
	for (var i in all){
		var img = all[i];
		cnt++;
		var selector = '.bg-'+cat+'-'+cnt+'(@color:#4389dc)';
		var style = 'background-image:url('+img+');background-color:@color;background-blend-mode:overlay;background-position:center;background-repeat:repeat;background-size:auto;';
		system_global_classes[selector] = {
			'cla_prop':style,
			'cla_type':'system_cla',
			'cla_cat':'Backgrounds',
			'render_style':'height:100px;',
		}
	}
}
