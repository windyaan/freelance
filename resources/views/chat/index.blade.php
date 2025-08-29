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
    --offer-bg: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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

.chat-header-actions {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-create-offer {
    background: var(--offer-bg);
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: var(--chat-shadow);
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.btn-create-offer:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
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

/* Offer Message Styles */
.offer-message {
    max-width: 80%;
    margin: 1rem 0;
}

.offer-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    border: 1px solid #e2e8f0;
}

.offer-header {
    background: var(--offer-bg);
    color: white;
    padding: 1rem;
}

.offer-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.offer-meta {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.5rem;
    font-size: 0.85rem;
    opacity: 0.9;
}

.offer-body {
    padding: 1rem;
}

.offer-price {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1a202c;
    margin-bottom: 0.5rem;
}

.offer-time {
    font-size: 0.75rem;
    color: #718096;
    margin-bottom: 1rem;
}

.offer-actions {
    display: flex;
    gap: 0.5rem;
}

.btn-offer {
    flex: 1;
    padding: 0.625rem 1rem;
    border: none;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    text-align: center;
}

.btn-details {
    background: #64748b;
    color: white;
}

.btn-details:hover {
    background: #475569;
    color: white;
    text-decoration: none;
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

/* Modal Styles */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.modal-content {
    background: white;
    border-radius: 12px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
    max-width: 500px;
    width: 90%;
    max-height: 80vh;
    overflow-y: auto;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.modal-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--chat-text-primary);
}

.modal-close {
    color: var(--chat-text-muted);
    cursor: pointer;
    padding: 0.25rem;
    border-radius: 6px;
    transition: colors 0.2s;
}

.modal-close:hover {
    color: var(--chat-text-secondary);
    background: #f1f5f9;
}

/* Form Styles */
.form-group {
    margin-bottom: 1rem;
}

.form-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--chat-text-primary);
    margin-bottom: 0.25rem;
}

.form-input, .form-select, .form-textarea {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid var(--chat-border);
    border-radius: 8px;
    font-size: 0.875rem;
    transition: all 0.2s ease;
    background: white;
}

.form-input:focus, .form-select:focus, .form-textarea:focus {
    outline: none;
    border-color: #374557;
    box-shadow: 0 0 0 3px rgba(55, 69, 87, 0.1);
}

.form-textarea {
    resize: vertical;
    min-height: 100px;
}

.form-help {
    font-size: 0.75rem;
    color: var(--chat-text-secondary);
    margin-top: 0.25rem;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
    margin-top: 1.5rem;
}

.btn {
    padding: 0.625rem 1rem;
    border: none;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn-secondary {
    background: #f1f5f9;
    color: var(--chat-text-secondary);
}

.btn-secondary:hover {
    background: #e2e8f0;
}

.btn-primary {
    background: #374557;
    color: white;
}

.btn-primary:hover {
    background: #2d3748;
}

/* Responsive Design */
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

    .message, .offer-message {
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

    .btn-create-offer {
        padding: 0.375rem 0.75rem;
        font-size: 0.8rem;
    }

    .form-grid {
        grid-template-columns: 1fr;
        gap: 0.75rem;
    }
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
            @forelse($chats as $chat)
                @php
                    $otherUser = null;
                    if (isset($chat->client_id) && $chat->client_id == auth()->id()) {
                        $otherUser = $chat->freelancer ?? null;
                    } else {
                        $otherUser = $chat->client ?? null;
                    }
                @endphp

                @if($otherUser)
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
                @endif
            @empty
                <div class="p-4 text-center text-gray-500">
                    <iconify-icon icon="material-symbols:chat-bubble-outline" class="text-4xl mb-2"></iconify-icon>
                    <p class="text-sm">Belum ada percakapan</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Chat Main Area -->
    <div class="chat-main">
        @if(isset($activeChat) && $activeChat)
            @php
                $otherUser = null;
                if (isset($activeChat->client_id) && $activeChat->client_id == auth()->id()) {
                    $otherUser = $activeChat->freelancer ?? null;
                } else {
                    $otherUser = $activeChat->client ?? null;
                }
            @endphp

        @if($otherUser)
            <h2>Chat dengan {{ $otherUser->name ?? 'User' }}</h2>
        @endif
    @else
        <p>Pilih chat untuk memulai percakapan.</p>
    @endif
</div>

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

                <!-- Add Offer Button (only for freelancers) -->
                @if(auth()->user()->role === 'freelancer')
                <div class="chat-header-actions">
                    <button onclick="openOfferModal()" class="btn-create-offer">
                        <iconify-icon icon="material-symbols:add" style="margin-right: 0.25rem;"></iconify-icon>
                        Create Offer
                    </button>
                </div>
                @endif
            </div>
            @if($otherUser)
                <!-- Header -->
                <div class="chat-header">
                    <div class="chat-header-avatar">
                        <img src="{{ $otherUser->profile->avatar_url ?? 'https://via.placeholder.com/48' }}"
                             alt="{{ $otherUser->name }}">
                    </div>
                    <div class="chat-header-info">
                        <div class="chat-header-name">
                            {{ $otherUser->name }}
                        </div>
                        <div class="chat-header-status">
                            Online • {{ $otherUser->profile->skills ?? 'No skills listed' }}
                        </div>
                    </div>
                    
                    <!-- Add Offer Button (only for freelancers) -->
                    @if(auth()->user()->role === 'freelancer')
                    <div class="chat-header-actions">
                        <button onclick="openOfferModal()" class="btn-create-offer">
                            <iconify-icon icon="material-symbols:add"></iconify-icon>
                            Create Offer
                        </button>
                    </div>
                    @endif
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

                <!-- Display Offers -->
                @if(isset($activeChat->offers))
                    @foreach($activeChat->offers as $offer)
                        @if($offer->status === 'pending')
                        <div class="offer-message {{ $offer->freelancer_id == auth()->id() ? 'sent' : 'received' }}">
                            <div class="offer-card">
                                <div class="offer-header">
                                    <div class="offer-title">{{ $offer->title }}</div>
                                    <div class="offer-meta">
                                        <div>price : {{ $offer->formatted_price }}</div>
                                        <div>revision : {{ $offer->revisions }}x</div>
                                        <div>deadline : {{ $offer->formatted_deadline }}</div>
                                        <div class="offer-time">{{ $offer->created_at->format('H:i A') }}</div>
                                    </div>
                                </div>

                                <!-- @if($offer->client_id == auth()->id())
                                <div class="offer-body">
                                    <div class="offer-actions">
                                        <a href="{{ route('offers.show', $offer) }}" class="btn-offer btn-details">
                                            Details
                                        </a>
                                    </div>
                                </div>
                                @endif -->

                                {{-- Offer Section --}}
@if(!empty($offer) && isset($offer->client_id) && $offer->client_id == auth()->id())
    <div class="offer-body">
        <div class="offer-actions">
            <a href="{{ route('offers.show', $offer) }}" class="btn-offer btn-details">
                Details
            </a>
        </div>
    </div>
@endif
                            </div>
                        </div>
                        @endif
                    @endforeach
                @endif
            </div>
                    <!-- Display Offers -->
                    @if(isset($activeChat->offers))
                        @foreach($activeChat->offers as $offer)
                            @if($offer->status === 'pending')
                            <div class="offer-message {{ $offer->freelancer_id == auth()->id() ? 'sent' : 'received' }}">
                                <div class="offer-card">
                                    <div class="offer-header">
                                        <div class="offer-title">{{ $offer->title }}</div>
                                        <div class="offer-meta">
                                            <div>Price: {{ $offer->formatted_price }}</div>
                                            <div>Deadline: {{ $offer->formatted_deadline }}</div>
                                            <div class="offer-time">{{ $offer->created_at->format('H:i A') }}</div>
                                        </div>
                                    </div>
                                    
                                    @if($offer->client_id == auth()->id())
                                    <div class="offer-body">
                                        <div class="offer-actions">
                                            <a href="{{ route('offers.show', $offer) }}" class="btn-offer btn-details">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif
                        @endforeach
                    @endif
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
                                      id="messageInput"
                                      required></textarea>
                            <button type="submit" class="chat-send-btn" id="sendBtn">
                                <iconify-icon icon="material-symbols:send" style="font-size: 1.25rem;"></iconify-icon>
                            </button>
                        </div>
                    </form>
                </div>
            @endif
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

<!-- Create Offer Modal (only show for freelancers) -->
@if(auth()->user()->role === 'freelancer' && isset($activeChat) && $activeChat)
<div id="createOfferModal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <div class="p-6">
            <div class="modal-header">
                <h3 class="modal-title">Buat Penawaran</h3>
                <button onclick="closeOfferModal()" class="modal-close">
                    <iconify-icon icon="material-symbols:close" style="font-size: 1.5rem;"></iconify-icon>
                </button>
            </div>

            <form id="offerForm" action="{{ route('offers.store') }}" method="POST">
                @csrf
                {{-- Tambahkan hidden input untuk client_id --}}
                <input type="hidden" name="client_id" value="{{ $activeChat->client_id }}">

               {{-- Pilih Job --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Job/Project</label>
            <select name="job_id" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">-- Pilih Job --</option>
                @forelse($availableJobs as $job)
                    <option value="{{ $job->id }}">
                        {{ $job->title }} - Rp {{ number_format($job->budget, 0, ',', '.') }}
                    </option>
                @empty
                    <option value="" disabled>Anda belum punya job</option>
                @endforelse
            </select>
            <p class="text-xs text-gray-500 mt-1">Pilih job yang ingin Anda ajukan penawaran</p>
        </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul Penawaran</label>
                        <input type="text" name="title" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Misal: UI Website Toko Pakaian">
                    </div>
                <input type="hidden" name="client_id" value="{{ $activeChat->client_id }}">
                
                <!-- Job Selection -->
                <div class="form-group">
                    <label class="form-label">Pilih Job/Project</label>
                    <select name="job_id" required class="form-select">
                        <option value="">-- Pilih Job --</option>
                        @forelse($availableJobs ?? [] as $job)
                            <option value="{{ $job->id }}">
                                {{ $job->title }} - Rp {{ number_format($job->budget, 0, ',', '.') }}
                            </option>
                        @empty
                            <option value="" disabled>Anda belum punya job</option>
                        @endforelse
                    </select>
                    <p class="form-help">Pilih job yang ingin Anda ajukan penawaran</p>
                </div>
                
                <!-- Offer Title -->
                <div class="form-group">
                    <label class="form-label">Judul Penawaran</label>
                    <input type="text" name="title" required class="form-input"
                           placeholder="Misal: UI Website Toko Pakaian">
                </div>

                <!-- Offer Description -->
                <div class="form-group">
                    <label class="form-label">Deskripsi Penawaran</label>
                    <textarea name="description" required class="form-textarea"
                              placeholder="Jelaskan detail project yang akan dikerjakan..."></textarea>
                </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
                            <input type="number" name="final_price" required min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="700000">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deadline</label>
                            <input type="date" name="deadline" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                        </div>
                <!-- Price and Deadline -->
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Harga (Rp)</label>
                        <input type="number" name="final_price" required min="0" class="form-input"
                               placeholder="700000">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Deadline</label>
                        <input type="date" name="deadline" required class="form-input"
                               min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                    </div>
                </div>



                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="button" onclick="closeOfferModal()" class="btn btn-secondary">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Kirim Penawaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection

@push('scripts')
<script>
// Modal functions
function openOfferModal() {
    document.getElementById('createOfferModal').style.display = 'flex';
}

function closeOfferModal() {
    document.getElementById('createOfferModal').style.display = 'none';
}

// Close modal when clicking outside
document.addEventListener('click', function(e) {
    const modal = document.getElementById('createOfferModal');
    if (e.target === modal) {
        closeOfferModal();
    }
});

// Handle offer form submission
document.addEventListener('DOMContentLoaded', function() {
    const offerForm = document.getElementById('offerForm');
    if (offerForm) {
        offerForm.addEventListener('submit', function(e) {
            e.preventDefault();

            
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = 'Mengirim...';
            submitBtn.disabled = true;
            
            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeOfferModal();
                    // Show success message
                    alert('Penawaran berhasil dikirim!');
                    location.reload(); // Refresh to show the offer
                } else {
                    throw new Error(data.message || 'Unknown error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan: ' + error.message);
            })
            .finally(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });
    }

    // Rest of the chat functionality
    const chatItems = document.querySelectorAll('.chat-item');
    const messageInput = document.getElementById('messageInput');


    // Chat item selection
    const chatItems = document.querySelectorAll('.chat-item');
    chatItems.forEach(item => {
        item.addEventListener('click', function() {
            const chatId = this.getAttribute('data-chat-id');
            if (chatId) {
                window.location.href = `{{ route(auth()->user()->role . '.chat') }}?chat_id=${chatId}`;
            }
        });
    });

    // Auto resize textarea
    const messageInput = document.getElementById('messageInput');
    if (messageInput) {
        messageInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });

        
        // Submit on Enter (without Shift)
        messageInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                const form = this.closest('form');
                if (this.value.trim()) {
                    form.submit();
                }
            }
        });
    }

    // Scroll to bottom of chat
    const chatMessages = document.getElementById('chatMessages');
    if (chatMessages) {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Real-time chat updates (if using Laravel Echo)
    if (window.Echo && window.currentChatId) {
        window.Echo.private(`chat.${window.currentChatId}`)
            .listen('MessageSent', (e) => {
                // Add new message to chat
                appendMessage(e.message);
            });
    }
});

// Function to append new messages (for real-time updates)
function appendMessage(message) {
    const chatMessages = document.getElementById('chatMessages');
    const isOwnMessage = message.sender_id == window.userId;
    
    const messageDiv = document.createElement('div');
    messageDiv.className = `message ${isOwnMessage ? 'sent' : 'received'}`;
    
    messageDiv.innerHTML = `
        <div class="message-avatar">
            <img src="${message.sender.profile?.avatar_url || 'https://via.placeholder.com/32'}"
                 alt="${message.sender.name}">
        </div>
        <div class="message-content">
            ${message.content}
            <div class="message-time">
                ${new Date(message.created_at).toLocaleTimeString('en-US', {hour: '2-digit', minute: '2-digit'})}
                ${isOwnMessage ? `
                    <span class="message-status">
                        <iconify-icon icon="material-symbols:check" style="font-size: 0.75rem; color: var(--chat-accent-green);"></iconify-icon>
                        <iconify-icon icon="material-symbols:check" style="font-size: 0.75rem; margin-left: -0.25rem; color: var(--chat-accent-green);"></iconify-icon>
                    </span>
                ` : ''}
            </div>
        </div>
    `;
    
    chatMessages.appendChild(messageDiv);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

// Set current chat data for Echo
window.currentChatId = "{{ isset($activeChat) ? $activeChat->id : '' }}";
window.userId = "{{ auth()->id() }}";
</script>
@endpush