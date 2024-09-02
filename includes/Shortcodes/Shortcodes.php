<?php

namespace WpDraftScripts\TalentPortal\Shortcodes;

use WpDraftScripts\TalentPortal\Traits\Singleton;

/**
 * Class Shortcodes
 * @package WpDraftScripts\TalentPortal\Shortcodes
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
