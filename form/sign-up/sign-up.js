function validate() {
    var emailValid = checkEmail();
    var passwordValid = checkPassword();
    if (emailValid && passwordValid) {
        return true;
    } else {
        return false;
    }
}
function checkEmail() {
    var emailInput = document.getElementById('email');
    var emailError = document.getElementById('emailError');
    var inputText = emailInput.value;
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

    if (inputText.match(mailformat)) {
        emailError.innerText = "";
        return true;
    } else {
        emailError.innerText = "Invalid email format";
        return false;
    }
}

function checkPassword() {
    var passwordInput = document.getElementById('pass');
    var passwordError = document.getElementById('passwordError');
    var password = passwordInput.value;
    if (password.length >= 8) {
        passwordError.innerText = "Password strength: Strong";
        return true;
    } else {
        passwordError.innerText = "Password strength: Weak (at least 8 characters required)";
        return false;
    }
}
