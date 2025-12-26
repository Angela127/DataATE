@extends('layouts.admin')

@section('content')
    <style>
        .fleet-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .fleet-title { font-size: 24px; font-weight: 700; color: #1E293B; }
        .fleet-toolbar { display: flex; gap: 12px; }
        .data-card { background: #FFFFFF; border-radius: 16px; padding: 32px; border: 1px solid #E2E8F0; box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06); max-width: 900px; }
        .sub-nav { display: flex; gap: 8px; margin-bottom: 20px; }
        .sub-nav a { padding: 6px 12px; border-radius: 8px; font-size: 13px; font-weight: 500; text-decoration: none; color: #64748B; background: #eff6ff; }
        .sub-nav a.active { background: #FFEADD; color: #D35400; font-weight: 600; }
        
        .form-label { display: block; font-size: 13px; font-weight: 600; color: #64748B; margin-bottom: 6px; }
        .form-input { width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 14px; color: #1E293B; transition: all 0.2s; outline: none; }
        .form-input:focus { border-color: #F97316; box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1); }
        .rule-row { display: flex; align-items: center; gap: 16px; padding: 16px; background: #F8FAFC; border-radius: 12px; margin-bottom: 12px; border: 1px solid #E2E8F0; }
    </style>

    <div class="fleet-header">
        <div class="fleet-title">Loyalty Configuration</div>
        <div class="fleet-toolbar">
            <div class="sub-nav" style="margin-bottom: 0;">
                <a href="{{ route('admin.vouchers.index') }}">Voucher Stats</a>
                <a href="{{ route('admin.loyalty.index') }}">Customer Loyalty</a>
                <a href="{{ route('admin.loyalty.rules') }}" class="active">Rules</a>
            </div>
        </div>
    </div>

    <div class="data-card">
        <div style="margin-bottom: 24px;">
            <h2 style="font-size: 18px; font-weight: 700; color: #1E293B; margin-bottom: 8px;">Reward Tiers</h2>
            <p style="color: #64748B; font-size: 14px; line-height: 1.5;">Define the rewards customers receive upon accumulating specific numbers of stamps. Changes saved here will apply immediately to new redemptions.</p>
        </div>
        
        <form action="{{ route('admin.loyalty.rules.update') }}" method="POST">
            @csrf
            
            <div style="display: flex; flex-direction: column; gap: 4px;">
                @foreach($tiers as $stamps => $rule)
                <div class="rule-row">
                    <div style="width: 140px;">
                        <span class="form-label">Stamps Required</span>
                        <div style="position: relative;">
                            <input type="number" name="rules[{{ $loop->index }}][stamps]" value="{{ $stamps }}" required min="1" class="form-input" style="padding-right: 32px;">
                            <div style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); font-size: 16px;"></div>
                        </div>
                    </div>
                    
                    <div style="flex: 1;">
                        <span class="form-label">Reward Type</span>
                        <select name="rules[{{ $loop->index }}][type]" class="form-input" style="background: white;">
                            <option value="discount" {{ $rule['type'] == 'discount' ? 'selected' : '' }}>Discount (%)</option>
                            <option value="free_hours" {{ $rule['type'] == 'free_hours' ? 'selected' : '' }}>Free Rental Hours</option>
                        </select>
                    </div>

                    <div style="width: 140px;">
                        <span class="form-label">Value</span>
                        <input type="number" name="rules[{{ $loop->index }}][amount]" value="{{ $rule['amount'] }}" required min="1" class="form-input">
                    </div>
                </div>
                @endforeach
            </div>

            <div style="margin-top: 32px; padding-top: 24px; border-top: 1px solid #E2E8F0; text-align: right;">
                 <button type="submit" style="background: #F97316; color: white; border: none; padding: 12px 32px; border-radius: 999px; font-weight: 600; cursor: pointer; font-size: 14px; box-shadow: 0 4px 12px rgba(249, 115, 22, 0.25); transition: transform 0.1s;">
                    Save Configuration
                 </button>
            </div>
        </form>
    </div>
@endsection
