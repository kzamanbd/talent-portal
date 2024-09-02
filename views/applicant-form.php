<?php
if ( isset( $_POST[ 'submit_applicant_form' ] ) ) {
    echo $this->handle_applicant_form_submission();
}
?>
<div id="form_message"></div>
<form method="post" id="applicant_form" enctype="multipart/form-data">
    <input type="hidden" name="submit_applicant_form">
    <div class="form-group">
        <label for="first_name">First Name: <span>*</span></label>
        <input type="text" id="first_name" name="first_name" class="talent__form-control" required>
    </div>
    <div class="form-group">
        <label for="last_name">Last Name: <span>*</span></label>
        <input type="text" id="last_name" name="last_name" class="talent__form-control" required>
    </div>
    <div class="form-group">
        <label for="address">Address: <span>*</span></label>
        <textarea id="address" name="address" class="talent__form-control" required></textarea>
    </div>
    <div class="form-group">
        <label for="email">Email: <span>*</span></label>
        <input type="email" id="email" name="email" class="talent__form-control" required>
    </div>
    <div class="form-group">
        <label for="mobile">Mobile No: <span>*</span></label>
        <input type="text" id="mobile" name="mobile" class="talent__form-control" required>
    </div>
    <div class="form-group">
        <label for="post_name">Post Name: <span>*</span></label>
        <input type="text" id="post_name" name="post_name" class="talent__form-control" required>
    </div>
    <div class="form-group">
        <input type="file" id="cv" name="cv" class="talent__form-control" required>
        <label for="cv">CV: <span>*</span></label>
    </div>

    <?php wp_nonce_field( 'talent_portal_form' );?>

    <input type="hidden" name="action" value="talent_portal_form">
    <div class="form-group">
        <button type="submit" class="talent__submit">
            Submit Application
        </button>
    </div>
</form>