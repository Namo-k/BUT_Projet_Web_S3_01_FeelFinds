document.addEventListener('DOMContentLoaded', function() {
    var container = document.querySelector('#container');
    container.classList.add('show');

    $('#mdpModif').hide();
    $('#suppCompte').hide();

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


});