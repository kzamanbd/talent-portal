<?php

namespace TalentPortal;

use TalentPortal\Admin\Actions\Applicant;
use TalentPortal\Forms\Apply;
use TalentPortal\Traits\Singleton;

/**
 * Ajax handler class
 * @package TalentPortal
 *
 *
 * @since 1.0.0
 */
class Ajax
{
    use Singleton;

    /**
     * Class constructor
     *
     * @return void
     */
    function __construct()
    {
        $apply = new Apply();
        $applicant = new Applicant();

        add_action( 'wp_ajax_talent-portal-delete', [ $applicant, 'delete_application' ] );
        add_action( 'wp_ajax_talent_portal_apply', [ $apply, 'handle_applicant_form_submission' ] );
        add_action( 'wp_ajax_nopriv_talent_portal_apply', [ $apply, 'handle_applicant_form_submission' ] );
    }
}
