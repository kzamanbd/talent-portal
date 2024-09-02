<?php
if ( isset( $_POST[ 'submit_applicant_form' ] ) ) {
    echo $this->handle_applicant_form_submission();
}
?>
<form method="post" id="applicant_form" enctype="multipart/form-data">
    <p>
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required>
    </p>
    <p>
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required>
    </p>
    <p>
        <label for="address">Present Address:</label>
        <textarea id="address" name="address" required></textarea>
    </p>
    <p>
        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" required>
    </p>
    <p>
        <label for="mobile">Mobile No:</label>
        <input type="text" id="mobile" name="mobile" required>
    </p>
    <p>
        <label for="post_name">Post Name:</label>
        <input type="text" id="post_name" name="post_name" required>
    </p>
    <p>
        <label for="cv">CV:</label>
        <input type="file" id="cv" name="cv" required>
    </p>
    <p>
        <input type="submit" value="Submit Application" name="submit_applicant_form">
    </p>
</form>
