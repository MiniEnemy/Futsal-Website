// Your existing JavaScript code remains unchanged

// Additional functions for opening and closing the login popup
function schedule() {
    // Specify the path to the local HTML file
    var localWebsitePath = "/booking/booking.html"; // Replace with the actual path
    window.open(localWebsitePath, '_blank');
}
function openLogin() {
    document.getElementById('loginOverlay').style.display = 'flex';
}

function closeLogin() {
    document.getElementById('loginOverlay').style.display = 'none';
}

document.addEventListener('contextmenu', function (e) {
    e.preventDefault();
});

document.addEventListener('mousedown', function (e) {
    if (e.button === 0) {
        e.preventDefault(); // Disable left-click
    }
});