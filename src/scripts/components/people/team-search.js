

jQuery(document).ready(function ($) {

    function loadTeamMembers(search = '', area = '') {
        $.ajax({
            url: mahbub_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'mahbub_team_search',
                search: search,
                area: area,
                posts_per_page: 6 // always 6 members
            },
            beforeSend: function () {
                $('.mahbub__team-results').html('<p>Loading...</p>');
            },
            success: function (response) {
                $('.mahbub__team-results').html(response);

                
                // Show selected category if any
                if (area !== '') {
                    var selectedText = $('select[name="mahbub__team_area"] option:selected').text();
                    $('.mahbub__selected-category-name').text(selectedText);
                    $('.mahbub__selected-category').show();
                } else {
                    $('.mahbub__selected-category').hide();
                }
            }
        });
    }

    // On form submit
    $('#mahbub__team-search-form').on('submit', function (e) {
        e.preventDefault();
        var searchInput = $('input[name="mahbub__team_search"]');
        var search = searchInput.val();
        var area = $('select[name="mahbub__team_area"]').val();
        
        // Clear search input text
        searchInput.val('');
        
        $('.our-people-container').addClass('is-searching'); // Shift to split-screen layout
        loadTeamMembers(search, area);
    });

    // Clear category button
    $(document).on('click', '.mahbub__clear-category', function () {
        $('select[name="mahbub__team_area"]').val('');
        $('input[name="mahbub__team_search"]').val('');
        $('.our-people-container').removeClass('is-searching'); // Revert to full-page layout
        loadTeamMembers(); // reset to initial 6 members
    });

});
