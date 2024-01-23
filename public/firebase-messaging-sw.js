/*
Give the service worker access to Firebase Messaging.
Note that you can only use Firebase Messaging here, other Firebase libraries are not available in the service worker.
*/
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
   
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
* New configuration for app@pulseservice.com
*/
firebase.initializeApp({
    apiKey: "AIzaSyBzypNw6h62u-IOCnyBobMPfBVOzbeez_4",
    authDomain: "crypto-da28a.firebaseapp.com",
    databaseURL: "https://crypto-da28a-default-rtdb.asia-southeast1.firebasedatabase.app",
    projectId: "crypto-da28a",
    storageBucket: "crypto-da28a.appspot.com",
    messagingSenderId: "873556556575",
    appId: "1:873556556575:web:6dcf8f681a301bfb1bce2a",
    measurementId: "G-851JLKQ5K5"
});
  
/*
Retrieve an instance of Firebase Messaging so that it can handle background messages.
*/
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
    console.log("Message received.", payload);
    const title = "Hello world is awesome";
    const options = {
        body: "Your notificaiton message .",
        icon: "/firebase-logo.png",
    };
    return self.registration.showNotification(
        title,
        options,
    );
});