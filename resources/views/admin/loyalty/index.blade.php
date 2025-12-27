@extends('layouts.admin')

@section('content')
    <style>
        .fleet-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .fleet-title { font-size: 24px; font-weight: 700; color: #1E293B; }
        .fleet-toolbar { display: flex; gap: 12px; }
        .fleet-search { display: flex; align-items: center; gap: 8px; background: #FFFFFF; border-radius: 999px; border: 1px solid #E2E8F0; padding: 8px 14px; min-width: 280px; }
        .fleet-search input { border: none; outline: none; font-size: 14px; width: 100%; background: transparent; color: #1E293B; }
        .fleet-search svg { width: 16px; height: 16px; color: #64748B; }
        .btn-add-car { border: none; outline: none; padding: 10px 18px; border-radius: 999px; font-size: 14px; font-weight: 600; background: #FF7F50; color: #FFFFFF; cursor: pointer; box-shadow: 0 8px 20px rgba(255, 127, 80, 0.35); transition: all 0.1s ease; text-decoration: none; display: inline-block;}
        .btn-add-car:hover { background: #ff6a32; }
        .fleet-card { background: #FFFFFF; border-radius: 16px; padding: 20px 24px; border: 1px solid #E2E8F0; box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06); }
        .fleet-table { width: 100%; border-collapse: collapse; font-size: 14px; }
        .fleet-table thead tr { background: rgba(255, 247, 237, 2); }
        .fleet-table th, .fleet-table td { padding: 12px 14px; text-align: left; border-bottom: 1px solid #E2E8F0; }
        .fleet-table th { font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: .04em; color: #000000ff; }
        .fleet-table tbody tr:hover { background: rgba(255, 247, 237, 0.5); }
        .sub-nav { display: flex; gap: 8px; margin-bottom: 20px; }
        .sub-nav a { padding: 6px 12px; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; color: #64748B; background: #eff6ff; }
        .sub-nav a.active { background: #FFEADD; color: #D35400; }
    </style>

    <div class="fleet-header">
        <div class="fleet-title">Customer Loyalty</div>
        <div class="fleet-toolbar">
            <div class="sub-nav" style="margin-bottom: 0;">
                <a href="{{ route('admin.vouchers.index') }}">Voucher Stats</a>
                <a href="{{ route('admin.loyalty.index') }}" class="active">Customer Loyalty</a>
                <a href="{{ route('admin.loyalty.rules') }}">Rules</a>
            </div>
        </div>
    </div>

    <div class="fleet-card">
        <table class="fleet-table">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Stamps</th>
                    <th>Active Status</th>
                    <th>Current Inventory</th>
                    <th>Past History</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                    <tr>
                        <td>
                            <div style="font-weight: 600; color: #0F172A;">{{ $customer['name'] }}</div>
                            <div style="font-size: 12px; color: #64748B;">{{ $customer['email'] }}</div>
                        </td>
                        <td>
                            <div style="display: inline-flex; align-items: center; gap: 6px; font-weight: 700; color: #D97706; background: #FFF7ED; padding: 4px 10px; border-radius: 99px; border: 1px solid #FFEDD5;">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor" stroke="none">
                                    <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"></path>
                                </svg>
                                {{ $customer['current_stamps'] }}
                            </div>
                        </td>
                        <td>
                            @if($customer['active_vouchers'] > 0)
                                <span style="background: #DCFCE7; color: #166534; padding: 4px 10px; border-radius: 99px; font-size: 12px; font-weight: 600;">
                                    {{ $customer['active_vouchers'] }} Active
                                </span>
                            @else
                                <span style="background: #F1F5F9; color: #64748B; padding: 4px 10px; border-radius: 99px; font-size: 12px; font-weight: 600;">
                                    None
                                </span>
                            @endif
                        </td>
                        <td style="width: 25%;">
                            <div style="font-family: monospace; font-size: 12px; color: #334155; white-space: pre-wrap; line-height: 1.4;">{{ $customer['voucher_inventory'] ?: '-' }}</div>
                        </td>
                        <td style="width: 25%;">
                            <div style="font-family: monospace; font-size: 12px; color: #94A3B8; white-space: pre-wrap; line-height: 1.4;">{{ $customer['voucher_history'] ?: '-' }}</div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: #64748B; padding: 32px;">No customer data found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
