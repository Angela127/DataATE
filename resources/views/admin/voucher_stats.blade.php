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
                    <th style="text-align: center; padding: 16px 24px; font-size: 12px; font-weight: 600; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em;">Total Issued</th>
                    <th style="text-align: center; padding: 16px 24px; font-size: 12px; font-weight: 600; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em;">Used</th>
                    <th style="text-align: center; padding: 16px 24px; font-size: 12px; font-weight: 600; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em;">Expired</th>
                    <th style="text-align: center; padding: 16px 24px; font-size: 12px; font-weight: 600; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em;">Active Rate</th>
                </tr>
            </thead>
            <tbody>
                @forelse($voucherStats as $stat)
                    <tr style="border-bottom: 1px solid #F1F5F9;">
                        <td style="padding: 16px 24px;">
                            <div style="font-weight: 600; color: #0F172A;">{{ $stat['type'] }}</div>
                        </td>
                        <td style="padding: 16px 24px; color: #334155; text-align: center;">{{ $stat['total_issued'] }}</td>
                        <td style="padding: 16px 24px; color: #334155; text-align: center;">{{ $stat['total_used'] }}</td>
                        <td style="padding: 16px 24px; color: #334155; text-align: center;">{{ $stat['total_expired'] }}</td>
                        <td style="padding: 16px 24px;">
                            <div style="display: flex; align-items: center; justify-content: center; gap: 12px;">
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
    <div style="margin-top: 40px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
        <h2 style="font-size: 18px; font-weight: 700; color: #1E293B;">Manage Individual Vouchers</h2>
        <a href="{{ route('admin.vouchers.create') }}" style="background: #F97316; color: white; padding: 10px 20px; border-radius: 8px; font-weight: 600; text-decoration: none; font-size: 14px;">+ Create Voucher</a>
    </div>

    <div style="background: white; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border: 1px solid #E2E8F0; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #F8FAFC; border-bottom: 1px solid #E2E8F0;">
                    <th style="text-align: left; padding: 16px 24px;">Code</th>
                    <th style="text-align: left; padding: 16px 24px;">Customer</th>
                    <th style="text-align: left; padding: 16px 24px;">Type</th>
                    <th style="text-align: left; padding: 16px 24px;">Status</th>
                    <th style="text-align: left; padding: 16px 24px;">Expiry</th>
                    <th style="text-align: right; padding: 16px 24px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allVouchers as $voucher)
                <tr style="border-bottom: 1px solid #F1F5F9;">
                    <td style="padding: 16px 24px; font-weight: 600;">{{ $voucher->voucher_code }}</td>
                    <td style="padding: 16px 24px;">{{ optional($voucher->customer->user)->email ?? 'N/A' }}</td>
                    <td style="padding: 16px 24px;">
                        @if($voucher->discount_percent) {{ $voucher->discount_percent }}% Off @endif
                        @if($voucher->free_hours) {{ $voucher->free_hours }}H Free @endif
                    </td>
                    <td style="padding: 16px 24px;">
                        <span style="padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600; 
                            background: {{ $voucher->status == 'active' ? '#DCFCE7' : ($voucher->status == 'used' ? '#E2E8F0' : '#FECACA') }};
                            color: {{ $voucher->status == 'active' ? '#166534' : ($voucher->status == 'used' ? '#475569' : '#991B1B') }};">
                            {{ ucfirst($voucher->status) }}
                        </span>
                    </td>
                     <td style="padding: 16px 24px; font-size: 13px;">{{ $voucher->expiry_date->format('d M Y') }}</td>
                     <td style="padding: 16px 24px; text-align: right;">
                         <a href="{{ route('admin.vouchers.edit', $voucher->id) }}" style="color: #4F46E5; text-decoration: none; margin-right: 12px; font-weight: 500;">Edit</a>
                         <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure?');">
                             @csrf @method('DELETE')
                             <button type="submit" style="background: none; border: none; color: #DC2626; cursor: pointer; font-weight: 500;">Delete</button>
                         </form>
                     </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="padding: 20px;">
            {{ $allVouchers->links() }}
        </div>
    </div>
</div>
@endsection
