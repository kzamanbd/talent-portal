console.log('talent-portal admin.js loaded');

(function ($) {
    $('table.wp-list-table.applications').on('click', 'a.submitdelete', function (e) {
        e.preventDefault();

        if (!confirm(talentPortal.confirm)) {
            return;
        }

        const self = $(this);
        const id = self.data('id');

        wp.ajax
            .post('talent-portal-delete', {
                id: id,
                _wpnonce: talentPortal.nonce
            })
            .done(function (response) {
                self.closest('tr')
                    .css('background-color', 'red')
                    .hide(400, function () {
                        $(this).remove();
                    });
            })
            .fail(function () {
                alert(talentPortal.error);
            });
    });
})(jQuery);
