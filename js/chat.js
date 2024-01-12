$(document).ready(function() {
    loadMessages();
    setInterval(loadMessages, 3000);
});

function loadMessages() {
    $.ajax({
        url: '../php-profil/get/getMessages.php',
        type: 'GET',
        success: function(response) {
            $('#messages').html(response);
            $('#messages').scrollTop($('#messages')[0].scrollHeight);
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function sendMessage() {
    var message = $('#message-input').val();

    $.ajax({
        url: '../php-profil/ajout/sendMessage.php',
        type: 'POST',
        data: { message: message },
        success: function(response) {
            $('#message-input').val('');
            loadMessages();
        },
        error: function(error) {
            console.log(error);
        }
    });
}
