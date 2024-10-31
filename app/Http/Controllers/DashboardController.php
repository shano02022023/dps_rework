<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Inertia\Inertia;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalApplicants = Application::count();
        $acceptedApplicants = Application::where('status', 'ACCEPTED')->count();
        $rejectedApplicants = Application::where('status', 'REJECTED')->count();

        return Inertia::render('Dashboard', [
            'totalApplicants' => $totalApplicants,
            'acceptedApplicants' => $acceptedApplicants,
            'rejectedApplicants' => $rejectedApplicants,
        ]);
    }

    public function getYears()
    {
        $years = Application::selectRaw('YEAR(created_at) as year')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get();
        return response()->json($years);
    }

    public function lineGraphData(Request $request)
    {
        $year = $request->input('year'); // Get selected year
        $month = $request->input('month'); // Get selected month (optional)

        // Check if a month is selected
        if ($month) {
            // If a month is selected, group data by day within that month
            $lineGraphData = Application::selectRaw('DAY(created_at) as day, COUNT(*) as count')
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->groupBy('day')
                ->get();
        } else {
            // If no month is selected, group data by month within the selected year
            $lineGraphData = Application::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', $year)
                ->groupBy('month')
                ->get();
        }

        return response()->json($lineGraphData);
    }
}
