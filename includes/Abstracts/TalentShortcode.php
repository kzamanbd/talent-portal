<?php

namespace WpDraftScripts\TalentPortal\Abstracts;

/**
 * Class TalentShortcode
 * @package WpDraftScripts\TalentPortal
 */

abstract class TalentShortcode
{
    /**
     * TalentShortcode constructor.
     * Register shortcode
     */
    public function __construct()
    {
        add_shortcode( $this->get_shortcode_tag(), [ $this, 'render' ] );
    }

    /**
     * Get shortcode tag
     * @return string
     */
    abstract public function get_shortcode_tag();

    /**
     * Render shortcode
     * @param $attrs array
     * @param string $content
     * @return void
     */
    abstract public function render( $attrs, $content = '' );
}
