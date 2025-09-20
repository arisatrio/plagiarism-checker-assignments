<?php

namespace App\Http\Controllers;

use App\Models\AssignmentCheckResultSummary;
use Illuminate\Http\Request;

class PlagiarismCheckerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $summaries = AssignmentCheckResultSummary::orderByDesc('checked_at')->get();

        return view('plagiarism-checker.index', compact('summaries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('plagiarism-checker.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate request
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'files' => 'required',
        ]);

        $assignmentService = new \App\Services\AssignmentService();
        $summary = $assignmentService->processAssignments($request);

        return redirect()->route('plagiarism-checker.show', $summary->id)
            ->with('success', 'Assignments uploaded and processed successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $summary = AssignmentCheckResultSummary::findOrFail($id);
        $results = $summary->details()->orderByDesc('similarity')->get();

        return view('plagiarism-checker.show', compact('summary', 'results'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
