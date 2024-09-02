<ul>
    <?php foreach ($results as $row): ?>
        <li>
            <strong><?php echo esc_html($row->first_name . ' ' . $row->last_name); ?></strong> applied for <em><?php echo esc_html($row->post_name); ?></em> on <?php echo esc_html($row->submission_date); ?>
        </li>
    <?php endforeach; ?>
</ul>