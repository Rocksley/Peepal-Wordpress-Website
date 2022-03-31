<?php
/**
 * Redux Theme functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package eleos
 */

if ( ! class_exists( 'ReduxFramewrk' ) ) {
    require_once( get_template_directory() . '/framework/sample-config.php' );
	function removeDemoModeLink() { // Be sure to rename this function to something more unique
		if ( class_exists('ReduxFrameworkPlugin') ) {
			remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2 );
		}
		if ( class_exists('ReduxFrameworkPlugin') ) {
			remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );    
		}
	}
	add_action('init', 'removeDemoModeLink');
}

if ( ! function_exists( 'eleos_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function eleos_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Redux Theme, use a find and replace
	 * to change 'eleos' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'eleos', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'eleos' ),
        'onepage' => esc_html__( 'OnePage Menu', 'eleos' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'audio',
		'image',
		'video',
		'gallery',
	) );
    add_theme_support( 'custom-header' );
    add_theme_support( 'custom-background'); 
	
}
endif; // eleos_setup
add_action( 'after_setup_theme', 'eleos_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function eleos_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'eleos_content_width', 640 );
}
add_action( 'after_setup_theme', 'eleos_content_width', 0 );

// Add specific CSS class by filter
add_filter( 'body_class', 'eleos_body_class_names' );
function eleos_body_class_names( $classes ) {
    global $eleos_option;

    // add 'class-name' to the $classes array
    if($eleos_option['show_pre'] != 'no') { 
        $classes[] = 'royal_preloader';
    } 
    
    // return the $classes array
    return $classes;
}

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function eleos_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'eleos' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Appears in the sidebar section of the site.', 'eleos' ),  
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside><div class="separator-sidebar"></div>',
		'before_title'  => '<h6 class="widget-title">',
		'after_title'   => '</h6>',
	) );
}
add_action( 'widgets_init', 'eleos_widgets_init' );

/**
 * Enqueue Google fonts.
 */
function eleos_fonts_url() {
    $fonts_url = '';
     
    /* Translators: If there are characters in your language that are not
    * supported by Montserrat, translate this to 'off'. Do not translate
    * into your own language.
    */
    $montserrat = _x( 'on', 'Montserrat font: on or off', 'eleos' );
     
    /* Translators: If there are characters in your language that are not
    * supported by Open Sans, translate this to 'off'. Do not translate
    * into your own language.
    */
    $open_sans = _x( 'on', 'Open Sans font: on or off', 'eleos' );
     
    if ( 'off' !== $montserrat || 'off' !== $open_sans ) {
    $font_families = array();
     
    if ( 'off' !== $montserrat ) {
        $font_families[] = 'Montserrat:400,700';
    }
     
    if ( 'off' !== $open_sans ) {
        $font_families[] = 'Open Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic';
    }
     
    $query_args = array(
        'family' => urlencode( implode( '|', $font_families ) ),
        'subset' => urlencode( 'latin,greek,greek-ext,vietnamese,cyrillic-ext,latin-ext,cyrillic' ),
    );
     
    $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
    }
     
    return esc_url_raw( $fonts_url );
}


/**
 * Enqueue scripts and styles.
 */
function eleos_scripts() {
	global $eleos_option;
	$protocol = is_ssl() ? 'https' : 'http';

	// Add custom fonts, used in the main stylesheet.
    wp_enqueue_style( 'eleos-fonts', eleos_fonts_url(), array(), null );

    /** All frontend css files **/     
    wp_enqueue_style( 'eleos-base', get_template_directory_uri().'/css/base.css');
    wp_enqueue_style( 'eleos-skeleton', get_template_directory_uri().'/css/skeleton.css');
    wp_enqueue_style( 'eleos-style', get_stylesheet_uri() );
    wp_enqueue_style( 'eleos-fontawesome', get_template_directory_uri().'/css/font-awesome/css/font-awesome.css');
    wp_enqueue_style( 'eleos-retina', get_template_directory_uri().'/css/retina.css');
    wp_enqueue_style( 'eleos-carousel', get_template_directory_uri().'/css/owl.carousel.css');
    wp_enqueue_style( 'eleos-transitions', get_template_directory_uri().'/css/owl.transitions.css');
    wp_enqueue_style( 'eleos-colorbox', get_template_directory_uri().'/css/colorbox.css');	

	/** All frontend javascript files **/ 
    if($eleos_option['show_pre'] != 'no') {
		wp_enqueue_script( 'eleos-royal_preloader', get_template_directory_uri() . '/js/royal_preloader.min.js', array( 'jquery' ), '20160404', false );
	}
	wp_enqueue_script( 'eleos-plugins', get_template_directory_uri() . '/js/plugins.js', array( 'jquery' ), '20160404', true );
	wp_enqueue_script( 'eleos-portfolio', get_template_directory_uri() . '/js/portfolio.js', array( 'jquery' ), '20160404', true );	
	wp_enqueue_script( 'eleos-parallax', get_template_directory_uri() . '/js/jquery.parallax-1.1.3.js', array( 'jquery' ), '20160404', true );	
	wp_enqueue_script( 'eleos-maps', "$protocol://maps.googleapis.com/maps/api/js?key=AIzaSyAvpnlHRidMIU374bKM5-sx8ruc01OvDjI", array( 'jquery' ), '20160404', true );
	wp_enqueue_script( 'eleos-YTPlayer', get_template_directory_uri() . '/js/YTPlayer.js', array( 'jquery' ), '20160404', true );
	wp_enqueue_script( 'eleos-custom', get_template_directory_uri() . '/js/custom.js', array( 'jquery' ), '20160404', true );
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'eleos_scripts' );

if(!function_exists('eleos_custom_frontend_scripts')){
  function eleos_custom_frontend_scripts(){
    global $eleos_option;
    if($eleos_option['show_pre'] != 'no') { 
	?>
		<script type="text/javascript">
		    window.jQuery = window.$ = jQuery;  
		    (function($) { "use strict";
				  Royal_Preloader.config({
					mode:        'text',
					text:        '<?php echo esc_attr($eleos_option['textpre']); ?>',
					text_colour: '<?php echo esc_attr($eleos_option['textcolor']); ?>',
					background:  '<?php echo esc_attr($eleos_option['bgpreload']); ?>'
				});
		    })(jQuery);
		</script>
	<?php
	}
  }
}
add_action('wp_footer', 'eleos_custom_frontend_scripts');

if(!function_exists('eleos_custom_frontend_style')){
    function eleos_custom_frontend_style(){
        global $eleos_option;
        echo '<style type="text/css">'.$eleos_option['custom-css'].'</style>';
    }
}
add_action('wp_head', 'eleos_custom_frontend_style');

/**
 * Implement the Custom Meta Boxs.
 */
require get_template_directory() . '/framework/meta-boxes.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/framework/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/framework/customizer.php';

//Code Visual Compurso.
function eleos_custom_css_classes_for_vc_row_and_vc_column($class_string, $tag) {
    if($tag=='vc_row' || $tag=='vc_row_inner') {
        $class_string = str_replace('vc_row-fluid', '', $class_string);
    }
    if($tag=='vc_column' || $tag=='vc_column_inner') {
        $class_string = preg_replace('/vc_col-sm-1/', 'one columns', $class_string);
        $class_string = preg_replace('/vc_col-sm-2/', 'two columns', $class_string);        
        $class_string = preg_replace('/vc_col-sm-3/', 'three columns', $class_string);
        $class_string = preg_replace('/vc_col-sm-4/', 'four columns', $class_string);       
        $class_string = preg_replace('/vc_col-sm-5/', 'five columns ', $class_string);
        $class_string = preg_replace('/vc_col-sm-6/', 'six columns', $class_string);
        $class_string = preg_replace('/vc_col-sm-7/', 'seven columns', $class_string);
        $class_string = preg_replace('/vc_col-sm-8/', 'eight columns', $class_string);
        $class_string = preg_replace('/vc_col-sm-9/', 'nine columns', $class_string);
        $class_string = preg_replace('/vc_col-sm-10/', 'ten columns', $class_string);
        $class_string = preg_replace('/vc_col-sm-11/', 'eleven columns', $class_string);    
        $class_string = preg_replace('/vc_col-sm-12/', 'twelve columns', $class_string);    
    }
    return $class_string;
}
// Filter to Replace default css class for vc_row shortcode and vc_column
add_filter('vc_shortcodes_css_class', 'eleos_custom_css_classes_for_vc_row_and_vc_column', 10, 2);

if(function_exists('vc_add_param')){
vc_add_param('vc_row',array(
                              "type" => "dropdown",
                              "heading" => esc_html__('Fullwidth', 'eleos'),
                              "param_name" => "fullwidth",
                              "value" => array(   
                                                esc_html__('No', 'eleos') => 'no',  
                                                esc_html__('Yes', 'eleos') => 'yes',                                                                                
                                              ),
                              "description" => esc_html__("Select Fullwidth or not, Default: No fullwidth", 'eleos'),      
                            ) 
);
vc_add_param('vc_column',array(
                              "type" => "dropdown",
                              "heading" => esc_html__('Column Effect', 'eleos'),
                              "param_name" => "column_effect",
                              "value" => array(    
									esc_html__('None', 'eleos') => 'none', 
										esc_html__('Bottom Move', 'eleos') => 'bottommove',     
										esc_html__('Top Move', 'eleos') => 'topmove',
										esc_html__('Left Move', 'eleos') => 'leftmove',
										esc_html__('Right Move', 'eleos') => 'rightmove',                       
									),
                              "description" => esc_html__("Select Effect for column, Default: None", 'eleos'),      

                            ) 

    );  

vc_add_param('vc_column',array(
                              "type" => "textfield",
                              "heading" => esc_html__('Animation Time', 'eleos'),
                              "param_name" => "time",
                              "value" => "",
                              "dependency"  => array( 'element' => 'column_effect', 'value' => array( 'bottommove', 'topmove', 'leftmove','rightmove' ) ),
                              "description" => esc_html__("Input time show column. Example: 1.5 , 3 ...", 'eleos'),
                            ) 

    );

vc_add_param('vc_column',array(
                              "type" => "textfield",
                              "heading" => esc_html__('Animation Distance', 'eleos'),
                              "param_name" => "distance",
                              "value" => "",
                              "dependency"  => array( 'element' => 'column_effect', 'value' => array( 'bottommove', 'topmove', 'leftmove','rightmove' ) ),
                              "description" => esc_html__("Input distance show column. Example: 250", 'eleos'),
                            ) 

    );
/* Here Rob Allow WPBakery features that was blocked by Theme
    vc_remove_param( "vc_row", "parallax" );
    vc_remove_param( "vc_row", "parallax_image" );
    vc_remove_param( "vc_row", "full_width" );
    vc_remove_param( "vc_row", "full_height" );
    vc_remove_param( "vc_row", "video_bg" );
    vc_remove_param( "vc_row", "video_bg_parallax" );
    vc_remove_param( "vc_row", "content_placement" );
    vc_remove_param( "vc_row", "video_bg_url" );
    vc_remove_param( "vc_row", "parallax_speed_bg" );
    vc_remove_param( "vc_row", "parallax_speed_video" );
    vc_remove_param( "vc_row", "columns_placement" );
    vc_remove_param( "vc_row", "equal_height" );
    vc_remove_param( "vc_row", "gap" );  */
}

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once get_template_directory() . '/framework/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'eleos_theme_register_required_plugins' );
function eleos_theme_register_required_plugins() {
  $plugins = array(

    array(
            'name'               => 'Meta Box',
            'slug'               => 'meta-box',
            'required'           => true,
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
    array(
            'name'      => 'Redux Framework',
            'slug'      => 'redux-framework',
            'required'           => true,
            'force_activation'   => false,
            'force_deactivation' => false,
        ),  
        
    array(
            'name'               => 'WPBakery Visual Composer', // The plugin name.
            'slug'               => 'js_composer', // The plugin slug (typically the folder name).
            'source'             => get_template_directory_uri() . '/framework/plugins/js_composer.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ),   
    array(
            'name'               => 'OT Visual Composer', // The plugin name.
            'slug'               => 'ot_composer', // The plugin slug (typically the folder name).
            'source'             => get_template_directory_uri() . '/framework/plugins/ot_composer.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ),      
    array(
            'name'               => 'OT Portfolios', // The plugin name.
            'slug'               => 'ot_portfolio', // The plugin slug (typically the folder name).
            'source'             => get_template_directory_uri() . '/framework/plugins/ot_portfolio.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ), 
    array(
            'name'               => 'OT Services', // The plugin name.
            'slug'               => 'ot_service', // The plugin slug (typically the folder name).
            'source'             => get_template_directory_uri() . '/framework/plugins/ot_service.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ),
    array(
            'name'               => 'OT Testimonials', // The plugin name.
            'slug'               => 'ot_testimonial', // The plugin slug (typically the folder name).
            'source'             => get_template_directory_uri() . '/framework/plugins/ot_testimonial.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ), 
    array(            
            'name'               => 'OT Slider Text', // The plugin name.
            'slug'               => 'ot_slider_text', // The plugin slug (typically the folder name).
            'source'             => get_template_directory_uri() . '/framework/plugins/ot_slider_text.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ),
    array(            
            'name'               => 'OT Slide Show', // The plugin name.
            'slug'               => 'ot_slide_show', // The plugin slug (typically the folder name).
            'source'             => get_template_directory_uri() . '/framework/plugins/ot_slide_show.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ),

    array(            
            'name'               => 'OT Agency', // The plugin name.
            'slug'               => 'ot_agency', // The plugin slug (typically the folder name).
            'source'             => get_template_directory_uri() . '/framework/plugins/ot_agency.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ),
    // This is an example of how to include a plugin from the WordPress Plugin Repository.
    array(
            'name'      => 'Contact Form 7',
            'slug'      => 'contact-form-7',
            'required'  => true,
        ),
	array(            
            'name'               => 'OT One Click Import Demo Content', // The plugin name.
            'slug'               => 'ot-themes-one-click-import', // The plugin slug (typically the folder name).
            'source'             => get_template_directory_uri() . '/framework/plugins/ot-themes-one-click-import.zip', // The plugin source.
            'required'           => false, // If false, the plugin is only 'recommended' instead of required.
        ), 	
  );



  /*
   * Array of configuration settings. Amend each line as needed.
   * If you want the default strings to be available under your own theme domain,
   * leave the strings uncommented.
   * Some of the strings are wrapped in a sprintf(), so see the comments at the
   * end of each line for what each argument will be.
   */

  $config = array(

    'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.

    'default_path' => '',                      // Default absolute path to pre-packaged plugins.

    'menu'         => 'tgmpa-install-plugins', // Menu slug.

    'parent_slug'  => 'themes.php',            // Parent menu slug.

    'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.

    'has_notices'  => true,                    // Show admin notices or not.

    'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.

    'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.

    'is_automatic' => false,                   // Automatically activate plugins after installation or not.

    'message'      => '',                      // Message to output right before the plugins table.

    'strings'      => array(

      'page_title'                      => esc_html__( 'Install Required Plugins', 'eleos' ),

      'menu_title'                      => esc_html__( 'Install Plugins', 'eleos' ),

      'installing'                      => __( 'Installing Plugin: %s', 'eleos' ), // %s = plugin name.

      'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'eleos' ),

      'notice_can_install_required'     => _n_noop(

        'This theme requires the following plugin: %1$s.',

        'This theme requires the following plugins: %1$s.',

        'eleos'

      ), // %1$s = plugin name(s).

      'notice_can_install_recommended'  => _n_noop(

        'This theme recommends the following plugin: %1$s.',

        'This theme recommends the following plugins: %1$s.',

        'eleos'

      ), // %1$s = plugin name(s).

      'notice_cannot_install'           => _n_noop(

        'Sorry, but you do not have the correct permissions to install the %s plugin.',

        'Sorry, but you do not have the correct permissions to install the %s plugins.',

        'eleos'

      ), // %1$s = plugin name(s).

      'notice_can_activate_required'    => _n_noop(

        'The following required plugin is currently inactive: %1$s.',

        'The following required plugins are currently inactive: %1$s.',

        'eleos'

      ), // %1$s = plugin name(s).

      'notice_can_activate_recommended' => _n_noop(

        'The following recommended plugin is currently inactive: %1$s.',

        'The following recommended plugins are currently inactive: %1$s.',

        'eleos'

      ), // %1$s = plugin name(s).

      'notice_cannot_activate'          => _n_noop(

        'Sorry, but you do not have the correct permissions to activate the %s plugin.',

        'Sorry, but you do not have the correct permissions to activate the %s plugins.',

        'eleos'

      ), // %1$s = plugin name(s).

      'notice_ask_to_update'            => _n_noop(

        'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',

        'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',

        'eleos'

      ), // %1$s = plugin name(s).

      'notice_cannot_update'            => _n_noop(

        'Sorry, but you do not have the correct permissions to update the %s plugin.',

        'Sorry, but you do not have the correct permissions to update the %s plugins.',

        'eleos'

      ), // %1$s = plugin name(s).

      'install_link'                    => _n_noop(

        'Begin installing plugin',

        'Begin installing plugins',

        'eleos'

      ),

      'activate_link'                   => _n_noop(

        'Begin activating plugin',

        'Begin activating plugins',

        'eleos'

      ),
      'return'                          => esc_html__( 'Return to Required Plugins Installer', 'eleos' ),
      'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'eleos' ),
      'complete'                        => __( 'All plugins installed and activated successfully. %s', 'eleos' ), // %s = dashboard link.
      'contact_admin'                   => esc_html__( 'Please contact the administrator of this site for help.', 'eleos' ),
      'nag_type'                        => 'updated', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.

    )

  );
  tgmpa( $plugins, $config );
}

