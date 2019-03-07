<?php
$csshero_version="3.42";
$csshero_version_styles="3.42";

// $active_plugins=get_option('active_plugins');print_r($active_plugins);die;
$theme_slug=csshero_get_active_theme_slug();
$html_theme_slug = $theme_slug;
//if (isset($_GET['csshero_rocket_mode']) && $_GET['csshero_rocket_mode']=='on') $rocket_mode_string="&rocket_mode=1"; else
$rocket_mode_string="";
if (is_child_theme()) $theme_slug=strtolower(get_template()); //gets the parent if we are using a child

//you can force here to override default configuration being applied to your theme
if (isset($_GET['override_theme_config'])) $theme_slug=$_GET['override_theme_config'];
//EXAMPLE: $theme_slug="yourtheme";

setcookie('csshero_is_on', 1, time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
global $csshero_public_demo_mode;
if ($csshero_public_demo_mode==TRUE) $ademo="cache_subject=demo&"; else $ademo="";

//$hero_js_root= plugins_url('/assets/js', __FILE__); $hero_js_root=str_replace("http://","//",$hero_js_root);
$site_base_url = site_url().'/';
$plugin_root_url= plugin_dir_url( __FILE__ );
?>

<!DOCTYPE html>
<html data-child-theme-slug="<?php echo $theme_slug; ?>">
<head>
	<meta charset="UTF-8">
	<meta name="robots" content="noindex,nofollow">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	<title>CSS Hero &mdash; <?php echo $csshero_version; ?></title>
	<link rel="stylesheet" href="<?php echo $plugin_root_url ?>styles/spectrum.css" />
	<link rel="stylesheet" href="<?php echo $plugin_root_url ?>styles/icons.css?v=<?php echo $csshero_version_styles;?>" />
	<link rel="stylesheet" href="<?php echo $plugin_root_url ?>styles/codemirror-base.css" />
	<?php if (isset($_GET['local'])){ ?>
		<link rel="stylesheet/less" type="text/css" href="<?php echo $plugin_root_url ?>styles/styles.less?v=<?php echo $csshero_version_styles;?>" />
	<?php } else { ?><link rel="stylesheet" type="text/css" href="https://csshero.org/production-v3/style-versioning/style.php?v=<?php echo $csshero_version_styles; ?>" /><?php } ?>
	
	<script src="<?php echo $plugin_root_url ?>js/jquery-3.1.1.min.js"></script>
	<script src="<?php echo $plugin_root_url ?>js/jquery-ui.min.js"></script>
	<script src="<?php echo $plugin_root_url ?>js/jquery.form.js"></script>
	<script src="<?php echo $plugin_root_url ?>js/jquery.perfect-scrollbar.min.js"></script>
	
	<script src="<?php echo $plugin_root_url ?>js/codemirror-5.21.0.js"></script>

	
	<script src="<?php echo $plugin_root_url ?>js/codemirror-css.js"></script>
	<script src="<?php echo $plugin_root_url ?>js/codemirror-autoclose-brackets.js"></script>
	<script src="<?php echo $plugin_root_url ?>js/codemirror-showhint.js"></script>
	<script src="<?php echo $plugin_root_url ?>js/codemirror-overlay.js"></script>
	
	<script src="<?php echo $plugin_root_url ?>js/codemirror-search.js"></script>
	<script src="<?php echo $plugin_root_url ?>js/codemirror-searchcursor.js"></script>
	<script src="<?php echo $plugin_root_url ?>js/codemirror-dialog.js"></script>
	<script src="<?php echo $plugin_root_url ?>js/codemirror.matchbrackets.js"></script>
	
	<script src="<?php echo $plugin_root_url ?>js/spectrum.js"></script> 
	<script src="<?php echo $plugin_root_url ?>js/less-2.7.1.min.js"></script>
	<script src="<?php echo $plugin_root_url ?>js/tipsy.js"></script>
	<script src="<?php echo $plugin_root_url ?>js/is-in-viewport.js"></script>
	<script src="<?php echo $plugin_root_url ?>js/selectize.js"></script>
	<script>
		
		window.csshero_plugin_root = '<?php echo $plugin_root_url ?>';
		window.csshero_admin_ajax_url='<?php echo admin_url( 'admin-ajax.php' ) ?>';
		
	</script>
	<?php 
		$herologo = '<svg version="1.1" class="cssherologo" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 width="120px" height="30px" viewBox="0 0 120 30" enable-background="new 0 0 120 30" xml:space="preserve"><g><g><path d="M3.088,15.831c0-4.924,3.815-8.186,8.547-8.186c4.157,0,6.161,2.43,6.821,4.711l-4.135,1.302 c-0.256-1.323-1.385-2.218-2.878-2.218c-2.302,0-3.901,1.961-3.901,4.093c0,1.621,1.237,3.027,3.198,3.027 c1.108,0,2.387-0.724,2.878-1.64l3.368,2.173c-1.77,2.558-4.541,3.261-6.481,3.261C6.434,22.354,3.088,19.839,3.088,15.831z"/><path d="M17.186,19.584l2.558-3.07c0.981,1.279,2.985,2.175,4.903,2.175c0.81,0,1.13-0.363,1.13-0.618 c0-1.194-6.8-1.151-6.8-5.308c0-2.473,2.046-5.094,6.097-5.094c2.323,0,4.647,0.809,6.203,2.366l-2.579,2.984 c-1.172-1.172-2.985-1.727-4.328-1.727c-0.554,0-0.874,0.257-0.874,0.576c0,1.13,6.821,1.194,6.821,5.308 c0,2.984-2.345,5.179-6.011,5.179C21.279,22.354,18.593,21.268,17.186,19.584z"/><path d="M30.26,19.584l2.558-3.07c0.981,1.279,2.985,2.175,4.903,2.175c0.81,0,1.13-0.363,1.13-0.618c0-1.194-6.8-1.151-6.8-5.308 c0-2.473,2.046-5.094,6.097-5.094c2.323,0,4.647,0.809,6.203,2.366l-2.579,2.984c-1.172-1.172-2.985-1.727-4.328-1.727 c-0.554,0-0.874,0.257-0.874,0.576c0,1.13,6.821,1.194,6.821,5.308c0,2.984-2.344,5.179-6.011,5.179 C34.353,22.354,31.667,21.268,30.26,19.584z"/></g><g><path d="M66.582,22.099l1.194-5.436h-5.095l-1.193,5.436h-4.306L60.316,7.88h4.305l-1.108,5.032h5.095l1.108-5.032h4.305 l-3.133,14.219H66.582z"/><path d="M73.2,22.099L76.334,7.88h10.786l-0.831,3.753h-6.479l-0.299,1.406h6.33l-0.831,3.753h-6.33l-0.342,1.555h6.481 l-0.831,3.753H73.2z"/><path d="M93.904,22.099l-0.979-4.476h-1.727l-0.981,4.476h-4.306L89.044,7.88h6.906c2.579,0,4.775,1.685,4.775,4.306 c0,2.515-1.64,4.456-3.496,5.117l1.408,4.796H93.904z M94.65,13.87c0.939,0,1.621-0.404,1.621-1.215 c0-0.595-0.533-1.022-1.194-1.022h-2.558l-0.489,2.237h2.557H94.65z"/><path d="M100.968,15.831c0-4.541,3.602-8.186,8.548-8.186c4.199,0,7.396,2.643,7.396,6.481c0,4.541-3.581,8.227-8.526,8.227 C104.165,22.354,100.968,19.69,100.968,15.831z M112.457,14.467c0-1.748-1.277-3.027-3.197-3.027c-2.26,0-3.836,1.92-3.836,4.093 c0,1.748,1.279,3.027,3.197,3.027C110.881,18.56,112.457,16.642,112.457,14.467z"/></g><g><g><path d="M48.247,22.479c-0.159-0.103,2.623-5.95,2.529-6.208c-0.098-0.255-3.045-1.192-3.192-1.644 c-0.145-0.451,5.825-7.237,5.983-7.105c0.154,0.131-2.602,6.017-2.527,6.208c0.075,0.191,3.098,1.167,3.19,1.645 C54.32,15.855,48.409,22.584,48.247,22.479z"/></g></g></g></svg>'; ?>
	<?php if (isset($_GET['local'])){ ?>
		
		<script charset="UTF-8" type="text/javascript" src='<?php echo $plugin_root_url ?>local-loader-v3.php?<?php echo $ademo ?>version=<?php echo $csshero_version .$rocket_mode_string ?>&key=<?php echo  wpcss_check_license() ?>&theme=<?php echo $theme_slug ?>&thv=<?php $my_theme = wp_get_theme(); echo   $my_theme->get( 'Version' ); ?>&plugins=<?php echo csshero_get_active_site_plugins() ?><?php if (isset($_GET['rocket_mode_version'])) echo "&rocket_mode_version=".$_GET['rocket_mode_version'] ?>'></script>
	<?php } else { ?>
	
		<script charset="UTF-8" type="text/javascript" src='https://csshero.org/production-v3/heroes-loader-v3.php?<?php echo $ademo ?>version=<?php echo $csshero_version .$rocket_mode_string ?>&key=<?php echo  wpcss_check_license() ?>&theme=<?php echo $theme_slug ?>&thv=<?php $my_theme = wp_get_theme(); echo   $my_theme->get( 'Version' ); ?>&plugins=<?php echo csshero_get_active_site_plugins() ?><?php if (isset($_GET['rocket_mode_version'])) echo "&rocket_mode_version=".$_GET['rocket_mode_version'] ?>'></script> 
	<?php } ?>
</head>
<body id="csshero-body" data-admin-url="<?php echo get_admin_url(); ?>" data-js-version="<?php echo $csshero_version;?>" data-css-version="<?php echo $csshero_version_styles; ?>" data-plugin-root="<?php echo $plugin_root_url ?>" data-mq-mode="all" data-site-base-url="<?php echo $site_base_url; ?>" class="show-bottom-navi">
	
	<div id="spinner"></div>
	<div id="csshero-interface-splash-loader"><span>Loading Interface</span><div><div class="reg"></div><?php echo $herologo; ?></div></div>
		
	<div id="csshero-frame-wrap" class="hidd">
		
		<div id="csshero-frame-nav">
			<div class="bar">
				<div class="csshero-navigator-wrap">
					
					<div class="csshero-selector-bar"></div>
					
					<div class="csshero-selectors-list">
						<span></span>
						<div class="csshero-selector-options"></div>
					</div>
					<div class="csshero-selector-refiner">
						<span></span>
						<div class="csshero-selector-refiner-inner"></div>
					</div>
					
				</div>
				<div class="csshero-mq-mode-item">
					<label></label>
					
					<div class="csshero-mq-mode-label">
						<span class="icon"></span>
						<span class="mq-name">All Devices</span>
						
						<span class="dd"></span>
					</div>
				</div>
				
			</div>
		</div>
		
		
		
		<div class="mq-mode-expander">
			<div class="csshero-mqs-scroller">
				<div class="mq-mode-expander-inner"></div>
			</div>
			<div class="csshero-service-actions">
				<span class="open-overlay" data-overlay-service="mq-manager">Media Query Manager</span>
			</div>
		</div>
		
		
		
		<div class="csshero-vertical-limiter">
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			<span class="l"></span>
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			<span class="l"></span>
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			<span class="l"></span>
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			<span class="l"></span>
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			<span class="l"></span>
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			<span class="l"></span>
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			<span class="l"></span>
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			<span class="l"></span>
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			<span class="l"></span>
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			<span class="l"></span>
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			<span class="l"></span>
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			<span class="l"></span>
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			<span class="l"></span>
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			<span class="l"></span>
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			<span class="l"></span>
			<div class="csshero-vertical-limiter-safe-area">
				<div class="v-limiter-handle">
					<div class="v-val">zurb</div>
				</div>
			</div>
		</div>
		<div id="csshero-editable-loader"><span></span></div>
		<div id="csshero-inner-frame-wrap">
			
			<div class="a">
				<div class="b"></div>
				<div class="c"></div>
				<div class="d"></div>
			</div>
			<div id="csshero-focus-view"></div>
			<iframe  src="<?php echo  remove_query_arg( 'csshero_action' ); ?>" id="csshero-iframe-main-page"   name="csshero-iframe-main-page"></iframe>
		</div>
	</div>
	<div class="csshero-overlay-service">
		<div class="overlay-inner" data-service="mq-manager">
			<div class="overlay-head">
				<span class="service-title">Media Query Manager</span>
				<span class="close-overlay"></span>
			</div>
			<div class="overlay-scroller">
				<div class="csshero-description">
					Control all your media queries here. Rendering on code follows the tabs order in this panel.
				</div>
				<div class="csshero-mqs-panel"></div>
				
			</div>
			<div class="overlay-footer">
				<span class="csshero-add-mq">Add Media Query</span>
			</div>
		</div>
		<div class="overlay-inner" data-service="font-manager">
			<div class="font-loader"></div>
			<div class="font-manager-tab">
				<span class="active" data-area="g">Google Fonts</span>
				<span data-area="t">Typekit</span>
			</div>
			<div data-area="g" class="font-manager-area active no-fonts-loaded">
			<div class="font-manager-side">
				<div class="fonts-sorter">
					<input class="search-font" type="text" />
					<span class="exp"></span>
						<ul>
							<li data-sort="all">All</li>
							<li data-sort="in-project">In Project</li>
						</ul>
					
				</div>
				<ul class="all-g-fonts font-side-lister"></ul>
			</div>
			<div class="font-manager-main">
				<div class="font-manager-top"><h1></h1><span class="close-overlay"></span></div>
				<div class="font-manager-browser google-fonts"></div>
				<div class="font-manager-bottom"><span class="font-adder"></span></div>
			</div>
			</div>
			<div data-area="t" class="font-manager-area no-fonts-loaded">
				<div class="font-manager-side">
					<div class="fonts-sorter tk">
						<label>Typekit ID:</label><input id="TKID" type="text">
						<span class="save-typekit">Save</span>
					</div>
					<ul class="all-tk-fonts font-side-lister"></ul>
				</div>
				<div class="font-manager-main">
					<div class="font-manager-top"><h1></h1><span class="close-overlay"></span></div>
					<div class="font-manager-browser typekit-fonts"></div>
					<div class="font-manager-bottom"><span class="font-adder"></span></div>
				</div>
			</div>
		</div>
	</div>
	
	
	
	<div class="csshero-services">
		
		<div class="csshero-service-block" data-service="tree">
			
			<span class="service-title">
				<span>Selectors</span>
				<span class="csshero-close-service"></span>
				<span class="csshero-search-service icon-search"></span>
			</span>
			<div class="csshero-service-search">
				<div class="csshero-search-in-service-wrap">
					<input data-search-item=".csshero-tree .yell" class="csshero-service-src" type="text" placeholder="search this service" />
					<span class="counter">0</span>
					<div class="nav" data-anchor=".tree-in">
						<span class="prev"></span>
						<span class="next"></span>
					</div>
				</div>
			</div>
			<div class="csshero-description">
					<p>Browse and add your custom CSS selectors</p>
				</div>
			<div class="csshero-service-actions">
				<span class="csshero-show-interstitial icon-plus has-icon">Add Selector</span>
			</div>
			
			
			<div class="csshero-custom-tree-add service-interstitial">
				<span class="service-title">Add Selector</span>
				<div class="input-w">
					<label>CSS Selector</label>
					<input class="add-new-custom-tree-el-selector" placeholder="Ex: .my_custom_header" />
				</div>
				<div class="input-w">
					<label>Description</label>
					<input class="add-new-custom-tree-el-name" placeholder="Ex: My Custom Header" />
				</div>
				<span class="add-selector-helper"></span>			
				<div class="csshero-tree-actions csshero-in-service-actions">
					<span class="csshero-hide-interstitial">Close</span>
					<span class="csshero-btn-add-new-custom-tree-el">Add New</span>
				</div>
			</div>
			
			<div class="csshero-custom-tree-logger service-logger"></div>
			
			
			<div class="csshero-tree-scroller csshero-service-scroller">
				<div data-title="Custom Editable Elements" class="csshero-tree custom-tree editable-tree"></div>
				<div data-title="Context Specific Editable Elements" class="csshero-tree context-tree editable-tree"></div>
				<span class="service-title">Default Theme Selectors</span>
				<div class="csshero-tree config-tree"></div>
			</div>
		</div>
		<div class="csshero-service-block" data-service="snapshots">
			<span class="service-title">
				<span>CheckPoints</span>
				<div class="service-actions">
					<span class="csshero-close-service"></span>
				</div>
			</span>
			<div class="csshero-service-scroller">
				<div class="csshero-description">
					<p>CheckPoints are stored copies of your work which you can save for further usage without publishing them to your live website. A CheckPoint includes all your edits applied in the moment you save it.</p>
				</div>
				<div class="csshero-snapshots csshero-stepper"></div>
			</div>
		</div>
		<div class="csshero-service-block" data-service="history">
			<span class="service-title">
				<span>History</span>
				<div class="service-actions">
					<span class="csshero-close-service"></span>
				</div>
			</span>
			<div class="csshero-service-scroller">
				<div class="csshero-description">
					<p>Browse your edits history here</p>
				</div>
				<div class="csshero-history csshero-stepper"></div>
			</div>
		</div>
		<div class="csshero-service-block" data-service="overview">
			<span class="service-title">
				<span>Project Overview</span>
				<span class="csshero-close-service"></span>
				<span class="csshero-search-service icon-search"></span>
			</span>
			<div class="csshero-service-search">
				<div class="csshero-search-in-service-wrap">
					<input data-search-item=".querable" class="csshero-service-src" type="text" placeholder="search this service" />
					<span class="counter">0</span>
					<div class="nav" data-anchor=".overview-selector-wrap">
						<span class="prev"></span>
						<span class="next"></span>
					</div>
				</div>
			</div>
			<div class="csshero-description">
				<p>Here you can find an overview of all your project edits, click on each of them to load it in the editor.</p>
			</div>
			<div class="csshero-service-scroller">
				<div class="csshero-project-overview folder-sortable"></div>
			</div>
		</div>
		<div class="csshero-service-block" data-service="variables">
			<span class="service-title">
				<span>Variables</span>
				<span class="csshero-close-service"></span>
			</span>
			<div class="csshero-description">
				<p>Variables can help you controlling commonly used values and make your code easier to maintain by giving you a way to manage those values from a single location</p>
			</div>
			<div class="csshero-service-actions">
				<span class="csshero-btn-add-new-var icon-plus has-icon">Add Variable</span>
			</div>
			<div class="csshero-variables csshero-service-scroller">
				<div class="csshero-variables-panel"></div>
			</div>
			<div class="csshero-variables-logger service-logger"></div>
		</div>
	</div>
	
	<div class="csshero-super-top-bar">
		
		<ul class="top-nav">
			<li class="enable-nav">
				<span class="select">Select</span>
				<span class="navigate">Navigate</span>
			</li>
			<li class="hr"></li>
			<li class="csshero-service-item disabled" data-service="quick-back" data-tip="Undo"></li>
			<li class="csshero-service-item disabled" data-service="quick-forward" data-tip="Redo"></li>
			<li class="csshero-service-item" data-service="history" data-tip="History"></li>
			<li class="hr"></li>
			<li class="menu-snapshots has-dd">
				<span>CheckPoints</span>
				<ul>
					<li class="csshero-save-snapshot">Save CheckPoint As...</li>
					<li class="csshero-service-item" data-service="snapshots">Open CheckPoints Panel</li>
					
				</ul>
			</li>
			
			<li class="menu-project has-dd">
				<span>Project</span>
				<ul>
					<li class="csshero-service-item" data-service="tree">CSS Selectors</li>
					<li class="csshero-service-item" data-service="variables">Project Variables</li>
					<li class="csshero-service-item" data-service="overview">Project Overview</li>
				</ul>
			</li>
			<li class="menu-tools has-dd">
				<span>Tools</span>
				<ul>
					<li class="csshero-view-as-unlogged unlogged-tool" data-switch-class="viewing-as-unlogged" data-param="&csshero_view_as_unlogged=1">View As Unlogged</li>
					<li class="csshero-style-login-page unlogged-tool" data-param="&csshero_style_wp_login_page=1" data-switch-class="viewing-login-page">Style Login Page</li>
					<li class="open-overlay" data-overlay-service="font-manager">Font Manager</li>
					
					<li class="csshero-reset">Reset Theme Edits</li>
				</ul>
			</li>
			<li class="menu-help has-dd">
				<span>Help</span>
				<ul>
					<li class="csshero-enable-tips">Show Tooltips</li>
					<li class="csshero-service-item" data-service="docs"><a href="https://www.csshero.org/docs-v3/" target="_blank">Documentation</a></li>
				</ul>
			</li>
			<li class="csshero-quit"><a href="?csshero_action=shutdown" data-tip="Quit"></a></li>
		</ul>
		
		
	</div>
	
	<div class="csshero-editor-container">
		<!--div class="csshero-click-inspector"></div -->
		<div class="csshero-first-drag-handle"></div>
		<div class="csshero-welcome">
			<svg version="1.1" id="cassio" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 width="40px" height="40px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">
<path fill="#111111" d="M36,10.431h-8.645l-0.329-5.674c0,0-0.018-0.007-0.059-0.022c-0.022-2.102-3.109-4.71-6.933-4.735
	C20.022,0.001,20.011,0,20,0c-0.01,0-0.022,0-0.031,0c-3.868,0-6.997,2.634-6.997,4.758l-0.327,5.674H4l5.833,17.355
	C8.6,28.411,4.44,30.41,4.44,30.41s4.645,0.573,9.123,3.208c2.422,1.425,4.814,3.455,6.437,6.323
	c0.011,0.02,0.023,0.039,0.033,0.058c4.604-8.224,15.527-9.59,15.527-9.59s-4.16-2-5.392-2.624L36,10.431z M10.947,11.064
	l-0.205,4.62l1.144,2.164l-1.837,8.596L4.88,11.064H10.947z M18.419,10.069l-3.943-0.313V8.893l3.943,0.45V10.069z M25.524,9.756
	l-3.946,0.313V9.343l3.946-0.45V9.756z M35.12,11.064l-5.169,15.38l-1.838-8.596l1.145-2.164l-0.205-4.62H35.12z"/>
</svg>
			<div class="csshero-editor-super-top">
					<div class="st-tab csshero-branding">
						<div class="logo">
							<?php echo $herologo; ?>
						</div>
					</div>
					<div class="st-tab inspector-branding">
						<div class="trig-csshero-trigger-inspector">
							Inspector
						</div>
					</div>
					<div class="welcome-csshero-detach-editor"></div>
				</div>
			
			
			
			<div class="inner">
				
				<b>Welcome to CSS Hero <span class="v"><?php echo $csshero_version; ?></span></b>
				<p class="first">Click an <span class="el">element</span> on the page to start editing your theme.</p>
	
				<svg version="1.1" class="help" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"	 viewBox="0 0 512 512" xml:space="preserve"><g>	<g>		<path d="M480.884,287.116c0-43.627-12.3-85.414-35.684-121.642l14.634-14.635l-67.556-67.557l-14.635,14.635			c-14.714-9.497-30.345-17.161-46.644-22.919L256,0l-74.999,75c-16.299,5.759-31.93,13.421-46.643,22.918l-14.635-14.635			L52.166,150.84l14.635,14.635c-23.384,36.228-35.685,78.015-35.685,121.643c0,43.627,12.301,85.414,35.685,121.642l-14.635,14.635			l67.557,67.556l14.635-14.635C170.586,499.699,212.374,512,256,512c43.627,0,85.415-12.3,121.643-35.684l14.634,14.634			l67.556-67.556l-14.634-14.635C468.583,372.531,480.884,330.745,480.884,287.116z M392.276,125.73l25.112,25.111l-67.774,67.774			l-25.112-25.111L392.276,125.73z M284.505,383.179c-18.536,5.424-38.474,5.424-57.01,0l2.449-2.449l-67.557-67.557l-2.449,2.449			c-5.424-18.536-5.424-38.474,0-57.009l2.449,2.449l67.557-67.557l-2.449-2.449c18.536-5.424,38.475-5.424,57.011,0l-2.449,2.449			l67.556,67.557l2.449-2.45c5.424,18.536,5.424,38.475,0,57.01l-2.449-2.449l-67.557,67.557L284.505,383.179z M256,42.447			l20.733,20.733c-6.854-0.621-13.769-0.944-20.733-0.944c-6.963,0-13.877,0.323-20.732,0.944L256,42.447z M256,92.248			c35.605,0,69.782,9.451,99.848,27.463l-47.936,47.936c-16.302-7.067-34.036-10.774-51.912-10.774			c-17.875,0-35.612,3.707-51.912,10.774l-47.936-47.936C186.218,101.699,220.395,92.248,256,92.248z M119.724,125.729			l67.773,67.775l-25.111,25.111L94.613,150.84L119.724,125.729z M61.131,287.116c0-35.605,9.451-69.782,27.464-99.848			l47.936,47.936c-7.067,16.302-10.774,34.036-10.774,51.912c0,17.876,3.707,35.612,10.774,51.912l-47.936,47.936			C70.583,356.9,61.131,322.722,61.131,287.116z M119.724,448.503l-25.111-25.11l67.773-67.774l25.111,25.111L119.724,448.503z			 M256,481.986c-35.605,0-69.782-9.451-99.848-27.464l47.936-47.936c16.302,7.067,34.036,10.775,51.912,10.775			c17.874,0,35.611-3.708,51.912-10.775l47.936,47.936C325.782,472.535,291.605,481.986,256,481.986z M392.276,448.504			l-67.774-67.774l25.112-25.111l67.775,67.774L392.276,448.504z M375.47,339.03c7.067-16.302,10.775-34.037,10.775-51.913			c0-17.875-3.708-35.611-10.775-51.912l47.936-47.936c18.011,30.067,27.464,64.245,27.464,99.848			c0,35.605-9.451,69.782-27.464,99.849L375.47,339.03z"/></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
				<p>Need some help getting started? <a href="https://www.csshero.org/docs-v3/#h5" target="_blank">Video Tutorials</a></p>
			</div>
			
					<svg version="1.1" id="cassio" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 width="40px" height="40px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">
<path fill="#111111" d="M36,10.431h-8.645l-0.329-5.674c0,0-0.018-0.007-0.059-0.022c-0.022-2.102-3.109-4.71-6.933-4.735
	C20.022,0.001,20.011,0,20,0c-0.01,0-0.022,0-0.031,0c-3.868,0-6.997,2.634-6.997,4.758l-0.327,5.674H4l5.833,17.355
	C8.6,28.411,4.44,30.41,4.44,30.41s4.645,0.573,9.123,3.208c2.422,1.425,4.814,3.455,6.437,6.323
	c0.011,0.02,0.023,0.039,0.033,0.058c4.604-8.224,15.527-9.59,15.527-9.59s-4.16-2-5.392-2.624L36,10.431z M10.947,11.064
	l-0.205,4.62l1.144,2.164l-1.837,8.596L4.88,11.064H10.947z M18.419,10.069l-3.943-0.313V8.893l3.943,0.45V10.069z M25.524,9.756
	l-3.946,0.313V9.343l3.946-0.45V9.756z M35.12,11.064l-5.169,15.38l-1.838-8.596l1.145-2.164l-0.205-4.62H35.12z"/>
</svg>
				
		</div>
		<div class="csshero-editor-wrap">
			<div class="csshero-editor-interface">
				<div class="csshero-editor-super-top">
					<div class="st-tab csshero-branding">
						<div class="logo">
							<?php echo $herologo; ?>
						</div>
					</div>
					<div class="st-tab inspector-branding">
						<div class="csshero-trigger-inspector">
							Inspector
						</div>
					</div>
					<div class="csshero-detach-editor"></div>
				</div>
				<div class="csshero-interface-title">
					<span></span>
					<b class="modify-selector" data-tip="Edit\Add Selector"></b>
					<b class="xpand"></b>
					<div class="csshero-selectors-list-inner"></div>
				</div>
				<div class="csshero-tabs-bar">
					<div class="csshero-mode-props active">
						<span>Properties
							<span class="num">0</span>
						</span>
					</div>
					<div class="csshero-mode-classes">
						<span>Snippets
							<span class="num">0</span>
						</span>
					</div>
					<div class="csshero-mode-animations">
						<b></b>
						<span>Animation
							<span class="num">0</span>
						</span>
					</div>
					
					
				</div>
				
				<div class="csshero-editor-interface-contents"></div>
				<div class="csshero-code-wrap">
					
					<div class="csshero-bottom-interface-actions">
						<div class="show-theme-code"></div>
						<div class="csshero-bottom-interface-actions-label">
							<div class="icon-toggle-css-editor"></div>
							<span>Code Editor</span>
						</div>
					</div>
					<div class="code-wrap-selector">Selector</div>
					<form>
						<textarea id="code" name="code">
						</textarea>
					</form>
					<div class="code-trail">}</div>
					<div class="csshero-code-wrap-expander">
						<ul>
							<li class="csshero-code-toggle-code-editor-pos"><label></label></li>
							<li class="csshero-change-editor-font-size plus">A+</li>
							<li class="csshero-change-editor-font-size minus">A-</li>
							<li class="open-project-manager">Inspector</li>
						</ul>
					</div>
					
				</div>
			</div>
		</div>
		<div class="interface-loader hidden">
			<div class="barr"></div>
		</div>
		<div class="csshero-save-actions">
			<div class="csshero-class-actions-wrap"></div>
			<div class="csshero-save-buttons-wrap">
				<div class="csshero-font-checker"></div>
				<div class="csshero-save-action csshero-cancel no-cancel-available">cancel</div>
				<div class="csshero-save-action csshero-save">save & publish</div>
				<form id="csshero-saving-form" method="post">
					<input type="hidden" name="wpcss_submit_form" value="1">
					<div id="csshero-saving-data-formresult"></div>
					<textarea id="csshero-livearray-saving-field" name="csshero-livearray-saving-field"></textarea>
					<textarea id="csshero-css-saving-field" name="csshero-css-saving-field" ></textarea>
					<div id="csshero-save-nonce" style="display: none"> <?php wp_nonce_field('csshero_saving_nonce','csshero_saving_nonce_field'); ?></div>
				</form>
			</div>
		</div>
	</div>
	
	
<div id="csshero-upload-img-box" style="display:none;">
	<div class="csshero-upload-response no-response"><div class="csshero-close-response"></div></div>
	<div class="csshero-upload-img-browse csshero-upload-img-tab">
	
	<?php
		
	$query_images_args = array(
	    'post_type'      => 'attachment',
	    'post_mime_type' => 'image',
	    'post_status'    => 'inherit',
	    'posts_per_page' => 30,
	);
	
	$query_images = new WP_Query( $query_images_args );
	foreach ( $query_images->posts as $image ) {
	 	$csshero_thumb_url = wp_get_attachment_image_src( $image->ID, 'thumbnail');
	 	// wp_get_attachment_metadata
	 	$csshero_thumb_url = $csshero_thumb_url[0];
	 	$sizes = wp_get_attachment_metadata($image->ID);
	 	$sizes = $sizes['sizes'];
	 	
	 	$flat_sizes = array();
	 	
	 	if ($sizes){
		 	$size_vals = array_keys($sizes);
		 	foreach ($size_vals as $s){
			 	$size_url = wp_get_attachment_image_src( $image->ID, $s);
			 	$flat_sizes[$s] = $size_url[0];
			}
	 	}
	 	$flat_sizes = json_encode($flat_sizes);
	 	echo '<div class="csshero-media-img" data-available-sizes="'.htmlspecialchars($flat_sizes).'"><img data-src="'. $csshero_thumb_url.'" /></div>';
	 	
	}	
		
	
		
	?>
	</div>
	<div class="csshero-upload-img-upload no-files csshero-upload-img-tab">
		
		<form class="csshero-upload-img-form" action="?csshero_action=upload_image" method="post" enctype="multipart/form-data"><label class="csshero-upload-label">Upload Image<input type="file" name="newpicture" size="25" /></label><span class="csshero-upload-img-name"></span><input type="submit" name="submit" value="Submit" /></form>
	</div>
</div>


<form> <!-- current state -->
	<textarea hidden name="csshero-data-from-db" id="csshero-data-from-db"><?php echo ((csshero_get_data())); //addslashes ?></textarea>  
</form>

<div class="csshero-bottom-navi"></div>
<div id="csshero-palette-designer">
	<div class="csshero-palettes-container">
		<nav class="csshero-palette-nav"></nav>
		<div class="csshero-palette-chooser"></div>
	</div>
</div>
</body>
</html>
