function schedule() {
    var localWebsitePath = "/booking/booking.html"; 
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
        e.preventDefault(); 
    }
});