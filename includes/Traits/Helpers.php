<?php

namespace TalentPortal\Traits;

/**
 * Helpers Trait
 * @package TalentPortal
 *
 * @since 1.0.0
 */
trait Helpers
{
    /**
     * Load view file
     *
     * @param string $view
     * @param array $data
     *
     * @return void
     */
    public function view( $view, $data = [  ] )
    {
        if ( file_exists( WP_TALENT_PORTAL_PATH . 'views/' . $view . '.php' ) ) {
            extract( $data );
            require_once WP_TALENT_PORTAL_PATH . 'views/' . $view . '.php';
        }
    }
}
