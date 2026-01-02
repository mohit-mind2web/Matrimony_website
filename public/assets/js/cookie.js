document.addEventListener('DOMContentLoaded', function () {
    var banner = document.getElementById('cookiebanner');
    var acceptbtn = document.getElementById('acceptcookies');
    var declinebtn = document.getElementById('declinecookies');

    if (!banner) {
        console.error('Cookie banner element not found in DOM');
        return;
    }
    var userId = banner.getAttribute('user-id');
    if (!userId) {
        console.error('User ID not set on cookie banner element');
        return;
    }

    var consentkey = 'cookieconsent_user_' + userId;
    var consent = localStorage.getItem(consentkey);
    if (!consent) {
        banner.style.display = 'flex';
    } else {
        banner.style.display = 'none';
    }
    if (acceptbtn) {
        acceptbtn.addEventListener('click', function () {
            localStorage.setItem(consentkey, 'accept');
            banner.style.display = 'none';
            console.log('Cookies accepted');
        });
    }
    if (declinebtn) {
        declinebtn.addEventListener('click', function () {
            localStorage.setItem(consentkey, 'decline');
            banner.style.display = 'none';
            console.log('Cookies declined');
        });
    }
});
