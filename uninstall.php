<?php

/**
 * Trigger this file on Plugin uninstall
 * @package TalentPortal
 */

use TalentPortal\Repositories\ApplicantRepository;

if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

// Clear Database stored data
$table_name = ApplicantRepository::get_table_name();
global $wpdb;
return $wpdb->query( "DROP TABLE IF EXISTS $table_name" );
