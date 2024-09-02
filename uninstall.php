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

( new ApplicantRepository() )->uninstaller();
