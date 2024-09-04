<?php

namespace TalentPortal;

use TalentPortal\Admin\Menu;
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
        add_action( 'admin_notices', [ $this, 'show_activation_notice' ] );
        $this->register_admin_menu();

    }

    /**
     * Add menu
     *
     * @return void
     */
    public function register_admin_menu()
    {
        $pages = [
            [
                'page_title' => __( 'Talent Portal', 'talent-portal' ),
                'menu_title' => __( 'Talent Portal', 'talent-portal' ),
                'capability' => 'manage_options',
                'menu_slug'  => 'talent-portal',
                'callback'   => array( $this, 'application_list' ),
                'icon_url'   => 'dashicons-admin-users',
                'position'   => 110,
             ],
         ];
        $sup_pages = [
            [
                'parent_slug' => 'talent-portal',
                'page_title'  => __( 'Overview', 'talent-portal' ),
                'menu_title'  => __( 'Overview', 'talent-portal' ),
                'capability'  => 'manage_options',
                'menu_slug'   => 'talent-overview',
                'callback'    => array( $this, 'overview' ),
             ],
         ];

        ( new Menu )->add_pages( $pages )
            ->with_sub_page( __( 'Applicant List', 'talent-portal' ) )
            ->add_sup_pages( $sup_pages )
            ->register();
    }

    /**
     * Render Overview
     *
     * @return void
     */

    public function overview()
    {
        $this->view( 'overview' );
    }

    /**
     * Render Applicant View
     *
     * @return void
     */

    public function application_list()
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
