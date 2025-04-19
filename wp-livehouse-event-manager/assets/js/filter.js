jQuery(function ($) {
    $('#wlem-month-select').on('change', function () {
        var month = $(this).val();
        WLEM_fetchEvents(month)
            .done(function (res) {
                if (res.success) {
                    var html = '';
                    res.data.forEach(function (e) {
                        html += '<li><a href="' + e.link + '">' + e.title + ' (' + e.date + ')</a></li>';
                    });
                    $('#wlem-events-list').html(html);
                }
            })
            .fail(function () {
                $('#wlem-events-list').html('<li><em>イベント情報の取得に失敗しました。</em></li>');
            });
    }).trigger('change');
});
