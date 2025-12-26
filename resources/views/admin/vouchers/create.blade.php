@extends('layouts.admin')

@section('content')
    <style>
        .fleet-page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .fleet-page-title { font-size: 24px; font-weight: 700; color: #1E293B; }
        .fleet-page-subtitle { font-size: 13px; color: #64748B; margin-top: 4px; }
        .btn-back { display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; border-radius: 999px; border: 1px solid #E2E8F0; background: #FFFFFF; font-size: 13px; color: #475569; text-decoration: none; }
        .btn-back svg { width: 16px; height: 16px; }
        .fleet-form-card { background: #FFFFFF; border-radius: 16px; padding: 20px 24px; border: 1px solid #E2E8F0; box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06); max-width: 960px; }
        .form-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px 24px; }
        .form-group label { display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 4px; }
        .form-group input, .form-group select { width: 100%; border-radius: 10px; border: 1px solid #E2E8F0; padding: 10px 12px; font-size: 14px; color: #0F172A; outline: none; }
        .form-group input:focus, .form-group select:focus { border-color: #FF7F50; box-shadow: 0 0 0 1px rgba(255, 127, 80, 0.25); }
        .form-group small { font-size: 12px; color: #94A3B8; }
        .section-title { font-size: 14px; font-weight: 700; color: #1E293B; margin: 10px 0 4px; }
        .section-divider { height: 1px; background: #E2E8F0; margin-bottom: 16px; }
        .fleet-form-footer { display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; }
        .btn-outline { border-radius: 999px; border: 1px solid #CBD5F5; padding: 9px 18px; font-size: 14px; color: #475569; background: #FFFFFF; cursor: pointer; text-decoration: none; }
        .btn-primary { border-radius: 999px; border: none; padding: 10px 20px; font-size: 14px; font-weight: 600; background: #FF7F50; color: #FFFFFF; cursor: pointer; }
        .btn-primary:hover { background: #ff6a32; }
        @media (max-width: 900px) { .form-grid { grid-template-columns: 1fr; } }
    </style>

    <div class="fleet-page-header">
        <div>
            <div class="fleet-page-title">Create New Voucher</div>
            <div class="fleet-page-subtitle">Issue a new voucher to a customer.</div>
        </div>
        <a href="{{ route('admin.voucher_stats') }}" class="btn-back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
            Back to list
        </a>
    </div>

    <div class="fleet-form-card">
        @if ($errors->any())
            <div style="margin-bottom: 14px; padding: 10px 12px; border-radius: 10px; background:#FEE2E2; color:#B91C1C; font-size: 13px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.vouchers.store') }}" method="POST">
            @csrf
            
            <div class="section-title">Recipient & Details</div>
            <div class="section-divider"></div>

            <div class="form-grid">
                <div class="form-group">
                    <label>Customer Email</label>
                    <input type="email" name="email" required placeholder="customer@example.com">
                </div>

                <div class="form-group">
                    <label>Description (Optional)</label>
                    <input type="text" name="description" placeholder="e.g. Birthday Special">
                </div>
            </div>

            <div class="section-title" style="margin-top: 24px;">Voucher Configuration</div>
            <div class="section-divider"></div>

            <div class="form-grid">
                <div class="form-group">
                    <label>Type</label>
                    <select name="type">
                        <option value="discount">Discount (%)</option>
                        <option value="free_hours">Free Hours</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Amount</label>
                    <input type="number" name="amount" required min="1" placeholder="e.g. 10 or 5">
                    <small>Enter percentage or hours based on type.</small>
                </div>
                
                <div class="form-group">
                    <label>Validity (Days)</label>
                    <input type="number" name="expiry_days" required value="30" min="1">
                </div>
            </div>

            <div class="fleet-form-footer">
                <a href="{{ route('admin.voucher_stats') }}" class="btn-outline">Cancel</a>
                <button type="submit" class="btn-primary">Create Voucher</button>
            </div>
        </form>
    </div>
@endsection
