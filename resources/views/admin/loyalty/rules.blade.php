@extends('layouts.admin')

@section('content')
<div class="top-bar">
    <h1 class="page-title">Loyalty Rules</h1>
    <a href="{{ route('admin.customer_loyalty') }}" class="btn-secondary" style="padding: 8px 16px; background: #F1F5F9; border-radius: 8px; text-decoration: none; color: #64748B; font-weight: 500;">Back</a>
</div>

<div style="background: white; padding: 32px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); max-width: 800px;">
    <p style="margin-bottom: 24px; color: #64748B;">Configure the rewards for each stamp tier. Changes apply immediately to new redemptions.</p>
    
    <form action="{{ route('admin.loyalty.rules.update') }}" method="POST">
        @csrf
        
        <table style="width: 100%; border-collapse: separate; border-spacing: 0 12px;">
            <thead>
                <tr>
                    <th style="text-align: left; font-size: 13px; color: #94A3B8;">Stamps Required</th>
                    <th style="text-align: left; font-size: 13px; color: #94A3B8;">Reward Type</th>
                    <th style="text-align: left; font-size: 13px; color: #94A3B8;">Value</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tiers as $stamps => $rule)
                <tr style="background: #F8FAFC; border-radius: 8px;">
                    <td style="padding: 16px; border-top-left-radius: 8px; border-bottom-left-radius: 8px;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <input type="number" name="rules[{{ $loop->index }}][stamps]" value="{{ $stamps }}" required min="1" style="width: 80px; padding: 8px; border: 1px solid #E2E8F0; border-radius: 6px;">
                            <span style="color: #64748B; font-weight: 600;">Stamps</span>
                        </div>
                    </td>
                    <td style="padding: 16px;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                           <span style="color: #64748B;">Reward:</span>
                           <select name="rules[{{ $loop->index }}][type]" style="width: 140px; padding: 8px; border: 1px solid #E2E8F0; border-radius: 6px;">
                                <option value="discount" {{ $rule['type'] == 'discount' ? 'selected' : '' }}>Discount (%)</option>
                                <option value="free_hours" {{ $rule['type'] == 'free_hours' ? 'selected' : '' }}>Free Hours</option>
                           </select>
                        </div>
                    </td>
                    <td style="padding: 16px; border-top-right-radius: 8px; border-bottom-right-radius: 8px;">
                         <div style="display: flex; align-items: center; gap: 8px;">
                             <span style="color: #64748B;">Value:</span>
                             <input type="number" name="rules[{{ $loop->index }}][amount]" value="{{ $rule['amount'] }}" required min="1" style="width: 100px; padding: 8px; border: 1px solid #E2E8F0; border-radius: 6px;">
                         </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 32px; text-align: right;">
             <button type="submit" style="background: #F97316; color: white; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; cursor: pointer;">Save Rules</button>
        </div>
    </form>
</div>
@endsection
