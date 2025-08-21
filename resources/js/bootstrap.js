import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

//reverb setup
import Echo from 'laravel-echo';

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY || '28n3qjbanvuelp4nqaoh',
    wsHost: import.meta.env.VITE_REVERB_HOST || window.location.hostname,
    wsPort: import.meta.env.VITE_REVERB_PORT || 8080,
    wssPort: import.meta.env.VITE_REVERB_PORT || 8080,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME || 'http') === 'https',
    enabledTransports: ['ws', 'wss'],
});

// ✅ Listen notifications secara global (setiap user login)
if (window.userId) {
    window.Echo.private(`App.Models.User.${window.userId}`)
        .notification((notification) => {
            console.log('🔔 New notification:', notification);
        });
}

// Listener chat realtime
if (window.currentChatId) {
    window.Echo.private(`chat.${window.currentChatId}`)
        .listen('MessageSent', (e) => {
            console.log('💬 New message:', e.message);

            // update DOM (pastikan e.message.sender_name ada)
            const box = document.getElementById('chatMessages');
            if (box) {
                box.innerHTML += `<p><strong>${e.message.sender_name}:</strong> ${e.message}</p>`;
                box.scrollTop = box.scrollHeight; // auto scroll ke bawah
            }
        });
    }


/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import './echo';
