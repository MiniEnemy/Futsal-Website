function validate() {
    var fnameValid = checkField('fname');
    var lnameValid = checkField('lname');
    var emailValid = checkEmail();
    var phoneValid = checkField('no');
    var usernameValid = checkField('user');
    var passwordValid = checkPassword();
    var confirmPasswordValid = checkConfirmPassword();

    return fnameValid && lnameValid && emailValid && phoneValid && usernameValid && passwordValid && confirmPasswordValid;
}

function checkField(fieldName) {
    var input = document.getElementById(fieldName);
    var errorElement = document.getElementById(fieldName + 'Error');
    var inputText = input.value.trim();

    if (inputText === "") {
        errorElement.innerText = "This field is required";
        return false;
    } else {
        errorElement.innerText = "";
        return true;
    }
}

function checkEmail() {
    var emailInput = document.getElementById('email');
    var emailError = document.getElementById('emailError');
    var inputText = emailInput.value;
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

    if (inputText.match(mailformat) || inputText === "") {
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

    if (password.length >= 8 || password === "") {
        passwordError.innerText = password.length >= 8 ? "Password strength: Strong" : "";
        return true;
    } else {
        passwordError.innerText = "Password strength: Weak (at least 8 characters required)";
        return false;
    }
}

function checkConfirmPassword() {
    var passwordInput = document.getElementById('pass');
    var confirmPasswordInput = document.getElementById('cnfpass');
    var confirmPasswordError = document.getElementById('cnfpassError');
    var confirmPassword = confirmPasswordInput.value;

    if (confirmPassword === passwordInput.value || confirmPassword === "") {
        confirmPasswordError.innerText = "";
        return true;
    } else {
        confirmPasswordError.innerText = "Passwords do not match";
        return false;
    }
}
