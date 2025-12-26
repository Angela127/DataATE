@extends('layouts.admin')

@section('content')
    <style>
        .fleet-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .fleet-title { font-size: 24px; font-weight: 700; color: #1E293B; }
        .fleet-toolbar { display: flex; gap: 12px; }
        .btn-add-car { border: none; outline: none; padding: 10px 18px; border-radius: 999px; font-size: 14px; font-weight: 600; background: #FF7F50; color: #FFFFFF; cursor: pointer; transition: all 0.1s ease; text-decoration: none; display: inline-block;}
        .btn-add-car:hover { background: #ff6a32; }
        .fleet-card { background: #FFFFFF; border-radius: 16px; padding: 20px 24px; border: 1px solid #E2E8F0; box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06); margin-bottom: 24px; }
        .fleet-table { width: 100%; border-collapse: collapse; font-size: 14px; }
        .fleet-table thead tr { background: rgba(255, 247, 237, 2); }
        .fleet-table th, .fleet-table td { padding: 12px 14px; text-align: left; border-bottom: 1px solid #E2E8F0; }
        .fleet-table th { font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: .04em; color: #000000ff; }
        .fleet-table tbody tr:hover { background: rgba(255, 247, 237, 0.5); }
        .sub-nav { display: flex; gap: 8px; margin-bottom: 20px; }
        .sub-nav a { padding: 6px 12px; border-radius: 8px; font-size: 13px; font-weight: 500; text-decoration: none; color: #64748B; background: #eff6ff; }
        .sub-nav a.active { background: #FFEADD; color: #D35400; font-weight: 600; }
    </style>

    <div class="fleet-header">
        <div class="fleet-title">Voucher Statistics</div>
        <div class="fleet-toolbar">
            <div class="sub-nav" style="margin-bottom: 0;">
                <a href="{{ route('admin.voucher_stats') }}" class="active">Voucher Stats</a>
                <a href="{{ route('admin.customer_loyalty') }}">Customer Loyalty</a>
                <a href="{{ route('admin.loyalty.rules') }}">Rules</a>
            </div>
        </div>
    </div>

    <!-- Statistics Table -->
    <div class="fleet-card">
        <div style="font-size: 16px; font-weight: 700; color: #1E293B; margin-bottom: 16px;">Overall Performance</div>
        <table class="fleet-table">
            <thead>
                <tr>
                    <th>Voucher Type</th>
                    <th style="text-align: center;">Total Issued</th>
                    <th style="text-align: center;">Used</th>
                    <th style="text-align: center;">Expired</th>
                    <th>Active Rate</th>
                </tr>
            </thead>
            <tbody>
                @forelse($voucherStats as $stat)
                    <tr>
                        <td>
                            <div style="font-weight: 600; color: #0F172A;">{{ $stat['type'] }}</div>
                        </td>
                        <td style="color: #334155; text-align: center;">{{ $stat['total_issued'] }}</td>
                        <td style="color: #334155; text-align: center;">{{ $stat['total_used'] }}</td>
                        <td style="color: #334155; text-align: center;">{{ $stat['total_expired'] }}</td>
                        <td>
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

    <!-- Individual Vouchers Table -->
    <div class="fleet-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <div style="font-size: 16px; font-weight: 700; color: #1E293B;">All Vouchers</div>
            <a href="{{ route('admin.vouchers.create') }}" class="btn-add-car">
                + Create Voucher
            </a>
        </div>
        <table class="fleet-table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Customer</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Expiry</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allVouchers as $voucher)
                <tr>
                    <td style="font-weight: 600; color: #0F172A;">{{ $voucher->voucher_code }}</td>
                    <td style="color: #475569;">{{ optional($voucher->customer->user)->email ?? 'N/A' }}</td>
                    <td>
                        @if($voucher->discount_percent) 
                            <span style="font-weight: 500; color: #0EA5E9;">{{ $voucher->discount_percent }}% Off</span>
                        @endif
                        @if($voucher->free_hours) 
                            <span style="font-weight: 500; color: #8B5CF6;">{{ $voucher->free_hours }}H Free</span>
                        @endif
                    </td>
                    <td>
                        <span style="padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 600; 
                            background: {{ $voucher->status == 'active' ? '#DCFCE7' : ($voucher->status == 'used' ? '#E2E8F0' : '#FECACA') }};
                            color: {{ $voucher->status == 'active' ? '#166534' : ($voucher->status == 'used' ? '#475569' : '#991B1B') }};">
                            {{ ucfirst($voucher->status) }}
                        </span>
                    </td>
                     <td style="font-size: 13px; color: #64748B;">{{ $voucher->expiry_date->format('d M Y') }}</td>
                     <td style="text-align: right;">
                         <a href="{{ route('admin.vouchers.edit', $voucher->id) }}" style="color: #4F46E5; text-decoration: none; margin-right: 12px; font-weight: 500; font-size: 13px;">Edit</a>
                         <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure?');">
                             @csrf @method('DELETE')
                             <button type="submit" style="background: none; border: none; color: #DC2626; cursor: pointer; font-weight: 500; font-size: 13px;">Delete</button>
                         </form>
                     </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="padding-top: 20px;">
            {{ $allVouchers->links() }}
        </div>
    </div>
@endsection
