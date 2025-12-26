<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Models\Customer;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Display the main dashboard with overview cards.
     */
    public function index()
    {
        // Calculate functionality-wide totals
        $totalVouchers = Voucher::count();
        $totalRedeemed = Voucher::where('status', 'used')->count();
        $totalExpired = Voucher::where('status', 'expired')
                        ->orWhere(function ($q) {
                            $q->where('status', 'active')->where('expiry_date', '<', now()->startOfDay());
                        })->count();

        // Count pending document approvals
        $pendingDocuments = Customer::where('documents_status', 'pending')->count();

        return view('admin.dashboard', compact(
            'totalVouchers', 
            'totalRedeemed', 
            'totalExpired',
            'pendingDocuments'
        ));
    }

    /**
     * Display Voucher Statistics page.
     */
    public function voucherStats()
    {
        // Fetch all vouchers
        $vouchers = Voucher::all();

        // Group vouchers by Type (Percent or Hours)
        $voucherStats = $vouchers->groupBy(function ($item) {
            if ($item->discount_percent > 0) {
                return $item->discount_percent . '% Discount';
            } elseif ($item->free_hours > 0) {
                return $item->free_hours . ' Hours Free';
            } else {
                return 'Other';
            }
        })->map(function ($group, $type) {
            $total = $group->count();
            $used = $group->where('status', 'used')->count();
            // Expired: Explicit 'expired' status OR 'active' but past date
            $expired = $group->filter(function($v) {
                return $v->status === 'expired' || ($v->status === 'active' && $v->expiry_date < now()->startOfDay());
            })->count();
            
            // Calculate active rate (Active / Total)
            $activeCount = $total - $used - $expired;
            $rate = $total > 0 ? round(($activeCount / $total) * 100) : 0;

            return [
                'type' => $type,
                'total_issued' => $total,
                'total_used' => $used,
                'total_expired' => $expired,
                'active_rate' => $rate
            ];
        })->values(); // Reset keys to array

        // Fetch paginated individual vouchers for CRUD list
        $allVouchers = Voucher::with('customer.user')->latest()->simplePaginate(15);

        return view('admin.voucher_stats', compact('voucherStats', 'allVouchers'));
    }

    /**
     * Display Customer Loyalty page.
     */
    public function customerLoyalty()
    {
        // Fetch ALL customers with their related data
        $customers = Customer::with(['user', 'loyalties', 'vouchers'])->get()
            ->map(function ($customer) {
                $latestLoyalty = $customer->currentLoyalty();
                $currentStamps = $latestLoyalty ? $latestLoyalty->rental_counter : 0;

                $activeVouchersCount = $customer->vouchers->where('status', 'active')->where('expiry_date', '>=', now()->startOfDay())->count();
                $usedVouchersCount = $customer->vouchers->where('status', 'used')->count(); // Or include expired? User said "past vouchers". Usually means used + expired.
                
                // Helper to format voucher display
                $formatVoucher = function($v) {
                   $type = $v->discount_percent > 0 ? "{$v->discount_percent}% Off" : ($v->free_hours > 0 ? "{$v->free_hours}h Free" : "Reward");
                   return "{$v->voucher_code} ({$type})";
                };

                return [
                    'name' => $customer->user->name ?? 'Unknown',
                    'email' => $customer->user->email ?? 'N/A',
                    'customer_id' => $customer->customer_id,
                    'current_stamps' => $currentStamps,
                    'active_vouchers' => $activeVouchersCount,
                    'used_vouchers' => $usedVouchersCount,
                    'voucher_inventory' => $customer->vouchers
                        ->where('status', 'active')
                        ->where('expiry_date', '>=', now()->startOfDay())
                        ->map($formatVoucher)
                        ->unique() // If multiple of same code exist? Unlikely but code is unique.
                        ->implode(', '),
                    'voucher_history' => $customer->vouchers
                        ->filter(fn($v) => $v->status == 'used' || $v->status == 'expired' || ($v->status == 'active' && $v->expiry_date < now()->startOfDay()))
                        ->map(function($v) use ($formatVoucher) {
                            $status = $v->status == 'used' ? 'Used' : 'Expired';
                            return $formatVoucher($v) . " [$status]";
                        })
                        ->implode(', ')
                ];
            });

        return view('admin.customer_loyalty', compact('customers'));
    }

    /**
     * Display Document Approvals page.
     */
    public function documentApprovals(Request $request)
    {
        $status = $request->get('status', 'all');

        $query = Customer::with('user')
            ->whereNotNull('license_image')
            ->whereNotNull('identity_card_image')
            ->whereNotNull('matric_staff_image');

        if ($status !== 'all') {
            $query->where('documents_status', $status);
        }

        $customers = $query->latest('documents_submitted_at')->paginate(15);

        // Count for badges
        $pendingCount = Customer::where('documents_status', 'pending')->count();
        $approvedCount = Customer::where('documents_status', 'approved')->count();
        $rejectedCount = Customer::where('documents_status', 'rejected')->count();

        return view('admin.document_approvals', compact('customers', 'status', 'pendingCount', 'approvedCount', 'rejectedCount'));
    }

    /**
     * Approve customer documents.
     */
    public function approveDocuments($customerId)
    {
        $customer = Customer::findOrFail($customerId);

        $customer->update([
            'documents_status' => 'approved',
            'documents_approved_at' => now(),
            'documents_rejection_reason' => null,
        ]);

        return redirect()->back()->with('success', 'Documents approved successfully for ' . $customer->user->name);
    }

    /**
     * Reject customer documents with reason.
     */
    public function rejectDocuments(Request $request, $customerId)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $customer = Customer::findOrFail($customerId);

        $customer->update([
            'documents_status' => 'rejected',
            'documents_rejection_reason' => $request->rejection_reason,
            'documents_approved_at' => null,
        ]);

        return redirect()->back()->with('success', 'Documents rejected for ' . $customer->user->name);
    }
}
