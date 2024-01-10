document.addEventListener('DOMContentLoaded', function() {
    var container = document.querySelector('#container');
    container.classList.add('show');

    $('#mdpModif').hide();
    $('#suppCompte').hide();
    $('#pseudoModif').hide();

$('#annulerCompte').on('click',function(){
    $('#suppCompte').hide();
    $('#showConfirmation').show();
});

$('#showConfirmation').on('click', function() {
    $('#suppCompte').show();
    $('#showConfirmation').hide();
});


$('#annuler').on('click', function(){
    $('#mdpModif').hide();
    $('#modifierMDP').show();
});

$('#modifierMDP').on('click', function(){
    $('#modifierMDP').hide();
    $('#mdpModif').show();

});


$('#annulerAvatar').on('click', function(){
    $('#formulaireContainer').hide();
});


$('#annulerPseudo').on('click', function(){
    $('#pseudoModif').hide();
    $('#modifierPseudo').show();
});

$('#modifierPseudo').on('click', function(){
    $('#modifierPseudo').hide();
    $('#pseudoModif').show();

});

});

function ouvrirFormulaire() {
    var formulaireContainer = document.getElementById("formulaireContainer");
    formulaireContainer.style.display = "block";
  }