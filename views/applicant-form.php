<form method="post" id="applicant_form" enctype="multipart/form-data">

    <div class="form-group">
        <label for="first_name">First Name: <span>*</span></label>
        <input type="text" id="first_name" name="first_name" class="talent__form-control" required />
    </div>

    <div class="form-group">
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" class="talent__form-control" />
    </div>

    <div class="form-group">
        <label for="address">Address: <span>*</span></label>
        <textarea id="address" name="address" class="talent__form-control" required></textarea>
    </div>

    <div class="form-group">
        <label for="email">Email: <span>*</span></label>
        <input type="email" id="email" name="email" class="talent__form-control" required />
    </div>

    <div class="form-group">
        <label for="mobile">Mobile No: <span>*</span></label>
        <input type="text" id="mobile" name="mobile" class="talent__form-control" required />
    </div>

    <div class="form-group">
        <label for="post_name">Post Name: <span>*</span></label>
        <select name="post_name" id="post_name" class="talent__form-control" required>
            <option value="" hidden>Select Position</option>
            <option value="DevOps Engineer">DevOps Engineer</option>
            <option value="Software Engineer">Software Engineer</option>
            <option value="Data Scientist">Data Scientist</option>
            <option value="Web Developer">Web Developer</option>
            <option value="Content Writer">Content Writer</option>
            <option value="SEO Expert">SEO Expert</option>
        </select>
    </div>

    <div class="attachment-details">
        <label for="cv-upload" class="attach-wrapper">
            <div class="upload-box">
                <h6>Drag and drop document here to upload</h6>
                <span class="or">OR</span>
                <div class="upload-btn">
                    <svg height="24" width="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M12 17L12 10M12 10L15 13M12 10L9 13" stroke="#026cd1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M16 7H12H8" stroke="#026cd1" stroke-width="1.5" stroke-linecap="round"></path>
                            <path opacity="0.5" d="M2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12Z" stroke="#026cd1" stroke-width="1.5"></path>
                        </g>
                    </svg>
                    <span id="cv-upload-label">Choose File</span>
                </div>
                <input type="file" id="cv-upload" class="d-none" name="cv" accept="application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" />
                <small>Up to 10 MB for PDF and up to 5 MB for DOC, DOCX, TXT</small>
            </div>
        </label>
    </div>

    <?php wp_nonce_field( 'talent_portal_apply' );?>

    <input type="hidden" name="action" value="talent_portal_apply">
    <div id="form_message"></div>
    <div class="form-group">
        <button type="submit" class="talent__submit">
            Apply
        </button>
    </div>
</form>
