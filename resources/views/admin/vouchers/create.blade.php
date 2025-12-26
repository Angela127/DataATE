@extends('layouts.admin')

@section('content')
<div class="top-bar">
    <h1 class="page-title">Create New Voucher</h1>
    <a href="{{ route('admin.voucher_stats') }}" class="btn-secondary" style="padding: 8px 16px; background: #F1F5F9; border-radius: 8px; text-decoration: none; color: #64748B; font-weight: 500;">Back</a>
</div>

<div style="background: white; padding: 32px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); max-width: 600px;">
    @if ($errors->any())
        <div style="margin-bottom: 24px; padding: 12px; background: #FEF2F2; color: #DC2626; border-radius: 8px; border: 1px solid #FECACA;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.vouchers.store') }}" method="POST">
        @csrf
        
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1E293B;">Customer Email</label>
            <input type="email" name="email" required placeholder="customer@example.com" style="width: 100%; padding: 10px; border: 1px solid #E2E8F0; border-radius: 8px; font-family: inherit;">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1E293B;">Description (Optional)</label>
            <input type="text" name="description" placeholder="e.g. Birthday Special" style="width: 100%; padding: 10px; border: 1px solid #E2E8F0; border-radius: 8px; font-family: inherit;">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1E293B;">Type</label>
                <select name="type" style="width: 100%; padding: 10px; border: 1px solid #E2E8F0; border-radius: 8px; font-family: inherit;">
                    <option value="discount">Discount (%)</option>
                    <option value="free_hours">Free Hours</option>
                </select>
            </div>
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1E293B;">Amount</label>
                <input type="number" name="amount" required min="1" placeholder="e.g. 10 or 5" style="width: 100%; padding: 10px; border: 1px solid #E2E8F0; border-radius: 8px; font-family: inherit;">
            </div>
        </div>

        <div style="margin-bottom: 32px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1E293B;">Validity (Days)</label>
            <input type="number" name="expiry_days" required value="30" min="1" style="width: 100%; padding: 10px; border: 1px solid #E2E8F0; border-radius: 8px; font-family: inherit;">
        </div>

        <button type="submit" style="background: #F97316; color: white; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; width: 100%;">Create Voucher</button>
    </form>
</div>
@endsection
