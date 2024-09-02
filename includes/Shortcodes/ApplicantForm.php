<?php

namespace WpDraftScripts\TalentPortal\Shortcodes;

use WpDraftScripts\TalentPortal\Abstracts\TalentShortcode;

/**
 * Class ApplicantForm
 * @package WpDraftScripts\TalentPortal\Shortcodes
 */
class ApplicantForm extends TalentShortcode
{

    /**
     * Get shortcode tag
     * @return string
     */
    public function get_shortcode_tag()
    {
        return 'applicant_form';
    }

    /**
     * Render shortcode
     * @return void
     */
    public function render( $attrs, $content = '' )
    {
        ob_start();
        require_once WP_TALENT_PORTAL_PLUGIN_PATH . 'templates/applicant-form.php';
        return ob_get_clean();
    }

    /**
     * Handle form submissions
     * @return void
     */
    public function handle_applicant_form_submission()
    {
        if ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST' ) {
            global $wpdb;

            $first_name = sanitize_text_field( $_POST[ 'first_name' ] );
            $last_name = sanitize_text_field( $_POST[ 'last_name' ] );
            $address = sanitize_textarea_field( $_POST[ 'address' ] );
            $email = sanitize_email( $_POST[ 'email' ] );
            $mobile = sanitize_text_field( $_POST[ 'mobile' ] );
            $post_name = sanitize_text_field( $_POST[ 'post_name' ] );

            // Handle file upload
            if ( !function_exists( 'wp_handle_upload' ) ) {
                require_once ABSPATH . 'wp-admin/includes/file.php';
            }

            $uploaded_file = $_FILES[ 'cv' ];
            $upload_overrides = array( 'test_form' => false );

            $move = wp_handle_upload( $uploaded_file, $upload_overrides );

            if ( $move && !isset( $move[ 'error' ] ) ) {
                $cv_url = $move[ 'url' ];

                $table_name = $wpdb->prefix . 'talent_submissions';

                $wpdb->insert( $table_name, array(
                    'first_name' => $first_name,
                    'last_name'  => $last_name,
                    'address'    => $address,
                    'email'      => $email,
                    'mobile'     => $mobile,
                    'post_name'  => $post_name,
                    'cv_url'     => $cv_url,
                ) );

                // Send notification email
                $to = $email;
                $subject = "New Applicant Submission - $first_name $last_name";
                $message = "You have received a new application for the position of $post_name.\n\n" .
                    "Name: $first_name $last_name\n" .
                    "Email: $email\n" .
                    "Mobile: $mobile\n" .
                    "Address: $address\n" .
                    "CV: $cv_url\n";

                wp_mail( $to, $subject, $message );

                return '<div class="success">Your application has been submitted successfully.</div>';
            } else {
                // Return error message
                return '<div class="error">Error uploading CV: ' . $move[ 'error' ] . '</div>';
            }
        }
        wp_die();
    }
}
