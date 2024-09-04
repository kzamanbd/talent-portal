<?php

namespace TalentPortal\Shortcodes;

use TalentPortal\Traits\Singleton;

/**
 * Class Shortcodes
 * @package TalentPortal\Shortcodes
 *
 * @since 1.0.0
 */
class Shortcodes
{
    use Singleton;
    /**
     * Shortcodes constructor.
     *
     * @return void
     */
    public function __construct()
    {
        new ApplicantForm();
    }
}
