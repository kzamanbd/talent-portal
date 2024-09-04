<?php

namespace TalentPortal\Admin;

use TalentPortal\Traits\Singleton;

/**
 * Class Menu
 * @package TalentPortal
 *
 * @since 1.0.0
 */

class Menu
{

    use Singleton;

    /**
     * @var array $pages
     */
    public array $pages = [  ];

    /**
     * @var array $sup_pages
     */
    public array $sup_pages = [  ];

    /**
     * Register the actions
     *
     * @return void
     */
    public function register()
    {
        if ( !empty( $this->pages ) || !empty( $this->sup_pages ) ) {
            add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
        }
    }

    /**
     * Add the admin menu
     *
     * @return void
     */

    public function add_admin_menu()
    {
        foreach ( $this->pages as $page ) {
            add_menu_page(
                $page[ 'page_title' ],
                $page[ 'menu_title' ],
                $page[ 'capability' ],
                $page[ 'menu_slug' ],
                $page[ 'callback' ] ?? null,
                $page[ 'icon_url' ] ?? null,
                $page[ 'position' ] ?? null
            );
        }

        foreach ( $this->sup_pages as $page ) {
            add_submenu_page(
                $page[ 'parent_slug' ],
                $page[ 'page_title' ],
                $page[ 'menu_title' ],
                $page[ 'capability' ],
                $page[ 'menu_slug' ],
                $page[ 'callback' ]
            );
        }
    }

    /**
     * Add the pages
     *
     * @param array $pages
     *
     * @return $this
     */

    public function add_pages( array $pages )
    {
        $this->pages = $pages;
        return $this;
    }

    /**
     * Add the sub pages
     *
     * @param string|null $title
     *
     * @return $this
     */

    public function with_sub_page( string $title = null )
    {
        if ( empty( $this->pages ) ) {
            return $this;
        }

        $parent = $this->pages[ 0 ];

        $sup_pages = [
            [
                'parent_slug' => $parent[ 'menu_slug' ],
                'page_title'  => $parent[ 'page_title' ],
                'menu_title'  => $title ? $title : $parent[ 'menu_title' ],
                'capability'  => $parent[ 'capability' ],
                'menu_slug'   => $parent[ 'menu_slug' ],
                'callback'    => $parent[ 'callback' ],
             ],
         ];

        $this->sup_pages = $sup_pages;

        return $this;
    }

    /**
     * Add the sub pages
     *
     * @param array $pages
     *
     * @return $this
     */

    public function add_sup_pages( array $pages )
    {
        $this->sup_pages = array_merge( $this->sup_pages, $pages );
        return $this;
    }
}
