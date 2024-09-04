<?php

namespace TalentPortal\Admin\Actions;

use TalentPortal\Repositories\ApplicantRepository;

/**
 * Class Applicant
 * @package TalentPortal\Admin\Actions
 *
 * @since 1.0.0
 */

class Applicant
{
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
     * Handle application deletion
     *
     * @return void
     */
    public function delete_application()
    {
        // Verify nonce
        if ( !wp_verify_nonce( $_REQUEST[ '_wpnonce' ], 'talent-portal-admin-nonce' ) ) {
            wp_send_json_error( [
                'message' => __( 'Nonce verification failed!', 'talent-portal' ),
             ] );
            return;
        }

        // Check permission

        if ( !current_user_can( 'manage_options' ) ) {
            wp_send_json_error( [
                'message' => __( 'No permission!', 'talent-portal' ),
             ] );
            return;
        }

        // Get application ID

        $id = isset( $_REQUEST[ 'id' ] ) ? intval( $_REQUEST[ 'id' ] ) : 0;

        if ( !$id ) {
            wp_send_json_error( [
                'message' => __( 'Invalid application ID!', 'talent-portal' ),
             ] );
            return;
        }

        // Delete application

        $result = $this->applicant_repository->delete_by_id( $id );

        // Check if error
        if ( $result === -1 ) {
            wp_send_json_error( [
                'message' => __( 'Error deleting application!', 'talent-portal' ),
             ] );
            return;
        }

        // Send success response
        wp_send_json_success( [
            'message' => __( 'Application deleted successfully!', 'talent-portal' ),
         ] );
    }
}
