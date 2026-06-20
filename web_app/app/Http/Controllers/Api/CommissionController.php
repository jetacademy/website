<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    /**
     * Get list of commissions (Admin & Affiliator)
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $query = \App\Models\Commission::query()->with(['affiliate.user', 'lead']);

        // Jika user adalah affiliator (dan bukan admin), hanya tampilkan miliknya
        if ($user && !$user->hasRole(['Super Admin', 'Admin']) && $user->hasRole('Affiliator')) {
            $affiliate = \App\Models\Affiliate::where('user_id', $user->id)->first();
            if ($affiliate) {
                $query->where('affiliate_id', $affiliate->id);
            } else {
                $query->where('affiliate_id', -1);
            }
        } // User Admin/lainnya bisa melihat semua (tergantung RBAC lebih ketat)

        $commissions = $query->latest()->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $commissions
        ]);
    }

    /**
     * Admin: Approve & Pay commission
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,paid'
        ]);

        $commission = \App\Models\Commission::findOrFail($id);
        $commission->status = $request->status;
        $commission->save();

        return response()->json([
            'success' => true,
            'message' => 'Status komisi berhasil diperbarui.',
            'data' => $commission
        ]);
    }
}
