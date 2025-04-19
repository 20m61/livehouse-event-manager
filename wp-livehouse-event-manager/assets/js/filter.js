jQuery(function ($) {
    $('#wlem-month-select').on('change', function () {
        var month = $(this).val();
        $.post(WLEM_Ajax.ajax_url, {
            action: 'wlem_filter_events',
            month: month,
            nonce: WLEM_Ajax.nonce
        }, function (res) {
            if (res.success) {
                var html = '';
                res.data.forEach(function (e) {
                    html += '<li><a href="' + e.link + '">' + e.title + ' (' + e.date + ')</a></li>';
                });
                $('#wlem-events-list').html(html);
            }
        });
    });
});
