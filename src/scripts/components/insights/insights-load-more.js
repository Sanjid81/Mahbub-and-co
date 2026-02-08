jQuery(function ($) {

    $(document).on('click', '.insights-load-more-btn', function (e) {
        e.preventDefault();

        var $btn = $(this);
        var offset = parseInt($btn.data('offset'));
        var ppp = parseInt($btn.data('ppp'));
        var total = parseInt($btn.data('total'));
        var category = $btn.data('category') || '';

        $btn.text('Loading...').prop('disabled', true);

        $.ajax({
            url: insightsAjax.ajaxurl,
            type: 'POST',
            data: {
                action: 'load_more_insights',
                offset: offset,
                ppp: ppp,
                category: category,
                nonce: insightsAjax.nonce
            },
            success: function (response) {
                if (response.success && response.data.html) {
                    $('.insights-posts-grid:visible').append(response.data.html);

                    var newOffset = offset + ppp;
                    $btn.data('offset', newOffset);

                    if (newOffset >= total) {
                        $btn.closest('.load-more-wrap').remove();
                    } else {
                        $btn.text('Load More').prop('disabled', false);
                    }
                } else {
                    $btn.closest('.load-more-wrap').remove();
                }
            },
            error: function () {
                $btn.text('Try Again').prop('disabled', false);
            }
        });
    });

});