<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Registrant;
use App\Models\PpdbSetting;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Visitor statistics
        $visitorCount = cache()->get('visitor_count', 0);

        // Active Academic Year
        $activeYear = AcademicYear::where('is_active', true)->first();

        // Registrant stats
        $totalRegistrants = 0;
        $pendingRegistrants = 0;
        $verifiedRegistrants = 0;
        $rejectedRegistrants = 0;
        $ppdbOpen = false;
        $quota = 0;

        if ($activeYear) {
            $totalRegistrants = Registrant::where('academic_year_id', $activeYear->id)->count();
            $pendingRegistrants = Registrant::where('academic_year_id', $activeYear->id)->where('status', 'pending')->count();
            $verifiedRegistrants = Registrant::where('academic_year_id', $activeYear->id)->where('status', 'verified')->count();
            $rejectedRegistrants = Registrant::where('academic_year_id', $activeYear->id)->where('status', 'rejected')->count();
            
            $setting = PpdbSetting::where('academic_year_id', $activeYear->id)->first();
            if ($setting) {
                $ppdbOpen = $setting->status === 'open';
                $quota = $setting->quota;
            }
        }

        // Recent Activity - last 5 registrations
        $recentRegistrations = Registrant::with(['academicYear', 'major'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'visitorCount',
            'activeYear',
            'totalRegistrants',
            'pendingRegistrants',
            'verifiedRegistrants',
            'rejectedRegistrants',
            'ppdbOpen',
            'quota',
            'recentRegistrations'
        ));
    }
}
