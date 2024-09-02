<?php

namespace WpDraftScripts\TalentPortal;

use WpDraftScripts\TalentPortal\Install\Installer;
use WpDraftScripts\TalentPortal\Traits\Singleton;

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
        add_action( 'wp_ajax_talent-portal-delete', [ $this, 'delete_application' ] );
    }

    /**
     * Handle contact deletion
     *
     * @return void
     */
    public function delete_application()
    {
        if ( !wp_verify_nonce( $_REQUEST[ '_wpnonce' ], 'talent-portal-admin-nonce' ) ) {
            wp_send_json_error( [
                'message' => __( 'Nonce verification failed!', 'talent-portal' ),
             ] );
        }

        if ( !current_user_can( 'manage_options' ) ) {
            wp_send_json_error( [
                'message' => __( 'No permission!', 'talent-portal' ),
             ] );
        }

        $id = isset( $_REQUEST[ 'id' ] ) ? intval( $_REQUEST[ 'id' ] ) : 0;
        $this->wd_ac_delete( $id );

        wp_send_json_success();
    }

    /**
     * Delete contact
     *
     * @param int $id
     * @return void
     */
    public function wd_ac_delete( $id )
    {
        global $wpdb;

        $table_name = $wpdb->prefix . Installer::TABLE_NAME;
        return $wpdb->delete(
            $table_name,
            [ 'id' => $id ],
            [ '%d' ]
        );
    }
}
