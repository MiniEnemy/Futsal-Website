function validate() {
    // Clear previous error messages
    document.querySelectorAll('.error').forEach(element => element.textContent = "");

    // Basic field validation
    const fields = {
        fname: {
            errorElement: document.getElementById('fnameError'),
            validator: value => !!value.trim() || 'First name is required'
        },
        lname: {
            errorElement: document.getElementById('lnameError'),
            validator: value => !!value.trim() || 'Last name is required'
        },
        email: {
            errorElement: document.getElementById('emailError'),
            validator: value => isEmailValid(value) || 'Invalid email format'
        },
        no: {
            errorElement: document.getElementById('phoneError'),
            validator: value => !!value.trim
        }
    }
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
        return false;
    }
}

function checkEmail() {
    var emailInput = document.getElementById('mail');
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
