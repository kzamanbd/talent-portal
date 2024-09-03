console.log('Hello from frontend', talentPortal);
(function ($) {
    $('#applicant_form').on('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        const submitBtn = $('.talent__submit');

        submitBtn.attr('disabled', true);
        submitBtn.html('Loading...');
        const messageContainer = $('#form_message');

        messageContainer.html('');

        $.ajax({
            url: talentPortal.ajax_url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.success) {
                    messageContainer.html('<div class="alert success">' + response.data.message + '</div>');
                    $('#applicant_form')[0].reset(); // Reset the form after successful submission
                    $('#cv-upload-label').html('Choose file');
                } else {
                    messageContainer.html('<div class="alert error">' + response.data.message + '</div>');
                }
                submitBtn.attr('disabled', false);
                submitBtn.html('Apply');
            },
            error: function (error) {
                console.log(error);
                $('#form_message').html(
                    '<div class="error">There was an error processing your request. Please try again.</div>'
                );
            }
        });
    });

    $('#cv-upload').on('change', function () {
        const file = $(this).prop('files')[0];
        const fileSize = file.size / 1024 / 1024; // in MB
        const allowedTypes = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ];

        if (fileSize > 5) {
            alert('File size must be less than 5MB');
            $(this).val('');
            return;
        }

        if (!allowedTypes.includes(file.type)) {
            alert('Please upload a valid file type. Allowed types are PDF, DOC, DOCX');
            $(this).val('');
            return;
        }

        $('#cv-upload-label').html(file.name);
    });
})(jQuery);
