document.addEventListener('DOMContentLoaded', function () {
    var passwordInput = document.getElementById('passInscr');
    var passwordConditions = document.createElement('div');
    var submitButton = document.querySelector('[name="incription"]');

    passwordConditions.className = 'password-conditions';
    passwordConditions.innerHTML = 'Conditions du mot de passe : ';

    passwordInput.parentNode.insertBefore(passwordConditions, passwordInput.nextSibling);

    function updatePasswordConditions() {
        var password = passwordInput.value;

        var lengthCondition = (password.length >= 8 && password.length <= 20);
        var specialCharCondition = /[!@#$%^&*(),.?":{}|<>]/.test(password);
        var digitCondition = /\d/.test(password);
        var letterCondition = /[a-zA-Z]/.test(password);

        passwordConditions.innerHTML = 'Conditions du mot de passe : ';

        if (lengthCondition) {
            passwordConditions.innerHTML += '<span style="color: green;">Longueur valide</span>, ';
        } else {
            passwordConditions.innerHTML += '<span style="color: red;">Longueur doit être entre 8 et 20 caractères</span>, ';
        }

        if (specialCharCondition) {
            passwordConditions.innerHTML += '<span style="color: green;">Caractères spéciaux présents</span>, ';
        } else {
            passwordConditions.innerHTML += '<span style="color: red;">Caractères spéciaux requis</span>, ';
        }

        if (digitCondition) {
            passwordConditions.innerHTML += '<span style="color: green;">Chiffres présents</span>, ';
        } else {
            passwordConditions.innerHTML += '<span style="color: red;">Chiffres requis</span>, ';
        }

        if (letterCondition) {
            passwordConditions.innerHTML += '<span style="color: green;">Lettres présentes</span>';
        } else {
            passwordConditions.innerHTML += '<span style="color: red;">Lettres requises</span>';
        }

        if (lengthCondition && specialCharCondition && digitCondition && letterCondition) {
            submitButton.removeAttribute('disabled');
            submitButton.classList.remove('disabled-button');
        } else {
            submitButton.setAttribute('disabled', 'disabled');
            submitButton.classList.add('disabled-button');
        }
    }

    passwordInput.addEventListener('input', updatePasswordConditions);
});

