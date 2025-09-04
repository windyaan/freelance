import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

// window.Echo.channel("user." + userId) // userId = ID user login (dari Blade)
//     .listen(".notification.created", (e) => {
//         console.log("New Notification:", e.notification);
//         // bisa update UI, tampilkan toast, dl
//         });

//notifikasi untuk offer diterima
window.Echo.private("user." + window.Laravel.userId)
    .listen(".NotificationCreated", (e) => {
        console.log("📩 New Notification:", e.notification);

        // contoh update badge notifikasi
        let badge = document.getElementById("notif-badge");
        if (badge) {
            let count = parseInt(badge.innerText) || 0;
            badge.innerText = count + 1;
        }
    });

//notifikasi untuk pesan baru
window.Echo.private("notifications." + window.Laravel.userId)
    .listen(".NotificationSent", (e) => {
        console.log("💌 Message Notification:", e);

        // contoh update badge pesan
        let badge = document.getElementById("message-badge");
        if (badge) {
            let count = parseInt(badge.innerText) || 0;
            badge.innerText = count + 1;
        }

        // bisa juga trigger popup/toast
        // alert("Pesan baru dari " + e.sender_name);
    });
