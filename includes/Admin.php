<?php

namespace TalentPortal;

use TalentPortal\Traits\Helpers;
use TalentPortal\Traits\Singleton;

/**
 * Class Admin
 * @package TalentPortal
 *
 * @since 1.0.0
 */

class Admin
{
    use Helpers, Singleton;

    /**
     * Admin constructor.
     *
     * @return void
     */

    public function __construct()
    {
        add_action( 'admin_menu', [ $this, 'add_menu' ] );
        add_action( 'admin_notices', [ $this, 'show_activation_notice' ] );
    }

    /**
     * Add menu
     *
     * @return void
     */
    public function add_menu()
    {
        add_menu_page(
            __( 'Talent Portal', 'talent-portal' ),
            __( 'Talent Portal', 'talent-portal' ),
            'manage_options',
            'talent-portal',
            [ $this, 'render' ],
            'dashicons-admin-users',
        );
    }

    /**
     * Render view
     *
     * @return void
     */

    public function render()
    {
        $this->view( 'applicant-view' );
    }

    /**
     * Show activation notice
     *
     * @return void
     */
    public function show_activation_notice()
    {
        if ( get_transient( 'applicant_submission_activation_notice' ) ) {
            $class = 'notice notice-success is-dismissible';
            $message = __( 'Talent Portal has been activated successfully!', 'talent-portal' );
            echo "<div class='$class'><p>$message</p></div>";
            delete_transient( 'applicant_submission_activation_notice' );
        }
    }
}
