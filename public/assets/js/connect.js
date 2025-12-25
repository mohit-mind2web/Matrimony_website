$(document).ready(function() {
    //connect button functionality
    $('.connect-btn').on('click', function() {
        var button = $(this);
        var receiverId = button.data('receiver-id'); 
        $.ajax({
            url: '/connect/send', 
            method: 'POST',
            data: { receiver_id: receiverId },
            success: function(response) {
                var result = JSON.parse(response);
                if (result.success) {
                    if(result.status === 0){
                        button.text('Request Sent');
                        button.prop('disabled', true);
                        button.addClass('btnd');
                    } else if(result.status === 1){
                        button.text('Contact Now');
                    }
                } else {
                    alert('Request already sent');
                }
            },
            error: function() {
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
});
