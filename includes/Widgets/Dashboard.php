<?php

namespace TalentPortal\Widgets;

use TalentPortal\Repositories\ApplicantRepository;
use TalentPortal\Traits\Helpers;
use TalentPortal\Traits\Singleton;

/**
 * Dashboard Widgets
 *
 */

class Dashboard
{
    use Singleton, Helpers;

    public function __construct()
    {
        add_action( 'wp_dashboard_setup', [ $this, 'add_dashboard_widgets' ] );
    }

    public function add_dashboard_widgets()
    {
        wp_add_dashboard_widget(
            'applicant_submissions_widget',
            __( 'Latest Applicant Submissions', TALENT_PORTAL_TEXT_DOMAIN ),
            [ $this, 'render_applicant_submissions_widget' ]
        );
    }

    public function render_applicant_submissions_widget()
    {
        $repository = new ApplicantRepository();

        $results = $repository->latest_applications( 5 );

        if ( $results ) {
            $this->view( 'dashboard', [
                'results' => $results,
             ] );
            return;
        }
        echo __( 'No applicant submissions found', TALENT_PORTAL_TEXT_DOMAIN );
    }
}
