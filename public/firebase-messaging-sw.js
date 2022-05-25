/*
Give the service worker access to Firebase Messaging.
Note that you can only use Firebase Messaging here, other Firebase libraries are not available in the service worker.
*/
importScripts("https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js");
importScripts(
    "https://www.gstatic.com/firebasejs/7.23.0/firebase-messaging.js"
);

/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
* New configuration for app@pulseservice.com
*/
firebase.initializeApp({
    apiKey: "AIzaSyCrV8YcSzsDF7KXJiBOk-ts3ScJyYMfVKk",
    authDomain: "larafirepush-388bc.firebaseapp.com",
    projectId: "larafirepush-388bc",
    storageBucket: "larafirepush-388bc.appspot.com",
    messagingSenderId: "541231733578",
    appId: "1:541231733578:web:5a69fcab4a736119c3bfb3",
    measurementId: "XG-W2QWT7GMF6XX",
});

/*
Retrieve an instance of Firebase Messaging so that it can handle background messages.
*/
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function (payload) {
    console.log(
        "[firebase-messaging-sw.js] Received background message ",
        payload
    );
    /* Customize notification here */
    const notificationTitle = "Background Message Title";
    const notificationOptions = {
        body: "Background Message body.",
        icon: "/itwonders-web-logo.png",
    };

    return self.registration.showNotification(
        notificationTitle,
        notificationOptions
    );
});
