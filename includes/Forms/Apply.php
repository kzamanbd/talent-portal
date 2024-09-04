<?php

namespace TalentPortal\Forms;

use TalentPortal\Repositories\ApplicantRepository;
use TalentPortal\Traits\Helpers;

/**
 * Class Apply
 * @package TalentPortal\Forms
 * @since 1.0.0
 */

class Apply
{
    use Helpers;

    /**
     * @var ApplicantRepository
     */

    public ApplicantRepository $applicant_repository;

    /**
     * ApplicantForm constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->applicant_repository = new ApplicantRepository();
    }
    /**
     * Handle form submissions
     *
     * @return void
     */
    public function handle_applicant_form_submission()
    {
        // Verify nonce
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
            $email = sanitize_textarea_field( $_POST[ 'email' ] );
            $mobile = sanitize_text_field( $_POST[ 'mobile' ] );
            $post_name = sanitize_text_field( $_POST[ 'post_name' ] );

            // Validate required fields
            if ( empty( $first_name ) || empty( $address ) || empty( $email ) || empty( $mobile ) || empty( $post_name ) ) {
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

            // validate mobile number
            if ( !preg_match( '/^(?:\+88|88)?(01[3-9]\d{8})$/', $mobile ) ) {
                wp_send_json_error( [
                    'message' => __( 'Invalid mobile number!', 'talent-portal' ),
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

            // check file type only pdf and doc or docx
            $allowed_types = [ 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ];

            if ( !in_array( $uploaded_file[ 'type' ], $allowed_types ) ) {
                wp_send_json_error( [
                    'message' => __( 'Invalid file type! Only PDF, DOC, DOCX files are allowed.', 'talent-portal' ),
                 ] );
                return;
            }
            // upload file
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
                $name = $first_name . ' ' . $last_name;
                $subject = __( 'We have received your application', 'talent-portal' );
                ob_start();
                $this->view( 'email-template', compact( 'name', 'post_name' ) );
                $message = ob_get_clean();

                // Send email
                wp_mail( $to, $subject, $message, [ 'Content-Type: text/html; charset=UTF-8' ] );

                // Send success response
                wp_send_json_success( [
                    'message' => __( 'Application submitted successfully!', 'talent-portal' ),
                 ] );
            } else {
                // Send error response
                wp_send_json_error( [
                    'message' => 'Error uploading CV: ' . $move[ 'error' ],
                 ] );
            }
        } else {
            wp_send_json_error( [
                'message' => __( 'Invalid request!', 'talent-portal' ),
             ] );
        }
    }
}
