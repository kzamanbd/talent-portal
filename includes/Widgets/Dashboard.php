<?php

namespace TalentPortal\Widgets;

use TalentPortal\Repositories\ApplicantRepository;
use TalentPortal\Traits\Helpers;
use TalentPortal\Traits\Singleton;

/**
 * Dashboard Widgets
 * @package TalentPortal
 *
 * @since 1.0.0
 */

class Dashboard
{
    use Singleton, Helpers;

    /**
     * Dashboard constructor.
     *
     * @return void
     */

    public function __construct()
    {
        add_action( 'wp_dashboard_setup', [ $this, 'add_dashboard_widgets' ] );
    }

    /**
     * Add dashboard widgets
     *
     * @return void
     */

    public function add_dashboard_widgets()
    {
        wp_add_dashboard_widget(
            'applicant_submissions_widget',
            __( 'Latest Applicant Submissions', 'talent-portal' ),
            [ $this, 'render_applicant_submissions_widget' ]
        );
    }

    /**
     * Render applicant submissions widget
     *
     * @return void
     */
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
        echo __( 'No applicant submissions found', 'talent-portal' );
    }
}
