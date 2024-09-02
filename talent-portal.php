<?php

/*
 * Plugin Name: Talent Portal
 * Plugin URI: https://draftscripts.com/wp-plugin/talent-portal
 * Description: This is a simple plugin for managing job applicants. It allows you to create job listings and accept applications from candidates.
 * Version: 1.0.0
 * Author: Kamruzzaman
 * Author URI: https://draftscripts.com/wp-plugin
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: talent-portal
 */

use TalentPortal\Admin;
use TalentPortal\Ajax;
use TalentPortal\Assets;
use TalentPortal\Frontend;
use TalentPortal\Install\Installer;
use TalentPortal\Shortcodes\Shortcodes;
use TalentPortal\Widgets\Dashboard;

if ( !defined( 'ABSPATH' ) ) {
    die( 'You are not allowed to access this file.' );
}

if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
    require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

final class TalentPortal
{
    /**
     * Plugin version
     * @var string
     */
    public $version = '1.0.0';

    /**
     * Instance of self
     *
     * @var TalentPortal
     */
    private static $instance = null;

    /**
     * Minimum PHP version required
     *
     * @var string
     */
    private $min_php = '7.4';

    /**
     * Holds various class instances
     *
     * @var array
     */
    private $container = [  ];

    /**
     * Plugin URL
     * @var string
     */
    public string $plugin_url;

    /**
     * Plugin path
     * @var string
     */
    public string $plugin_path;

    /**
     * Plugin base name
     * @var string
     */
    public string $plugin_base_name;

    /**
     * Text domain
     * @var string
     */
    public string $text_domain = 'talent-portal';

    /**
     * TalentPortal constructor.
     * Load the plugin
     */
    public function __construct()
    {
        $this->define_constants();

        register_activation_hook( __FILE__, [ $this, 'activate' ] );
        register_deactivation_hook( __FILE__, [ $this, 'deactivate' ] );
    }

    /**
     * Check if the PHP version is supported
     *
     * @return bool
     */
    public function is_supported_php()
    {
        if ( version_compare( PHP_VERSION, $this->min_php, '<=' ) ) {
            return false;
        }

        return true;
    }

    /**
     * Define the required constants
     */
    private function define_constants()
    {
        define( 'WP_TALENT_PORTAL_VERSION', $this->version );
        define( 'WP_TALENT_PORTAL_FILE', __FILE__ );
        define( 'WP_TALENT_PORTAL_PATH', plugin_dir_path( WP_TALENT_PORTAL_FILE ) );
        define( 'WP_TALENT_PORTAL_PLUGIN_URL', plugins_url( '', WP_TALENT_PORTAL_FILE ) );
        define( 'WP_TALENT_PORTAL_PLUGIN_BASENAME', plugin_basename( WP_TALENT_PORTAL_FILE ) );
        define( 'WP_TALENT_PORTAL_ASSETS', WP_TALENT_PORTAL_PLUGIN_URL . '/assets' );

        $this->plugin_url = WP_TALENT_PORTAL_PLUGIN_URL;
        $this->plugin_path = WP_TALENT_PORTAL_PATH;
        $this->plugin_base_name = WP_TALENT_PORTAL_PLUGIN_BASENAME;

        $this->init_hooks();
    }

    /**
     * Initializes the TalentPortal() class
     *
     * Checks for an existing TalentPortal() instance
     * and if it doesn't find one, create it.
     */
    public static function init()
    {
        if ( !self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Activate the plugin
     */
    public function activate()
    {
        ( new Installer )->run();
    }

    /**
     * Deactivate the plugin
     */

    public function deactivate()
    {
        // Deactivation code here
    }

    /**
     * Initialize the plugin hooks
     */
    private function init_hooks()
    {
        add_action( 'init', [ $this, 'init_classes' ] );
        add_action( 'plugins_loaded', [ $this, 'load_textdomain' ] );
    }

    /**
     * Load the plugin text domain
     */
    public function load_textdomain()
    {
        load_plugin_textdomain(
            'talent-portal',
            false,
            WP_TALENT_PORTAL_PATH . 'languages'
        );
    }

    /**
     * Initialize the plugin classes
     */
    public function init_classes()
    {
        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            Ajax::instance();
        }

        if ( is_admin() ) {
            Admin::instance();
            Dashboard::instance();
        } else {
            Frontend::instance();
        }

        // assets init
        new Assets();

        // register shortcode
        Shortcodes::instance();
    }
}

/**
 * Initializes the TalentPortal() class
 */

function talent_portal()
{
    return TalentPortal::init();
}

talent_portal();
