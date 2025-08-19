@extends('layouts.app')

@section('title', 'Chat - SkillMatch')

@section('page-title', 'Chat')

@section('navigation')
    <a href="{{ route(auth()->user()->role . '.dashboard') }}" class="nav-item">
        <div class="nav-icon">
            <iconify-icon icon="material-symbols:dashboard"></iconify-icon>
        </div>
        <span class="nav-text">Dashboard</span>
    </a>
    
    <a href="{{ route(auth()->user()->role . '.chat') }}" class="nav-item active">
        <div class="nav-icon">
            <iconify-icon icon="material-symbols:chat"></iconify-icon>
        </div>
        <span class="nav-text">Chat</span>
        <span class="nav-badge">3</span>
    </a>
    
    <a href="{{ route(auth()->user()->role . '.order') }}" class="nav-item {{ request()->routeIs(auth()->user()->role . '.order*') ? 'active' : '' }}">
        <div class="nav-icon">
            <iconify-icon icon="material-symbols:list-alt"></iconify-icon>
        </div>
        <span class="nav-text">Order</span>
    </a>

   
@endsection

@section('navbar-center')
    <div class="search-container">
        <iconify-icon icon="material-symbols:search" class="search-icon"></iconify-icon>
        <input type="text" class="search-input" placeholder="Search conversations..." id="globalSearch">
        <button class="search-btn" id="searchBtn">Search</button>
    </div>
@endsection

@push('styles')
<style>
/* Chat-specific styles */
.chat-container {
    display: flex;
    height: calc(100vh - var(--navbar-height));
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-light);
}

/* Chat Sidebar */
.chat-sidebar {
    width: 350px;
    background: white;
    border-right: 1px solid var(--border-color);
    display: flex;
    flex-direction: column;
    flex-shrink: 0;
}

.chat-sidebar-header {
    padding: 2rem 1.5rem 1rem 1.5rem;
    border-bottom: 1px solid var(--border-light);
    background: var(--bg-muted);
}

.chat-sidebar-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.chat-sidebar-subtitle {
    font-size: 0.85rem;
    color: var(--text-secondary);
}

.chat-list {
    flex: 1;
    overflow-y: auto;
    padding: 0.5rem 0;
}

.chat-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem 1.5rem;
    cursor: pointer;
    transition: all 0.2s ease;
    border-left: 3px solid transparent;
}

.chat-item:hover {
    background: var(--bg-secondary);
}

.chat-item.active {
    background: #f0fdfc;
    border-left-color: var(--primary-color);
}

.chat-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0;
    border: 2px solid var(--border-light);
}

.chat-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.chat-info {
    flex: 1;
    min-width: 0;
}

.chat-name {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
    font-size: 0.95rem;
}

.chat-preview {
    font-size: 0.8rem;
    color: var(--text-secondary);
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin-bottom: 0.75rem;
}

.chat-skills {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.chat-skill-tag {
    background: #e0f7ff;
    color: #0891b2;
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    font-size: 0.65rem;
    font-weight: 500;
    border: 1px solid #b3e5fc;
}

/* Chat Main Area */
.chat-main {
    flex: 1;
    display: flex;
    flex-direction: column;
    background: white;
    min-width: 0;
}

.chat-header {
    padding: 1.5rem 2rem;
    border-bottom: 1px solid var(--border-color);
    background: white;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.chat-header-avatar {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    overflow: hidden;
    border: 2px solid var(--border-color);
}

.chat-header-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.chat-header-info {
    flex: 1;
}

.chat-header-name {
    font-weight: 600;
    color: var(--text-primary);
    font-size: 1.1rem;
    margin-bottom: 0.25rem;
}

.chat-header-status {
    font-size: 0.85rem;
    color: var(--text-secondary);
}

/* Chat Messages */
.chat-messages {
    flex: 1;
    overflow-y: auto;
    padding: 1.5rem 2rem;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    background: var(--bg-secondary);
}

.message {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    max-width: 75%;
}

.message.sent {
    align-self: flex-end;
    flex-direction: row-reverse;
}

.message.received {
    align-self: flex-start;
}

.message-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0;
    border: 1px solid var(--border-color);
}

.message-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.message-content {
    background: white;
    padding: 1rem 1.25rem;
    border-radius: 18px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    border: 1px solid var(--border-light);
    position: relative;
    word-wrap: break-word;
    line-height: 1.5;
}

.message.sent .message-content {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.message.received .message-content {
    background: white;
    color: var(--text-primary);
}

.message-time {
    font-size: 0.7rem;
    color: var(--text-muted);
    margin-top: 0.5rem;
    text-align: center;
}

.message.sent .message-time {
    color: rgba(255, 255, 255, 0.8);
}

/* Chat Input */
.chat-input-container {
    padding: 1.5rem 2rem;
    border-top: 1px solid var(--border-color);
    background: white;
}

.chat-input-wrapper {
    display: flex;
    align-items: flex-end;
    gap: 1rem;
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    border-radius: 16px;
    padding: 0.75rem;
    transition: all 0.3s ease;
}

.chat-input-wrapper:focus-within {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(56, 193, 185, 0.1);
}

.chat-input {
    flex: 1;
    border: none;
    background: transparent;
    padding: 0.5rem;
    font-size: 0.9rem;
    color: var(--text-primary);
    resize: none;
    outline: none;
    min-height: 44px;
    max-height: 120px;
    line-height: 1.5;
    font-family: inherit;
}

.chat-input::placeholder {
    color: var(--text-muted);
}

.chat-send-btn {
    background: var(--primary-color);
    color: white;
    border: none;
    border-radius: 12px;
    padding: 0.75rem;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    flex-shrink: 0;
}

.chat-send-btn:hover {
    background: var(--primary-hover);
    transform: scale(1.05);
}

.chat-send-btn:disabled {
    background: #cbd5e1;
    cursor: not-allowed;
    transform: none;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .chat-container {
        flex-direction: column;
        height: calc(100vh - var(--navbar-height) - 2rem);
    }
    
    .chat-sidebar {
        width: 100%;
        height: 200px;
        border-right: none;
        border-bottom: 1px solid var(--border-color);
    }
    
    .chat-main {
        height: calc(100% - 200px);
    }
    
    .message {
        max-width: 85%;
    }
    
    .chat-messages {
        padding: 1rem;
    }
    
    .chat-input-container {
        padding: 1rem;
    }
}

@media (max-width: 640px) {
    .chat-sidebar {
        height: 160px;
    }
    
    .chat-main {
        height: calc(100% - 160px);
    }
    
    .message {
        max-width: 90%;
    }
}

/* Scrollbar Styling */
.chat-messages::-webkit-scrollbar,
.chat-list::-webkit-scrollbar {
    width: 6px;
}

.chat-messages::-webkit-scrollbar-track,
.chat-list::-webkit-scrollbar-track {
    background: var(--border-light);
}

.chat-messages::-webkit-scrollbar-thumb,
.chat-list::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

.chat-messages::-webkit-scrollbar-thumb:hover,
.chat-list::-webkit-scrollbar-thumb:hover {
    background: var(--text-muted);
}
</style>
@endpush

@section('content')
<div class="chat-container">
    <!-- Chat Sidebar -->
    <div class="chat-sidebar">
        <div class="chat-sidebar-header">
            <h2 class="chat-sidebar-title">Messages</h2>
            <p class="chat-sidebar-subtitle">Recent conversations</p>
        </div>
        
        <div class="chat-list" id="chatList">
            <!-- Chat Item 1 -->
            <div class="chat-item active" data-chat-id="1" data-user-name="Nadia Irma">
                <div class="chat-avatar">
                    <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?w=50&h=50&fit=crop&crop=face" alt="Nadia Irma">
                </div>
                <div class="chat-info">
                    <div class="chat-name">Nadia Irma</div>
                    <div class="chat-preview">Baik Ibu, saya menghendaki 1 bulan untuk desainnya, sekaligus saya buatkan form penawarannya</div>
                    <div class="chat-skills">
                        <span class="chat-skill-tag">UI Design</span>
                        <span class="chat-skill-tag">Front-End</span>
                    </div>
                </div>
            </div>
            
            <!-- Chat Item 2 -->
            <div class="chat-item" data-chat-id="2" data-user-name="Tiara Hasna">
                <div class="chat-avatar">
                    <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=50&h=50&fit=crop&crop=face" alt="Tiara Hasna">
                </div>
                <div class="chat-info">
                    <div class="chat-name">Tiara Hasna</div>
                    <div class="chat-preview">Bisa Bu, untuk jasa fullstacknya saya tawarkan diskon 10%</div>
                    <div class="chat-skills">
                        <span class="chat-skill-tag">Back-End</span>
                        <span class="chat-skill-tag">Fullstack</span>
                    </div>
                </div>
            </div>
            
            <!-- Chat Item 3 -->
            <div class="chat-item" data-chat-id="3" data-user-name="Karina Carlo">
                <div class="chat-avatar">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=50&h=50&fit=crop&crop=face" alt="Karina Carlo">
                </div>
                <div class="chat-info">
                    <div class="chat-name">Karina Carlo</div>
                    <div class="chat-preview">Ini nih Bu untuk logo cafe dan toko pakaiannnya</div>
                    <div class="chat-skills">
                        <span class="chat-skill-tag">Graphic Design</span>
                        <span class="chat-skill-tag">Illustrator</span>
                    </div>
                </div>
            </div>
            
            <!-- Chat Item 4 -->
            <div class="chat-item" data-chat-id="4" data-user-name="Erma Nadila">
                <div class="chat-avatar">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=50&h=50&fit=crop&crop=face" alt="Erma Nadila">
                </div>
                <div class="chat-info">
                    <div class="chat-name">Erma Nadila</div>
                    <div class="chat-preview">saya mau editannya nuansa ungu ya mbak</div>
                    <div class="chat-skills">
                        <span class="chat-skill-tag">Illustrator</span>
                        <span class="chat-skill-tag">Video Editor</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Chat Main Area -->
    <div class="chat-main">
        <!-- Active Chat Header -->
        <div class="chat-header" id="chatHeader">
            <div class="chat-header-avatar">
                <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?w=45&h=45&fit=crop&crop=face" alt="Nadia Irma" id="headerAvatar">
            </div>
            <div class="chat-header-info">
                <div class="chat-header-name" id="headerName">Nadia Irma</div>
                <div class="chat-header-status" id="headerStatus">Online • UI Design, Front-End</div>
            </div>
        </div>
        
        <!-- Chat Messages -->
        <div class="chat-messages" id="chatMessages">
            <!-- Sample messages for Nadia Irma -->
            <div class="message received">
                <div class="message-avatar">
                    <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?w=36&h=36&fit=crop&crop=face" alt="Nadia Irma">
                </div>
                <div class="message-content">
                    Halo Bu, terima kasih sudah menghubungi saya untuk proyek UI Design website cafe.
                    <div class="message-time">10:30 AM</div>
                </div>
            </div>
            
            <div class="message sent">
                <div class="message-avatar">
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=36&h=36&fit=crop&crop=face" alt="You">
                </div>
                <div class="message-content">
                    Halo Nadia, saya perlu desain untuk website cafe dan juga toko pakaian. Kira-kira berapa lama pengerjaannya?
                    <div class="message-time">10:32 AM</div>
                </div>
            </div>
            
            <div class="message received">
                <div class="message-avatar">
                    <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?w=36&h=36&fit=crop&crop=face" alt="Nadia Irma">
                </div>
                <div class="message-content">
                    Baik Ibu, saya menghendaki 1 bulan untuk desainnya, sekaligus saya buatkan form penawarannya. Untuk 2 website, saya tawarkan harga Rp 8.500.000
                    <div class="message-time">10:35 AM</div>
                </div>
            </div>
            
            <div class="message sent">
                <div class="message-avatar">
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=36&h=36&fit=crop&crop=face" alt="You">
                </div>
                <div class="message-content">
                    Oke, bisa tolong kirimkan portfolionya dulu?
                    <div class="message-time">10:36 AM</div>
                </div>
            </div>
        </div>
        
        <!-- Chat Input -->
        <div class="chat-input-container">
            <div class="chat-input-wrapper">
                <textarea class="chat-input" id="messageInput" placeholder="Type your message..." rows="1"></textarea>
                <button class="chat-send-btn" id="sendBtn">
                    <iconify-icon icon="material-symbols:send"></iconify-icon>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Chat functionality
document.addEventListener('DOMContentLoaded', function() {
    // Cache DOM elements
    const chatItems = document.querySelectorAll('.chat-item');
    const chatMessages = document.getElementById('chatMessages');
    const messageInput = document.getElementById('messageInput');
    const sendBtn = document.getElementById('sendBtn');
    const headerName = document.getElementById('headerName');
    const headerStatus = document.getElementById('headerStatus');
    const headerAvatar = document.getElementById('headerAvatar');
    const searchInput = document.getElementById('globalSearch');
    
    // Sample chat data
    const chatData = {
        1: {
            name: "Nadia Irma",
            status: "Online • UI Design, Front-End",
            avatar: "https://images.unsplash.com/photo-1494790108755-2616b612b786?w=45&h=45&fit=crop&crop=face",
            messages: [
                {
                    type: 'received',
                    content: 'Halo Bu, terima kasih sudah menghubungi saya untuk proyek UI Design website cafe.',
                    time: '10:30 AM',
                    avatar: 'https://images.unsplash.com/photo-1494790108755-2616b612b786?w=36&h=36&fit=crop&crop=face'
                },
                {
                    type: 'sent',
                    content: 'Halo Nadia, saya perlu desain untuk website cafe dan juga toko pakaian. Kira-kira berapa lama pengerjaannya?',
                    time: '10:32 AM',
                    avatar: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=36&h=36&fit=crop&crop=face'
                },
                {
                    type: 'received',
                    content: 'Baik Ibu, saya menghendaki 1 bulan untuk desainnya, sekaligus saya buatkan form penawarannya. Untuk 2 website, saya tawarkan harga Rp 8.500.000',
                    time: '10:35 AM',
                    avatar: 'https://images.unsplash.com/photo-1494790108755-2616b612b786?w=36&h=36&fit=crop&crop=face'
                },
                {
                    type: 'sent',
                    content: 'Oke, bisa tolong kirimkan portfolionya dulu?',
                    time: '10:36 AM',
                    avatar: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=36&h=36&fit=crop&crop=face'
                }
            ]
        },
        2: {
            name: "Tiara Hasna",
            status: "Online • Back-End, Fullstack",
            avatar: "https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=45&h=45&fit=crop&crop=face",
            messages: [
                {
                    type: 'received',
                    content: 'Selamat siang Bu, saya lihat Ibu membutuhkan developer fullstack untuk proyek e-commerce?',
                    time: '2:15 PM',
                    avatar: 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=36&h=36&fit=crop&crop=face'
                },
                {
                    type: 'sent',
                    content: 'Iya betul, saya butuh website e-commerce lengkap dengan sistem pembayaran. Berapa estimasi biayanya?',
                    time: '2:18 PM',
                    avatar: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=36&h=36&fit=crop&crop=face'
                },
                {
                    type: 'received',
                    content: 'Bisa Bu, untuk jasa fullstacknya saya tawarkan diskon 10%. Total menjadi Rp 15.000.000 untuk fitur lengkap',
                    time: '2:20 PM',
                    avatar: 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=36&h=36&fit=crop&crop=face'
                }
            ]
        },
        3: {
            name: "Karina Carlo",
            status: "Online • Graphic Design, Illustrator",
            avatar: "https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=45&h=45&fit=crop&crop=face",
            messages: [
                {
                    type: 'received',
                    content: 'Halo Bu, saya sudah selesai buat beberapa konsep logo untuk cafe dan toko pakaiannya.',
                    time: '4:45 PM',
                    avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=36&h=36&fit=crop&crop=face'
                },
                {
                    type: 'sent',
                    content: 'Wah cepat sekali! Boleh saya lihat hasil konsepnya?',
                    time: '4:47 PM',
                    avatar: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=36&h=36&fit=crop&crop=face'
                },
                {
                    type: 'received',
                    content: 'Ini nih Bu untuk logo cafe dan toko pakaiannnya. Saya buat 3 variasi untuk masing-masing bisnis.',
                    time: '4:50 PM',
                    avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=36&h=36&fit=crop&crop=face'
                }
            ]
        },
        4: {
            name: "Erma Nadila",
            status: "Online • Illustrator, Video Editor",
            avatar: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=45&h=45&fit=crop&crop=face",
            messages: [
                {
                    type: 'sent',
                    content: 'Halo Erma, saya butuh video promosi untuk cafe baru saya. Durasinya sekitar 2-3 menit.',
                    time: '11:20 AM',
                    avatar: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=36&h=36&fit=crop&crop=face'
                },
                {
                    type: 'received',
                    content: 'Siap Bu! Untuk tema warnanya ada preferensi khusus tidak?',
                    time: '11:25 AM',
                    avatar: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=36&h=36&fit=crop&crop=face'
                },
                {
                    type: 'sent',
                    content: 'saya mau editannya nuansa ungu ya mbak, sesuai dengan branding cafe saya',
                    time: '11:27 AM',
                    avatar: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=36&h=36&fit=crop&crop=face'
                }
            ]
        }
    };
    
    // Function to load chat messages
    function loadChatMessages(chatId) {
        const chat = chatData[chatId];
        if (!chat) return;
        
        // Update header
        if (headerName) headerName.textContent = chat.name;
        if (headerStatus) headerStatus.textContent = chat.status;
        if (headerAvatar) headerAvatar.src = chat.avatar;
        
        // Clear messages
        if (chatMessages) {
            chatMessages.innerHTML = '';
            
            // Add messages
            chat.messages.forEach(message => {
                const messageDiv = document.createElement('div');
                messageDiv.className = `message ${message.type}`;
                messageDiv.innerHTML = `
                    <div class="message-avatar">
                        <img src="${message.avatar}" alt="Avatar">
                    </div>
                    <div class="message-content">
                        ${message.content}
                        <div class="message-time">${message.time}</div>
                    </div>
                `;
                chatMessages.appendChild(messageDiv);
            });
            
            // Scroll to bottom
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    }
    
    // Function to send message
    function sendMessage() {
        if (!messageInput || !messageInput.value.trim()) return;
        
        const messageText = messageInput.value.trim();
        const currentTime = new Date().toLocaleTimeString('en-US', {
            hour: 'numeric',
            minute: '2-digit',
            hour12: true
        });
        
        // Create message element
        const messageDiv = document.createElement('div');
        messageDiv.className = 'message sent';
        messageDiv.innerHTML = `
            <div class="message-avatar">
                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=36&h=36&fit=crop&crop=face" alt="You">
            </div>
            <div class="message-content">
                ${messageText}
                <div class="message-time">${currentTime}</div>
            </div>
        `;
        
        // Add to chat
        if (chatMessages) {
            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
        
        // Clear input
        messageInput.value = '';
        autoResizeTextarea();
        
        // Simulate typing indicator and response (optional)
        setTimeout(() => {
            simulateTypingResponse();
        }, 1000);
    }
    
    // Simulate typing response
    function simulateTypingResponse() {
        const responses = [
            "Terima kasih atas pesannya, saya akan segera membalas.",
            "Baik Bu, saya cek dulu detailnya ya.",
            "Oke, nanti saya kirimkan proposal lengkapnya.",
            "Siap Bu, akan saya kerjakan sesuai timeline yang disepakati."
        ];
        
        const randomResponse = responses[Math.floor(Math.random() * responses.length)];
        const currentTime = new Date().toLocaleTimeString('en-US', {
            hour: 'numeric',
            minute: '2-digit',
            hour12: true
        });
        
        // Get current active chat avatar
        const activeChat = document.querySelector('.chat-item.active');
        const activeAvatar = activeChat ? activeChat.querySelector('.chat-avatar img').src : '';
        
        const messageDiv = document.createElement('div');
        messageDiv.className = 'message received';
        messageDiv.innerHTML = `
            <div class="message-avatar">
                <img src="${activeAvatar}" alt="Contact">
            </div>
            <div class="message-content">
                ${randomResponse}
                <div class="message-time">${currentTime}</div>
            </div>
        `;
        
        if (chatMessages) {
            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    }
    
    // Auto resize textarea
    function autoResizeTextarea() {
        if (messageInput) {
            messageInput.style.height = 'auto';
            messageInput.style.height = Math.min(messageInput.scrollHeight, 120) + 'px';
        }
    }
    
    // Search functionality - integrates with global search
    window.performSearch = function(query) {
        const chatItems = document.querySelectorAll('.chat-item');
        chatItems.forEach(item => {
            const name = item.querySelector('.chat-name').textContent.toLowerCase();
            const preview = item.querySelector('.chat-preview').textContent.toLowerCase();
            const searchTerm = query.toLowerCase();
            
            if (name.includes(searchTerm) || preview.includes(searchTerm) || query === '') {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    };
    
    // Event listeners
    
    // Chat item selection
    chatItems.forEach(item => {
        item.addEventListener('click', function() {
            // Remove active from all items
            chatItems.forEach(i => i.classList.remove('active'));
            
            // Add active to clicked item
            this.classList.add('active');
            
            // Load chat messages
            const chatId = this.getAttribute('data-chat-id');
            loadChatMessages(chatId);
        });
    });
    
    // Send button
    if (sendBtn) {
        sendBtn.addEventListener('click', function(e) {
            e.preventDefault();
            sendMessage();
        });
    }
    
    // Enter key to send
    if (messageInput) {
        messageInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });
        
        // Auto resize on input
        messageInput.addEventListener('input', autoResizeTextarea);
    }
    
    // Initialize first chat
    loadChatMessages('1');
    
    console.log('Chat page initialized successfully');
});
</script>
@endpush