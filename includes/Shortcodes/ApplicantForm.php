<?php

namespace TalentPortal\Shortcodes;

use TalentPortal\Abstracts\TalentShortcode;
use TalentPortal\Traits\Helpers;

/**
 * Class ApplicantForm
 * @package TalentPortal\Shortcodes
 */
class ApplicantForm extends TalentShortcode
{
    use Helpers;

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
        wp_enqueue_style( 'talent-style' );
        wp_enqueue_script( 'talent-script' );
        ob_start();
        $this->view( 'applicant-form' );
        return ob_get_clean();
    }
}
