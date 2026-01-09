$(document).ready(function () {
    //connect button functionality
    $(document).on('click', '.connect-btn', function () {
        var button = $(this);
        var receiverId = button.data('receiver-id');
        $.ajax({
            url: '/connect/send',
            method: 'POST',
            data: { receiver_id: receiverId },
            success: function (response) {
                var result = JSON.parse(response);
                if (result.success) {
                    if (result.status == 0) {
                        button.text('Interest Sent');
                        button.prop('disabled', true);
                        button.addClass('btnd');
                    } else if (result.status == 1) {
                        button.text('Disconnect');
                    }
                } else {
                    alert('Request already sent');
                }
            },
            error: function () {
                alert('There was an error sending the request.');
            }
        });
    });


    //shorlist functinality
    $(document).on('click', '.shortlist-icon', function (e) {
        e.preventDefault();
        let icon = $(this).find('i');
        let text = $(this).find('.shortlist-text');
        let shortlist_id = $(this).data('profile-id');
        $.ajax({
            url: '/shortlist/toggle',
            type: 'POST',
            data: { shortlist_userid: shortlist_id },
            success: function (response) {

                let result = JSON.parse(response);

                if (result.status === 'added') {
                    icon.removeClass('fa-regular').addClass('fa-solid');
                    if (text.length) text.text('Shortlisted');

                } else if (result.status === 'removed') {
                    icon.removeClass('fa-solid').addClass('fa-regular');
                    if (text.length) text.text('Shortlist');
                }
            },
            error: function () {
                alert('Error updating shortlist');
            }
        });
    });
    // Submit filters using ajax
    let filterActive = false;
    $('#filterForm').on('submit', function (e) {
        e.preventDefault();
        filterActive = true;
        $.ajax({
            url: '/user/matches/filter',
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                $('#profilesContainer').html(response);
            }
        });
    });


    $(document).on('click', '.page-link', function (e) {
        e.preventDefault();
        let page = $(this).data('page');

        let data = $('#filterForm').serializeArray();
        data.push({ name: 'page', value: page });

        $.ajax({
            url: '/user/matches/filter',
            type: 'POST',
            data: $.param(data),
            success: function (res) {
                $('#profilesContainer').html(res);
            }
        });
    });
    $(document).on('click', '.pagination a', function (e) {
        if (!filterActive) return;
        e.preventDefault();
        let page = new URL($(this).attr('href'), window.location.origin)
            .searchParams.get('page');

        let data = $('#filterForm').serializeArray();
        data.push({ name: 'page', value: page });

        $.ajax({
            url: '/user/matches/filter',
            type: 'POST',
            data: $.param(data),
            success: function (res) {
                $('#profilesContainer').html(res);
            }
        });
    });

    // Reset filters
    $('#resetFilters').on('click', function (e) {
        e.preventDefault();
        $('#filterForm')[0].reset();

        // Trigger change for dependent filters
        $('select[name="age_from"]').trigger('change');

        $('#filterForm').trigger('submit');
    });

    // Dependent Age Filters
    const $ageFrom = $('select[name="age_from"]');
    const $ageTo = $('select[name="age_to"]');

    function updateAgeToOptions() {
        const selectedFrom = parseInt($ageFrom.val()) || 18;
        const selectedTo = parseInt($ageTo.val());

        $ageTo.find('option').each(function () {
            const val = parseInt($(this).val());
            if (val && val < selectedFrom) {
                $(this).hide();
            } else {
                $(this).show();
            }
        });
        if (selectedTo && selectedTo < selectedFrom) {
            $ageTo.val('');
        }
    }

    $ageFrom.on('change', updateAgeToOptions);
    updateAgeToOptions();
});

// Modal Logic
function openModal() {
    document.getElementById('completeProfileModal').style.display = 'flex';
}

$(document).ready(function () {
    $('.close-modal').on('click', function () {
        $('#completeProfileModal').hide();
    });

    $(window).on('click', function (event) {
        if (event.target == document.getElementById('completeProfileModal')) {
            $('#completeProfileModal').hide();
        }
    });
});
