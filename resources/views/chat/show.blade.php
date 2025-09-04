@extends('layouts.app')

@section('title', 'Chat with ' . $user->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden h-96">
            <!-- Chat Header -->
            <div class="bg-blue-600 text-white px-6 py-4 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <a href="{{ route(auth()->user()->role . '.chat') }}"
                       class="text-white hover:text-blue-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                        <span class="text-white font-medium">{{ substr($user->name, 0, 1) }}</span>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold">{{ $user->name }}</h2>
                        <p class="text-blue-100 text-sm">{{ ucfirst($user->role) }}</p>
                    </div>
                </div>
                <div class="text-sm text-blue-100">
                    <span class="inline-block w-2 h-2 bg-green-400 rounded-full mr-2"></span>
                    Online
                </div>
            </div>

            <!-- Messages Container -->
            <div id="messages-container" class="flex-1 overflow-y-auto p-6 space-y-4 bg-gray-50" style="height: 300px;">
                @forelse($messages ?? [] as $message)
                    <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-xs lg:max-w-md px-4 py-2 rounded-lg {{ $message->sender_id === auth()->id() ? 'bg-blue-600 text-white' : 'bg-white text-gray-800' }}">
                            <p class="text-sm">{{ $message->content }}</p>
                            <p class="text-xs mt-1 {{ $message->sender_id === auth()->id() ? 'text-blue-200' : 'text-gray-500' }}">
                                {{ $message->created_at->format('H:i') }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <p class="text-gray-500">No messages yet. Start the conversation!</p>
                    </div>
                @endforelse
            </div>

            <!-- Message Input -->
            <div class="border-t bg-white px-6 py-4">
                <form id="message-form" action="{{ route('chat.send', $chat->id ?? $user->id) }}" method="POST" class="flex space-x-4">
                    @csrf
                    <div class="flex-1">
                        <input type="text"
                               name="content"
                               id="message-input"
                               placeholder="Type your message..."
                               required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200 flex items-center space-x-2">
                        <span>Send</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- Hidden data for JavaScript -->
        <div id="chat-data"
             data-chat-id="{{ $chat->id ?? '' }}"
             data-user-id="{{ auth()->id() }}"
             style="display: none;"></div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/chat.js') }}"></script>
{{-- <script>
document.addEventListener('DOMContentLoaded', function() {
    var messagesContainer = document.getElementById('messages-container');
    var messageForm = document.getElementById('message-form');
    var messageInput = document.getElementById('message-input');
    var chatData = document.getElementById('chat-data');

    function scrollToBottom() {
        if (messagesContainer) {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
    }

    function escapeHtml(text) {
        var div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Initial scroll
    scrollToBottom();

    // Handle form submission
    if (messageForm) {
        messageForm.addEventListener('submit', function(e) {
            e.preventDefault();
            var message = messageInput.value.trim();
            if (!message) return;

            // Add message bubble immediately
            var messageDiv = document.createElement('div');
            messageDiv.className = 'flex justify-end';
            messageDiv.innerHTML =
                '<div class="max-w-xs lg:max-w-md px-4 py-2 rounded-lg bg-blue-600 text-white">' +
                    '<p class="text-sm">' + escapeHtml(message) + '</p>' +
                    '<p class="text-xs mt-1 text-blue-200">' +
                        new Date().toLocaleTimeString('en-GB', {hour:'2-digit', minute:'2-digit'}) +
                    '</p>' +
                '</div>';

            if (messagesContainer) {
                messagesContainer.appendChild(messageDiv);
                scrollToBottom();
            }

            messageInput.value = '';

            // Send to server
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ content: message })
            }).catch(function(error) {
                console.error('Error sending message:', error);
                // Optional: Show error message to user
            });
        });
    }

    // Laravel Echo Listener (Safe Implementation)
    if (chatData) {
        var chatId = chatData.getAttribute('data-chat-id');
        var currentUserId = parseInt(chatData.getAttribute('data-user-id'));

        if (chatId && typeof Echo !== 'undefined') {
            Echo.private('chat.' + chatId)
                .listen('MessageSent', function(e) {
                    console.log('New message received:', e);

                    // Don't show message if it's from current user
                    if (e.message && e.message.sender_id === currentUserId) {
                        return;
                    }

                    // Add received message
                    var messageDiv = document.createElement('div');
                    messageDiv.className = 'flex justify-start';
                    messageDiv.innerHTML =
                        '<div class="max-w-xs lg:max-w-md px-4 py-2 rounded-lg bg-white text-gray-800">' +
                            '<p class="text-sm">' + escapeHtml(e.message.content || '') + '</p>' +
                            '<p class="text-xs mt-1 text-gray-500">' +
                                new Date(e.message.created_at).toLocaleTimeString('en-GB', {hour:'2-digit', minute:'2-digit'}) +
                            '</p>' +
                        '</div>';

                    if (messagesContainer) {
                        messagesContainer.appendChild(messageDiv);
                        scrollToBottom();
                    }
                })
                .error(function(error) {
                    console.error('Echo connection error:', error);
                });
        } else if (!chatId) {
            console.log('No chat ID available for real-time messaging');
        } else {
            console.warn('Laravel Echo is not loaded');
        }
    }

    // Enter key to send message
    if (messageInput) {
        messageInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                if (messageForm) {
                    messageForm.dispatchEvent(new Event('submit'));
                }
            }
        });
    }
});
</script> --}}
@endpush

@endsection
