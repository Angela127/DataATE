@extends('layouts.admin')

@section('content')
<div class="top-bar">
    <h1 class="page-title">Document Approvals</h1>
    
    <div class="sub-nav">
        <a href="{{ route('admin.document_approvals', ['status' => 'all']) }}" class="{{ $status === 'all' ? 'active' : '' }}">
            All
        </a>
        <a href="{{ route('admin.document_approvals', ['status' => 'pending']) }}" class="{{ $status === 'pending' ? 'active' : '' }}">
            Pending
            @if($pendingCount > 0)
                <span style="background: #EF4444; color: white; padding: 2px 8px; border-radius: 99px; font-size: 11px; font-weight: 700; margin-left: 6px;">{{ $pendingCount }}</span>
            @endif
        </a>
        <a href="{{ route('admin.document_approvals', ['status' => 'approved']) }}" class="{{ $status === 'approved' ? 'active' : '' }}">
            Approved
        </a>
        <a href="{{ route('admin.document_approvals', ['status' => 'rejected']) }}" class="{{ $status === 'rejected' ? 'active' : '' }}">
            Rejected
        </a>
    </div>
</div>

<div class="dashboard-content">
    @if(session('success'))
        <div style="background: #DCFCE7; border: 1px solid #86EFAC; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-weight: 500;">
            {{ session('success') }}
        </div>
    @endif

    <div style="background: white; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border: 1px solid #E2E8F0; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #F8FAFC; border-bottom: 1px solid #E2E8F0;">
                    <th style="text-align: left; padding: 16px 24px; font-size: 12px; font-weight: 600; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em;">Customer</th>
                    <th style="text-align: left; padding: 16px 24px; font-size: 12px; font-weight: 600; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em;">Submitted</th>
                    <th style="text-align: left; padding: 16px 24px; font-size: 12px; font-weight: 600; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em;">Status</th>
                    <th style="text-align: left; padding: 16px 24px; font-size: 12px; font-weight: 600; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                    <tr style="border-bottom: 1px solid #F1F5F9;">
                        <td style="padding: 16px 24px;">
                            <div style="font-weight: 600; color: #0F172A;">{{ $customer->user->name ?? 'Unknown' }}</div>
                            <div style="font-size: 13px; color: #64748B;">{{ $customer->user->email ?? 'N/A' }}</div>
                            <div style="font-size: 12px; color: #94A3B8; margin-top: 2px;">ID: {{ $customer->customer_id }}</div>
                        </td>
                        <td style="padding: 16px 24px;">
                            <div style="font-size: 14px; color: #334155;">
                                {{ $customer->documents_submitted_at ? $customer->documents_submitted_at->format('M d, Y') : 'N/A' }}
                            </div>
                            <div style="font-size: 12px; color: #94A3B8;">
                                {{ $customer->documents_submitted_at ? $customer->documents_submitted_at->format('h:i A') : '' }}
                            </div>
                        </td>
                        <td style="padding: 16px 24px;">
                            @if($customer->documents_status === 'pending')
                                <span style="background: #FEF3C7; color: #92400E; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600;">
                                    ⏳ Pending
                                </span>
                            @elseif($customer->documents_status === 'approved')
                                <span style="background: #DCFCE7; color: #166534; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600;">
                                    ✓ Approved
                                </span>
                            @elseif($customer->documents_status === 'rejected')
                                <span style="background: #FEE2E2; color: #991B1B; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600;">
                                    ✗ Rejected
                                </span>
                            @else
                                <span style="background: #F1F5F9; color: #64748B; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600;">
                                    Unknown
                                </span>
                            @endif
                        </td>
                        <td style="padding: 16px 24px;">
                            <div style="display: flex; gap: 8px;">
                                <button onclick="viewDocuments({{ $customer->id }}, '{{ $customer->user->name }}', '{{ asset($customer->license_image) }}', '{{ asset($customer->identity_card_image) }}', '{{ asset($customer->matric_staff_image) }}')" 
                                    style="background: #3B82F6; color: white; padding: 8px 16px; border-radius: 6px; border: none; font-size: 13px; font-weight: 600; cursor: pointer;">
                                    👁️ View
                                </button>
                                
                                @if($customer->documents_status !== 'approved')
                                    <form action="{{ route('admin.documents.approve', $customer->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" 
                                            style="background: #10B981; color: white; padding: 8px 16px; border-radius: 6px; border: none; font-size: 13px; font-weight: 600; cursor: pointer;">
                                            ✓ Approve
                                        </button>
                                    </form>
                                @endif
                                
                                @if($customer->documents_status !== 'rejected')
                                    <button onclick="showRejectModal({{ $customer->id }}, '{{ $customer->user->name }}')" 
                                        style="background: #EF4444; color: white; padding: 8px 16px; border-radius: 6px; border: none; font-size: 13px; font-weight: 600; cursor: pointer;">
                                        ✗ Reject
                                    </button>
                                @endif
                            </div>
                            
                            @if($customer->documents_status === 'rejected' && $customer->documents_rejection_reason)
                                <div style="margin-top: 8px; padding: 8px; background: #FEF2F2; border-left: 3px solid #EF4444; font-size: 12px; color: #991B1B;">
                                    <strong>Reason:</strong> {{ $customer->documents_rejection_reason }}
                                </div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="padding: 48px; text-align: center; color: #64748B;">
                            <div style="font-size: 48px; margin-bottom: 12px;">📄</div>
                            <div style="font-size: 16px; font-weight: 600; margin-bottom: 4px;">No documents found</div>
                            <div style="font-size: 14px;">No customers have submitted documents for approval yet.</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($customers->hasPages())
        <div style="margin-top: 24px;">
            {{ $customers->links() }}
        </div>
    @endif
</div>

<!-- View Documents Modal -->
<div id="viewModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.7); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 16px; max-width: 1200px; width: 90%; max-height: 90vh; overflow-y: auto; padding: 32px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h2 style="font-size: 24px; font-weight: 700; color: #0F172A; margin: 0;" id="modalCustomerName">Customer Documents</h2>
            <button onclick="closeViewModal()" style="background: #F1F5F9; border: none; width: 36px; height: 36px; border-radius: 50%; cursor: pointer; font-size: 20px; color: #64748B;">×</button>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px;">
            <div>
                <h3 style="font-size: 14px; font-weight: 600; color: #64748B; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.05em;">License Image</h3>
                <img id="licenseImg" src="" alt="License" style="width: 100%; border-radius: 8px; border: 1px solid #E2E8F0;">
            </div>
            <div>
                <h3 style="font-size: 14px; font-weight: 600; color: #64748B; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.05em;">Identity Card</h3>
                <img id="identityImg" src="" alt="Identity Card" style="width: 100%; border-radius: 8px; border: 1px solid #E2E8F0;">
            </div>
            <div>
                <h3 style="font-size: 14px; font-weight: 600; color: #64748B; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.05em;">Matric/Staff Card</h3>
                <img id="matricImg" src="" alt="Matric/Staff Card" style="width: 100%; border-radius: 8px; border: 1px solid #E2E8F0;">
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.7); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 16px; max-width: 500px; width: 90%; padding: 32px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h2 style="font-size: 24px; font-weight: 700; color: #0F172A; margin: 0;">Reject Documents</h2>
            <button onclick="closeRejectModal()" style="background: #F1F5F9; border: none; width: 36px; height: 36px; border-radius: 50%; cursor: pointer; font-size: 20px; color: #64748B;">×</button>
        </div>
        
        <p style="color: #64748B; margin-bottom: 20px;">Please provide a reason for rejecting <strong id="rejectCustomerName"></strong>'s documents:</p>
        
        <form id="rejectForm" method="POST">
            @csrf
            <textarea name="rejection_reason" required 
                style="width: 100%; min-height: 120px; padding: 12px; border: 1px solid #E2E8F0; border-radius: 8px; font-size: 14px; font-family: inherit; resize: vertical;"
                placeholder="e.g., License image is blurry, Identity card has expired, etc."></textarea>
            
            <div style="display: flex; gap: 12px; margin-top: 20px;">
                <button type="button" onclick="closeRejectModal()" 
                    style="flex: 1; background: #F1F5F9; color: #64748B; padding: 12px; border-radius: 8px; border: none; font-size: 14px; font-weight: 600; cursor: pointer;">
                    Cancel
                </button>
                <button type="submit" 
                    style="flex: 1; background: #EF4444; color: white; padding: 12px; border-radius: 8px; border: none; font-size: 14px; font-weight: 600; cursor: pointer;">
                    Reject Documents
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function viewDocuments(customerId, customerName, licenseImg, identityImg, matricImg) {
    document.getElementById('modalCustomerName').textContent = customerName + "'s Documents";
    document.getElementById('licenseImg').src = licenseImg;
    document.getElementById('identityImg').src = identityImg;
    document.getElementById('matricImg').src = matricImg;
    document.getElementById('viewModal').style.display = 'flex';
}

function closeViewModal() {
    document.getElementById('viewModal').style.display = 'none';
}

function showRejectModal(customerId, customerName) {
    document.getElementById('rejectCustomerName').textContent = customerName;
    document.getElementById('rejectForm').action = '/admin/documents/' + customerId + '/reject';
    document.getElementById('rejectModal').style.display = 'flex';
}

function closeRejectModal() {
    document.getElementById('rejectModal').style.display = 'none';
}

// Close modals when clicking outside
document.getElementById('viewModal').addEventListener('click', function(e) {
    if (e.target === this) closeViewModal();
});

document.getElementById('rejectModal').addEventListener('click', function(e) {
    if (e.target === this) closeRejectModal();
});
</script>
@endsection
