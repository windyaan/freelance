<!-- <!-- @extends('layouts.app')

@section('title', 'Milestones - ' . $order->title)
@section('page-title', 'Project Milestones')

@section('navbar-center')
    @component('components.search')
        @slot('placeholder', 'Search milestones...')
    @endcomponent
@endsection

@section('navigation')
    <a href="{{ auth()->user()->role === 'client' ? route('client.dashboard') : route('freelancer.dashboard') }}" class="nav-item">
        <div class="nav-icon">
            <iconify-icon icon="material-symbols:dashboard"></iconify-icon>
        </div>
        <span class="nav-text">Dashboard</span>
    </a>

    <a href="{{ auth()->user()->role === 'client' ? route('client.order') : route('freelancer.order') }}" class="nav-item">
        <div class="nav-icon">
            <iconify-icon icon="material-symbols:work"></iconify-icon>
        </div>
        <span class="nav-text">Orders</span>
    </a>

    <a href="{{ route('milestones.index', $order) }}" class="nav-item active">
        <div class="nav-icon">
            <iconify-icon icon="material-symbols:flag"></iconify-icon>
        </div>
        <span class="nav-text">Milestones</span>
    </a>
@endsection

@section('content')
<div class="milestone-container">
    <!-- Back Button -->
    <div class="back-section">
        <a href="{{ auth()->user()->role === 'client' ? route('client.order') : route('freelancer.order') }}" 
           class="back-btn">
            <iconify-icon icon="material-symbols:arrow-back"></iconify-icon>
            Back to Orders
        </a>
    </div>

    <!-- Project Header -->
    <div class="project-header">
        <div class="project-info">
            <div class="project-meta">
                <span class="project-date">{{ $order->created_at->format('l, d F Y') }}</span>
                <div class="project-status status-{{ strtolower(str_replace(' ', '-', $order->status)) }}">
                    {{ ucfirst($order->status) }}
                </div>
            </div>
            
            <h1 class="project-title">Project Title: {{ $order->title }}</h1>
            <p class="client-info">
                Client: <strong>{{ $order->client->name }}</strong>
            </p>
            
            <div class="project-details">
                <div class="detail-item">
                    <span class="label">Revision:</span>
                    <span class="value">{{ $order->revisions ?? '2x' }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">Budget:</span>
                    <span class="value budget">{{ $order->formatted_budget ?? 'Rp700.000' }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">Paid:</span>
                    <span class="value paid">{{ $order->formatted_paid ?? 'Rp300.000' }} 
                        <span class="payment-badge">💳</span>
                    </span>
                </div>
            </div>

            <div class="project-description">
                <h3>Description:</h3>
                <div class="description-content">
                    <p><strong>Tema:</strong> {{ $order->theme ?? 'Kombinasi tradisional-modern, nuansa Bali' }}</p>
                    <p><strong>Warna utama:</strong> {{ $order->primary_colors ?? 'Oranje (boleh tambah warna pendukung seperti hitam, putih, emas)' }}</p>
                    <p><strong>Gaya:</strong> {{ $order->style ?? 'Ilustrasi detail + pola dekoratif' }}</p>
                    <p><strong>Mood:</strong> {{ $order->mood ?? 'Berani, kuat, energik' }}</p>
                    <p><strong>Penempatan desain:</strong> {{ $order->placement ?? 'Fokus bagian depan atau full-print' }}</p>
                </div>

                <div class="output-requirements">
                    <h4>Output:</h4>
                    <ul>
                        <li>{{ $order->output_vector ?? 'File vector (AI/PSD)' }}</li>
                        <li>{{ $order->output_png ?? 'File PNG resolusi tinggi' }}</li>
                        <li>{{ $order->output_print ?? 'Siap cetak untuk produksi kaos' }}</li>
                    </ul>
                </div>
            </div>

            <!-- Payment Schedule -->
            <div class="payment-schedule">
                <div class="schedule-item">
                    <span class="schedule-label">Waktu Pengerjaan:</span>
                    <div class="schedule-value">
                        <input type="date" value="{{ $order->due_date ? $order->due_date->format('Y-m-d') : '2025-08-12' }}" readonly>
                    </div>
                </div>
            </div>

            <!-- Progress Update Section -->
            @if(auth()->user()->role === 'freelancer')
            <div class="progress-update-section">
                <h3>Detail Progress</h3>
                <form action="{{ route('milestones.updateProgress', [$order, $milestones->first()]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="progress-form">
                        <textarea name="progress_description" 
                                  placeholder="Pembuatan design barong dan makna tiap ikon.&#10;&#10;link: https://drive.google.com/file/d/1AbCdEfGhIjKlMnOpQrStUvWxYz123456/view?usp=sharing"
                                  class="progress-textarea">{{ old('progress_description', $milestones->first()->progress_description ?? 'Pembuatan design barong dan makna tiap ikon.

link: https://drive.google.com/file/d/1AbCdEfGhIjKlMnOpQrStUvWxYz123456/view?usp=sharing') }}</textarea>
                        
                        <div class="form-actions">
                            <button type="submit" class="submit-progress-btn">Submit Progress</button>
                            <button type="button" class="done-btn" onclick="markMilestoneComplete()">Done ✓</button>
                        </div>
                    </div>
                </form>
            </div>
            @endif
        </div>

        <!-- Milestone Timeline -->
        <div class="milestone-timeline">
            <h2 class="timeline-title">
                <iconify-icon icon="material-symbols:flag"></iconify-icon>
                Milestone
            </h2>
            
            <div class="timeline">
                @forelse($milestones as $milestone)
                <div class="timeline-item {{ $milestone->status }}">
                    <div class="timeline-marker">
                        <div class="marker-dot status-{{ $milestone->status }}"></div>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-date">{{ $milestone->formatted_due_date }}</div>
                        <div class="timeline-text">{{ $milestone->title }}</div>
                        @if($milestone->status === 'approved')
                            <div class="timeline-status approved">✓</div>
                        @elseif($milestone->status === 'in_progress')
                            <div class="timeline-status progress">⏳</div>
                        @elseif($milestone->status === 'completed')
                            <div class="timeline-status done">✓</div>
                        @elseif($milestone->status === 'revision_requested')
                            <div class="timeline-status revision">🔄</div>
                        @endif
                    </div>
                </div>
                @empty
                <!-- Default milestones -->
                <div class="timeline-item approved">
                    <div class="timeline-marker">
                        <div class="marker-dot status-approved"></div>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-date">8 Agustus 2025</div>
                        <div class="timeline-text">Sketsa pen desain barong</div>
                        <div class="timeline-status approved">✓</div>
                    </div>
                </div>

                <div class="timeline-item progress">
                    <div class="timeline-marker">
                        <div class="marker-dot status-in-progress"></div>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-date">30 Juli 2025</div>
                        <div class="timeline-text">Project diorder</div>
                        <div class="timeline-status progress">⏳</div>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Milestone Legend -->
            <div class="milestone-legend">
                <div class="legend-item">
                    <div class="legend-dot status-start"></div>
                    <span>Start</span>
                </div>
                <div class="legend-item">
                    <div class="legend-dot status-progress"></div>
                    <span>Progress</span>
                </div>
                <div class="legend-item">
                    <div class="legend-dot status-done"></div>
                    <span>Done</span>
                </div>
                <div class="legend-item">
                    <div class="legend-dot status-revision"></div>
                    <span>Revision</span>
                </div>
            </div>

            <!-- Action Buttons -->
            @if(auth()->user()->role === 'freelancer' && $order->status !== 'completed')
                <div class="milestone-actions">
                    <a href="{{ route('milestones.create', $order) }}" class="btn btn-primary">
                        <iconify-icon icon="material-symbols:add"></iconify-icon>
                        Add Milestone
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-section" id="milestoneStats">
        <div class="stat-card">
            <div class="stat-icon">
                <iconify-icon icon="material-symbols:flag"></iconify-icon>
            </div>
            <div class="stat-content">
                <div class="stat-number" id="totalMilestones">{{ $milestones->count() }}</div>
                <div class="stat-label">Total Milestones</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon approved">
                <iconify-icon icon="material-symbols:check-circle"></iconify-icon>
            </div>
            <div class="stat-content">
                <div class="stat-number" id="approvedMilestones">{{ $milestones->where('status', 'approved')->count() }}</div>
                <div class="stat-label">Approved</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon progress">
                <iconify-icon icon="material-symbols:schedule"></iconify-icon>
            </div>
            <div class="stat-content">
                <div class="stat-number" id="progressMilestones">{{ $milestones->where('status', 'in_progress')->count() }}</div>
                <div class="stat-label">In Progress</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <iconify-icon icon="material-symbols:payments"></iconify-icon>
            </div>
            <div class="stat-content">
                <div class="stat-number" id="progressPercentage">{{ $order->milestone_progress ?? '43' }}%</div>
                <div class="stat-label">Progress</div>
            </div>
        </div>
    </div>
</div>

<!-- Client Action Modal -->
@if(auth()->user()->role === 'client')
<div class="modal-overlay" id="clientActionModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle">Milestone Action</h3>
            <button class="modal-close" onclick="closeModal()">
                <iconify-icon icon="material-symbols:close"></iconify-icon>
            </button>
        </div>
        <div class="modal-body" id="modalBody">
            <!-- Content will be populated by JavaScript -->
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal()">Cancel</button>
            <button class="btn btn-primary" id="confirmAction">Confirm</button>
        </div>
    </div>
</div>
@endif

@endsection

@push('styles')
<style>
:root {
    --primary-color: #38C1B9;
    --secondary-color: #7E8EF1;
    --success-color: #22c55e;
    --warning-color: #f59e0b;
    --error-color: #ef4444;
    --bg-primary: #ffffff;
    --bg-secondary: #f8fafc;
    --bg-muted: #f1f5f9;
    --text-primary: #1e293b;
    --text-secondary: #64748b;
    --border-color: #e2e8f0;
    --border-light: #f1f5f9;
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
    --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1);
}

.milestone-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem;
    background: var(--bg-secondary);
    min-height: 100vh;
}

/* Back Section */
.back-section {
    margin-bottom: 2rem;
}

.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-secondary);
    text-decoration: none;
    font-weight: 500;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    transition: all 0.2s ease;
    border: 1px solid var(--border-color);
    background: white;
}

.back-btn:hover {
    color: var(--primary-color);
    background: var(--bg-muted);
    transform: translateX(-2px);
}

/* Project Header */
.project-header {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 3rem;
    margin-bottom: 3rem;
}

.project-info {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border-light);
}

.project-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--border-light);
}

.project-date {
    color: var(--text-secondary);
    font-size: 1rem;
    font-weight: 500;
}

.project-status {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
    text-transform: capitalize;
}

.status-accepted {
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.15), rgba(34, 197, 94, 0.1));
    color: #16a34a;
    border: 1px solid rgba(34, 197, 94, 0.3);
}

.status-in-progress {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(59, 130, 246, 0.1));
    color: #2563eb;
    border: 1px solid rgba(59, 130, 246, 0.3);
}

.project-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
    line-height: 1.2;
}

.client-info {
    color: var(--text-secondary);
    font-size: 1rem;
    margin-bottom: 1.5rem;
}

.client-info strong {
    color: var(--text-primary);
    font-weight: 600;
}

.project-details {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    margin-bottom: 2rem;
    padding: 1rem;
    background: var(--bg-muted);
    border-radius: 12px;
}

.detail-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.detail-item .label {
    font-size: 0.8rem;
    color: var(--text-secondary);
    font-weight: 500;
}

.detail-item .value {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary);
}

.detail-item .value.budget {
    color: var(--primary-color);
    font-size: 1.1rem;
}

.detail-item .value.paid {
    color: var(--success-color);
    font-size: 1.1rem;
}

.payment-badge {
    font-size: 0.8rem;
}

.project-description h3 {
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 1rem;
}

.description-content {
    background: var(--bg-muted);
    padding: 1.5rem;
    border-radius: 12px;
    margin-bottom: 1rem;
}

.description-content p {
    margin-bottom: 0.75rem;
    line-height: 1.5;
    color: var(--text-secondary);
}

.description-content strong {
    color: var(--text-primary);
    font-weight: 600;
}

.output-requirements {
    background: var(--bg-muted);
    padding: 1.5rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
}

.output-requirements h4 {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.75rem;
}

.output-requirements ul {
    list-style: none;
    padding: 0;
}

.output-requirements li {
    padding: 0.5rem 0;
    color: var(--text-secondary);
    position: relative;
    padding-left: 1.5rem;
}

.output-requirements li::before {
    content: "✓";
    position: absolute;
    left: 0;
    color: var(--success-color);
    font-weight: bold;
}

.payment-schedule {
    margin-bottom: 2rem;
}

.schedule-item {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.schedule-label {
    font-weight: 600;
    color: var(--text-primary);
    min-width: 150px;
}

.schedule-value input {
    padding: 0.5rem 1rem;
    border: 2px solid var(--border-color);
    border-radius: 8px;
    font-size: 0.9rem;
    color: var(--text-primary);
    background: white;
}

/* Progress Update Section */
.progress-update-section {
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 2px solid var(--border-light);
}

.progress-update-section h3 {
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 1rem;
}

.progress-form {
    background: var(--bg-muted);
    padding: 1.5rem;
    border-radius: 12px;
}

.progress-textarea {
    width: 100%;
    min-height: 120px;
    padding: 1rem;
    border: 2px solid var(--border-color);
    border-radius: 8px;
    font-size: 0.9rem;
    line-height: 1.5;
    color: var(--text-primary);
    background: white;
    resize: vertical;
    margin-bottom: 1rem;
}

.progress-textarea:focus {
    outline: none;
    border-color: var(--primary-color);
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
}

.submit-progress-btn, .done-btn {
    padding: 0.75rem 2rem;
    border: none;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}

.submit-progress-btn {
    background: var(--text-primary);
    color: white;
}

.submit-progress-btn:hover {
    background: #0f172a;
    transform: translateY(-1px);
}

.done-btn {
    background: var(--success-color);
    color: white;
}

.done-btn:hover {
    background: #16a34a;
    transform: translateY(-1px);
}

/* Milestone Timeline */
.milestone-timeline {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border-light);
}

.timeline-title {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 2rem;
    text-align: center;
    justify-content: center;
}

.timeline-title iconify-icon {
    color: var(--primary-color);
    font-size: 1.8rem;
}

.timeline {
    position: relative;
    padding-left: 2rem;
    margin-bottom: 2rem;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: linear-gradient(180deg, var(--primary-color), var(--secondary-color));
}

.timeline-item {
    position: relative;
    margin-bottom: 2rem;
    padding-left: 2rem;
}

.timeline-marker {
    position: absolute;
    left: -2rem;
    top: 0.25rem;
}

.marker-dot {
    width: 16px;
    height: 16px;
    border-radius: 50%;
    border: 3px solid white;
    box-shadow: var(--shadow-sm);
}

.marker-dot.status-approved {
    background: var(--success-color);
}

.marker-dot.status-in-progress {
    background: var(--warning-color);
    animation: pulse 2s infinite;
}

.marker-dot.status-done {
    background: var(--primary-color);
}

.marker-dot.status-revision {
    background: var(--error-color);
}

@keyframes pulse {
    0%, 100% {
        box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.4);
    }
    50% {
        box-shadow: 0 0 0 8px rgba(245, 158, 11, 0);
    }
}

.timeline-content {
    background: var(--bg-muted);
    padding: 1rem;
    border-radius: 12px;
    position: relative;
}

.timeline-date {
    font-size: 0.8rem;
    color: var(--text-secondary);
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.timeline-text {
    font-size: 0.9rem;
    color: var(--text-primary);
    font-weight: 500;
}

.timeline-status {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    font-size: 1.2rem;
}

.timeline-status.approved {
    color: var(--success-color);
}

.timeline-status.progress {
    color: var(--warning-color);
}

.timeline-status.done {
    color: var(--primary-color);
}

.timeline-status.revision {
    color: var(--error-color);
}

/* Milestone Legend */
.milestone-legend {
    display: flex;
    justify-content: center;
    gap: 2rem;
    margin-bottom: 2rem;
    padding: 1rem;
    background: var(--bg-muted);
    border-radius: 12px;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.8rem;
    font-weight: 500;
    color: var(--text-secondary);
}

.legend-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.legend-dot.status-start {
    background: var(--primary-color);
}

.legend-dot.status-progress {
    background: var(--warning-color);
}

.legend-dot.status-done {
    background: var(--success-color);
}

.legend-dot.status-revision {
    background: var(--error-color);
}

.milestone-actions {
    text-align: center;
}

/* Statistics Section */
.stats-section {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    padding: 1.5rem;
    border-radius: 16px;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border-light);
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    font-size: 1.5rem;
}

.stat-icon.approved {
    background: linear-gradient(135deg, var(--success-color), #16a34a);
}

.stat-icon.progress {
    background: linear-gradient(135deg, var(--warning-color), #d97706);
}

.stat-content {
    flex: 1;
}

.stat-number {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--text-primary);
    line-height: 1;
}

.stat-label {
    font-size: 0.9rem;
    color: var(--text-secondary);
    font-weight: 500;
}

/* Modal Styles */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    backdrop-filter: blur(4px);
}

.modal-overlay.show {
    display: flex;
}

.modal-content {
    background: white;
    border-radius: 16px;
    width: 90%;
    max-width: 500px;
    max-height: 80vh;
    overflow-y: auto;
    box-shadow: var(--shadow-xl);
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-light);
}

.modal-header h3 {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0;
}

.modal-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: var(--text-secondary);
    padding: 0.5rem;
    border-radius: 50%;
    transition: all 0.2s ease;
}

.modal-close:hover {
    background: var(--bg-muted);
    color: var(--text-primary);
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    padding: 1.5rem;
    border-top: 1px solid var(--border-light);
}

.btn {
    padding: 0.6rem 1.2rem;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    border: none;
}

.btn-primary {
    background: var(--primary-color);
    color: white;
}

.btn-primary:hover {
    background: #2dd4cc;
    transform: translateY(-1px);
}

.btn-secondary {
    background: var(--bg-muted);
    color: var(--text-secondary);
    border: 1px solid var(--border-color);
}

.btn-secondary:hover {
    background: var(--border-color);
    color: var(--text-primary);
}

/* Mobile Responsiveness */
@media (max-width: 1024px) {
    .project-header {
        grid-template-columns: 1fr;
        gap: 2rem;
    }

    .stats-section {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .milestone-container {
        padding: 1rem;
    }

    .project-details {
        grid-template-columns: 1fr;
        gap: 0.5rem;
    }

    .form-actions {
        flex-direction: column;
    }

    .milestone-legend {
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .stats-section {
        grid-template-columns: 1fr;
    }

    .stat-card {
        padding: 1rem;
    }

    .timeline {
        padding-left: 1rem;
    }

    .timeline-item {
        padding-left: 1.5rem;
    }

    .timeline-marker {
        left: -1.5rem;
    }
}

@media (max-width: 480px) {
    .project-title {
        font-size: 1.4rem;
    }

    .modal-content {
        width: 95%;
        margin: 1rem;
    }

    .milestone-legend {
        grid-template-columns: 1fr;
        gap: 0.5rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Global variables
// let currentOrder = @json($order);
// let milestones = @json($milestones);

// Initialize milestone page
function initMilestonePage() {
    console.log('Initializing milestone page...');
    
    // Load statistics
    loadMilestoneStatistics();
    
    // Setup event listeners
    setupEventListeners();
    
    console.log('Milestone page initialized');
}

function setupEventListeners() {
    // Modal close on overlay click
    const modal = document.getElementById('clientActionModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });
    }

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });

    // Auto-resize textarea
    const textarea = document.querySelector('.progress-textarea');
    if (textarea) {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    }
}

function loadMilestoneStatistics() {
    // Update statistics from server
    fetch(`/orders/${currentOrder.id}/milestones/statistics`)
        .then(response => response.json())
        .then(data => {
            updateStatisticsDisplay(data);
        })
        .catch(error => {
            console.error('Failed to load statistics:', error);
        });
}

function updateStatisticsDisplay(stats) {
    const totalElement = document.getElementById('totalMilestones');
    const approvedElement = document.getElementById('approvedMilestones');
    const progressElement = document.getElementById('progressMilestones');
    const percentageElement = document.getElementById('progressPercentage');

    if (totalElement) totalElement.textContent = stats.total;
    if (approvedElement) approvedElement.textContent = stats.approved;
    if (progressElement) progressElement.textContent = stats.in_progress;
    if (percentageElement) percentageElement.textContent = stats.progress_percentage + '%';
}

function markMilestoneComplete() {
    const currentMilestone = milestones.find(m => m.status === 'in_progress' || m.status === 'pending');
    
    if (!currentMilestone) {
        alert('No active milestone to complete');
        return;
    }

    if (confirm('Are you sure you want to mark this milestone as complete?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/orders/${currentOrder.id}/milestones/${currentMilestone.id}/complete`;
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (csrfToken) {
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken.content;
            form.appendChild(csrfInput);
        }

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PATCH';
        form.appendChild(methodInput);

        document.body.appendChild(form);
        form.submit();
    }
}

function approveMilestone(milestoneId) {
    showClientModal('approve', milestoneId);
}

function requestRevision(milestoneId) {
    showClientModal('revision', milestoneId);
}

function showClientModal(action, milestoneId) {
    const modal = document.getElementById('clientActionModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalBody = document.getElementById('modalBody');
    const confirmBtn = document.getElementById('confirmAction');

    if (!modal) return;

    const milestone = milestones.find(m => m.id === milestoneId);
    if (!milestone) return;

    if (action === 'approve') {
        modalTitle.textContent = 'Approve Milestone';
        modalBody.innerHTML = `
            <div class="approval-content">
                <p>Are you sure you want to approve the milestone "<strong>${milestone.title}</strong>"?</p>
                <div class="milestone-summary">
                    <h4>Milestone Details:</h4>
                    <p><strong>Title:</strong> ${milestone.title}</p>
                    <p><strong>Amount:</strong> ${milestone.formatted_amount}</p>
                    <p><strong>Due Date:</strong> ${milestone.formatted_due_date}</p>
                    ${milestone.progress_description ? `<p><strong>Progress:</strong> ${milestone.progress_description}</p>` : ''}
                </div>
                <div class="warning-note">
                    <p><strong>Note:</strong> Once approved, this milestone payment will be processed and cannot be undone.</p>
                </div>
            </div>
        `;
        
        confirmBtn.textContent = 'Approve Milestone';
        confirmBtn.className = 'btn btn-primary';
        confirmBtn.onclick = () => executeMilestoneAction('approve', milestoneId);
        
    } else if (action === 'revision') {
        modalTitle.textContent = 'Request Revision';
        modalBody.innerHTML = `
            <div class="revision-content">
                <p>Request revision for milestone "<strong>${milestone.title}</strong>"</p>
                <div class="form-group">
                    <label for="revisionNotes">Revision Notes:</label>
                    <textarea id="revisionNotes" placeholder="Please describe what needs to be revised..." rows="4" style="width: 100%; padding: 0.5rem; border: 2px solid var(--border-color); border-radius: 8px; resize: vertical;"></textarea>
                </div>
            </div>
        `;
        
        confirmBtn.textContent = 'Request Revision';
        confirmBtn.className = 'btn btn-primary';
        confirmBtn.onclick = () => executeMilestoneAction('revision', milestoneId);
    }

    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
}

function executeMilestoneAction(action, milestoneId) {
    const form = document.createElement('form');
    form.method = 'POST';
    
    if (action === 'approve') {
        form.action = `/orders/${currentOrder.id}/milestones/${milestoneId}/approve`;
    } else if (action === 'revision') {
        form.action = `/orders/${currentOrder.id}/milestones/${milestoneId}/revision`;
        
        const revisionNotes = document.getElementById('revisionNotes');
        if (!revisionNotes || !revisionNotes.value.trim()) {
            alert('Please provide revision notes');
            return;
        }
        
        const notesInput = document.createElement('input');
        notesInput.type = 'hidden';
        notesInput.name = 'revision_notes';
        notesInput.value = revisionNotes.value;
        form.appendChild(notesInput);
    }
    
    // Add CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (csrfToken) {
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken.content;
        form.appendChild(csrfInput);
    }

    // Add method
    const methodInput = document.createElement('input');
    methodInput.type = 'hidden';
    methodInput.name = '_method';
    methodInput.value = 'PATCH';
    form.appendChild(methodInput);

    document.body.appendChild(form);
    form.submit();
}

function closeModal() {
    const modal = document.getElementById('clientActionModal');
    if (modal) {
        modal.classList.remove('show');
        document.body.style.overflow = '';
    }
}

function downloadAttachment(orderId, milestoneId) {
    window.open(`/orders/${orderId}/milestones/${milestoneId}/attachment`, '_blank');
}

// Global functions for compatibility
window.markMilestoneComplete = markMilestoneComplete;
window.approveMilestone = approveMilestone;
window.requestRevision = requestRevision;
window.closeModal = closeModal;
window.downloadAttachment = downloadAttachment;


document.addEventListener('DOMContentLoaded', function() {
    initMilestonePage();
});


document.addEventListener('submit', function(e) {
    if (e.target.matches('.progress-form form')) {
        const submitBtn = e.target.querySelector('.submit-progress-btn');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<iconify-icon icon="material-symbols:hourglass-empty"></iconify-icon> Updating...';
        }
    }
});


let autoSaveTimeout;
const progressTextarea = document.querySelector('.progress-textarea');
if (progressTextarea) {
    progressTextarea.addEventListener('input', function() {
        clearTimeout(autoSaveTimeout);
        autoSaveTimeout = setTimeout(() => {
          
            console.log('Auto-saving progress...');
        }, 2000);
    });
}
</script>
@endpush 