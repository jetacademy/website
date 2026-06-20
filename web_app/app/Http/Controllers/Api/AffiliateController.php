<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AffiliateController extends Controller
{
    /**
     * Admin: Get all affiliates.
     */
    public function index()
    {
        $affiliates = \App\Models\Affiliate::with('user')
            ->withCount([
                'leads as total_leads',
                'leads as total_closing' => function ($q) {
                    $q->where('status', 'closed_won');
                }
            ])
            ->latest()
            ->paginate(20);

        // Hitung konversi
        $affiliates->getCollection()->transform(function ($aff) {
            $aff->conversion_rate = $aff->total_leads > 0
                ? round(($aff->total_closing / $aff->total_leads) * 100, 1)
                : 0;
            return $aff;
        });

        return response()->json([
            'success' => true,
            'data' => $affiliates
        ]);
    }

    /**
     * Admin: Create a new affiliate (from existing user or create user first, simplified here)
     */
    public function store(Request $request)
    {
        $request->validate([
            'commission_type' => 'required|in:percentage,fixed',
            'commission_rate' => 'required|numeric|min:0',
            'name' => 'required_without:user_id|string|max:255',
            'email' => 'required_without:user_id|email|unique:users,email',
            'password' => 'required_without:user_id|string|min:6',
        ]);

        $userId = $request->user_id;

        if (!$userId) {
            $user = \App\Models\User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => \Illuminate\Support\Facades\Hash::make($request->password),
                'email_verified_at' => now(),
            ]);
            $userId = $user->id;
        }

        // Cek affiliasi sudah ada
        if (\App\Models\Affiliate::where('user_id', $userId)->exists()) {
            return response()->json(['success' => false, 'message' => 'User sudah menjadi affiliator.'], 400);
        }

        $referralCode = 'JET-' . strtoupper(\Illuminate\Support\Str::random(6));

        $affiliate = \App\Models\Affiliate::create([
            'user_id' => $userId,
            'referral_code' => $referralCode,
            'commission_type' => $request->commission_type,
            'commission_rate' => $request->commission_rate,
        ]);

        // Assign role to user
        $user = \App\Models\User::find($userId);
        if ($user && method_exists($user, 'assignRole')) {
            $user->assignRole('Affiliator');
        }

        return response()->json([
            'success' => true,
            'message' => 'Afiliator berhasil ditambahkan.',
            'data' => $affiliate->load('user')
        ], 201);
    }

    /**
     * Admin: Update affiliator commission
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'commission_type' => 'required|in:percentage,fixed',
            'commission_rate' => 'required|numeric|min:0',
        ]);

        $affiliate = \App\Models\Affiliate::findOrFail($id);
        $affiliate->commission_type = $request->commission_type;
        $affiliate->commission_rate = $request->commission_rate;
        $affiliate->save();

        return response()->json([
            'success' => true,
            'message' => 'Komisi berhasil diperbarui.',
            'data' => $affiliate
        ]);
    }

    /**
     * Affiliator: Get own dashboard stats
     */
    public function dashboard(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $affiliate = \App\Models\Affiliate::where('user_id', $user->id)->first();

        // Auto-create affiliate record jika user punya role Affiliator tapi belum ada record
        if (!$affiliate && $user->hasRole('Affiliator')) {
            $referralCode = 'JET-' . strtoupper(\Illuminate\Support\Str::random(6));
            $affiliate = \App\Models\Affiliate::create([
                'user_id' => $user->id,
                'referral_code' => $referralCode,
                'commission_type' => 'percentage',
                'commission_rate' => 10,
            ]);
        }

        if (!$affiliate) {
            return response()->json(['success' => false, 'message' => 'Bukan affiliator.'], 403);
        }

        // Optimized: single query with conditional aggregation
        $leadStats = \App\Models\Lead::where('affiliate_id', $affiliate->id)
            ->selectRaw("
                COUNT(*) as total_leads,
                SUM(CASE WHEN status = 'closed_won' THEN 1 ELSE 0 END) as total_deals
            ")
            ->first();

        $totalLeads = $leadStats->total_leads ?? 0;
        $totalDeals = $leadStats->total_deals ?? 0;

        // Commission totals
        $commissionStats = \App\Models\Commission::where('affiliate_id', $affiliate->id)
            ->selectRaw("
                SUM(CASE WHEN status = 'pending' THEN amount ELSE 0 END) as total_pending,
                SUM(CASE WHEN status = 'paid' THEN amount ELSE 0 END) as total_paid
            ")
            ->first();

        return response()->json([
            'success' => true,
            'data' => [
                'referral_code' => $affiliate->referral_code,
                'total_clicks' => $affiliate->total_clicks ?? 0,
                'total_leads' => $totalLeads,
                'total_deals' => $totalDeals,
                'conversion_rate' => $totalLeads > 0 ? round(($totalDeals / $totalLeads) * 100, 1) : 0,
                'total_pending_commission' => $commissionStats->total_pending ?? 0,
                'total_paid_commission' => $commissionStats->total_paid ?? 0,
            ]
        ]);
    }

    /**
     * Affiliator: Update referral code
     */
    public function updateReferralCode(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'referral_code' => 'required|string|min:4|max:50|unique:affiliates,referral_code,' . $user->id . ',user_id'
        ], [
            'referral_code.unique' => 'Kode referal tersebut sudah digunakan oleh mitra lain.',
            'referral_code.min' => 'Kode referal minimal harus 4 karakter.'
        ]);

        // Sanitasi sedikit untuk mencegah spasi dan karakter aneh jika perlu
        $newCode = preg_replace('/[^A-Za-z0-9_-]/', '', $request->referral_code);

        $affiliate = \App\Models\Affiliate::where('user_id', $user->id)->first();
        if (!$affiliate) {
            return response()->json(['success' => false, 'message' => 'Bukan affiliator.'], 403);
        }

        $affiliate->referral_code = strtoupper($newCode);
        $affiliate->save();

        return response()->json([
            'success' => true,
            'message' => 'Kode Referal berhasil diperbarui.',
            'data' => [
                'referral_code' => $affiliate->referral_code
            ]
        ]);
    }

    /**
     * Public: Track klik link affiliate (dengan rate limiting)
     */
    public function trackClick(Request $request)
    {
        // Rate limiting: max 60 click tracks per minute per IP
        $throttleKey = 'affiliate-click:' . $request->ip();
        if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($throttleKey, 60)) {
            return response()->json(['tracked' => false, 'message' => 'Rate limit exceeded.'], 429);
        }
        \Illuminate\Support\Facades\RateLimiter::hit($throttleKey, 60);

        $code = $request->input('ref');
        if (!$code) {
            return response()->json(['tracked' => false], 200);
        }

        // Sanitize referral code
        $code = preg_replace('/[^A-Za-z0-9_-]/', '', $code);

        $affiliate = \App\Models\Affiliate::where('referral_code', $code)->first();
        if ($affiliate) {
            $affiliate->increment('total_clicks');
            return response()->json(['tracked' => true], 200);
        }

        return response()->json(['tracked' => false], 200);
    }
}
