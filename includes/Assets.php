<?php

namespace WpDraftScripts\TalentPortal;

/**
 * Class Assets
 * @package WpDraftScripts\TalentPortal
 */
class Assets
{

    public function __construct()
    {
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
    }

    public function enqueue_scripts()
    {
        wp_enqueue_style( 'talent-portal-style', WP_TALENT_PORTAL_ASSETS . '/build/css/app.css', [  ], WP_TALENT_PORTAL_VERSION );
        wp_enqueue_script( 'talent-portal-script', WP_TALENT_PORTAL_ASSETS . '/build/js/app.js', [ 'jquery' ], WP_TALENT_PORTAL_VERSION, true );
    }
}
