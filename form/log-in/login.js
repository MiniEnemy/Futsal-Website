function validate() {
    var username = document.getElementById('username').value;
    var password = document.getElementById('pass').value;
    var usernameError = document.getElementById('usernameError'); // why?
    var passwordError = document.getElementById('passwordError');

    usernameError.innerText = ""; //why?
    passwordError.innerText = "";

    if (username === "") {
        usernameError.innerText = "Please enter your username";
        return false;
    } else if (password === "") {
        passwordError.innerText = "Please enter your password";
        return false;
    }
    return true;
}