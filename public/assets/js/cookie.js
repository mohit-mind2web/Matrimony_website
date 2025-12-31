document.addEventListener('DOMContentLoaded', function () {
    var banner = document.getElementById('cookiebanner');
    var acceptbtn = document.getElementById('acceptcookies');
    var declinebtn = document.getElementById('declinecookies');

    if (!banner) {
        console.error('Cookie banner element not found in DOM');
        return;
    }
    var consent = localStorage.getItem('cookieconsent');
    if (!consent) {
        banner.style.display = 'flex';  
    } else {
        banner.style.display = 'none';
    }
    if (acceptbtn) {
        acceptbtn.addEventListener('click', function () {
            localStorage.setItem('cookieconsent', 'accept');
            banner.style.display = 'none';
            console.log('Cookies accepted');
        });
    }
    if (declinebtn) {
        declinebtn.addEventListener('click', function () {
            localStorage.setItem('cookieconsent', 'decline');
            banner.style.display = 'none';
            console.log('Cookies declined');
        });
    }
});
