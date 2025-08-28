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

      <a href="{{ route('freelancer.services') }}" class="nav-item {{ request()->routeIs('freelancer.services*') ? 'active' : '' }}">
        <div class="nav-icon">
            <iconify-icon icon="material-symbols:work"></iconify-icon>
        </div>
        <span class="nav-text">Service</span>
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

                <div class="chat-item flex items-center p-4 cursor-pointer hover:bg-gray-100
                            {{ isset($activeChat) && $activeChat->id === $chat->id ? 'bg-gray-200' : '' }}"
                     data-chat-id="{{ $chat->id }}"
                     data-user-name="{{ $otherUser->name }}">

                    <!-- Avatar -->
                    <div class="chat-avatar mr-3">
                        <img src="{{ $otherUser->profile->avatar_url ?? 'https://via.placeholder.com/50' }}"
                             alt="{{ $otherUser->name }}"
                             class="w-12 h-12 rounded-full object-cover">
                    </div>

                    <!-- Info -->
                    <div class="chat-info flex-1">
                        <div class="chat-name font-semibold">{{ $otherUser->name }}</div>
                        <div class="chat-preview text-sm text-gray-500 truncate">
                            {{ $chat->messages->last()->content ?? 'Belum ada pesan' }}
                        </div>
                        <div class="chat-skills text-xs text-gray-400 mt-1">
                            @if($otherUser->profile && $otherUser->profile->skills)
                                @foreach(explode(',', $otherUser->profile->skills) as $skill)
                                    <span class="chat-skill-tag bg-gray-100 px-2 py-0.5 rounded mr-1">
                                        {{ trim($skill) }}
                                    </span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Chat Main Area -->
    <div class="chat-main flex-1 flex flex-col">
        @if($activeChat)
            @php
                $otherUser = $activeChat->client_id == auth()->id()
                    ? $activeChat->freelancer
                    : $activeChat->client;
            @endphp

            <!-- Header -->
            <div class="chat-header flex items-center p-4 border-b bg-white" id="chatHeader">
                <div class="chat-header-avatar mr-3">
                    <img src="{{ $otherUser->profile->avatar_url ?? 'https://via.placeholder.com/45' }}"
                         alt="{{ $otherUser->name }}"
                         class="w-10 h-10 rounded-full object-cover">
                </div>
                <div class="chat-header-info">
                    <div class="chat-header-name font-semibold text-gray-800" id="headerName">
                        {{ $otherUser->name }}
                    </div>
                    <div class="chat-header-status text-sm text-gray-500" id="headerStatus">
                        Online
                        @if($otherUser->role === 'freelancer')
        • {{ $otherUser->profile->skills ?? '' }}
    @endif
                    </div>
                </div>
            </div>

            <!-- Messages -->
            <div class="chat-messages flex-1 p-4 overflow-y-auto bg-gray-50" id="chatMessages">
                @foreach($activeChat->messages as $msg)
                    <div class="message {{ $msg->sender_id == auth()->id() ? 'sent flex justify-end mb-4' : 'received flex justify-start mb-4' }}">

                        <div class="flex items-end space-x-2 {{ $msg->sender_id == auth()->id() ? 'flex-row-reverse space-x-reverse' : '' }}">
                            <!-- Avatar -->
                            <div class="message-avatar">
                                <img src="{{ $msg->sender->profile->avatar_url ?? 'https://via.placeholder.com/36' }}"
                                     alt="{{ $msg->sender->name }}"
                                     class="w-9 h-9 rounded-full object-cover">
                            </div>

                            <!-- Content -->
                            <div class="message-content max-w-xs px-4 py-2 rounded-lg
                                        {{ $msg->sender_id == auth()->id() ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800' }}">
                                {{ $msg->content }}
                                <div class="message-time text-xs mt-1 text-gray-400">
                                    {{ $msg->created_at->format('H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Chat Input -->
            <div class="chat-input-container p-4 border-t bg-white">
                <form action="{{ route('chat.message.store', $activeChat) }}" method="POST" class="chat-input-wrapper flex items-center">
                    @csrf
                    <textarea class="chat-input flex-1 resize-none border rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                              name="content"
                              placeholder="Type your message..."
                              rows="1"></textarea>
                    <button class="chat-send-btn ml-2 p-2 bg-blue-500 text-white rounded-full hover:bg-blue-600 transition">
                        <iconify-icon icon="material-symbols:send"></iconify-icon>
                    </button>
                </form>
            </div>
        @else
            <!-- Jika belum ada chat aktif -->
            <div class="flex-1 flex items-center justify-center text-gray-400">
                Pilih percakapan untuk mulai chat
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
{{-- <script type="module">
    Echo.channel('example')
        .listen("Example", (e) => {
            console.log("Pesan baru:", e); --}}
            {{-- // tampilkan pesan ke UI
        }); --}}
    {{-- // console.log('test');

    // window.currentChatId = @json($chat->id);

    // if (window.currentChatId && window.Echo) {
    // } else {
    //     console.error("Echo belum siap atau chatId tidak ada");
    // } --}}
</script>
@endpush


@push('scripts')
<script type="module">
       console.log('test');

    window.currentChatId = @json($chat->id);

    if (window.currentChatId && window.Echo) {
        Echo.private(`chat.${window.currentChatId}`)
            .listen('MessageSent', (e) => {
                console.log("Pesan baru:", e);
                // tampilkan pesan ke UI
            });
    } else {
        console.error("Echo belum siap atau chatId tidak ada");
    }
</script>
<script>
    window.currentChatId = "{{ $activeChat ? $activeChat->id : '' }}";
    window.userId = "{{ auth()->id() }}";
</script>


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
