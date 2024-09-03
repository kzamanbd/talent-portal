<div id="form_message"></div>
<form method="post" id="applicant_form" enctype="multipart/form-data">

    <div class="form-group">
        <label for="first_name">First Name: <span>*</span></label>
        <input type="text" id="first_name" name="first_name" class="talent__form-control">
    </div>

    <div class="form-group">
        <label for="last_name">Last Name: <span>*</span></label>
        <input type="text" id="last_name" name="last_name" class="talent__form-control">
    </div>

    <div class="form-group">
        <label for="address">Address: <span>*</span></label>
        <textarea id="address" name="address" class="talent__form-control"></textarea>
    </div>

    <div class="form-group">
        <label for="email">Email: <span>*</span></label>
        <input type="email" id="email" name="email" class="talent__form-control">
    </div>

    <div class="form-group">
        <label for="mobile">Mobile No: <span>*</span></label>
        <input type="text" id="mobile" name="mobile" class="talent__form-control">
    </div>

    <div class="form-group">
        <label for="post_name">Post Name: <span>*</span></label>
        <select name="post_name" id="post_name" class="talent__form-control">
            <option value="DevOps Engineer">DevOps Engineer</option>
            <option value="Software Engineer">Software Engineer</option>
            <option value="Data Scientist">Data Scientist</option>
            <option value="Web Developer">Web Developer</option>
            <option value="Content Writer">Content Writer</option>
            <option value="SEO Expert">SEO Expert</option>
        </select>
    </div>

    <div class="form-group">
        <label for="cv">CV: <span>*</span></label>
        <input type="file" id="cv" name="cv" class="talent__form-control" accept="application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
    </div>

    <?php wp_nonce_field( 'talent_portal_apply' );?>

    <input type="hidden" name="action" value="talent_portal_apply">

    <div class="form-group">
        <button type="submit" class="talent__submit">
            Apply
        </button>
    </div>
</form>