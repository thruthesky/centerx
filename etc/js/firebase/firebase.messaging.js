
/** Again import google libraries */
importScripts("https://www.gstatic.com/firebasejs/8.6.1/firebase-app.js");
importScripts("https://www.gstatic.com/firebasejs/8.6.1/firebase-messaging.js");

/** Your web app's Firebase configuration
 * Copy from Login
 *      Firebase Console -> Select Projects From Top Navigation
 *      -> Left Side bar -> Project Overview -> Project Settings
 *      -> General -> Scroll Down and Choose CDN for all the details
 */
var firebaseConfig =  {
    apiKey: "AIzaSyDWiVaWIIrAsEP-eHq6bFBY09HLyHHQW2U",
    authDomain: "sonub-version-2020.firebaseapp.com",
    databaseURL: "https://sonub-version-2020.firebaseio.com",
    projectId: "sonub-version-2020",
    storageBucket: "sonub-version-2020.appspot.com",
    messagingSenderId: "446424199137",
    appId: "1:446424199137:web:f421c562ba0a35ac89aca0",
    measurementId: "G-F86L9641ZQ"
};
// Initialize Firebase
firebase.initializeApp(firebaseConfig);
// Retrieve an instance of Firebase Data Messaging so that it can handle background messages.
const messaging = firebase.messaging();

/** THIS IS THE MAIN WHICH LISTENS IN BACKGROUND */
messaging.setBackgroundMessageHandler(function(payload) {
    const notificationTitle = 'BACKGROUND MESSAGE TITLE';
    const notificationOptions = {
        body: 'Data Message body',
        icon: 'https://c.disquscdn.com/uploads/users/34896/2802/avatar92.jpg',
        image: 'https://c.disquscdn.com/uploads/users/34896/2802/avatar92.jpg'
    };

    return self.registration.showNotification(notificationTitle, notificationOptions);
});