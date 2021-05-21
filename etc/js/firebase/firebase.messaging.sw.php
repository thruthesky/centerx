<?php
header("Content-Type: application/javascript");
header("Cache-Control: max-age=604800, public");
const STOP_LIVE_RELOAD = false;
require_once '../../../boot.php';
?>
/** Import google libraries */
importScripts("https://www.gstatic.com/firebasejs/8.6.1/firebase-app.js");
importScripts("https://www.gstatic.com/firebasejs/8.6.1/firebase-messaging.js");

/** Your web app's Firebase configuration
* Copy from Login
*      Firebase Console -> Select Projects From Top Navigation
*      -> Left Side bar -> Project Overview -> Project Settings
*      -> General -> Scroll Down and Choose CDN for all the details
*/
var firebaseConfig = <?php echo FIREBASE_SDK_ADMIN_KEY?>;

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
<?php exit();