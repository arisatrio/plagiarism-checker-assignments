<?php

namespace App\Http\Controllers;

use App\Models\AssignmentCheckResultSummary;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAssignments = AssignmentCheckResultSummary::count();
        $totalFiles = AssignmentCheckResultSummary::sum('total_files');
        $averageSimilarity = AssignmentCheckResultSummary::avg('average_similarity') ? round(AssignmentCheckResultSummary::avg('average_similarity') * 100, 2) : 0;
        $recentSummaries = AssignmentCheckResultSummary::orderByDesc('checked_at')->limit(5)->get();
        
        return view('dashboard', compact('totalAssignments', 'totalFiles', 'averageSimilarity', 'recentSummaries'));
    }
}
