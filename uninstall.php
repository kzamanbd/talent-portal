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

class TalentPortalUninstall
{
    public function __construct()
    {
        $this->deleteApplicants();
    }

    public function deleteApplicants()
    {
        // Clear Database stored data
        ( new ApplicantRepository() )->cleanup();
    }
}

/**
 * Uninstall
 */

function uninstall()
{
    return new TalentPortalUninstall();
}

uninstall();
