<?php

use App\Http\Controllers\ProfileController;
use App\Services\PdfToTextService;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // 

    Route::resource('plagiarism-checker', \App\Http\Controllers\PlagiarismCheckerController::class);

    // 
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/pdf-to-text', function () {
    $service = new PdfToTextService();
    $pdfPath = base_path('public/sample-docs/TUGAS_0920240001_KRPL2425_-_Sistem_Operasi_2425191B.pdf');
    $text = $service->convert($pdfPath);

    $pdfPath2 = base_path('public/sample-docs/TUGAS_0920240004_KRPL2425_-_Sistem_Operasi_2425191B.pdf');
    $text2 = $service->convert($pdfPath2);

    return response()->json(['text' => $text, 'text2' => $text2]);
})->name('pdf.to.text');

// route check similarity from pdf text
Route::get('/pdf-to-text/similarity', function () {
    $service = new PdfToTextService();
    $pre = new \App\Services\Preprocessing();
    $shingling = new \App\Services\Shingling();
    $jaccard = new \App\Services\JaccardAlgorithm();

    $pdfPath1 = base_path('public/sample-docs/TUGAS_0920240001_KRPL2425_-_Sistem_Operasi_2425191B.pdf');
    $pdfPath2 = base_path('public/sample-docs/TUGAS_0920240004_KRPL2425_-_Sistem_Operasi_2425191B.pdf');
    $text1 = $service->convert($pdfPath1);
    $text2 = $service->convert($pdfPath2);

    // Preprocessing
    $text1 = $pre->toLowercase($text1);
    $text1 = $pre->punctuationRemoval($text1);
    $text1 = $pre->whitespaceStandarization($text1);
    $text2 = $pre->toLowercase($text2);
    $text2 = $pre->punctuationRemoval($text2);
    $text2 = $pre->whitespaceStandarization($text2);

    // Shingling
    $shingleSize = 10;
    $shingles1 = $shingling->getShingles($text1, $shingleSize);
    $shingles2 = $shingling->getShingles($text2, $shingleSize);

    // Jaccard Similarity
    $similarity = $jaccard->calculateSimilarity($shingles1, $shingles2);

    return response()->json([
        'similarity' => $similarity,
        'similarity_score' => round($similarity * 100, 2).'%',
        'shingle_size' => $shingleSize,
        'shingles1_count' => count($shingles1),
        'shingles2_count' => count($shingles2),
        'shingles' => [ //get only 5 shingles
            'text1' => array_slice($shingles1, 0, 5),
            'text2' => array_slice($shingles2, 0, 5),
        ],
        'preprocessing' => [
            'text1' => $text1,
            'text2' => $text2,
        ]
    ]);
});

require __DIR__.'/auth.php';
