<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

if( !class_exists('GF_LEAD_Main') ){

	class GF_LEAD_Main
	{

		public $pluginName;
		public $plugin_file;
		public $plugin_dir;
		public $plugin_path;
		public $plugin_url;

		public $parent_menu_slug;
		protected static $instance;
		public static function instance() {
			if ( ! self::$instance ) {
				self::$instance = new self;
			}
			return self::$instance;
		}


		public function fn_enqueue_admin_scripts( $hook){
			$screen = get_current_screen();
			if (is_admin()) {
				$screen = get_current_screen(); 
	            if ( $screen->base == $hook ){ 
	                
					wp_register_style('bootstrap_css', $this->plugin_url . 'assets/css/bootstrap.min.css');
					wp_enqueue_style('bootstrap_css');
					wp_enqueue_script('bootstrap_js', $this->plugin_url . 'assets/js/bootstrap.min.js');
					wp_enqueue_script('script', $this->plugin_url . 'assets/js/jquery.min.js');
					wp_enqueue_script('ui', $this->plugin_url . 'assets/js/jquery-ui.js');
					wp_register_style('dataTables', $this->plugin_url . 'assets/css/jquery.dataTables.css');
					wp_enqueue_style('dataTables');
					wp_enqueue_script('dataTablesJs', $this->plugin_url . 'assets/js/jquery.dataTables.min.js');
					wp_enqueue_script('Adminjs', $this->plugin_url . 'assets/js/main.js');
					wp_enqueue_style( 'admin-css', $this->plugin_url.'assets/css/main.css');
	                wp_localize_script('Adminjs', 'scriptParams', $script_params);
	            }
			}
		}
		
		public function __construct()
		{
			$this->plugin_file = gf_PLUGIN_FILE;
			$this->plugin_path = trailingslashit( dirname( $this->plugin_file ) );
			$this->plugin_dir  = trailingslashit( basename( $this->plugin_path ) );
			$this->plugin_url  = str_replace( basename( $this->plugin_file ), '', plugins_url( basename( $this->plugin_file ), $this->plugin_file ) );

			add_action( 'init', array($this, 'gf_form_init' ) );
			add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ), 1 );
			add_action('admin_enqueue_scripts', array($this, 'fn_enqueue_admin_scripts'));
		}

		public static function activate() {
			$plugin_path = dirname( gf_PLUGIN_FILE );
		}

		public static function deactivate( $network_deactivating ) {

		}

		public static function uninstall() {

		}

		public function plugins_loaded() {
			add_action( 'admin_menu', array($this, 'register_gf_form_menu_page' ));
		}


		public function gf_form_init() {
			add_action( 'admin_menu', array($this, 'register_gf_form_menu_page' ));
		}

		public function register_gf_form_menu_page() {
			add_menu_page(__('Form Entries Count', 'form_entries_week_count'), 'Gravity Form Entries', 'manage_options', 'form_entries_week_count', array(
				$this,
				'form_entries_count_view'
			), 'dashicons-forms', 25);
			add_submenu_page('form_entries_week_count', '# entries week', '# entries week', 'manage_options', 'form_entries_week_count', array(
                $this,
                'form_entries_count_view'
            ));
            add_submenu_page('form_entries_week_count', '# entries day', '# entries day', 'manage_options', 'form_entries_date_count', array(
                $this,
                'form_entries_date_count'
            ));
		}

		public function form_entries_count_view(){
			require_once $this->plugin_path . 'include/templates/entries_count.php';
		}

		function form_entries_date_count(){
            require_once $this->plugin_path . 'include/templates/entries_date_count.php';
        }    
    }
}
