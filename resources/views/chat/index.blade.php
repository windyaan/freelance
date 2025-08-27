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

    {{-- Hide Order navigation for freelancers, only show for clients --}}
    @if(auth()->user()->role !== 'freelancer')
        <a href="{{ route(auth()->user()->role . '.order') }}" class="nav-item {{ request()->routeIs(auth()->user()->role . '.order*') ? 'active' : '' }}">
            <div class="nav-icon">
                <iconify-icon icon="material-symbols:list-alt"></iconify-icon>
            </div>
            <span class="nav-text">Order</span>
        </a>
    @endif

    {{-- Only show Service navigation for freelancers --}}
    @if(auth()->user()->role === 'freelancer')
        <a href="{{ route('freelancer.services') }}" class="nav-item {{ request()->routeIs('freelancer.services*') ? 'active' : '' }}">
            <div class="nav-icon">
                <iconify-icon icon="material-symbols:work"></iconify-icon>
            </div>
            <span class="nav-text">Service</span>
        </a>
    @endif
@endsection



@push('styles')
<style>
/* Modern Chat Styles */
:root {
    --chat-bg-primary: #f8fafc;
    --chat-bg-secondary: #ffffff;
    --chat-border: #e2e8f0;
    --chat-text-primary: #1a202c;
    --chat-text-secondary: #718096;
    --chat-text-muted: #a0aec0;
    --chat-sent-bg: #374557;
    --chat-received-bg: #ffffff;
    --chat-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    --chat-shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.1);
    --chat-accent-green: #4CBC9A;
}

.chat-container {
    display: flex;
    height: calc(100vh - var(--navbar-height));
    background: var(--chat-bg-primary);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: var(--chat-shadow-lg);
    border: 1px solid var(--chat-border);
}

/* Chat Sidebar */
.chat-sidebar {
    width: 320px;
    background: var(--chat-bg-secondary);
    border-right: 1px solid var(--chat-border);
    display: flex;
    flex-direction: column;
    flex-shrink: 0;
}

.chat-sidebar-header {
    padding: 1.5rem 1.25rem 1rem 1.25rem;
    border-bottom: 1px solid var(--chat-border);
    background: var(--chat-bg-secondary);
}

.chat-sidebar-title {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--chat-text-primary);
    margin-bottom: 0.25rem;
}

.chat-sidebar-subtitle {
    font-size: 0.8rem;
    color: var(--chat-text-secondary);
}

.chat-list {
    flex: 1;
    overflow-y: auto;
    padding: 0.25rem 0;
}

.chat-item {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    padding: 0.75rem 1.25rem;
    cursor: pointer;
    transition: all 0.3s ease;
    border-left: 3px solid transparent;
    position: relative;
}

.chat-item::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, #374557 0%, #4a5568 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
    border-radius: 0 12px 12px 0;
}

.chat-item:hover::before {
    opacity: 0.03;
}

.chat-item.active::before {
    opacity: 0.08;
}

.chat-item:hover {
    background: rgba(55, 69, 87, 0.02);
}

.chat-item.active {
    background: rgba(55, 69, 87, 0.05);
    border-left-color: #374557;
}

.chat-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0;
    border: 2px solid #e2e8f0;
    position: relative;
    z-index: 1;
}

.chat-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.chat-info {
    flex: 1;
    min-width: 0;
    position: relative;
    z-index: 1;
}

.chat-name {
    font-weight: 600;
    color: var(--chat-text-primary);
    margin-bottom: 0.25rem;
    font-size: 0.9rem;
}

.chat-preview {
    font-size: 0.8rem;
    color: var(--chat-text-secondary);
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin-bottom: 0.5rem;
}

.chat-skills {
    display: flex;
    gap: 0.25rem;
    flex-wrap: wrap;
}

.chat-skill-tag {
    background: linear-gradient(135deg, #e0f7ff 0%, #f0f9ff 100%);
    color: #0891b2;
    padding: 0.125rem 0.5rem;
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
    background: var(--chat-bg-primary);
    min-width: 0;
}

.chat-header {
    padding: 1.25rem 1.75rem;
    border-bottom: 1px solid var(--chat-border);
    background: var(--chat-bg-secondary);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    box-shadow: var(--chat-shadow);
}

.chat-header-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    overflow: hidden;
    border: 2px solid var(--chat-border);
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
    color: var(--chat-text-primary);
    font-size: 1rem;
    margin-bottom: 0.125rem;
}

.chat-header-status {
    font-size: 0.8rem;
    color: var(--chat-text-secondary);
}

/* Chat Messages */
.chat-messages {
    flex: 1;
    overflow-y: auto;
    padding: 1rem 1.75rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
    background: var(--chat-bg-primary);
}

.message {
    display: flex;
    align-items: flex-start;
    gap: 0.5rem;
    max-width: 70%;
    animation: slideInMessage 0.3s ease-out;
}

@keyframes slideInMessage {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.message.sent {
    align-self: flex-end;
    flex-direction: row-reverse;
}

.message.received {
    align-self: flex-start;
}

.message-avatar {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0;
    border: 1px solid var(--chat-border);
}

.message-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.message-content {
    position: relative;
    padding: 0.75rem 1rem;
    border-radius: 16px;
    box-shadow: var(--chat-shadow);
    word-wrap: break-word;
    line-height: 1.4;
    font-size: 0.9rem;
    max-width: 100%;
}

.message.sent .message-content {
    background: var(--chat-sent-bg);
    color: white;
    border-bottom-right-radius: 8px;
}

.message.received .message-content {
    background: var(--chat-bg-secondary);
    color: var(--chat-text-primary);
    border: 1px solid var(--chat-border);
    border-bottom-left-radius: 8px;
}

.message-time {
    font-size: 0.7rem;
    margin-top: 0.25rem;
    text-align: right;
    opacity: 0.8;
}

.message.sent .message-time {
    color: rgba(255, 255, 255, 0.9);
}

.message.received .message-time {
    color: var(--chat-text-muted);
}

/* Message Status Icons */
.message-status {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    margin-left: 0.5rem;
}

.message.sent .message-status {
    color: rgba(255, 255, 255, 0.9);
}

/* Chat Input */
.chat-input-container {
    padding: 1rem 1.75rem;
    border-top: 1px solid var(--chat-border);
    background: var(--chat-bg-secondary);
}

.chat-input-wrapper {
    display: flex;
    align-items: flex-end;
    gap: 0.75rem;
    background: var(--chat-bg-primary);
    border: 2px solid var(--chat-border);
    border-radius: 16px;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
    position: relative;
}

.chat-input-wrapper:focus-within {
    border-color: #374557;
    box-shadow: 0 0 0 3px rgba(55, 69, 87, 0.1);
}

.chat-input {
    flex: 1;
    border: none;
    background: transparent;
    padding: 0.5rem 0;
    font-size: 0.95rem;
    color: var(--chat-text-primary);
    resize: none;
    outline: none;
    min-height: 24px;
    max-height: 120px;
    line-height: 1.5;
    font-family: inherit;
}

.chat-input::placeholder {
    color: var(--chat-text-muted);
}

.chat-send-btn {
    background: var(--chat-sent-bg);
    color: white;
    border: none;
    border-radius: 12px;
    padding: 0.625rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    flex-shrink: 0;
    box-shadow: var(--chat-shadow);
}

.chat-send-btn:hover {
    transform: scale(1.05);
    background: #2d3748;
    box-shadow: 0 6px 20px rgba(55, 69, 87, 0.3);
}

.chat-send-btn:disabled {
    background: #cbd5e1;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

/* Typing Indicator */
.typing-indicator {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem 1.5rem;
    color: var(--chat-text-secondary);
    font-size: 0.85rem;
    font-style: italic;
}

.typing-dots {
    display: flex;
    gap: 0.25rem;
}

.typing-dots span {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--chat-text-secondary);
    animation: typingDot 1.4s infinite ease-in-out;
}

.typing-dots span:nth-child(1) { animation-delay: -0.32s; }
.typing-dots span:nth-child(2) { animation-delay: -0.16s; }

@keyframes typingDot {
    0%, 80%, 100% {
        transform: scale(0);
        opacity: 0.5;
    }
    40% {
        transform: scale(1);
        opacity: 1;
    }
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .chat-container {
        flex-direction: column;
        height: calc(100vh - var(--navbar-height) - 1rem);
        border-radius: 16px;
    }

    .chat-sidebar {
        width: 100%;
        height: 180px;
        border-right: none;
        border-bottom: 1px solid var(--chat-border);
    }

    .chat-main {
        height: calc(100% - 180px);
    }

    .message {
        max-width: 85%;
    }

    .chat-messages {
        padding: 1rem;
        gap: 0.75rem;
    }

    .chat-input-container {
        padding: 1rem;
    }

    .chat-header {
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
    background: transparent;
}

.chat-messages::-webkit-scrollbar-thumb,
.chat-list::-webkit-scrollbar-thumb {
    background: rgba(203, 213, 225, 0.6);
    border-radius: 6px;
}

.chat-messages::-webkit-scrollbar-thumb:hover,
.chat-list::-webkit-scrollbar-thumb:hover {
    background: rgba(148, 163, 184, 0.8);
}

/* Empty State */
.chat-empty-state {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    color: var(--chat-text-secondary);
    padding: 2rem;
}

.chat-empty-state iconify-icon {
    font-size: 4rem;
    color: var(--chat-text-muted);
    margin-bottom: 1rem;
}

.chat-empty-state h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--chat-text-primary);
    margin-bottom: 0.5rem;
}

.chat-empty-state p {
    font-size: 0.9rem;
    color: var(--chat-text-secondary);
}
</style>
@endpush


@section('content')
<div class="chat-container flex h-screen">
    <!-- Chat Sidebar -->
    <div class="chat-sidebar w-1/3 border-r flex flex-col bg-white">
        <div class="chat-sidebar-header p-4 border-b">
            <h2 class="chat-sidebar-title text-lg font-bold">Messages</h2>
            <p class="chat-sidebar-subtitle text-sm text-gray-500">Recent conversations</p>
        </div>

        <div class="chat-list flex-1 overflow-y-auto" id="chatList">
            @foreach($chats as $chat)
                @php
                    $otherUser = $chat->client_id == auth()->id()
                        ? $chat->freelancer
                        : $chat->client;
                @endphp

                <div class="chat-item {{ isset($activeChat) && $activeChat->id === $chat->id ? 'active' : '' }}"
                     data-chat-id="{{ $chat->id }}"
                     data-user-name="{{ $otherUser->name }}">

                    <!-- Avatar -->
                    <div class="chat-avatar">
                        <img src="{{ $otherUser->profile->avatar_url ?? 'https://via.placeholder.com/52' }}"
                             alt="{{ $otherUser->name }}">
                    </div>

                    <!-- Info -->
                    <div class="chat-info">
                        <div class="chat-name">{{ $otherUser->name }}</div>
                        <div class="chat-preview">
                            {{ $chat->messages->last()->content ?? 'Belum ada pesan' }}
                        </div>
                        @if($otherUser->profile && $otherUser->profile->skills)
                            <div class="chat-skills">
                                @foreach(array_slice(explode(',', $otherUser->profile->skills), 0, 2) as $skill)
                                    <span class="chat-skill-tag">
                                        {{ trim($skill) }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Chat Main Area -->
    <div class="chat-main">
        @if($activeChat)
            @php
                $otherUser = $activeChat->client_id == auth()->id()
                    ? $activeChat->freelancer
                    : $activeChat->client;
            @endphp

            <!-- Header -->
            <div class="chat-header" id="chatHeader">
                <div class="chat-header-avatar">
                    <img src="{{ $otherUser->profile->avatar_url ?? 'https://via.placeholder.com/48' }}"
                         alt="{{ $otherUser->name }}">
                </div>
                <div class="chat-header-info">
                    <div class="chat-header-name" id="headerName">
                        {{ $otherUser->name }}
                    </div>
                    <div class="chat-header-status" id="headerStatus">
                        Online • {{ $otherUser->profile->skills ?? '' }}
                    </div>
                </div>
            </div>

            <!-- Messages -->
            <div class="chat-messages" id="chatMessages">
                @foreach($activeChat->messages as $msg)
                    <div class="message {{ $msg->sender_id == auth()->id() ? 'sent' : 'received' }}">
                        <div class="message-avatar">
                            <img src="{{ $msg->sender->profile->avatar_url ?? 'https://via.placeholder.com/32' }}"
                                 alt="{{ $msg->sender->name }}">
                        </div>
                        <div class="message-content">
                            {{ $msg->content }}
                            <div class="message-time">
                                {{ $msg->created_at->format('H:i A') }}
                                @if($msg->sender_id == auth()->id())
                                    <span class="message-status">
                                        <iconify-icon icon="material-symbols:check" style="font-size: 0.75rem; color: var(--chat-accent-green);"></iconify-icon>
                                        <iconify-icon icon="material-symbols:check" style="font-size: 0.75rem; margin-left: -0.25rem; color: var(--chat-accent-green);"></iconify-icon>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Chat Input -->
            <div class="chat-input-container">
                <form action="{{ route('chat.message.store', $activeChat) }}" method="POST">
                    @csrf
                    <div class="chat-input-wrapper">
                        <textarea class="chat-input"
                                  name="content"
                                  placeholder="Ketik pesan Anda..."
                                  rows="1"
                                  id="messageInput"></textarea>
                        <button type="submit" class="chat-send-btn" id="sendBtn">
                            <iconify-icon icon="material-symbols:send" style="font-size: 1.25rem;"></iconify-icon>
                        </button>
                    </div>
                </form>
            </div>
        @else
            <!-- Empty State -->
            <div class="chat-empty-state">
                <iconify-icon icon="material-symbols:chat-bubble-outline"></iconify-icon>
                <h3>Pilih Percakapan</h3>
                <p>Pilih percakapan dari daftar untuk mulai chat</p>
            </div>
        @endif
    </div>
</div>
@endsection

<script>
    window.currentChatId = "{{ $activeChat ? $activeChat->id : '' }}";
    window.userId = "{{ auth()->id() }}";
</script>

@push('scripts')
<script>
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

    function sendMessage() {
    if (!messageInput || !messageInput.value.trim()) return;

    const content = messageInput.value.trim();

    // POST ke backend
    axios.post(`/chat/{{ $activeChat->id }}/message`, { content })
        .then(() => {
            messageInput.value = '';
            autoResizeTextarea();
            // Pesan akan muncul otomatis via Echo listener
        })
        .catch(err => console.error(err));
}

// Event listener tombol kirim
if (sendBtn) {
    sendBtn.addEventListener('click', function(e) {
        e.preventDefault();
        sendMessage();
    });
}

// Event listener enter key
if (messageInput) {
    messageInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });
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
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    }

    // Search functionality
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
    // Listener realtime Laravel Echo
    if (window.currentChatId) {
    Echo.private(`chat.${window.currentChatId}`)
        .listen('MessageSent', (e) => {
            console.log("Pesan baru:", e);

            // Jangan render pesan sendiri, karena sudah ditangani oleh sendMessage()
            if (e.message.sender_id !== parseInt(window.userId)) {
                const chatMessages = document.getElementById('chatMessages');
                if (chatMessages) {
                    const messageDiv = document.createElement('div');
                    messageDiv.className = 'message received flex justify-start mb-4';
                    messageDiv.innerHTML = `
                        <div class="flex items-end space-x-2">
                            <div class="message-avatar">
                                <img src="${e.message.sender.avatar_url ?? 'https://via.placeholder.com/36'}"
                                     alt="${e.message.sender.name}"
                                     class="w-9 h-9 rounded-full object-cover">
                            </div>
                            <div class="message-content max-w-xs px-4 py-2 rounded-lg bg-gray-200 text-gray-800">
                                ${e.message.content}
                                <div class="message-time text-xs mt-1 text-gray-400">
                                    ${new Date(e.message.created_at).toLocaleTimeString()}
                                </div>
                            </div>
                        </div>
                    `;
                    chatMessages.appendChild(messageDiv);
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }
            }
        });
}

    // Chat item selection
    chatItems.forEach(item => {
        item.addEventListener('click', function() {
            const chatId = this.getAttribute('data-chat-id');
            window.location.href = `{{ route(auth()->user()->role . '.chat') }}?chat_id=${chatId}`;
        });
    });

    // Auto resize on input
    if (messageInput) {
        messageInput.addEventListener('input', autoResizeTextarea);
        
        // Enter key to send (Shift+Enter for new line)
        messageInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                if (chatForm) {
                    chatForm.submit();
                }
            }
        });
    }

    // Form submission
    if (chatForm) {
        chatForm.addEventListener('submit', function(e) {
            if (messageInput && !messageInput.value.trim()) {
                e.preventDefault();
                return;
            }
        });
    }

    // Initialize
    scrollToBottom();
    autoResizeTextarea();

    console.log('Modern chat interface initialized successfully');
});
</script>
@endpush