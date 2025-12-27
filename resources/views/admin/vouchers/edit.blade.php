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
            <div class="fleet-page-title">Edit Voucher</div>
            <div class="fleet-page-subtitle">Update voucher details for {{ $voucher->voucher_code }}.</div>
        </div>
        <a href="{{ route('admin.vouchers.index') }}" class="btn-back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
            Back to list
        </a>
    </div>

    <div class="fleet-form-card">
        <form action="{{ route('admin.vouchers.update', $voucher->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="section-title">Voucher Overview</div>
            <div class="section-divider"></div>

            <div class="form-grid">
                <div class="form-group">
                    <label>Voucher Code</label>
                    <input type="text" value="{{ $voucher->voucher_code }}" disabled style="background: #F1F5F9; color: #64748B;">
                </div>

                <div class="form-group">
                    <label>Details</label>
                    <input type="text" value="{{ $voucher->discount_percent ? $voucher->discount_percent . '% Discount' : $voucher->free_hours . ' Hours Free' }}" disabled style="background: #F1F5F9; color: #64748B;">
                </div>
            </div>

            <div class="section-title" style="margin-top: 24px;">Configuration</div>
            <div class="section-divider"></div>

            <div class="form-grid">
                <div class="form-group">
                    <label>Description</label>
                    <input type="text" name="description" value="{{ $voucher->description }}" placeholder="Voucher description">
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status">
                        <option value="active" {{ $voucher->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="used" {{ $voucher->status == 'used' ? 'selected' : '' }}>Used</option>
                        <option value="expired" {{ $voucher->status == 'expired' ? 'selected' : '' }}>Expired</option>
                    </select>
                </div>

                 <div class="form-group">
                    <label>Expiry Date</label>
                    <input type="date" name="expiry_date" required value="{{ $voucher->expiry_date->format('Y-m-d') }}">
                </div>
            </div>

            <div class="fleet-form-footer">
                <a href="{{ route('admin.voucher_stats') }}" class="btn-outline">Cancel</a>
                <button type="submit" class="btn-primary">Update Voucher</button>
            </div>
        </form>
    </div>
@endsection
