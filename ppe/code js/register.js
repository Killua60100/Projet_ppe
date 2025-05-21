
document.getElementById('registerForm').addEventListener('submit', function(event) {
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirmPassword').value;
    
    if (password !== confirmPassword) {
        event.preventDefault();
        alert("Les mots de passe ne correspondent pas.");
    }
});

function acceptCookies() {
    document.querySelector('.cookie-banner').style.display = 'none';
}

function rejectCookies() {
    document.querySelector('.cookie-banner').style.display = 'none';
}

function openCookieSettings() {
    alert("Ouverture de la politique des cookies");
}