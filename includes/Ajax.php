<?php

namespace TalentPortal;

use TalentPortal\Shortcodes\ApplicantForm;
use TalentPortal\Traits\Singleton;

/**
 * Ajax handler class
 */
class Ajax
{
    use Singleton;
    /**
     * Class constructor
     */
    function __construct()
    {
        $form = new ApplicantForm();
        add_action( 'wp_ajax_talent-portal-delete', [ $form, 'delete_application' ] );
        add_action( 'wp_ajax_talent_portal_apply', [ $form, 'handle_applicant_form_submission' ] );
        add_action( 'wp_ajax_nopriv_talent_portal_apply', [ $form, 'handle_applicant_form_submission' ] );
    }
}
