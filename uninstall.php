<?php

/**
 * Trigger this file on Plugin uninstall
 * @package TalentPortal
 */

use TalentPortal\Repositories\ApplicantRepository;

if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Uninstall
 */

function uninstall()
{
    return ( new ApplicantRepository() )->cleanup();
}

uninstall();
