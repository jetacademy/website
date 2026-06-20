<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Affiliate;
use App\Models\Lead;
use App\Models\Post;

class StatsController extends Controller
{
    public function index()
    {
        $todayLeads = Lead::whereDate('created_at', today())->count();
        $totalLeads = Lead::count();

        $convertedLeads = Lead::where('status', 'closed_won')->count();
        $conversionRate = $totalLeads > 0 ? round(($convertedLeads / $totalLeads) * 100, 1) : 0;

        $totalUsers = User::count();
        $totalAffiliates = Affiliate::count();
        $totalPosts = Post::count();

        // Total clicks across all affiliates
        $totalClicks = Affiliate::sum('total_clicks');

        return response()->json([
            'metrics' => [
                'total_leads' => $totalLeads,
                'today_leads' => $todayLeads,
                'conversion_rate' => $conversionRate,
                'total_users' => $totalUsers,
                'total_affiliates' => $totalAffiliates,
                'total_posts' => $totalPosts,
                'total_clicks' => $totalClicks,
            ]
        ]);
    }
}
