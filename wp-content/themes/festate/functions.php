<?php
/**
 * fEstate functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 */

if ( ! function_exists( 'festate_setup' ) ) :
	/**
	 * fEstate setup.
	 *
	 * Set up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support post thumbnails.
	 *
	 */
	function festate_setup() {

		/*
		 * Make theme available for translation.
		 *
		 * Translations can be filed in the /languages/ directory
		 *
		 * If you're building a theme based on fEstate, use a find and replace
		 * to change 'festate' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'festate', get_template_directory() . '/languages' );

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

		add_image_size( 'festate-thumbnail-avatar', 100, 100, true );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		/*
		 * This theme styles the visual editor to resemble the theme style,
		 * specifically font, colors, and column width.
	 	 */
		add_editor_style( array( 'css/editor-style.css', 
								 get_template_directory_uri() . '/css/font-awesome.css',
								 festate_fonts_url()
						  ) );

		/*
		 * Set Custom Background
		 */				 
		add_theme_support( 'custom-background', array ('default-color'  => '#ffffff') );

		// Set the default content width.
		$GLOBALS['content_width'] = 900;

		// This theme uses wp_nav_menu() in header menu
		register_nav_menus( array(
			'primary'   => __( 'Primary Menu', 'festate' ),
			'footer'    => __( 'Footer Menu', 'festate' ),
		) );

		$defaults = array(
	        'flex-height' => false,
	        'flex-width'  => false,
	        'header-text' => array( 'site-title', 'site-description' ),
	    );
	    add_theme_support( 'custom-logo', $defaults );
	}
endif; // festate_setup
add_action( 'after_setup_theme', 'festate_setup' );

if ( ! function_exists( 'festate_display_slider' ) ) :
	/**
	 * Displays Slider
	 */
	function festate_display_slider() {

?>
		<div class="slider-wrapper">
	 		<div class="sldr">
				<ul class="wrp animate">
<?php
					for ( $i = 1; $i <= 3; ++$i ) {
					
						$defaultSlideImage = get_template_directory_uri().'/images/slider/' . $i .'.jpg';

						$slideImage = get_theme_mod( 'festate_slide'.$i.'_image', $defaultSlideImage );
?>
						<li class="elmnt-<?php echo esc_attr($i); ?>">
							<div class="skew">
								<div class="wrap">
									<img src="<?php echo esc_url( $slideImage ); ?>" class="sldr-img" />
								</div>
							</div>
						</li>

<?php
					}
?>
			</ul><!-- .wrp animate -->
		</div><!-- .sldr -->

		<div class="clear">
		</div>

		<button class="sldr-prv sldr-nav prev"><?php esc_html_e( 'Prev', 'festate' ); ?></button>
		<button class="sldr-nxt sldr-nav next"><?php esc_html_e( 'Next', 'festate' ); ?></button>

	</div><!-- .slider-wrapper --> 

	<?php
	}
endif; // festate_display_slider

if ( ! function_exists( 'festate_fonts_url' ) ) :
	/**
	 *	Load google font url used in the fEstate theme
	 */
	function festate_fonts_url() {

	    $fonts_url = '';
	 
	    /* Translators: If there are characters in your language that are not
	    * supported by Dosis, translate this to 'off'. Do not translate
	    * into your own language.
	    */
	    $questrial = _x( 'on', 'Dosis font: on or off', 'festate' );

	    if ( 'off' !== $questrial ) {
	        $font_families = array();
	 
	        $font_families[] = 'Dosis';
	 
	        $query_args = array(
	            'family' => urlencode( implode( '|', $font_families ) ),
	            'subset' => urlencode( 'latin,latin-ext' ),
	        );
	 
	        $fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
	    }
	 
	    return $fonts_url;
	}
endif; // festate_fonts_url

if ( ! function_exists( 'festate_load_scripts' ) ) :
	/**
	 * the main function to load scripts in the fEstate theme
	 * if you add a new load of script, style, etc. you can use that function
	 * instead of adding a new wp_enqueue_scripts action for it.
	 */
	function festate_load_scripts() {

		// load main stylesheet.
		wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.css', array( ) );
		wp_enqueue_style( 'animate-css', get_template_directory_uri() . '/css/animate.css', array( ) );
		wp_enqueue_style( 'festate-style', get_stylesheet_uri(), array() );
		
		wp_enqueue_style( 'festate-fonts', festate_fonts_url(), array(), null );
		
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		wp_enqueue_script( 'viewportchecker',
			get_template_directory_uri() . '/js/viewportchecker.js',
            array( 'jquery' ) );
		
		// Load Utilities JS Script
		wp_enqueue_script( 'festate-js',
			get_template_directory_uri() . '/js/festate.js',
			array( 'jquery', 'viewportchecker' ) );

		$data = array(
	        'loading_effect' => ( get_theme_mod('festate_animations_display', 1) == 1 ),
	    );
	    wp_localize_script('festate-js', 'festate_options', $data);

		wp_enqueue_script( 'jquery-sldr',
			get_template_directory_uri() . '/js/jquery.sldr.js',
			array( 'jquery' ) );
	}
endif; // festate_load_scripts
add_action( 'wp_enqueue_scripts', 'festate_load_scripts' );

if ( ! function_exists( 'festate_widgets_init' ) ) :
	/**
	 *	widgets-init action handler. Used to register widgets and register widget areas
	 */
	function festate_widgets_init() {
		
		// Register Sidebar Widget.
		register_sidebar( array (
							'name'	 		 =>	 __( 'Sidebar Widget Area', 'festate'),
							'id'		 	 =>	 'sidebar-widget-area',
							'description'	 =>  __( 'The sidebar widget area', 'festate'),
							'before_widget'	 =>  '',
							'after_widget'	 =>  '',
							'before_title'	 =>  '<div class="sidebar-before-title"></div><h3 class="sidebar-title">',
							'after_title'	 =>  '</h3><div class="sidebar-after-title"></div>',
						) );

		// Register Footer Widget
		register_sidebar( array (
								'name'			 =>  __( 'Footer Content Area', 'festate' ),
								'id' 			 =>  'footer-widget-area',
								'description'	 =>  __( 'The Footer Content widget area', 'festate' ),
								'before_widget'  =>  '',
								'after_widget'	 =>  '',
								'before_title'	 =>  '<h2 class="footer-title">',
								'after_title'	 =>  '</h2><div class="footer-after-title"></div>',
							) );
	}
endif; // festate_widgets_init
add_action( 'widgets_init', 'festate_widgets_init' );

if ( ! function_exists( 'festate_custom_header_setup' ) ) :
  /**
   * Set up the WordPress core custom header feature.
   *
   * @uses festate_header_style()
   */
  function festate_custom_header_setup() {

  	add_theme_support( 'custom-header', array (
                         'default-image'          => '',
                         'flex-height'            => true,
                         'flex-width'             => true,
                         'uploads'                => true,
                         'width'                  => 900,
                         'height'                 => 100,
                         'default-text-color'     => '#434343',
                         'wp-head-callback'       => 'festate_header_style',
                      ) );
  }
endif; // festate_custom_header_setup
add_action( 'after_setup_theme', 'festate_custom_header_setup' );

if ( ! function_exists( 'festate_header_style' ) ) :

  /**
   * Styles the header image and text displayed on the blog.
   *
   * @see festate_custom_header_setup().
   */
  function festate_header_style() {

  	$header_text_color = get_header_textcolor();

      if ( ! has_header_image()
          && ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color
               || 'blank' === $header_text_color ) ) {

          return;
      }

      $headerImage = get_header_image();
  ?>
      <style id="festate-custom-header-styles" type="text/css">

          <?php if ( has_header_image() ) : ?>

                  #header-main-fixed {background-image: url("<?php echo esc_url( $headerImage ); ?>");}

          <?php endif; ?>

          <?php if ( get_theme_support( 'custom-header', 'default-text-color' ) !== $header_text_color
                      && 'blank' !== $header_text_color ) : ?>

                  #header-main-fixed, #header-main-fixed h1.entry-title {color: #<?php echo sanitize_hex_color_no_hash( $header_text_color ); ?>;}

          <?php endif; ?>
      </style>
  <?php
  }
endif; // End of festate_header_style.

if ( class_exists('WP_Customize_Section') ) {
	class festate_Customize_Section_Pro extends WP_Customize_Section {

		// The type of customize section being rendered.
		public $type = 'festate';

		// Custom button text to output.
		public $pro_text = '';

		// Custom pro button URL.
		public $pro_url = '';

		// Add custom parameters to pass to the JS via JSON.
		public function json() {
			$json = parent::json();

			$json['pro_text'] = $this->pro_text;
			$json['pro_url']  = esc_url( $this->pro_url );

			return $json;
		}

		// Outputs the template
		protected function render_template() { ?>

			<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">

				<h3 class="accordion-section-title">
					{{ data.title }}

					<# if ( data.pro_text && data.pro_url ) { #>
						<a href="{{ data.pro_url }}" class="button button-primary alignright" target="_blank">{{ data.pro_text }}</a>
					<# } #>
				</h3>
			</li>
		<?php }
	}
}

/**
 * Singleton class for handling the theme's customizer integration.
 */
final class festate_Customize {

	// Returns the instance.
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	// Constructor method.
	private function __construct() {}

	// Sets up initial actions.
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	// Sets up the customizer sections.
	public function sections( $manager ) {

		// Load custom sections.

		// Register custom section types.
		$manager->register_section_type( 'festate_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section(
			new festate_Customize_Section_Pro(
				$manager,
				'festate',
				array(
					'title'    => esc_html__( 'tEstate', 'festate' ),
					'pro_text' => esc_html__( 'Upgrade to Pro', 'festate' ),
					'pro_url'  => esc_url( 'https://tishonator.com/product/testate' )
				)
			)
		);
	}

	// Loads theme customizer CSS.
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'festate-customize-controls', trailingslashit( get_template_directory_uri() ) . 'js/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'festate-customize-controls', trailingslashit( get_template_directory_uri() ) . 'css/customize-controls.css' );
	}
}

// Doing this customizer thang!
festate_Customize::get_instance();

if ( ! function_exists( 'festate_customize_register' ) ) :
	/**
	 * Add postMessage support for site title and description for the Theme Customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	function festate_customize_register( $wp_customize ) {

		/**
		 * Add Slider Section
		 */
		$wp_customize->add_section(
			'festate_slider_section',
			array(
				'title'       => __( 'Slider', 'festate' ),
				'capability'  => 'edit_theme_options',
			)
		);
		
		// Add display slider option
		$wp_customize->add_setting(
				'festate_slider_display',
				array(
						'default'           => 0,
						'sanitize_callback' => 'festate_sanitize_checkbox',
				)
		);

		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'festate_slider_display',
								array(
									'label'          => __( 'Display Slider', 'festate' ),
									'section'        => 'festate_slider_section',
									'settings'       => 'festate_slider_display',
									'type'           => 'checkbox',
								)
							)
		);

		for ($i = 1; $i <= 3; ++$i) {
		
			$slideImageId = 'festate_slide'.$i.'_image';
			$defaultSliderImagePath = get_template_directory_uri().'/images/slider/'.$i.'.jpg';
			
			// Add Slide Background Image
			$wp_customize->add_setting( $slideImageId,
				array(
					'default' => $defaultSliderImagePath,
					'sanitize_callback' => 'esc_url_raw'
				)
			);

			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $slideImageId,
					array(
						'label'   	 => sprintf( esc_html__( 'Slide #%s Image', 'festate' ), $i ),
						'section' 	 => 'festate_slider_section',
						'settings'   => $slideImageId,
					) 
				)
			);
		}

		/**
	     * Add Animations Section
	     */
	    $wp_customize->add_section(
	        'festate_animations_display',
	        array(
	            'title'       => __( 'Animations', 'festate' ),
	            'capability'  => 'edit_theme_options',
	        )
	    );

	    // Add display Animations option
	    $wp_customize->add_setting(
	            'festate_animations_display',
	            array(
	                    'default'           => 1,
	                    'sanitize_callback' => 'esc_attr',
	            )
	    );

	    $wp_customize->add_control( new WP_Customize_Control( $wp_customize,
	                        'festate_animations_display',
	                            array(
	                                'label'          => __( 'Enable Animations', 'festate' ),
	                                'section'        => 'festate_animations_display',
	                                'settings'       => 'festate_animations_display',
	                                'type'           => 'checkbox',
	                            )
	                        )
	    );
	}
endif; // festate_customize_register
add_action( 'customize_register', 'festate_customize_register' );

if ( ! function_exists( 'festate_sanitize_checkbox' ) ) :
	/**
	 * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
	 * as a boolean value, either TRUE or FALSE.
	 *
	 * @param bool $checked Whether the checkbox is checked.
	 * @return bool Whether the checkbox is checked.
	 */
	function festate_sanitize_checkbox( $checked ) {
		// Boolean check.
		return ( ( isset( $checked ) && true == $checked ) ? true : false );
	}
endif; // festate_sanitize_checkbox
