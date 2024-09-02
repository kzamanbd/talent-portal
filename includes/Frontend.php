<?php

namespace WpDraftScripts\TalentPortal;

use WpDraftScripts\TalentPortal\Traits\Singleton;

/**
 * Class Frontend
 * @package WpDraftScripts\TalentPortal
 */

class Frontend
{
    use Singleton;

    public function __construct()
    {
        //
    }

    public static function init()
    {
        return self::instance();
    }
}
