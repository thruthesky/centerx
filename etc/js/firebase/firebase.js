/** Your web app's Firebase configuration
 * Copy from Login
 *      Firebase Console -> Select Projects From Top Naviagation
 *      -> Left Side bar -> Project Overview -> Project Settings
 *      -> General -> Scroll Down and Choose CDN for all the details
 */

/**
 * We can start messaging using messaging() service with firebase object
 */
var messaging = firebase.messaging();

/** Register your service worker here
 *  It starts listening to incoming push notifications from here
 */
navigator.serviceWorker.register('/etc/js/firebase/firebase.messaging.sw.php')
    .then(function (registration) {

        /** Since we are using our own service worker ie firebase-messaging-sw.js file */
        messaging.useServiceWorker(registration);

        /** Lets request user whether we need to send the notifications or not */
        messaging.requestPermission()
            .then(function () {
                /** Standard function to get the token */
                messaging.getToken()
                    .then(function(token) {
                        /** Here I am logging to my console. This token I will use for testing with PHP Notification */
                        console.log("Token", token);
                        if(localStorage.pushToken === token) return;
                        saveToken(token, location.hostname);
                        localStorage.setItem("pushToken", token);
                        /** SAVE TOKEN::From here you need to store the TOKEN by AJAX request to your server */
                    })
                    .catch(function(error) {
                        /** If some error happens while fetching the token then handle here */
                        // updateUIForPushPermissionRequired();
                        console.log('Error while fetching the token ' + error);
                    });
            })
            .catch(function (error) {
                /** If user denies then handle something here */
                console.log('Permission denied ' + error);
            })
    })
    .catch(function (e) {
        console.log('Error in registering service worker::', e);
    });

/** What we need to do when the existing token refreshes for a user */
messaging.onTokenRefresh(function() {
    messaging.getToken()
        .then(function(renewedToken) {
            if(localStorage.pushToken === renewedToken) return;
            saveToken(renewedToken, location.hostname);
            localStorage.setItem("pushToken", renewedToken);
            /** UPDATE TOKEN::From here you need to store the TOKEN by AJAX request to your server */
        })
        .catch(function(error) {
            /** If some error happens while fetching the token then handle here */
            console.log('Error in fetching refreshed token ' + error);
        });
});

// Handle incoming messages
messaging.onMessage(function(payload) {
    // console.log('onMessage::',payload);
    // console.log('loginIdx()::',loginIdx());
    const notification = payload.notification;
    const data = payload.data ? payload.data : {};
    if (loginIdx() === data['senderIdx']) return;
    alert(notification.title + "\n" +notification.body);
});