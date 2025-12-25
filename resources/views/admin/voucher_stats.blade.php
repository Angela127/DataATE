@extends('layouts.admin')

@section('content')
<div class="top-bar">
    <h1 class="page-title">Voucher Statistics</h1>
    
    <div class="sub-nav">
        <a href="{{ route('admin.voucher_stats') }}" class="active">Voucher Stats</a>
        <a href="{{ route('admin.customer_loyalty') }}">Customer Loyalty</a>
    </div>
</div>

<div class="dashboard-content">
    <div style="background: white; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border: 1px solid #E2E8F0; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #F8FAFC; border-bottom: 1px solid #E2E8F0;">
                    <th style="text-align: left; padding: 16px 24px; font-size: 12px; font-weight: 600; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em;">Voucher Type</th>
                    <th style="text-align: left; padding: 16px 24px; font-size: 12px; font-weight: 600; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em;">Total Issued</th>
                    <th style="text-align: left; padding: 16px 24px; font-size: 12px; font-weight: 600; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em;">Redeemed</th>
                    <th style="text-align: left; padding: 16px 24px; font-size: 12px; font-weight: 600; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em;">Expired</th>
                    <th style="text-align: left; padding: 16px 24px; font-size: 12px; font-weight: 600; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em;">Active Rate</th>
                </tr>
            </thead>
            <tbody>
                @forelse($voucherStats as $stat)
                    <tr style="border-bottom: 1px solid #F1F5F9;">
                        <td style="padding: 16px 24px;">
                            <div style="font-weight: 600; color: #0F172A;">{{ $stat['type'] }}</div>
                        </td>
                        <td style="padding: 16px 24px; color: #334155;">{{ $stat['total_issued'] }}</td>
                        <td style="padding: 16px 24px; color: #334155;">{{ $stat['total_used'] }}</td>
                        <td style="padding: 16px 24px; color: #334155;">{{ $stat['total_expired'] }}</td>
                        <td style="padding: 16px 24px;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="flex: 1; height: 8px; background: #F1F5F9; border-radius: 4px; max-width: 120px;">
                                    <div style="width: {{ $stat['active_rate'] }}%; height: 100%; background: #14B8A6; border-radius: 4px;"></div>
                                </div>
                                <span style="font-size: 13px; font-weight: 500; color: #64748B;">{{ $stat['active_rate'] }}%</span>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding: 32px; text-align: center; color: #64748B;">No voucher statistics available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
