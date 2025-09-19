<?php

namespace App\Http\Controllers;

use App\Services\PdfToTextService;
use Smalot\PdfParser\Parser;
use Illuminate\Http\Request;

class PlagiarismCheckerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('plagiarism-checker.index');
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

        // $pdfParser = new Parser();
        // $pdf = $pdfParser->parseFile($request->file('files')[0]);
        // // $details = $pdf->getDetails(); // Includes author, title, etc.
        // $images =  $pdf->getObjectsByType('XObject', 'Image');
        // dd(exif_read_data($images['668_0']->getContent()));
        // dd($images['668_0']->getContent());

        // dd($request->all());
        $service = new PdfToTextService();
        $pre = new \App\Services\Preprocessing();
        $shingling = new \App\Services\Shingling();
        $jaccard = new \App\Services\JaccardAlgorithm();

        $totalAssignments = count($request->file('files'));

        $shingleSize = 10;

        $assignmentFiles = $request->file('files');

        $shingleSets = [];
        foreach ($assignmentFiles as $key => $file) {
            $text = $service->convert($file);

            $processedText = $pre->process($text);
            if($request->file('template_file')){
                $templateText = $service->convert($request->file('template_file'));
                $processedTemplateText = $pre->process($templateText);
                // remove processed template text from processed text
                $processedText = str_replace($processedTemplateText, '', $processedText);
            }

            $shingleSets[$key] = $shingling->getShingles($processedText, $shingleSize);
        }

        // dd($shingleSets);

        $results = [];

        for ($i = 0; $i < $totalAssignments; $i++) {
            for ($j = $i + 1; $j < $totalAssignments; $j++) {
                $similarity = $jaccard->calculateSimilarity($shingleSets[$i], $shingleSets[$j]);
                $percentage = round($similarity * 100, 2);;

                // save to array results
                $results[] = [
                    'file1' => $assignmentFiles[$i]->getClientOriginalName(),
                    'file2' => $assignmentFiles[$j]->getClientOriginalName(),
                    'similarity' => $similarity,
                    'similarity_score' => $percentage . '%',
                ];
            }
        }

        return view('plagiarism-checker.show',[ 'results' => $results])
            ->with('success', 'Assignments uploaded and processed successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return view('plagiarism-checker.show');
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
