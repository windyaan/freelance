@extends('layouts.client')

@section('title', 'Profile - SkillMatch')

@section('content')
{{-- Paste semua CSS dan HTML dari template Anda di sini --}}

<!-- Ganti bagian profile data dengan data dari controller -->
<div class="profile-card">
    <img src="{{ $user->profile_image ?? 'https://images.unsplash.com/photo-1494790108755-2616b612b47c?w=200&h=200&fit=crop&crop=face' }}" 
         alt="Profile" class="profile-image">
    
    <h1 class="profile-name">{{ $user->name ?? 'Nadia Ima' }}</h1>
    
    <div class="profile-skills">
        <span class="skill-tag">UI Design</span>
        <span class="skill-tag">Front-End</span>
    </div>
    
    <div class="profile-contact">
        <div class="contact-item">
            <strong>EMAIL :</strong> {{ $user->email ?? 'namira@gmail.com' }}
        </div>
        <div class="contact-item">
            <strong>SKILLS :</strong> {{ $user->profile->skills ?? 'photoshop, canva, laravel' }}
        </div>
    </div>
    
    <div class="profile-bio">
        <p>{{ $user->profile->bio ?? "I'm a third-year IT student at Airlangga University passionate about software development, UI design, and data analytics." }}</p>
        
        <p style="margin-top: 1rem;">{{ $user->profile->achievement ?? "As a Top 200 Finalist in the 2023 National UI Design Competition, I demonstrated my ability to create intuitive, visually appealing digital experiences." }}</p>
    </div>
</div>

{{-- JavaScript tetap sama --}}
@endsection