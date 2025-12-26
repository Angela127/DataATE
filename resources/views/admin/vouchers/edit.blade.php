@extends('layouts.admin')

@section('content')
<div class="top-bar">
    <h1 class="page-title">Edit Voucher</h1>
    <a href="{{ route('admin.voucher_stats') }}" class="btn-secondary" style="padding: 8px 16px; background: #F1F5F9; border-radius: 8px; text-decoration: none; color: #64748B; font-weight: 500;">Back</a>
</div>

<div style="background: white; padding: 32px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); max-width: 600px;">
    <form action="{{ route('admin.vouchers.update', $voucher->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1E293B;">Voucher Code</label>
            <div style="padding: 10px; background: #F1F5F9; border-radius: 8px; color: #64748B;">{{ $voucher->voucher_code }}</div>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1E293B;">Details</label>
            <div style="padding: 10px; background: #F1F5F9; border-radius: 8px; color: #64748B;">
                {{ $voucher->discount_percent ? $voucher->discount_percent . '% Discount' : $voucher->free_hours . ' Hours Free' }}
            </div>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1E293B;">Description</label>
            <input type="text" name="description" value="{{ $voucher->description }}" placeholder="Voucher description" style="width: 100%; padding: 10px; border: 1px solid #E2E8F0; border-radius: 8px; font-family: inherit;">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1E293B;">Status</label>
            <select name="status" style="width: 100%; padding: 10px; border: 1px solid #E2E8F0; border-radius: 8px; font-family: inherit;">
                <option value="active" {{ $voucher->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="used" {{ $voucher->status == 'used' ? 'selected' : '' }}>Used</option>
                <option value="expired" {{ $voucher->status == 'expired' ? 'selected' : '' }}>Expired</option>
            </select>
        </div>

        <div style="margin-bottom: 32px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1E293B;">Expiry Date</label>
            <input type="date" name="expiry_date" required value="{{ $voucher->expiry_date->format('Y-m-d') }}" style="width: 100%; padding: 10px; border: 1px solid #E2E8F0; border-radius: 8px; font-family: inherit;">
        </div>

        <button type="submit" style="background: #F97316; color: white; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; width: 100%;">Update Voucher</button>
    </form>
</div>
@endsection
