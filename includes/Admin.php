<?php

namespace WpDraftScripts\TalentPortal;

use WpDraftScripts\TalentPortal\Traits\Helpers;
use WpDraftScripts\TalentPortal\Traits\Singleton;

/**
 * Class Admin
 * @package WpDraftScripts\TalentPortal
 */

class Admin
{
    use Helpers, Singleton;

    /**
     * Admin constructor.
     */

    public function __construct()
    {
        add_action( 'admin_menu', [ $this, 'add_menu' ] );
    }

    /**
     * Add menu
     * @return void
     */
    public function add_menu()
    {
        add_menu_page(
            __( 'Talent Portal', TALENT_PORTAL_TEXT_DOMAIN ),
            __( 'Talent Portal', TALENT_PORTAL_TEXT_DOMAIN ),
            'manage_options',
            'talent-portal',
            [ $this, 'render' ],
            'dashicons-admin-users',
        );
    }

    public function render()
    {
        $this->view( 'applicant-view' );
    }
}
