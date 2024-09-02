console.log('Hello from frontend', talentPortal);
(function ($) {
    $('#applicant_form').on('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        const submitBtn = $('.talent__submit');

        submitBtn.attr('disabled', true);
        submitBtn.html('Loading...');

        $.ajax({
            url: talentPortal.ajax_url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                var messageContainer = $('#form_message');
                if (response.success) {
                    messageContainer.html('<div class="success">' + response.data.message + '</div>');
                    // $('#applicant_form')[0].reset(); // Reset the form after successful submission
                } else {
                    messageContainer.html('<div class="error">' + response.data.message + '</div>');
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
})(jQuery);
