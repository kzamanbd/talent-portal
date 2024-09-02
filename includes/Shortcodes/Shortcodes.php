<?php

namespace TalentPortal\Shortcodes;

use TalentPortal\Traits\Singleton;

/**
 * Class Shortcodes
 * @package TalentPortal\Shortcodes
 */
class Shortcodes
{
    use Singleton;
    /**
     * Shortcodes constructor.
     */
    public function __construct()
    {
        new ApplicantForm();
    }
}
