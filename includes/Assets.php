<?php

namespace TalentPortal;

/**
 * Class Assets
 * @package TalentPortal
 */
class Assets
{

    /**
     * Class constructor
     */
    function __construct()
    {
        add_action( 'wp_enqueue_scripts', [ $this, 'register_assets' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'register_assets' ] );
    }

    /**
     * All available scripts
     *
     * @return array
     */
    public function scripts()
    {
        return [
            'talent-script'       => [
                'src'     => WP_TALENT_PORTAL_ASSETS . '/build/js/frontend.js',
                'version' => filemtime( WP_TALENT_PORTAL_PATH . '/assets/build/js/frontend.js' ),
                'deps'    => [ 'jquery' ],
             ],
            'talent-admin-script' => [
                'src'     => WP_TALENT_PORTAL_ASSETS . '/build/js/admin.js',
                'version' => filemtime( WP_TALENT_PORTAL_PATH . '/assets/build/js/admin.js' ),
                'deps'    => [ 'jquery', 'wp-util' ],
             ],
         ];
    }

    /**
     * All available styles
     *
     * @return array
     */
    public function styles()
    {
        return [
            'talent-style'       => [
                'src'     => WP_TALENT_PORTAL_ASSETS . '/build/css/frontend.css',
                'version' => filemtime( WP_TALENT_PORTAL_PATH . '/assets/build/css/frontend.css' ),
             ],
            'talent-admin-style' => [
                'src'     => WP_TALENT_PORTAL_ASSETS . '/build/css/admin.css',
                'version' => filemtime( WP_TALENT_PORTAL_PATH . '/assets/build/css/admin.css' ),
             ],
         ];
    }

    /**
     * Register scripts and styles
     *
     * @return void
     */
    public function register_assets()
    {
        $scripts = $this->scripts();
        $styles = $this->styles();

        foreach ( $scripts as $handle => $script ) {
            $deps = isset( $script[ 'deps' ] ) ? $script[ 'deps' ] : false;

            wp_register_script( $handle, $script[ 'src' ], $deps, $script[ 'version' ], true );
        }

        foreach ( $styles as $handle => $style ) {
            $deps = isset( $style[ 'deps' ] ) ? $style[ 'deps' ] : false;

            wp_register_style( $handle, $style[ 'src' ], $deps, $style[ 'version' ] );
        }

        wp_localize_script( 'talent-script', 'talentPortal', [
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'error'    => __( 'Something went wrong', TALENT_PORTAL_TEXT_DOMAIN ),
         ] );

        wp_localize_script( 'talent-admin-script', 'talentPortal', [
            'nonce'   => wp_create_nonce( 'talent-portal-admin-nonce' ),
            'confirm' => __( 'Are you sure?', TALENT_PORTAL_TEXT_DOMAIN ),
            'error'   => __( 'Something went wrong', TALENT_PORTAL_TEXT_DOMAIN ),
         ] );
    }
}
