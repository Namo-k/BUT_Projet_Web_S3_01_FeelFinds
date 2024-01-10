$(document).ready(function() {
    // Chargez les messages existants lors de l'ouverture de la page
    loadMessages();

    // Mettez à jour les messages toutes les 3 secondes (à des fins de démonstration)
    setInterval(loadMessages, 3000);
});

function loadMessages() {
    // Chargez les messages existants depuis le serveur
    $.ajax({
        url: 'getMessages.php',
        type: 'GET',
        success: function(response) {
            $('#messages').html(response);
            // Faites défiler vers le bas pour voir les derniers messages
            $('#messages').scrollTop($('#messages')[0].scrollHeight);
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function sendMessage() {
    // Récupérez le message de l'input
    var message = $('#message-input').val();

    // Envoyez le message au serveur
    $.ajax({
        url: 'sendMessage.php',
        type: 'POST',
        data: { message: message },
        success: function(response) {
            // Effacez le champ de saisie après l'envoi
            $('#message-input').val('');
            // Rechargez les messages pour afficher le nouveau message
            loadMessages();
        },
        error: function(error) {
            console.log(error);
        }
    });
}
