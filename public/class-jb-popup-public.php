<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://jbprovider.com/author/jackbui
 * @since      1.0.0
 *
 * @package    Jb_Popup
 * @subpackage Jb_Popup/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Jb_Popup
 * @subpackage Jb_Popup/public
 * @author     Jack Bui <jackbui2014@gmail.com>
 */
class Jb_Popup_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Jb_Popup_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Jb_Popup_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( 'bootstrap-css',  'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/jb-popup-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Jb_Popup_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Jb_Popup_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( 'bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/jb-popup-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * All init functions
	 *
	 * @since    1.0.0
	 */
	public function init() {

		$this->register_custom_post_type();
	}

	/**
	 * Register jb_popup custom post type
	 *
	 * @since    1.0.0
	 */
	public function register_custom_post_type() {

		$labels =   array(
                'name'          => __('JB Popups', 'jb-popup'),
                'singular_name' => __('JB Popup ', 'jb-popup'),
            	);
	    $args = array(
	        'labels'             => $labels,
	        'description'        => __('JB Popup custom post type.', 'jb-popup'),
	        'public'             => true,
	        'publicly_queryable' => false,
	        'show_ui'            => true,
	        'show_in_menu'       => true,
	        'query_var'          => true,
	        'rewrite'            => array( 'slug' => 'jb_popup' ),
	        'capability_type'    => 'post',
	        'has_archive'        => false,
	        'hierarchical'       => false,
	        'menu_position'      => 6,
	        'supports'           => array( 'title', 'editor', 'author' ),
	        'show_in_rest'       => true
	    );
	      
	    register_post_type( JB_POPUP, $args );
	}

	/**
	 *
	 *
	 * Check if modal will be shown or not
	 *
	 * @since 1.0
	 *
	 * @param Object $item modal post object
	 * @param Object $curent_page the current page object
	 * @return Bolean true if the modal is shown and false if it's not.
	 */
	public function will_modal_show( $item = null, $current_page = null ) {		
		if ( null != $item && null != $current_page ) {
			$exceptions = get_post_meta( $item->ID,'exclude_on', true );
			if ( ! empty( $exceptions ) && in_array( $current_page->ID, $exceptions ) ) {
				return false;
			}
			$display_location = get_post_meta( $item->ID, 'display_on', true );
					
			if ( empty( $display_location ) || $display_location == array('') ) {
				return true;
			} else {
				if ( in_array( $current_page->ID, $display_location ) ) {
					return true;
				}				
				return false;
			}
		}		
		return false;
	}

	/**
	 
	 *
	 * render popup template
	 *
	 * @since 1.0
	 *
	 *
	 * @param Object $item the popup post
	 * @param integer $current_page
	 * @return void
	 */
	public function render_poup($item, $current_page){
		// $hide_modal_title  = get_post_meta($item->ID, 'hide_modal_title', true );
		// $hide_modal_footer = get_post_meta($item->ID,  'hide_modal_footer', true );
		
		if( $this->will_modal_show($item, $current_page) ):
			$popup_background = get_post_meta($item->ID, 'popup_background',true);
			$background = '';
			if( !empty($popup_background) ):
				$background = 'style="background: '.$popup_background.'"; border:0;';
			endif;
		?>
		<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-<?php echo $item->ID; ?>">
		  <div class="modal-dialog scc-modal-dialog" role="document">
			<div class="modal-content" <?php echo $background ; ?>>
			  <div class="modal-header">				
				<button type="button" class="btn-close-white scc-modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
			  </div>
			  <div class="modal-body scc-page-content">
			  	<div class="modal-body-container">
					<?php echo apply_filters( 'the_content', $item->post_content ); ?>
				</div>
			  </div>			 
			</div>
		  </div>
		</div>
		<?php	
		endif;	
	}

	

}
