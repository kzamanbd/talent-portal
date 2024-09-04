<ul>
    <?php foreach ( $results as $row ): ?>
        <li>
            <!-- if submission is today then add pills as new -->
            <?php if ( date( 'Y-m-d', strtotime( $row->submission_date ) ) === date( 'Y-m-d' ) ): ?>
                <span style="background: #60bd1b; border-radius: 5px;padding:3px 5px; color: white;">New</span>
            <?php endif;?>
            <strong><?php echo esc_html( $row->first_name . ' ' . $row->last_name ); ?></strong> applied for <strong><em><?php echo esc_html( $row->post_name ); ?></em></strong> on <?php echo esc_html( date_format( date_create( $row->submission_date ), 'd-M-Y H:i A' ) ); ?>
        </li>
    <?php endforeach;?>
</ul>