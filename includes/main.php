<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

/*plugin class*/
class AnimateGL
{

	public $version;
	public $path;
	public $plugin_dir_path;
	public $plugin_dir_url;

	// Singleton
	private static $instance = null;

	public static function get_instance()
	{

		if (null == self::$instance) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	protected function __construct()
	{

		$this->version = ANIMATE_GL_VERSION;
		$this->path = ANIMATE_GL_FILE;
		$this->plugin_dir_path = plugin_dir_path($this->path);
		$this->plugin_dir_url = plugin_dir_url($this->path);
		$this->ajaxurl = admin_url('admin-ajax.php');

		add_action('init', array($this, 'init'));
		add_action('admin_menu', array($this, "admin_menu"));

		if (is_admin()) {
			add_action('wp_ajax_agl_json', array($this,  'ajax_update_settings'));
			add_action('wp_ajax_nopriv_agl_json', array($this,  'ajax_update_settings'));
		}

		register_activation_hook($this->path, array($this, "plugin_activated"));
	}

	public function plugin_activated()
	{

		if (defined('WP_DEBUG') && WP_DEBUG) {

			error_log("Animate GL activated");
		}
	}

	public function ajax_update_settings()
	{

		check_ajax_referer('agl_nonce', 'security');

		$json = sanitize_text_field(stripslashes($_POST['json']));

		update_option("agl_json", $json);

		die();
	}


	public function init()
	{

		load_plugin_textdomain('animate-gl', false, plugin_basename(dirname(ANIMATE_GL_FILE)) . '/languages');

		// register front end scripts
		$version      = $this->version;

		wp_register_script('agl', $this->plugin_dir_url . 'js/lib/animategl.min.js', array('jquery' /* just for test */), $version);
		wp_register_script('agl-editor', $this->plugin_dir_url . 'js/lib/animategl.editor.min.js', array(), $version);
		wp_register_script('agl-embed', $this->plugin_dir_url . 'js/embed.js', array(), $version);
		wp_register_script('agl-admin', $this->plugin_dir_url . 'js/admin.js', array(), $version);
		wp_register_style('agl', $this->plugin_dir_url . 'css/animategl.css', array(), $version);

		if (!wp_script_is('agl', 'enqueued')) wp_enqueue_script("agl");
		if (!wp_style_is('agl', 'enqueued')) wp_enqueue_style("agl");

		if (!wp_script_is('agl-embed', 'enqueued')) wp_enqueue_script("agl-embed");

		$agl_nonce = wp_create_nonce("agl_nonce");
		wp_localize_script('agl', 'agl_nonce', array($agl_nonce));

		$json = get_option('agl_json');
		wp_localize_script('agl-embed', 'agl_options', array($json, $this->plugin_dir_url, $this->ajaxurl));
	}

	public function admin_menu()
	{

		add_menu_page(
			'AnimateGL',
			'AnimateGL',
			"publish_posts",
			'agl_admin',
			array($this, "agl_admin"),
			'dashicons-book'
		);
	}



	public function agl_admin()
	{
		include_once('agl_admin.php');
	}
}
