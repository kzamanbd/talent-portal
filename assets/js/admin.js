console.log('talent-portal admin.js loaded');

(function ($) {
    $('table.wp-list-table.applications').on('click', 'a.submitdelete', function (e) {
        e.preventDefault();

        if (!confirm(talentPortal.confirm)) {
            return;
        }

        const self = $(this);
        const id = self.data('id');
        const messageContainer = $('#form_message');

        wp.ajax
            .post('talent-portal-delete', {
                id: id,
                _wpnonce: talentPortal.nonce
            })
            .done(function (response) {
                console.log(response);
                messageContainer.html('<div class="alert success">' + response.message + '</div>');
                self.closest('tr')
                    .css('background-color', 'red')
                    .hide(400, function () {
                        $(this).remove();
                    });
            })
            .fail(function (response) {
                messageContainer.html('<div class="alert error">' + response.message || talentPortal.error + '</div>');
            });
    });
})(jQuery);
