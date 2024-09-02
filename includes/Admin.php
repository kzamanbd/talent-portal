<?php

namespace WpDraftScripts\TalentPortal;

use WpDraftScripts\TalentPortal\Install\Installer;
use WpDraftScripts\TalentPortal\Traits\Helpers;

/**
 * Class Admin
 * @package WpDraftScripts\TalentPortal
 */

class Admin
{
    use Helpers;
    /**
     * Instance of self
     *
     * @var Admin
     */
    public static $instance = null;

    public static function init()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Admin constructor.
     */

    public function __construct()
    {
        add_action('admin_menu', [$this, 'add_menu']);
    }

    /**
     * Add menu
     * @return void
     */
    public function add_menu()
    {
        add_menu_page(
            __('Talent Portal', TALENT_PORTAL_TEXT_DOMAIN),
            __('Talent Portal', TALENT_PORTAL_TEXT_DOMAIN),
            'manage_options',
            'talent-portal',
            [$this, 'render'],
            'dashicons-admin-users',
        );
    }

    public function render()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . Installer::TABLE_NAME;

        if (isset($_POST['delete_submission'])) {
            $id = intval($_POST['submission_id']);
            $wpdb->delete($table_name, array('id' => $id));
        }

        $search = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';
        $sort_order = isset($_GET['sort']) && $_GET['sort'] === 'asc' ? 'asc' : 'desc';

        $query = "SELECT * FROM $table_name";
        if ($search) {
            $query .= $wpdb->prepare(" WHERE first_name LIKE %s OR last_name LIKE %s", '%' . $search . '%', '%' . $search . '%');
        }
        $query .= " ORDER BY submission_date $sort_order";

        $results = $wpdb->get_results($query);

        $this->view('applicant-view', [
            'search' => $search,
            'results' => $results
        ]);
    }
}
