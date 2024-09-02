<?php

namespace WpDraftScripts\TalentPortal\Traits;

/**
 * Helpers Trait
 *
 */
trait Helpers
{
    public function view( $view, $data = [  ] )
    {
        if ( file_exists( WP_TALENT_PORTAL_PLUGIN_PATH . 'views/' . $view . '.php' ) ) {
            extract( $data );
            require_once WP_TALENT_PORTAL_PLUGIN_PATH . 'views/' . $view . '.php';
        }
    }
}
