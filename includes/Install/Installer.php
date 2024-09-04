<?php

namespace TalentPortal\Install;

use TalentPortal\Repositories\ApplicantRepository;

/**
 * Class Installer
 * @package TalentPortal
 *
 * @since 1.0.0
 */

class Installer
{
    /**
     * Run the installer
     *
     * @return void
     */
    public function run()
    {
        $this->add_version();
        $this->create_tables();

        // Set a transient to trigger the admin notice after activation
        set_transient( 'applicant_submission_activation_notice', true, 5 );
    }

    /**
     * Add time and version on DB
     *
     * @return void
     */
    public function add_version()
    {
        $installed = get_option( 'talent_portal_installed' );

        if ( !$installed ) {
            update_option( 'talent_portal_installed', time() );
        }

        update_option( 'talent_portal_version', WP_TALENT_PORTAL_VERSION );
    }

    /**
     * Create necessary database tables
     *
     * @return void
     */
    public function create_tables()
    {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $table_name = ApplicantRepository::get_table_name();

        $schema = "CREATE TABLE IF NOT EXISTS $table_name (
            id int(11) unsigned NOT NULL AUTO_INCREMENT,
            first_name varchar(255) NOT NULL,
            last_name varchar(255) NOT NULL,
            address text NOT NULL,
            email varchar(255) NOT NULL,
            mobile varchar(20) NOT NULL,
            post_name varchar(255) NOT NULL,
            cv_path varchar(255) NOT NULL,
            submission_date datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate";

        if ( !function_exists( 'dbDelta' ) ) {
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        }

        dbDelta( $schema );
    }
}
