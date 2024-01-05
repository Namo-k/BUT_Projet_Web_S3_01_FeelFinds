document.addEventListener('DOMContentLoaded', function() {
    var container = document.querySelector('#container');
    container.classList.add('show');



$('#showConfirmation').on('click', function() {
    // Demander une confirmation avant la suppression
    console.log("test non");
    var confirmation = confirm('Voulez-vous vraiment supprimer cet avis?');

    if (confirmation) {
        // Si l'utilisateur clique sur "OK", effectuer la suppression
        $.ajax({
            type: 'POST',
            url: 'supprimerCompte.php',
            success: function (response) {
                console.log('Compte supprimé avec succès');
                console.log(response);
                window.location.href="../index.html";
            },
            error: function (error) {
                console.error('Erreur lors de la suppression du compte', error);
            }
        });
    } else {
        // Si l'utilisateur clique sur "Annuler", ne rien faire
        console.log('Suppression annulée par l\'utilisateur');
    }
});
});