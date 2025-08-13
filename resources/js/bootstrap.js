import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

//reverb setup
import Echo from 'laravel-echo';
import Reverb from '@reverb/reverb-js';

window.reverb = new Reverb({
    host: import.meta.env.VITE_REVERB_HOST,
    port: Number(import.meta.env.VITE_REVERB_PORT),
    scheme: import.meta.env.VITE_REVERB_SCHEME,
    key: import.meta.env.VITE_REVERB_APP_KEY,
});

window.Echo = new Echo({
    broadcaster: 'reverb',
    client: window.reverb
});

// Mendengarkan channel chat
window.Echo.channel('chat.' + window.currentChatId)
    .listen('MessageSent', (e) => {
        console.log('New message:', e.message);
    });

// Reverb connection events
window.reverb.on('connect', () => console.log('✅ Reverb connected'));
window.reverb.on('disconnect', () => console.log('⚠️ Reverb disconnected'));
window.reverb.on('error', (err) => console.error('Reverb error:', err));

// Optional: listen notifications
window.Echo.private('App.Models.User.' + window.userId)
    .notification((notification) => console.log('New notification:', notification));


