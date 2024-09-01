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

use WpDraftScripts\TalentPortal\Admin;
use WpDraftScripts\TalentPortal\Frontend;
use WpDraftScripts\TalentPortal\Install\Installer;
use WpDraftScripts\TalentPortal\Shortcodes\Shortcodes;

if (!defined('ABSPATH')) {
    die('You are not allowed to access this file.');
}


if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
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
     * @since 2.6.10
     *
     * @var array
     */
    private $container = [];

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

        register_activation_hook(__FILE__, [$this, 'activate']);
        register_deactivation_hook(__FILE__, [$this, 'deactivate']);
    }

    /**
     * Check if the PHP version is supported
     *
     * @return bool
     */
    public function is_supported_php()
    {
        if (version_compare(PHP_VERSION, $this->min_php, '<=')) {
            return false;
        }

        return true;
    }

    /**
     * Define the required constants
     */
    private function define_constants()
    {
        define('WP_TALENT_PORTAL_VERSION', $this->version);
        define('TALENT_PORTAL_TEXT_DOMAIN', $this->text_domain);
        define('WP_TALENT_PORTAL_FILE', __FILE__);
        define('WP_TALENT_PORTAL_PLUGIN_URL', plugins_url('', WP_TALENT_PORTAL_FILE));
        define('WP_TALENT_PORTAL_PLUGIN_PATH', plugin_dir_path(WP_TALENT_PORTAL_FILE));
        define('WP_TALENT_PORTAL_PLUGIN_BASENAME', plugin_basename(WP_TALENT_PORTAL_FILE));

        $this->plugin_url = WP_TALENT_PORTAL_PLUGIN_URL;
        $this->plugin_path = WP_TALENT_PORTAL_PLUGIN_PATH;
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
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Activate the plugin
     */
    public function activate()
    {
        (new Installer)->run();
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
        add_action('init', [$this, 'init_classes']);
    }

    /**
     * Initialize the plugin classes
     */
    public function init_classes()
    {

        if (is_admin()) {
            Admin::init();
        } else {
            Frontend::init();
        }

        // register shortcode
        Shortcodes::init();
    }
}

/**
 * Initializes the TalentPortal() class
 */

TalentPortal::init();
