importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
   
firebase.initializeApp({
    apiKey: "AIzaSyCbOd2CRTQJnMT8dHsmOGWuADGcDPIl_iw",
 
    projectId: "laravel-push-fae18",
 
    messagingSenderId: "179442027857",
    appId: "1:179442027857:web:77e5dd372f51d5788c9770"
  
 
});
  
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function({data:{title,body,icon}}) {
    return self.registration.showNotification(title,{body,icon});
}); 