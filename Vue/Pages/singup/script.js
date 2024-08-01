
    function togglePasswordVisibility() {
    const passwordField = document.getElementById('password');
    const passwordRepeatField = document.getElementById('password_repeat');
    const eyeIcon = document.getElementById('eye-icon');

    if (passwordField.type === 'password' && passwordRepeatField.type === 'password') {
    passwordField.type = 'text';
    passwordRepeatField.type = 'text';
    eyeIcon.classList.remove('fa-eye');
    eyeIcon.classList.add('fa-eye-slash');
} else {
    passwordField.type = 'password';
    passwordRepeatField.type = 'password';
    eyeIcon.classList.remove('fa-eye-slash');
    eyeIcon.classList.add('fa-eye');
}
}

document.getElementById('registrationForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Empêche le rechargement de la page
        let isValid = true;

        // Réinitialiser les messages d'erreur
        document.querySelectorAll('.error-message').forEach(function(el) {
            el.textContent = '';
        });

        // Vérifier le nom
        const nom = document.getElementById('nom').value;
        if (nom.length > 50) {
            isValid = false;
            document.getElementById('nomError').textContent = 'Le nom ne doit pas dépasser 50 caractères.';
        }

        // Vérifier le prénom
        const prenom = document.getElementById('prenom').value;
        if (prenom.length > 50) {
            isValid = false;
            document.getElementById('prenomError').textContent = 'Le prénom ne doit pas dépasser 50 caractères.';
        }

        // Vérifier l'adresse
        const adresse = document.getElementById('adresse').value;
        if (adresse.length > 100) {
            isValid = false;
            document.getElementById('adresseError').textContent = 'L\'adresse ne doit pas dépasser 100 caractères.';
        }

        // Vérifier le contact
        const contact = document.getElementById('contact').value;
        if (contact.length > 20 || !/^\d+$/.test(contact)) {
            isValid = false;
            document.getElementById('contactError').textContent = 'Le contact doit être un numéro valide et ne doit pas dépasser 20 caractères.';
        }

        // Vérifier le pays
        const pays = document.getElementById('pays').value;
        if (!pays) {
            isValid = false;
            document.getElementById('paysError').textContent = 'Veuillez sélectionner un pays.';
        }

        // Vérifier la ville
        const ville = document.getElementById('ville').value;
        if (ville.length > 50) {
            isValid = false;
            document.getElementById('villeError').textContent = 'La ville ne doit pas dépasser 50 caractères.';
        }

        // Vérifier le métier
        const metier = document.getElementById('metier').value;
        if (metier.length > 50) {
            isValid = false;
            document.getElementById('metierError').textContent = 'Le métier ne doit pas dépasser 50 caractères.';
        }

        // Vérifier le pseudo
        const pseudo = document.getElementById('pseudo').value;
        if (pseudo.length > 20) {
            isValid = false;
            document.getElementById('pseudoError').textContent = 'Le pseudo ne doit pas dépasser 20 caractères.';
        }

        // Vérifier le mot de passe
        const password_repeat = document.getElementById('password').value;
        if (password_repeat.length < 6) {
            isValid = false;
            document.getElementById('password_repeatError').textContent = 'Le mot de passe doit contenir au moins 6 caractères.';
        }
        const password = document.getElementById('password').value;
        if (password.length < 6) {
            isValid = false;
            document.getElementById('passwordError').textContent = 'Le mot de passe doit contenir au moins 6 caractères.';
        }

        if (isValid) {
            // Si toutes les validations passent, soumettre le formulaire
            this.submit();
        }
    });