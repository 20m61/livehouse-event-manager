(function ($) {
    window.WLEM_fetchEvents = function (month) {
        return $.ajax({
            url: WLEM_Ajax.ajax_url,
            method: 'POST',
            data: {
                action: 'wlem_filter_events',
                month: month,
                nonce: WLEM_Ajax.nonce
            },
            dataType: 'json'
        });
    };
})(jQuery);
