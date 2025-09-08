@extends('layouts.app')

@section('title', 'Laporkan Masalah - SkillMatch')

@section('page-title', 'Laporkan Masalah')

@section('navigation')
<a href="{{ route('client.dashboard') }}" class="nav-item">
    <div class="nav-icon">
        <iconify-icon icon="material-symbols:dashboard"></iconify-icon>
    </div>
    <span class="nav-text">Dashboard</span>
</a>
<a href="{{ route('client.order') }}" class="nav-item">
    <div class="nav-icon">
        <iconify-icon icon="material-symbols:list-alt"></iconify-icon>
    </div>
    <span class="nav-text">Orders</span>
</a>
<a href="#" class="nav-item active">
    <div class="nav-icon">
        <iconify-icon icon="material-symbols:report-problem"></iconify-icon>
    </div>
    <span class="nav-text">Laporan</span>
</a>
@endsection

@push('styles')
<style>
    .report-container {
        max-width: 800px;
        margin: 0 auto;
        background: white;
        border-radius: 16px;
        padding: 2.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
    }

    .report-header {
        text-align: center;
        margin-bottom: 2.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid #f1f5f9;
    }

    .report-header h1 {
        font-size: 2.2rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
    }

    .report-header iconify-icon {
        font-size: 2.5rem;
        color: #dc2626;
    }

    .report-header p {
        color: #64748b;
        font-size: 1.1rem;
        line-height: 1.6;
    }

    .order-context {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .order-context h3 {
        font-size: 1.2rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .order-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .order-detail-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .order-detail-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .order-detail-value {
        font-size: 1rem;
        color: #1e293b;
        font-weight: 500;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        font-size: 1rem;
    }

    .form-label.required::after {
        content: ' *';
        color: #dc2626;
    }

    .form-input,
    .form-select,
    .form-textarea {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.2s ease;
        background: white;
    }

    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
        outline: none;
        border-color: #38C1B9;
        box-shadow: 0 0 0 3px rgba(56, 193, 185, 0.1);
    }

    .form-textarea {
        resize: vertical;
        min-height: 120px;
        font-family: inherit;
    }

    .form-help {
        font-size: 0.85rem;
        color: #64748b;
        margin-top: 0.5rem;
    }

    .category-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        margin-top: 0.5rem;
    }

    .category-option {
        position: relative;
    }

    .category-radio {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .category-label {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        background: white;
    }

    .category-label:hover {
        border-color: #38C1B9;
        background: #f0fdfc;
    }

    .category-radio:checked + .category-label {
        border-color: #38C1B9;
        background: #f0fdfc;
    }

    .category-icon {
        flex-shrink: 0;
        width: 24px;
        height: 24px;
        color: #38C1B9;
    }

    .category-content h4 {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.25rem;
        font-size: 0.95rem;
    }

    .category-content p {
        font-size: 0.8rem;
        color: #64748b;
        line-height: 1.4;
    }

    .button-group {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2.5rem;
        padding-top: 2rem;
        border-top: 1px solid #e5e7eb;
    }

    .btn {
        padding: 0.75rem 2rem;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-cancel {
        background: #f1f5f9;
        color: #64748b;
        border: 1px solid #e2e8f0;
    }

    .btn-cancel:hover {
        background: #e2e8f0;
        color: #475569;
    }

    .btn-submit {
        background: #dc2626;
        color: white;
    }

    .btn-submit:hover {
        background: #b91c1c;
        transform: translateY(-1px);
    }

    .btn-submit:disabled {
        background: #9ca3af;
        cursor: not-allowed;
        transform: none;
    }

    .alert {
        padding: 1rem 1.25rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        font-size: 0.95rem;
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .alert-error {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }

    @media (max-width: 768px) {
        .report-container {
            padding: 1.5rem;
            margin: 1rem;
        }

        .report-header h1 {
            font-size: 1.8rem;
        }

        .category-grid {
            grid-template-columns: 1fr;
        }

        .button-group {
            flex-direction: column-reverse;
            gap: 0.75rem;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<div class="report-container">
    <!-- Report Header -->
    <div class="report-header">
        <h1>
            <iconify-icon icon="material-symbols:report-problem"></iconify-icon>
            Laporkan Masalah
        </h1>
        <p>Sampaikan keluhan atau masalah yang Anda alami dengan freelancer atau layanan. Tim kami akan meninjau laporan Anda dalam 1x24 jam.</p>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success">
            <iconify-icon icon="material-symbols:check-circle"></iconify-icon>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            <iconify-icon icon="material-symbols:error"></iconify-icon>
            <strong>Terdapat kesalahan:</strong>
            <ul style="margin-top: 0.5rem; margin-left: 1rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Order Context (if order is provided) -->
    @if($orderContext)
        <div class="order-context">
            <h3>
                <iconify-icon icon="material-symbols:assignment"></iconify-icon>
                Detail Order
            </h3>
            <div class="order-details">
                <div class="order-detail-item">
                    <span class="order-detail-label">Order ID</span>
                    <span class="order-detail-value">#{{ $orderContext->id }}</span>
                </div>
                <div class="order-detail-item">
                    <span class="order-detail-label">Judul</span>
                    <span class="order-detail-value">{{ $orderContext->offer->title ?? 'N/A' }}</span>
                </div>
                <div class="order-detail-item">
                    <span class="order-detail-label">Freelancer</span>
                    <span class="order-detail-value">{{ $orderContext->offer->job->freelancer->name ?? 'N/A' }}</span>
                </div>
                <div class="order-detail-item">
                    <span class="order-detail-label">Status</span>
                    <span class="order-detail-value">{{ ucfirst($orderContext->status) }}</span>
                </div>
                <div class="order-detail-item">
                    <span class="order-detail-label">Nilai</span>
                    <span class="order-detail-value">Rp{{ number_format($orderContext->amount, 0, ',', '.') }}</span>
                </div>
                <div class="order-detail-item">
                    <span class="order-detail-label">Tanggal Order</span>
                    <span class="order-detail-value">{{ $orderContext->created_at->format('d M Y') }}</span>
                </div>
            </div>
        </div>
    @endif

    <!-- Report Form -->
    <form action="{{ route('client.reports.store') }}" method="POST" id="reportForm">
        @csrf
        
        <!-- Hidden fields -->
        @if($orderContext)
            <input type="hidden" name="order_id" value="{{ $orderContext->id }}">
            <input type="hidden" name="freelancer_id" value="{{ $orderContext->offer->job->freelancer->id ?? '' }}">
        @endif

        <!-- Freelancer Selection (if no order context) -->
        @if(!$orderContext && count($freelancers) > 0)
            <div class="form-group">
                <label class="form-label required" for="freelancer_id">Freelancer</label>
                <select class="form-select" id="freelancer_id" name="freelancer_id" required>
                    <option value="">Pilih freelancer yang ingin dilaporkan</option>
                    @foreach($freelancers as $freelancer)
                        <option value="{{ $freelancer->id }}" {{ old('freelancer_id') == $freelancer->id ? 'selected' : '' }}>
                            {{ $freelancer->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif

        <!-- Report Category -->
        <div class="form-group">
            <label class="form-label required">Kategori Masalah</label>
            <div class="category-grid">
                <div class="category-option">
                    <input type="radio" name="category" value="quality_issue" id="quality_issue" class="category-radio" {{ old('category') == 'quality_issue' ? 'checked' : '' }}>
                    <label for="quality_issue" class="category-label">
                        <iconify-icon icon="material-symbols:star-rate" class="category-icon"></iconify-icon>
                        <div class="category-content">
                            <h4>Masalah Kualitas</h4>
                            <p>Hasil kerja tidak sesuai ekspektasi atau brief</p>
                        </div>
                    </label>
                </div>
                
                <div class="category-option">
                    <input type="radio" name="category" value="communication_problem" id="communication_problem" class="category-radio" {{ old('category') == 'communication_problem' ? 'checked' : '' }}>
                    <label for="communication_problem" class="category-label">
                        <iconify-icon icon="material-symbols:chat-error" class="category-icon"></iconify-icon>
                        <div class="category-content">
                            <h4>Masalah Komunikasi</h4>
                            <p>Freelancer tidak responsif atau sulit dihubungi</p>
                        </div>
                    </label>
                </div>
                
                <div class="category-option">
                    <input type="radio" name="category" value="deadline_missed" id="deadline_missed" class="category-radio" {{ old('category') == 'deadline_missed' ? 'checked' : '' }}>
                    <label for="deadline_missed" class="category-label">
                        <iconify-icon icon="material-symbols:schedule" class="category-icon"></iconify-icon>
                        <div class="category-content">
                            <h4>Deadline Terlewat</h4>
                            <p>Pekerjaan tidak selesai tepat waktu</p>
                        </div>
                    </label>
                </div>
                
                <div class="category-option">
                    <input type="radio" name="category" value="payment_dispute" id="payment_dispute" class="category-radio" {{ old('category') == 'payment_dispute' ? 'checked' : '' }}>
                    <label for="payment_dispute" class="category-label">
                        <iconify-icon icon="material-symbols:payment" class="category-icon"></iconify-icon>
                        <div class="category-content">
                            <h4>Sengketa Pembayaran</h4>
                            <p>Masalah terkait pembayaran atau refund</p>
                        </div>
                    </label>
                </div>
                
                <div class="category-option">
                    <input type="radio" name="category" value="inappropriate_behavior" id="inappropriate_behavior" class="category-radio" {{ old('category') == 'inappropriate_behavior' ? 'checked' : '' }}>
                    <label for="inappropriate_behavior" class="category-label">
                        <iconify-icon icon="material-symbols:report" class="category-icon"></iconify-icon>
                        <div class="category-content">
                            <h4>Perilaku Tidak Pantas</h4>
                            <p>Perilaku tidak profesional atau melanggar aturan</p>
                        </div>
                    </label>
                </div>
                
                <div class="category-option">
                    <input type="radio" name="category" value="other" id="other" class="category-radio" {{ old('category') == 'other' ? 'checked' : '' }}>
                    <label for="other" class="category-label">
                        <iconify-icon icon="material-symbols:help" class="category-icon"></iconify-icon>
                        <div class="category-content">
                            <h4>Lainnya</h4>
                            <p>Masalah lain yang tidak termasuk kategori di atas</p>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Report Title -->
        <div class="form-group">
            <label class="form-label required" for="title">Judul Laporan</label>
            <input type="text" class="form-input" id="title" name="title" 
                   value="{{ old('title') }}" 
                   placeholder="Ringkasan singkat masalah yang Anda alami"
                   required maxlength="255">
            <div class="form-help">Maksimal 255 karakter</div>
        </div>

        <!-- Report Description -->
        <div class="form-group">
            <label class="form-label required" for="description">Detail Masalah</label>
            <textarea class="form-textarea" id="description" name="description" 
                      placeholder="Jelaskan secara detail masalah yang Anda alami. Semakin lengkap informasi yang Anda berikan, semakin mudah bagi tim kami untuk membantu menyelesaikan masalah."
                      required minlength="10">{{ old('description') }}</textarea>
            <div class="form-help">Minimal 10 karakter. Berikan detail sebanyak mungkin untuk proses penyelesaian yang lebih efektif.</div>
        </div>

        <!-- Submit Buttons -->
        <div class="button-group">
            <a href="{{ route('client.order') }}" class="btn btn-cancel">
                <iconify-icon icon="material-symbols:arrow-back"></iconify-icon>
                Kembali
            </a>
            <button type="submit" class="btn btn-submit" id="submitBtn">
                <iconify-icon icon="material-symbols:send"></iconify-icon>
                Kirim Laporan
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('reportForm');
    const submitBtn = document.getElementById('submitBtn');
    
    // Form validation
    form.addEventListener('submit', function(e) {
        const title = document.getElementById('title').value.trim();
        const description = document.getElementById('description').value.trim();
        const category = document.querySelector('input[name="category"]:checked');
        
        if (!title || !description || !category) {
            e.preventDefault();
            alert('Mohon lengkapi semua field yang wajib diisi.');
            return;
        }
        
        if (description.length < 10) {
            e.preventDefault();
            alert('Detail masalah minimal 10 karakter.');
            return;
        }
        
        // Disable submit button to prevent double submission
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<iconify-icon icon="material-symbols:hourglass-top"></iconify-icon> Mengirim...';
    });
    
    // Character counter for title
    const titleInput = document.getElementById('title');
    titleInput.addEventListener('input', function() {
        const remaining = 255 - this.value.length;
        const helpText = this.nextElementSibling;
        helpText.textContent = `${remaining} karakter tersisa`;
        
        if (remaining < 50) {
            helpText.style.color = '#dc2626';
        } else {
            helpText.style.color = '#64748b';
        }
    });
    
    // Word counter for description
    const descriptionTextarea = document.getElementById('description');
    descriptionTextarea.addEventListener('input', function() {
        const wordCount = this.value.trim().split(/\s+/).length;
        const charCount = this.value.length;
        const helpText = this.nextElementSibling;
        
        if (charCount >= 10) {
            helpText.textContent = `${charCount} karakter, ${wordCount} kata`;
            helpText.style.color = '#64748b';
        } else {
            helpText.textContent = `Minimal 10 karakter (${charCount} saat ini)`;
            helpText.style.color = '#dc2626';
        }
    });
});
</script>
@endsection