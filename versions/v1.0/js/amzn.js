window.onAmazonLoginReady = function() {
    amazon.Login.setClientId('amzn1.application-oa2-client.269ef1cfdcf448a5baca31d0cd310676');
};

(function(d) {
    var a = d.createElement('script');
    a.type = 'text/javascript';
    a.async = true;
    a.id = 'amazon-login-sdk';
    a.src = 'https://api-cdn.amazon.com/sdk/login1.js';
    d.getElementById('amazon-root').appendChild(a);
})(document);

$('#LoginWithAmazon').click(function() {
    options = {
        scope: 'profile',
        popup: false,
        response_type: 'token'
    };

    amazon.Login.authorize(options, 'https://vertretungsplan.alexa.146programming.de/handle_login_pre');

    return false;
});

$('#Logout').click(function() {
    amazon.Login.logout();
    document.cookie = "token=";
    document.cookie = "user_id=";

    if (gapi.auth2 != undefined){
        var auth2 = gapi.auth2.getAuthInstance();
        auth2.signOut().then(function() {
            console.log('User signed out.');
        });
    }


    location.reload();
});

function getCookie(name) {
    var value = "; " + document.cookie;
    var parts = value.split("; " + name + "=");
    if (parts.length == 2) return parts.pop().split(";").shift();
}

function onSignIn(googleUser) {
    var profile = googleUser.getBasicProfile();
    var id_token = googleUser.getAuthResponse().id_token;
    console.log('token', id_token);
    console.log('Name: ' + profile.getName());
    console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.

    if ( $('body').hasClass('logged_in') ){
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'https://vertretungsplan.alexa.146programming.de/gauth/gauthHandle.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        var jsonResponse = JSON.parse(xhr.responseText);
        console.log(jsonResponse);
        if (jsonResponse.status == 200) {
            document.cookie = "token=" + jsonResponse.token;
            document.cookie = "user_id=" + jsonResponse.user_id;
            location.reload();
        }
    };
    xhr.send("id_token=" + id_token);
}

function getHash() {
    var buf = new Uint8Array(512);
    window.crypto.getRandomValues(buf);
    var out = "";
    for (var i = 0; i < buf.length; i++) {
        var c = buf[i].toString(16);
        out += c;
    }
    return out;
}

function gAPIDidLoad(){
    if (gapi == undefined){
        return;
    }

    gapi.load('client:auth2', {
        callback: function() {
            // Handle gapi.client initialization.
            gapi.auth2.init({
                client_id: '282504638010-tsccvq2298o6nhektmpdk1pfult4sjkd.apps.googleusercontent.com'
            })
        },
        onerror: function() {
            // Handle loading error.
            alert('gapi.client failed to load!');
        },
        timeout: 5000, // 5 seconds.
        ontimeout: function() {
            // Handle timeout.
            alert('gapi.client could not load in a timely manner!');
        }
    });

    renderButton()

}

function renderButton() {
      gapi.signin2.render('google-button', {
        'scope': 'profile email',
        'width': 250,
        'height': 50,
        'longtitle': true,
        'theme': 'dark',
        'onsuccess': onSignIn,
        'onfailure': null
      });
    }
