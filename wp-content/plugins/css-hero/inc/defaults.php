// <script>
// DEFAULT VALS

var flat_palette = ['#1abc9c','#2ecc71','#3498db','#9b59b6','#34495e','#16a085','#27ae60','#2980b9','#8e44ad','#2c3e50','#f1c40f','#e67e22','#e74c3c','#ecf0f1','#95a5a6','#f39c12','#d35400','#c0392b','#bdc3c7','#7f8c8d'];

var material_palette = ['#f44336','#E91E63','#9C27B0','#673AB7','#3F51B5','#2196F3','#03A9F4','#00BCD4','#009688','#4CAF50','#8BC34A','#CDDC39','#FFEB3B','#FFC107','#FF9800','#FF5722','#795548','#9E9E9E','#607D8B','#263238']

var additional_palettes = {'flat':flat_palette,'material':material_palette};


var default_mqs = {
	"tablet-landscape":{
		mq_details:{
			'max-width':"1024px",
		},
		pr:{}
	},
	"tablet-portrait":{
		mq_details:{
			'max-width':"768px",
		},
		pr:{}
	},
	"mobile-landscape":{
		mq_details:{
			'max-width':"568px",
		},
		pr:{}
	},
	"mobile-portrait":{
		mq_details:{
			'max-width':"320px",
		},
		pr:{}
	},
}

var default_mq_settings_array = default_mqs;


desktop_only_parameter = 1025;
system_vars = {"@desktop_only":{"var_prop":"~'only screen and (min-width: "+desktop_only_parameter+"px)'","var_type":"system_var"}};

var default_gfontlist = ['Playfair Display','Work Sans','Space Mono','Source Sans Pro','Source Serif Pro','Roboto','Roboto Slab','BioRhyme','Montserrat','Lato','Cardo','Open Sans','Inconsolata','Cabin','Raleway','Anonymous Pro','Arvo','Merriweather'];

var system_fonts = ['Georgia, serif','Palatino Linotype, Book Antiqua, Palatino, serif','Times New Roman, Times, serif','Arial, Helvetica, sans-serif','Comic Sans MS, cursive, sans-serif','Impact, Charcoal, sans-serif','Lucida Sans Unicode, Lucida Grande, sans-serif','Tahoma, Geneva, sans-serif','Trebuchet MS, Helvetica, sans-serif','Verdana, Geneva, sans-serif','Courier New, Courier, monospace','Lucida Console, Monaco, monospace'];


//// __ indica le proprietà di un gruppo, mai mettere un gruppo hidden o pro come ultimo della lista
// THE EDITABLE PROPS GROUPS
var props_groups = {
	"background":{
		"background-color":{
			"colorpicker" 	: 1,
		},
		"background-image":{
			"set_none":1,
			"dropdown":['linear-gradient(90deg,#FDEB71,#F8D800)',
						'linear-gradient(90deg,#ABDCFF,#0396FF)',
						'linear-gradient(90deg,#FEB692,#EA5455)',
						'linear-gradient(90deg,#CE9FFC,#7367F0)',
						'linear-gradient(90deg,#90F7EC,#32CCBC)',
						'linear-gradient(90deg,#FFF6B7,#F6416C)',
						'linear-gradient(90deg,#81FBB8,#28C76F)',
						'linear-gradient(90deg,#E2B0FF,#9F44D3)',
						'linear-gradient(90deg,#F97794,#623AA2)',
						'linear-gradient(90deg,#FCCF31,#F55555)',
						'linear-gradient(90deg,#F761A1,#8C1BAB)',
						'linear-gradient(90deg,#43CBFF,#9708CC)',
						'linear-gradient(90deg,#5EFCE8,#736EFE)',
						'linear-gradient(90deg,#FAD7A1,#E96D71)',
						'linear-gradient(90deg,#FFD26F,#3677FF)',
						'linear-gradient(90deg,#A0FE65,#FA016D)',
						'linear-gradient(90deg,#FFDB01,#0E197D)',
						'linear-gradient(90deg,#FEC163,#DE4313)',
						'linear-gradient(90deg,#92FFC0,#002661)',
						'linear-gradient(90deg,#EEAD92,#6018DC)',
						'linear-gradient(90deg,#F6CEEC,#D939CD)',
						'linear-gradient(90deg,#52E5E7,#130CB7)',
						'linear-gradient(90deg,#F1CA74,#A64DB6)',
						'linear-gradient(90deg,#E8D07A,#5312D6)',
						'linear-gradient(90deg,#EECE13,#B210FF)',
						'linear-gradient(90deg,#79F1A4,#0E5CAD)',
						'linear-gradient(90deg,#FDD819,#E80505)',
						'linear-gradient(90deg,#FFF3B0,#CA26FF)',
						'linear-gradient(90deg,#FFF5C3,#9452A5)',
						'linear-gradient(90deg,#F05F57,#360940)',
						'linear-gradient(90deg,#2AFADF,#4C83FF)',
						'linear-gradient(90deg,#FFF886,#F072B6)',
						'linear-gradient(90deg,#97ABFF,#123597)',
						'linear-gradient(90deg,#F5CBFF,#C346C2)',
						'linear-gradient(90deg,#FFF720,#3CD500)',
						'linear-gradient(90deg,#FF6FD8,#3813C2)',
						'linear-gradient(90deg,#EE9AE5,#5961F9)',
						'linear-gradient(90deg,#FFD3A5,#FD6585)',
						'linear-gradient(90deg,#C2FFD8,#465EFB)',
						'linear-gradient(90deg,#FD6585,#0D25B9)',
						'linear-gradient(90deg,#FD6E6A,#FFC600)',
						'linear-gradient(90deg,#65FDF0,#1D6FA3)',
						'linear-gradient(90deg,#6B73FF,#000DFF)',
						'linear-gradient(90deg,#FF7AF5,#513162)',
						'linear-gradient(90deg,#F0FF00,#58CFFB)',
						'linear-gradient(90deg,#FFE985,#FA742B)',
						'linear-gradient(90deg,#FFA6B7,#1E2AD2)',
						'linear-gradient(90deg,#FFAA85,#B3315F)',
						'linear-gradient(90deg,#72EDF2,#5151E5)',
						'linear-gradient(90deg,#FF9D6C,#BB4E75)',
						'linear-gradient(90deg,#F6D242,#FF52E5)',
						'linear-gradient(90deg,#69FF97,#00E4FF)',
						'linear-gradient(90deg,#3B2667,#BC78EC)',
						'linear-gradient(90deg,#70F570,#49C628)',
						'linear-gradient(90deg,#3C8CE7,#00EAFF)',
						'linear-gradient(90deg,#FAB2FF,#1904E5)',
						'linear-gradient(90deg,#81FFEF,#F067B4)',
						'linear-gradient(90deg,#FFA8A8,#FCFF00)',
						'linear-gradient(90deg,#FFCF71,#2376DD)',
						'linear-gradient(90deg,#FF96F9,#C32BAC)'
						]	
		
		},
		"background-repeat":{
			"advanced" : 1,
			"buttons":['no-repeat','repeat','repeat-x','repeat-y'],
		},
		"background-size":{
			"buttons":['auto','cover','contain','100% 100%'],
			"advanced" : 1,
		},
		"background-position":{
			"buttons":['top left','top','top right','left','center','right','bottom left','bottom','bottom right'],
		},
		"background-blend-mode":{
			"advanced" : 1,
			"dropdown":['normal','multiply','screen','overlay','darken','lighten','color-dodge','dodge','saturation','color','luminosity'],
			"description":"The background-blend-mode property defines the blending mode of each background layer (color and/or image)."
		},
		"background-attachment":{
			"dropdown":['fixed','scroll']
		}
		
	},
	"typography":{
		"color":{
			"colorpicker"	: 1,
		},
		"font-family":{
			"dropdown":['1','2'],
		},
		"font-weight":{
			"dropdown":['100','200','300','400','500','600','700','800','900']
		},
		"font-size":{
			"numeric" : 1,
			"slidable":1,
			"range":[0,100]
		},
		
		"line-height":{
			"numeric":1,
			"slidable":1,
			"range":[-20,100]
		},
		"font-style":{
			"buttons":['normal','italic']
		},
		"text-transform":{
			"buttons":['none','capitalize','uppercase','lowercase']
		},
		"text-decoration":{
			"buttons":['none','underline','overline','line-through']
		},
		
		"text-align":{
			"buttons":['left','center','right','justify']	
		},
		"letter-spacing":{
			"numeric":1,
			"slidable":1,
			"range":[-10,50]
		},
		"word-spacing":{
			"numeric":1,
			"slidable":1,
			"range":[-20,100]
		},
		"text-shadow":{
			"set_none":1,
			//"dropdown":['linear-gradient(45deg,#FDEB71,#F8D800)'],
		}
	},
	
	"borders":{
		"border-width":{
			"numeric":1,
			"slidable":1,
			"range":[0,100],
			"inner_group":'border-all',
		},
		"border-color":{
			 "colorpicker" : 1,
			 "inner_group":'border-all',
		},
		"border-style":{
			"buttons":['none','solid','dotted','dashed'],
			"inner_group":'border-all',
		},
		/*
		"border-image":{
			"description":"Allows you to specify an image to be used instead of the normal border around an element. Requires the border-size and border-style property to be set.",
			"set_none":1,
		},
		
		*/
		
		"border-top-width":{
			"numeric":1,
			"slidable":1,
			"range":[0,100],
			"inner_group":'border-top',
			
		},
		"border-top-color":{
			 "colorpicker" : 1,
			  "inner_group":'border-top',
		},
		"border-top-style":{
			"buttons":['none','solid','dotted','dashed'],
			"inner_group":'border-top',
		},
	
		"border-right-width":{
			"numeric":1,
			"slidable":1,
			"range":[0,100],
			"inner_group":'border-right',
			
		},
		"border-right-color":{
			 "colorpicker" : 1,
			 "inner_group":'border-right',
		},
		"border-right-style":{
			"inner_group":'border-right',
			"buttons":['none','solid','dotted','dashed'],
		},
	
		"border-bottom-width":{
			"numeric":1,
			"slidable":1,
			"range":[0,100],
			"inner_group":'border-bottom',
		},
		"border-bottom-color":{
			 "colorpicker" : 1,
			 "inner_group":'border-bottom',
		},
		"border-bottom-style":{
			"inner_group":'border-bottom',
			"buttons":['none','solid','dotted','dashed'],
		},
	
		"border-left-width":{
			"numeric":1,
			"slidable":1,
			"range":[0,100],
			"inner_group":'border-left',
		},
		"border-left-color":{
			 "colorpicker" : 1,
			 "inner_group":'border-left',
		},
		"border-left-style":{
			"inner_group":'border-left',
			"buttons":['none','solid','dotted','dashed'],
		},
	},
	"border-radius":{
		"border-radius":{
			"numeric":1,
			"slidable":1,
			"range":[0,100],
		},
		"border-top-left-radius":{
			"numeric":1,
			"slidable":1,
			"range":[0,100],
		},
		"border-top-right-radius":{
			"numeric":1,
			"slidable":1,
			"range":[0,100],
		},
		"border-bottom-right-radius":{
			"numeric":1,
			"slidable":1,
			"range":[0,100],
		},
		"border-bottom-left-radius":{
			"numeric":1,
			"slidable":1,
			"range":[0,100],
		},
		
	},
	"padding":{
		"padding-top":{
			"numeric" : 1,
			"slidable":1,
			"range":[0,100]
		},
		"padding-right":{
			"numeric" : 1,
			"slidable":1,
			"range":[0,100]
		},
		"padding-bottom":{
			"numeric" : 1,
			"slidable":1,
			"range":[0,100]
		},
		"padding-left":{
			"numeric" : 1,
			"slidable":1,
			"range":[0,100]
		},
	},
	"margin":{
		"margin-top":{
			"numeric" : 1,
			"slidable":1,
			"range":[-100,100]
		},
		"margin-right":{
			"numeric" : 1,
			"slidable":1,
			"range":[-100,100]
		},
		"margin-bottom":{
			"numeric" : 1,
			"slidable":1,
			"range":[-100,100]
		},
		"margin-left":{
			"numeric" : 1,
			"slidable":1,
			"range":[-100,100]
		},
	},
	
	"lists":{
		"list-style-type":{
			"buttons":['disc','circle','decimal'],
		},
		"list-style-image":{
		},
	
		"list-style-position":{
			"buttons":['inside','outside']
		},
		
	},
	
	"measures":{
		"__is-advanced":true,
		"__notice":'<b>Warning:</b> those properties may break your layout, use\'m only if you\'re 100% sure of what you\'re doing.',
		"width":{
			"numeric" : 1,
			"slidable":1,
			"range":[0,2000]
		},
		"height":{
			"numeric" : 1,
			"slidable":1,
			"range":[0,2000]
		},
		"min-width":{
			"numeric" : 1,
			"slidable":1,
			"range":[0,2000]
		},
		"min-height":{
			"numeric" : 1,
			"slidable":1,
			"range":[0,2000]
		},
		"max-height":{
			"numeric" : 1,
			"slidable":1,
			"range":[0,2000]
		}
		
	},
	
	"positioning":{
		"__is-advanced":true,
		"__notice":'<b>Warning:</b> those properties may break your layout, use\'m only if you\'re 100% sure of what you\'re doing.',
		"position":{
			"dropdown":['static','relative','absolute','fixed']
		},
		"top":{
			"numeric" : 1,
			"slidable":1,
			"range":[-1000,1000]
		},
		"right":{
			"numeric" : 1,
			"slidable":1,
			"range":[-1000,1000]
		},
		"bottom":{
			"numeric" : 1,
			"slidable":1,
			"range":[-1000,1000]
		},
		"left":{
			"numeric" : 1,
			"slidable":1,
			"range":[-1000,1000]
		}
		
	},
	
	
	"extra":{
		"box-shadow":{
			"set_none":1,
		},
		"float":{
			"buttons":['none','left','right']	
		},
	//	"clear":{
	//		"buttons":['none','left','right','both']
	//	},
		"visibility":{
			"buttons":['visible','hidden'],
		},
		"opacity":{
		//	"numeric" : 1,
			"slidable":1,
			"range":[0,1]
		},
		"box-sizing":{
			"buttons":['border-box','content-box']
		},
		"display":{
			"buttons":['none','block','inline','inline-block']
		},
		"transform":{
			
		},
		"transition":{
			"set_none":1,
		}
		
	}
}


////// TOOLTIPS

var global_tips = {
	'.count-els-in-page span':{
		'desc':'Instances of this element on the page',
		'dir':'n'
	},
	'.csshero-selector .counter':{
		'desc':'Instances of this element on the page',
		'dir':'w'
	},
	'.csshero-change-editor-font-size.plus':{
		'desc':'Increase font size',
		'dir':'s'
	},
	'.csshero-change-editor-font-size.minus':{
		'desc':'Decrease font size',
		'dir':'s'
	},
	
	'.enable-nav .csshero-n':{
		'desc':'Enable Navigation',
		'dir':'n'
	},
	'.enable-nav .csshero-s':{
		'desc':'Enable Selection',
		'dir':'n'
	},
	'.show-theme-code':{
		'desc':'Show inherited styles from theme',
		'dir':'w'
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}