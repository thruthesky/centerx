/** Again import google libraries */
importScripts("https://www.gstatic.com/firebasejs/8.6.5/firebase-app.js");
importScripts("https://www.gstatic.com/firebasejs/8.6.5/firebase-messaging.js");

// importScripts("https://www.gstatic.com/firebasejs/9.0.0-beta.7/firebase-app.js");
// importScripts("https://www.gstatic.com/firebasejs/9.0.0-beta.7/firebase-messaging.js");

/** Your web app's Firebase configuration
 * Copy from Login
 *      Firebase Console -> Select Projects From Top Naviagation
 *      -> Left Side bar -> Project Overview -> Project Settings
 *      -> General -> Scroll Down and Choose CDN for all the details
 */
var config = {
  apiKey: "AIzaSyDWiVaWIIrAsEP-eHq6bFBY09HLyHHQW2U",
  authDomain: "sonub-version-2020.firebaseapp.com",
  databaseURL: "https://sonub-version-2020.firebaseio.com",
  projectId: "sonub-version-2020",
  storageBucket: "sonub-version-2020.appspot.com",
  messagingSenderId: "446424199137",
  appId: "1:446424199137:web:f421c562ba0a35ac89aca0",
  measurementId: "G-F86L9641ZQ",
};
firebase.initializeApp(config);

// Retrieve an instance of Firebase Data Messaging so that it can handle background messages.
const messaging = firebase.messaging();

/** THIS IS THE MAIN WHICH LISTENS IN BACKGROUND */
messaging.setBackgroundMessageHandler(function (payload) {
  const notificationTitle = "BACKGROUND MESSAGE TITLE";
  const notificationOptions = {
    body: "Data Message body",
    icon: "https://c.disquscdn.com/uploads/users/34896/2802/avatar92.jpg",
    image: "https://c.disquscdn.com/uploads/users/34896/2802/avatar92.jpg",
  };

  return self.registration.showNotification(notificationTitle, notificationOptions);
});
