<?php

namespace WpDraftScripts\TalentPortal;

use WpDraftScripts\TalentPortal\Interfaces\Action;

/**
 * Class Admin
 * @package WpDraftScripts\TalentPortal
 */

class Admin implements Action
{
    /**
     * Instance of self
     *
     * @var Admin
     */
    public static $instance = null;

    public static function init()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Admin constructor.
     */

    public function __construct()
    {
        add_action('admin_menu', [$this, 'add_menu']);
    }

    /**
     * Add menu
     * @return void
     */
    public function add_menu()
    {
        add_menu_page(
            __('Talent Portal', TALENT_PORTAL_TEXT_DOMAIN),
            __('Talent Portal', TALENT_PORTAL_TEXT_DOMAIN),
            'manage_options',
            'talent-portal',
            [$this, 'render'],
            'dashicons-admin-users',
            6
        );
    }

    public static function render()
    {
        echo '<h1>Talent Portal</h1>';
    }
}
