<?php
//--------- settings class install ---------------- //

require_once dirname( __FILE__ ) . '/class.settings-api.php';

/**
 * installing setting api class by wedevs
 */
if ( !class_exists('TR_Option_Main_API' ) ):
class TR_Option_Main_API {

    private $settings_api;

    function __construct() {
        $this->settings_api = new TR_settings_main_class;

        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );
    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }
	
    function admin_menu() {
        add_options_page( 'TR Faq', 'TR Faq', 'delete_posts', 'wpb_wps_zoom', array($this, 'tr_plugin_page') );
    }
	// setings tabs
    function get_settings_sections() {
        $sections = array(
           
            array(
                'id' => 'tr_wozoom_style',
                'title' => __( 'Style Settings', 'wpuf' )
            )
        );
        return $sections;
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields() {
        $settings_fields = array(
      
            'tr_wozoom_style' => array(
				array(
                    'name' => 'tr_color_style',
                    'label' => __( 'Title Color', 'tr' ),
                    'desc' => __( 'Select a color for product price. Default #16A085', 'tr' ),
                    'type' => 'color',
                    'default' => '#F90'
                ),

				array(
                    'name' => 'lens_color_style',
                    'label' => __( 'Title Background', 'tr' ),
                    'desc' => __( 'Select a color for product price. Default #16A085', 'tr' ),
                    'type' => 'color',
                    'default' => '#F90'
                ),
				
		
            )
        );
		return $settings_fields;
    }
	
	// warping the settings
    function tr_plugin_page() {
        echo '<div class="wrap">';
			$this->settings_api->show_navigation();
			$this->settings_api->show_forms();
		echo '</div>';
    }

    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    function get_pages() {
        $pages = get_pages();
        $pages_options = array();
        if ( $pages ) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }
        return $pages_options;
    }
}
endif;

$settings = new TR_Option_Main_API();