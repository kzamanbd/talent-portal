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
        $this->search_box( __( 'Search Applicants', 'talent-portal' ), 'applicant-search-input' );

        parent::display();

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
        // Process bulk actions
        $this->process_bulk_action();
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
     * Process the bulk action
     */

    public function process_bulk_action()
    {
        if ( 'trash' === $this->current_action() ) {
            // Check if any IDs are passed for deletion
            if ( isset( $_POST[ 'applicant_id' ] ) && is_array( $_POST[ 'applicant_id' ] ) ) {
                global $wpdb;
                $table_name = $wpdb->prefix . Installer::TABLE_NAME;

                // Sanitize the IDs
                $ids = array_map( 'intval', $_POST[ 'applicant_id' ] );
                $ids_placeholder = implode( ',', array_fill( 0, count( $ids ), '%d' ) );

                // Perform the deletion
                $wpdb->query( $wpdb->prepare( "DELETE FROM $table_name WHERE id IN ($ids_placeholder)", $ids ) );

                // Optionally add a notice
                echo '<div class="updated"><p>' . __( 'Selected applicants have been deleted.', 'talent-portal' ) . '</p></div>';
            }
        }
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
            '<input type="checkbox" name="applicant_id[]" value="%d" />',
            $item->id
        );
    }

    /**
     * Render the search box
     * @param string $text
     * @param string $input_id
     */

    public function search_box( $text, $input_id )
    {
        echo '<p class="search-box">';
        echo '<label class="screen-reader-text" for="' . esc_attr( $input_id ) . '">' . esc_html( $text ) . ':</label>';
        echo '<input type="search" placeholder="Search" id="' . esc_attr( $input_id ) . '" name="s" value="' . esc_attr( isset( $_REQUEST[ 's' ] ) ? $_REQUEST[ 's' ] : '' ) . '" />';
        submit_button( $text, '', '', false, [ 'id' => 'search-submit' ] );
        echo '</p>';
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

        // Handle search
        $search = '';
        if ( isset( $_REQUEST[ 's' ] ) && !empty( $_REQUEST[ 's' ] ) ) {
            $search = trim( $_REQUEST[ 's' ] );
        }

        $args = wp_parse_args( $args, $defaults );

        $sql = "SELECT * FROM $table_name ";

        if ( !empty( $search ) ) {
            $sql .= $wpdb->prepare( " WHERE first_name LIKE %s OR last_name LIKE %s OR email LIKE %s OR post_name LIKE %s", "%$search%", "%$search%", "%$search%", "%$search%" );
        }

        $sql .= $wpdb->prepare(
            "ORDER BY {$args[ 'orderby' ]} {$args[ 'order' ]}
                LIMIT %d, %d",
            $args[ 'offset' ],
            $args[ 'number' ]
        );

        return $wpdb->get_results( $sql );
    }

    /**
     * Submission count
     * @return int
     */
    public function submission_count()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . Installer::TABLE_NAME;
        return (int) $wpdb->get_var( "SELECT count(id) FROM $table_name" );
    }
}
