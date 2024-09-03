<?php

namespace TalentPortal\Repositories;

use TalentPortal\Install\Installer;

/**
 * Class ApplicantRepository
 * @package TalentPortal\Repositories
 */
class ApplicantRepository
{
    /**
     * @var string
     * Table name
     */
    private $table_name;

    /**
     * ApplicantRepository constructor.
     */
    public function __construct()
    {
        global $wpdb;
        $this->table_name = $wpdb->prefix . Installer::TABLE_NAME;
    }

    /**
     * Insert data into the table
     *
     * @param $data array
     * @return int
     */
    public function insert( $data )
    {
        global $wpdb;
        $wpdb->insert( $this->table_name, $data );
        return $wpdb->insert_id;
    }

    /**
     * Get all applicants
     *
     * @param array $args
     * @param string $search
     * @return array
     */

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

    /**
     * Get applicant by ID
     *
     * @param $id
     * @return array
     */

    public function get_by_id( $id )
    {
        global $wpdb;
        return $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $this->table_name WHERE id = %d", $id ), ARRAY_A );
    }

    /**
     * Find applicant by email
     *
     * @param $email
     * @return array
     */

    public function find_by_email( $email )
    {
        global $wpdb;
        return $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $this->table_name WHERE email = %s", $email ), ARRAY_A );
    }

    /**
     * Update applicant
     *
     * @param $data
     * @param $id
     * @return int
     */

    public function update( $data, $id )
    {
        global $wpdb;
        return $wpdb->update( $this->table_name, $data, [ 'id' => $id ] );
    }

    /**
     * Delete applicant
     *
     * @param $ids
     * @return false|int
     */
    public function delete( $ids )
    {
        try {
            global $wpdb;
            $ids_placeholder = implode( ',', array_fill( 0, count( $ids ), '%d' ) );
            // if $cv_path is not empty, delete the file
            $applicants = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $this->table_name WHERE id IN ($ids_placeholder)", $ids ) );
            foreach ( $applicants as $applicant ) {
                if ( !empty( $applicant->cv_path ) ) {
                    unlink( wp_get_upload_dir()[ 'basedir' ] . '/' . $applicant->cv_path );
                }
            }
            return $wpdb->query( $wpdb->prepare( "DELETE FROM $this->table_name WHERE id IN ($ids_placeholder)", $ids ) );
        } catch ( \Exception $e ) {
            return -1;
        }
    }

    public function delete_by_id( $id )
    {
        global $wpdb;
        // if cv_path is not empty, delete the file
        $applicant = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $this->table_name WHERE id = %d", $id ) );
        if ( !empty( $applicant->cv_path ) ) {
            unlink( wp_get_upload_dir()[ 'basedir' ] . '/' . $applicant->cv_path );
        }
        return $wpdb->delete( $this->table_name, [ 'id' => $id ] );
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

    public function latest_applications( $limit = 5 )
    {
        global $wpdb;
        return $wpdb->get_results( "SELECT * FROM $this->table_name ORDER BY submission_date DESC LIMIT $limit" );
    }

    public function uninstaller()
    {
        global $wpdb;
        // if cv_path is not empty, delete the file
        $applicants = $wpdb->get_results( "SELECT * FROM $this->table_name" );
        foreach ( $applicants as $applicant ) {
            if ( !empty( $applicant[ 'cv_path' ] ) ) {
                unlink( wp_get_upload_dir()[ 'basedir' ] . '/' . $applicant[ 'cv_path' ] );
            }
        }
        return $wpdb->query( "DROP TABLE IF EXISTS $this->table_name" );
    }
}
