/** Your web app's Firebase configuration
 * Copy from Login
 *      Firebase Console -> Select Projects From Top Naviagation
 *      -> Left Side bar -> Project Overview -> Project Settings
 *      -> General -> Scroll Down and Choose CDN for all the details
 */

// Initialize Firebase
firebase.initializeApp(config.firebaseConfig);

/**
 * We can start messaging using messaging() service with firebase object
 */
var messaging = firebase.messaging();

/** Register your service worker here
 *  It starts listening to incoming push notifications from here
 */
navigator.serviceWorker.register(config.themeFolderName + '/firebase-messaging-sw.js')
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
                        app.saveToken(token, config.defaultTopic);
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
            app.saveToken(renewedToken, config.defaultTopic);
            /** UPDATE TOKEN::From here you need to store the TOKEN by AJAX request to your server */
        })
        .catch(function(error) {
            /** If some error happens while fetching the token then handle here */
            console.log('Error in fetching refreshed token ' + error);
        });
});

// Handle incoming messages
messaging.onMessage(function(payload) {
    // const notificationTitle = 'Data Message Title';
    // const notificationOptions = {
    //     body: 'Data Message body',
    //     icon: 'https://c.disquscdn.com/uploads/users/34896/2802/avatar92.jpg',
    //     image: 'https://c.disquscdn.com/uploads/users/34896/2802/avatar92.jpg'
    // };
    console.log('onMessage::',payload);
    console.log('app.$data.user::',app.$data.user);
    const notification = payload.notification;
    const data = payload.data ? payload.data : {};
    if (app.loggedIn() && app.$data.user.ID === data['sender']) return;
    app.alert(notification.title,notification.body);
});