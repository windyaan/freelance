import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

//reverb setup
import Echo from 'laravel-echo';

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST ?? window.location.hostname,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

// // Mendengarkan channel chat
// window.Echo.channel('chat.' + window.currentChatId)
//     .listen('MessageSent', (e) => {
//         console.log('New message:', e.message);
//     });

// // Optional: listen notifications
// window.Echo.private('App.Models.User.' + window.userId)
//     .notification((notification) => console.log('New notification:', notification));

// ✅ Listen notifications secara global (setiap user login)
if (window.userId) {
    window.Echo.private(`App.Models.User.${window.userId}`)
        .notification((notification) => {
            console.log('🔔 New notification:', notification);
        });
}

// ✅ Listen chat kalau sedang di halaman chat
if (window.currentChatId) {
    window.Echo.private(`chat.${window.currentChatId}`)
        .listen('.MessageSent', (e) => {
            console.log('💬 New message:', e.message);

            // contoh update DOM
            let box = document.getElementById('chat-box');
            if (box) {
                box.innerHTML += `<p><strong>${e.message.sender.name}:</strong> ${e.message.content}</p>`;
            }
        });
    }

