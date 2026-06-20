<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class LeadController extends Controller
{
    /**
     * Store a newly created lead in storage.
     * Menerima form demo dari publik dan mengecek kode referal
     */
    public function store(Request $request)
    {
        // Rate limiting: max 5 submissions per 10 minutes per IP
        $throttleKey = 'lead-submit:' . $request->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return response()->json([
                'success' => false,
                'message' => "Terlalu banyak pengiriman. Coba lagi dalam {$seconds} detik.",
                'retry_after' => $seconds,
            ], 429);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'school_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20|regex:/^[0-9+\-\s()]+$/',
            'heard_from' => 'nullable|string|max:255',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'school_name.required' => 'Nama sekolah wajib diisi.',
            'phone_number.required' => 'Nomor HP/WhatsApp wajib diisi.',
            'phone_number.regex' => 'Nomor HP/WhatsApp hanya boleh berisi angka dan karakter +, -, spasi, kurung.',
        ]);

        // Cek referral code dari payload atau header/cookie
        $referralCode = $request->input('ref');
        $affiliateId = null;

        if ($referralCode) {
            // Sanitize referral code
            $referralCode = preg_replace('/[^A-Za-z0-9_-]/', '', $referralCode);
            $affiliate = \App\Models\Affiliate::where('referral_code', $referralCode)->first();
            if ($affiliate) {
                $affiliateId = $affiliate->id;
            }
        }

        $lead = \App\Models\Lead::create([
            'affiliate_id' => $affiliateId,
            'name' => $validated['name'],
            'school_name' => $validated['school_name'],
            'phone_number' => $validated['phone_number'],
            'heard_from' => $request->input('heard_from', 'website_contact'),
            'package' => $request->input('package'),
            'status' => 'new',
        ]);

        // Hit rate limiter only on successful submission
        RateLimiter::hit($throttleKey, 600); // 10 minutes window

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menjadwalkan demo. Tim kami akan segera menghubungi Anda.',
            'data' => $lead
        ], 201);
    }

    /**
     * Get list of leads (Admin only - protected by route middleware)
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $query = \App\Models\Lead::query()->with('affiliate.user');

        // Jika user adalah affiliator (dan bukan admin), hanya tampilkan miliknya
        if ($user && !$user->hasRole(['Super Admin', 'Admin']) && $user->hasRole('Affiliator')) {
            $affiliate = \App\Models\Affiliate::where('user_id', $user->id)->first();
            if ($affiliate) {
                $query->where('affiliate_id', $affiliate->id);
            } else {
                $query->where('affiliate_id', -1); // Empty result
            }
        }

        $leads = $query->latest()->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $leads
        ]);
    }

    /**
     * Update lead status (Admin only)
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:new,contacted,demo_scheduled,closed_won,closed_lost',
            'deal_value' => 'nullable|numeric|min:0|max:999999999999'
        ]);

        $lead = \App\Models\Lead::findOrFail($id);
        $lead->status = $request->status;

        // Only update deal_value if provided
        if ($request->filled('deal_value')) {
            $lead->deal_value = $request->deal_value;
        }

        $lead->save();

        // Jika status closed_won, ciptakan komisi
        if ($lead->status === 'closed_won' && $lead->affiliate_id) {
            $this->generateCommission($lead, $request->deal_value);
        }

        return response()->json([
            'success' => true,
            'message' => 'Status lead berhasil diperbarui.',
            'data' => $lead
        ]);
    }

    private function generateCommission($lead, $dealValue)
    {
        $affiliate = $lead->affiliate;
        if (!$affiliate)
            return;

        // Cek jika sudah ada komisi untuk lead ini
        $existing = \App\Models\Commission::where('lead_id', $lead->id)->first();
        if ($existing) {
            return;
        }

        // Tentukan amount
        $amount = 0;
        if ($affiliate->commission_type === 'percentage') {
            $amount = floatval($dealValue ?? 0) * (floatval($affiliate->commission_rate) / 100);
        } else {
            $amount = floatval($affiliate->commission_rate);
        }

        \App\Models\Commission::create([
            'affiliate_id' => $affiliate->id,
            'lead_id' => $lead->id,
            'amount' => $amount,
            'status' => 'pending'
        ]);
    }
}
