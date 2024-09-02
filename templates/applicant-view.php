<div class="wrap">
    <h2>Applicant Submissions</h2>
    <form method="get">
        <input type="hidden" name="page" value="applicant-submissions">
        <input type="text" name="s" value="<?php echo esc_attr($search); ?>" placeholder="Search submissions...">
        <input type="submit" value="Search" class="button">
    </form>
    <table class="widefat fixed">
        <thead>
            <tr>
                <th><a href="?page=applicant-submissions&sort=<?php echo $sort_order === 'asc' ? 'desc' : 'asc'; ?>">Date</a></th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Post Name</th>
                <th>CV</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($results): ?>
                <?php foreach ($results as $row): ?>
                    <tr>
                        <td><?php echo esc_html($row->submission_date); ?></td>
                        <td><?php echo esc_html($row->first_name . ' ' . $row->last_name); ?></td>
                        <td><?php echo esc_html($row->email); ?></td>
                        <td><?php echo esc_html($row->mobile); ?></td>
                        <td><?php echo esc_html($row->post_name); ?></td>
                        <td><a href="<?php echo esc_url($row->cv_url); ?>" target="_blank">Download</a></td>
                        <td>
                            <form method="post" onsubmit="return confirm('Are you sure you want to delete this submission?');">
                                <input type="hidden" name="submission_id" value="<?php echo esc_attr($row->id); ?>">
                                <input type="submit" name="delete_submission" value="Delete" class="button">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No submissions found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>