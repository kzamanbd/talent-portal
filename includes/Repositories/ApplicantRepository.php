<?php

namespace TalentPortal\Repositories;

use TalentPortal\Install\Installer;

class ApplicantRepository
{
    private $table_name;

    public function __construct()
    {
        global $wpdb;
        $this->table_name = $wpdb->prefix . Installer::TABLE_NAME;
    }

    public function insert( $data )
    {
        global $wpdb;
        $wpdb->insert( $this->table_name, $data );
        return $wpdb->insert_id;
    }

    public function all( $args = [  ], $search = '' )
    {
        global $wpdb;
        $sql = "SELECT * FROM $this->table_name ";

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

    public function get_by_id( $id )
    {
        global $wpdb;
        return $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $this->table_name WHERE id = %d", $id ), ARRAY_A );
    }

    public function find_by_email( $email )
    {
        global $wpdb;
        return $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $this->table_name WHERE email = %s", $email ), ARRAY_A );
    }

    public function update( $data, $id )
    {
        global $wpdb;
        return $wpdb->update( $this->table_name, $data, [ 'id' => $id ] );
    }

    public function delete( $ids )
    {
        global $wpdb;
        $ids_placeholder = implode( ',', array_fill( 0, count( $ids ), '%d' ) );
        return $wpdb->query( $wpdb->prepare( "DELETE FROM $this->table_name WHERE id IN ($ids_placeholder)", $ids ) );
    }

    public function count( $search = '' )
    {
        global $wpdb;
        $query = "SELECT COUNT(*) FROM $this->table_name";

        if ( !empty( $search ) ) {
            $query .= $wpdb->prepare( " WHERE first_name LIKE %s OR last_name LIKE %s OR email LIKE %s OR post_name LIKE %s", "%$search%", "%$search%", "%$search%", "%$search%" );
        }

        return $wpdb->get_var( $query );
    }
}
