<?php

namespace TalentPortal\Forms;

use TalentPortal\Repositories\ApplicantRepository;

/**
 * Class Apply
 * @package TalentPortal\Forms
 */

class Apply
{

    /**
     * @var ApplicantRepository
     */

    public ApplicantRepository $applicant_repository;

    /**
     * ApplicantForm constructor.
     */
    public function __construct()
    {
        $this->applicant_repository = new ApplicantRepository();
    }
    /**
     * Handle form submissions
     * @return void
     */
    public function handle_applicant_form_submission()
    {
        if ( !wp_verify_nonce( $_REQUEST[ '_wpnonce' ], 'talent_portal_apply' ) ) {
            wp_send_json_error( [
                'message' => __( 'Request verification failed!', 'talent-portal' ),
             ] );
            return;
        }

        if ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST' ) {
            $first_name = sanitize_text_field( $_POST[ 'first_name' ] );
            $last_name = sanitize_text_field( $_POST[ 'last_name' ] );
            $address = sanitize_textarea_field( $_POST[ 'address' ] );
            $email = sanitize_email( $_POST[ 'email' ] );
            $mobile = sanitize_text_field( $_POST[ 'mobile' ] );
            $post_name = sanitize_text_field( $_POST[ 'post_name' ] );

            if ( empty( $first_name ) || empty( $last_name ) || empty( $address ) || empty( $email ) || empty( $mobile ) || empty( $post_name ) ) {
                wp_send_json_error( [
                    'message' => __( 'All fields are required!', 'talent-portal' ),
                 ] );
                return;
            }

            // Validate email
            if ( !is_email( $email ) ) {
                wp_send_json_error( [
                    'message' => __( 'Invalid email address!', 'talent-portal' ),
                 ] );
                return;
            }

            // check already applied
            $applicant = $this->applicant_repository->find_by_email( $email );

            if ( $applicant ) {
                return wp_send_json_error( [
                    'message' => __( 'You have already applied for this post!', 'talent-portal' ),
                 ] );
            }

            // Handle file upload
            if ( !function_exists( 'wp_handle_upload' ) ) {
                require_once ABSPATH . 'wp-admin/includes/file.php';
            }

            $uploaded_file = $_FILES[ 'cv' ];
            $upload_overrides = array( 'test_form' => false );

            $move = wp_handle_upload( $uploaded_file, $upload_overrides );

            if ( $move && !isset( $move[ 'error' ] ) ) {
                $cv_path = str_replace( wp_get_upload_dir()[ 'baseurl' ] . '/', '', $move[ 'url' ] );

                $insert_id = $this->applicant_repository->insert( [
                    'first_name'      => $first_name,
                    'last_name'       => $last_name,
                    'address'         => $address,
                    'email'           => $email,
                    'mobile'          => $mobile,
                    'post_name'       => $post_name,
                    'submission_date' => current_time( 'mysql' ),
                    'cv_path'         => $cv_path,
                 ] );

                // Send notification email
                $to = $email;
                $cv_url = $move[ 'url' ];
                $subject = "New Applicant Submission - $first_name $last_name";
                $message = "You have received a new application for the position of $post_name.\n\n" .
                    "Name: $first_name $last_name\n" .
                    "Email: $email\n" .
                    "Mobile: $mobile\n" .
                    "Address: $address\n" .
                    "CV: $cv_url\n";

                wp_mail( $to, $subject, $message );

                wp_send_json_success( [
                    'message' => __( 'Application submitted successfully!', 'talent-portal' ),
                 ] );
            } else {
                wp_send_json_error( [
                    'message' => 'Error uploading CV: ' . $move[ 'error' ],
                 ] );
            }
        }
        wp_die();
    }
}
