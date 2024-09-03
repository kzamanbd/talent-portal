<?php

/**
 * Trigger this file on Plugin uninstall
 * @package TalentPortal
 */

use TalentPortal\Repositories\ApplicantRepository;

if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

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

new TalentPortalUninstall();
