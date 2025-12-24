$(document).ready(function() {
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
});
