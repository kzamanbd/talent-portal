<?php

namespace WpDraftScripts\TalentPortal\Widgets;

use WpDraftScripts\TalentPortal\Install\Installer;
use WpDraftScripts\TalentPortal\Traits\Helpers;
use WpDraftScripts\TalentPortal\Traits\Singleton;

/**
 * Dashboard Widgets
 *
 */

class Dashboard
{
    use Singleton, Helpers;

    public function __construct()
    {
        add_action('wp_dashboard_setup', [$this, 'add_dashboard_widgets']);
    }

    public static function init()
    {
        return self::instance();
    }

    public function add_dashboard_widgets()
    {
        wp_add_dashboard_widget('applicant_submissions_widget', 'Recent Applicant Submissions', [$this, 'render_applicant_submissions_widget']);
    }

    public function render_applicant_submissions_widget()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . Installer::TABLE_NAME;

        $results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY submission_date DESC LIMIT 5");

        if ($results) {
            $this->view('dashboard', [
                'results' => $results,
            ]);
            return;
        }
        echo 'No submissions found.';
    }
}
