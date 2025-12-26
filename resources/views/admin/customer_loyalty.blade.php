@extends('layouts.admin')

@section('content')
<div class="top-bar">
    <h1 class="page-title">Customer Loyalty</h1>
    
    <div class="sub-nav">
        <a href="{{ route('admin.voucher_stats') }}">Voucher Stats</a>
        <a href="{{ route('admin.customer_loyalty') }}" class="active">Customer Loyalty</a>
        <a href="{{ route('admin.loyalty.rules') }}" style="background: #F1F5F9; color: #475569; margin-left: 12px; border: 1px solid #E2E8F0;">⚙️ Rules</a>
    </div>
</div>

<div class="dashboard-content">
    <div style="background: white; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border: 1px solid #E2E8F0; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #F8FAFC; border-bottom: 1px solid #E2E8F0;">
                    <th style="text-align: left; padding: 16px 24px; font-size: 12px; font-weight: 600; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em;">Customer</th>
                    <th style="text-align: left; padding: 16px 24px; font-size: 12px; font-weight: 600; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em;">Stamps</th>
                    <th style="text-align: left; padding: 16px 24px; font-size: 12px; font-weight: 600; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em;">Status</th>
                    <th style="text-align: left; padding: 16px 24px; font-size: 12px; font-weight: 600; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em;">Current Inventory</th>
                    <th style="text-align: left; padding: 16px 24px; font-size: 12px; font-weight: 600; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em;">Past History</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                    <tr style="border-bottom: 1px solid #F1F5F9;">
                        <td style="padding: 16px 24px;">
                            <div style="font-weight: 600; color: #0F172A;">{{ $customer['name'] }}</div>
                            <div style="font-size: 13px; color: #64748B;">{{ $customer['email'] }}</div>
                            <div style="font-size: 12px; color: #94A3B8; margin-top: 2px;">ID: {{ $customer['customer_id'] }}</div>
                        </td>
                        <td style="padding: 16px 24px;">
                            <div style="display: inline-flex; align-items: center; gap: 6px; font-weight: 700; color: #0F172A; background: #FFEDD5; padding: 4px 12px; border-radius: 99px;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="#F97316" stroke="none">
                                    <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"></path>
                                </svg>
                                {{ $customer['current_stamps'] }}
                            </div>
                        </td>
                        <td style="padding: 16px 24px;">
                            @if($customer['active_vouchers'] > 0)
                                <span style="background: #DCFCE7; color: #166534; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 600;">
                                    {{ $customer['active_vouchers'] }} Active
                                </span>
                            @else
                                <span style="background: #F1F5F9; color: #64748B; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 600;">
                                    No Active Vouchers
                                </span>
                            @endif
                        </td>
                        <td style="padding: 16px 24px; width: 25%;">
                            <div style="font-family: monospace; font-size: 13px; color: #334155; white-space: pre-wrap; line-height: 1.5;">{{ $customer['voucher_inventory'] ?: '-' }}</div>
                        </td>
                        <td style="padding: 16px 24px; width: 25%;">
                            <div style="font-family: monospace; font-size: 13px; color: #64748B; white-space: pre-wrap; line-height: 1.5;">{{ $customer['voucher_history'] ?: '-' }}</div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding: 32px; text-align: center; color: #64748B;">No customer data found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
