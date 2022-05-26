/*
Give the service worker access to Firebase Messaging.
Note that you can only use Firebase Messaging here, other Firebase libraries are not available in the service worker.
*/
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-messaging.js');

/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
* New configuration for app@pulseservice.com
*/
firebase.initializeApp({
    apiKey: "AIzaSyCSxzVlRUiwuFm5WGfyFdNW1jsJkmKc_JM",
    authDomain: "laravelnotificationfcm.firebaseapp.com",
    projectId: "laravelnotificationfcm",
    storageBucket: "laravelnotificationfcm.appspot.com",
    messagingSenderId: "817845056777",
    appId: "1:817845056777:web:faae8224030fc1cb4ccfd8",
    measurementId: "G-7S8ZDVCEML",
    databaseURL: "https://itdemo-push-notification.firebaseio.com",
    // measurementId: "G-R1KQTR3JBN"
});

/*
Retrieve an instance of Firebase Messaging so that it can handle background messages.
*/
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function (payload) {
    console.log(
        "[firebase-messaging-sw.js] Received background message ",
        payload,
    );
    // Customize notification here
    const notificationTitle = "Background Message Title";
    const notificationOptions = {
        body: "Background Message body.",
        icon: "/itwonders-web-logo.png",
    };

    return self.registration.showNotification(
        notificationTitle,
        notificationOptions,
    );
});
