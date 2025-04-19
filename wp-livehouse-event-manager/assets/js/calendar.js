jQuery(function ($) {
    function fetchEvents(month, cb) {
        $.post(WLEM_Ajax.ajax_url, {
            action: 'wlem_filter_events',
            month: month,
            nonce: WLEM_Ajax.nonce
        }, function (res) {
            if (res.success) cb(res.data);
        });
    }

    // リスト表示制御
    $('#wlem-month-select').on('change', function () {
        var m = $(this).val();
        fetchEvents(m, function (data) {
            var html = '';
            data.forEach(e => html += '<li><a href="' + e.link + '">' + e.title + ' (' + e.date + ')</a></li>');
            $('#wlem-events-list').html(html);
        });
    }).trigger('change');

    // カレンダー表示制御
    var $cal = $('#wlem-calendar'), $nav = $('.wlem-calendar-nav');
    function renderCalendar(month, data) {
        // ヘッダー：曜日
        var days = ['日', '月', '火', '水', '木', '金', '土'];
        var html = '<tr>' + days.map(d => '<th>' + d + '</th>').join('') + '</tr>';
        var parts = month.split('-'), y = +parts[0], m = +parts[1] - 1;
        var first = new Date(y, m, 1).getDay(), total = new Date(y, m + 1, 0).getDate();
        var day = 1, rows = Math.ceil((first + total) / 7);
        for (var r = 0; r < rows; r++) {
            html += '<tr>';
            for (var c = 0; c < 7; c++) {
                if (r === 0 && c < first || day > total) {
                    html += '<td></td>';
                } else {
                    var key = month + '-' + ('0' + day).slice(-2);
                    var ev = data.filter(e => e.date === key);
                    html += '<td><strong>' + day + '</strong>';
                    ev.forEach(e => html += '<div><a href="' + e.link + '">' + e.title + '</a></div>');
                    html += '</td>'; day++;
                }
            }
            html += '</tr>';
        }
        $cal.html(html);
    }
    $nav.on('click', 'button', function () {
        var mtxt = $('#wlem-cal-month').text().split('-'), y = +mtxt[0], m = +mtxt[1];
        m = $(this).data('action') === 'prev' ? m - 1 : m + 1;
        if (m < 1) { y--; m = 12; } if (m > 12) { y++; m = 1; }
        var next = ('0' + m).slice(-2), nm = y + '-' + next;
        $('#wlem-cal-month').text(nm);
        fetchEvents(nm, data => renderCalendar(nm, data));
    });
    // 初期表示
    var init = $('#wlem-cal-month').text();
    fetchEvents(init, data => renderCalendar(init, data));
});
