<?php

namespace WpDraftScripts\TalentPortal\Admin;

use WpDraftScripts\TalentPortal\Install\Installer;
use WpDraftScripts\TalentPortal\Traits\Singleton;

if ( !class_exists( 'WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * Class ApplicationList
 * @package WpDraftScripts\TalentPortal
 */

class ApplicationList extends \WP_List_Table

{
    use Singleton;

    /**
     * ApplicationList constructor.
     */
    public function __construct()
    {
        parent::__construct( [
            'singular' => 'application',
            'plural'   => 'applications',
            'ajax'     => false,
         ] );

        $this->prepare_items();
        $this->search_box( 'search', 'search_id' );

        $this->display();

        wp_enqueue_style( 'talent-admin-style' );
        wp_enqueue_script( 'talent-admin-script' );

    }

    /**
     * Message to show if no designation found
     *
     * @return void
     */
    public function no_items()
    {
        _e( 'No talent found', 'talent-portal' );
    }

    /**
     * Prepare items
     */
    public function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = [ $columns, $hidden, $sortable ];

        $per_page = 10;
        $current_page = $this->get_pagenum();
        $offset = ( $current_page - 1 ) * $per_page;

        $args = [
            'number' => $per_page,
            'offset' => $offset,
         ];

        if ( isset( $_REQUEST[ 'orderby' ] ) && isset( $_REQUEST[ 'order' ] ) ) {
            $args[ 'orderby' ] = $_REQUEST[ 'orderby' ];
            $args[ 'order' ] = $_REQUEST[ 'order' ];
        }

        $this->items = $this->get_applications( $args );

        $this->set_pagination_args( [
            'total_items' => $this->submission_count(),
            'per_page'    => $per_page,
         ] );

    }

    /**
     * Get columns
     * @return array
     */
    public function get_columns()
    {
        return [
            'cb'              => '<input type="checkbox" />',
            'name'            => __( 'Name', 'talent-portal' ),
            'email'           => __( 'Email', 'talent-portal' ),
            'mobile'          => __( 'Mobile', 'talent-portal' ),
            'post_name'       => __( 'Post Name', 'talent-portal' ),
            'submission_date' => __( 'Submission Date', 'talent-portal' ),
            'cv'              => __( 'CV', 'talent-portal' ),
         ];
    }

    // Column rendering
    public function column_default( $item, $column_name )
    {
        switch ( $column_name ) {
            case 'name':
                return $item->first_name . ' ' . $item->last_name;
            case 'submission_date':
                return wp_date( get_option( 'date_format' ), strtotime( $item->submission_date ) );
            case 'cv':
                return '<a href="' . wp_get_upload_dir()[ 'baseurl' ] . "/" . $item->cv_url . '">Download CV</a>';
            default:
                return isset( $item->$column_name ) ? $item->$column_name : '';
        }
    }

    /**
     * Get hidden columns
     * @return array
     */
    public function get_hidden_columns()
    {
        return [  ];
    }

    /**
     * Get sortable columns
     * @return array
     */
    public function get_sortable_columns()
    {
        return [
            'submission_date' => [ 'submission_date', false ],
         ];
    }

    /**
     * Set the bulk actions
     *
     * @return array
     */
    public function get_bulk_actions()
    {
        $actions = array(
            'trash' => __( 'Move to Trash', 'talent-portal' ),
        );

        return $actions;
    }

    /**
     * Render the "name" column
     *
     * @param  object $item
     *
     * @return string
     */
    public function column_name( $item )
    {
        $actions = [  ];

        $actions[ 'delete' ] = sprintf( '<a href="#" class="submitdelete" data-id="%s">%s</a>', $item->id, __( 'Trash', 'talent-portal' ) );

        return sprintf(
            '<a href="%1$s"><strong>%2$s</strong></a> %3$s',
            admin_url( 'admin.php?page=talent-portal&action=view&id' . $item->id ),
            $item->first_name,
            $this->row_actions( $actions )
        );
    }

    /**
     * Render the "cb" column
     *
     * @param  object $item
     *
     * @return string
     */
    protected function column_cb( $item )
    {
        return sprintf(
            '<input type="checkbox" name="talent_id[]" value="%d" />', $item->id
        );
    }

    /**
     * Get applications
     * @return array
     */
    public function get_applications( $args = [  ] )
    {
        global $wpdb;

        $table_name = $wpdb->prefix . Installer::TABLE_NAME;

        $defaults = [
            'number'  => 20,
            'offset'  => 0,
            'orderby' => 'id',
            'order'   => 'ASC',
         ];

        $args = wp_parse_args( $args, $defaults );

        $last_changed = wp_cache_get_last_changed( 'application' );
        $key = md5( serialize( array_diff_assoc( $args, $defaults ) ) );
        $cache_key = "all:$key:$last_changed";

        $sql = $wpdb->prepare(
            "SELECT * FROM $table_name
                ORDER BY {$args[ 'orderby' ]} {$args[ 'order' ]}
                LIMIT %d, %d",
            $args[ 'offset' ], $args[ 'number' ]
        );

        $items = wp_cache_get( $cache_key, 'application' );

        if ( false === $items ) {
            $items = $wpdb->get_results( $sql );

            wp_cache_set( $cache_key, $items, 'application' );
        }

        return $items;
    }

    /**
     * Submission count
     * @return int
     */
    public function submission_count()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . Installer::TABLE_NAME;
        $count = wp_cache_get( 'count', 'application' );

        if ( false === $count ) {
            $count = (int) $wpdb->get_var( "SELECT count(id) FROM $table_name" );

            wp_cache_set( 'count', $count, 'application' );
        }

        return $count;
    }
}
