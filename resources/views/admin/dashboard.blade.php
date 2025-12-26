@extends('layouts.admin')

@section('content')
<div class="top-bar">
    <h1 class="page-title">Admin Dashboard</h1>
</div>

<div class="dashboard-content">
    <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 24px; color: #1E293B;">Voucher Overview</h2>
    
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;">
        <div style="background: white; padding: 24px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border: 1px solid #E2E8F0;">
            <div style="font-size: 36px; font-weight: 700; color: #0F172A; margin-bottom: 4px;">{{ $totalVouchers }}</div>
            <div style="color: #64748B; font-size: 14px; font-weight: 500;">Total Vouchers Issued</div>
        </div>
        
        <div style="background: white; padding: 24px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border: 1px solid #E2E8F0;">
            <div style="font-size: 36px; font-weight: 700; color: #14B8A6; margin-bottom: 4px;">{{ $totalRedeemed }}</div>
            <div style="color: #64748B; font-size: 14px; font-weight: 500;">Total Used</div>
        </div>
        
        <div style="background: white; padding: 24px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border: 1px solid #E2E8F0;">
            <div style="font-size: 36px; font-weight: 700; color: #F59E0B; margin-bottom: 4px;">{{ $totalExpired }}</div>
            <div style="color: #64748B; font-size: 14px; font-weight: 500;">Expired Vouchers</div>
        </div>
    </div>
</div>
@endsection
