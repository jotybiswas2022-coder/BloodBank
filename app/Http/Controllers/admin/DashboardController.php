<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Profile;
use App\Models\BloodRequest;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(){
        // Fetch counts. A donor is a profile with a blood group, which is the
        // same set the Donor List page shows.
        $donorsCount = Profile::whereNotNull('blood')->count();

        // ===== Blood Group Distribution =====
        $bloodGroups = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];
        $bloodGroupCounts = [];
        foreach ($bloodGroups as $group) {
            $bloodGroupCounts[$group] = Profile::where('blood', $group)->count();
        }

        // ===== Donor Registration Trends (last 30 days) =====
        $donorTrends = [];
        $trendLabels = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $trendLabels[] = $date->format('M d');
            $donorTrends[] = Profile::whereDate('created_at', $date)->count();
        }

        // ===== Blood Request Stats =====
        $pendingRequests = BloodRequest::where('status', 'pending')->count();
        $matchedRequests = BloodRequest::where('status', 'matched')->count();
        $fulfilledRequests = BloodRequest::where('status', 'fulfilled')->count();
        $cancelledRequests = BloodRequest::where('status', 'cancelled')->count();
        $totalRequests = BloodRequest::count();

        // ===== Eligible Donors =====
        // Same donor set as above, counted in SQL: never donated, or the last
        // donation was at least 90 days ago (see Profile::canDonateNow()).
        $eligibleCutoff = Carbon::now()->subDays(90);
        $eligibleDonors = Profile::whereNotNull('blood')
            ->where(function ($query) use ($eligibleCutoff) {
                $query->whereNull('last_donated')
                      ->orWhere('last_donated', '<=', $eligibleCutoff);
            })
            ->count();

        // ===== Urgency Breakdown =====
        $criticalRequests = BloodRequest::where('urgency', 'critical')->whereIn('status', ['pending', 'matched'])->count();
        $urgentRequests = BloodRequest::where('urgency', 'urgent')->whereIn('status', ['pending', 'matched'])->count();
        $normalRequests = BloodRequest::where('urgency', 'normal')->whereIn('status', ['pending', 'matched'])->count();

        // Fetch recent data
        $contacts = Contact::latest()->take(5)->get();
        $donors = Profile::latest()->take(10)->get();
        $account = Account::first();

        return view('backend.index', compact(
            'contacts',
            'donors',
            'account',
            'donorsCount',
            'bloodGroupCounts',
            'bloodGroups',
            'donorTrends',
            'trendLabels',
            'pendingRequests',
            'matchedRequests',
            'fulfilledRequests',
            'cancelledRequests',
            'totalRequests',
            'eligibleDonors',
            'criticalRequests',
            'urgentRequests',
            'normalRequests'
        ));
    }
}