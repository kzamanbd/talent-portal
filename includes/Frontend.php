<?php

namespace WpDraftScripts\TalentPortal;

use WpDraftScripts\TalentPortal\Interfaces\Action;

/**
 * Class Frontend
 * @package WpDraftScripts\TalentPortal
 */

class Frontend implements Action
{
    /**
     * Instance of self
     *
     * @var Frontend
     */
    public static $instance = null;

    public function __construct()
    {
        // 
    }

    public static function init()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
