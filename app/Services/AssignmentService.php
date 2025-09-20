<?php

namespace App\Services;

use App\Models\AssignmentCheckResultSummary;
use App\Models\AssignmentCheckResultDetail;
use App\Services\PdfToTextService;
use App\Services\Preprocessing;
use App\Services\Shingling;
use App\Services\JaccardAlgorithm;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Carbon;

class AssignmentService
{
	public function processAssignments($request)
	{
		$service = new PdfToTextService();
		$pre = new Preprocessing();
		$shingling = new Shingling();
		$jaccard = new JaccardAlgorithm();

		$totalAssignments = count($request->file('files'));
		$shingleSize = $request->input('shingles_size', 10);
		$assignmentFiles = $request->file('files');
		$startTime = microtime(true);

		$shingleSets = [];
		foreach ($assignmentFiles as $key => $file) {
			$fileHash = md5_file($file->getPathname());
			$cacheKey = 'plagiarism_pipeline_' . $fileHash . '_' . $shingleSize;
			$shingleSets[$key] = Cache::remember($cacheKey, 60 * 60 * 24, function() use ($service, $pre, $shingling, $file, $request, $shingleSize) {
				$text = $service->convert($file);
				$processedText = $pre->process($text);
				if($request->file('template_file')){
					$templateFile = $request->file('template_file');
					$templateText = $service->convert($templateFile);
					$processedTemplateText = $pre->process($templateText);
					$processedText = str_replace($processedTemplateText, '', $processedText);
				}
				return $shingling->getShingles($processedText, $shingleSize);
			});
		}

		$results = [];
		for ($i = 0; $i < $totalAssignments; $i++) {
			for ($j = $i + 1; $j < $totalAssignments; $j++) {
				$fileHash1 = md5_file($assignmentFiles[$i]->getPathname());
				$fileHash2 = md5_file($assignmentFiles[$j]->getPathname());
				$pairKey = 'similarity_' . $fileHash1 . '_' . $fileHash2 . '_' . $shingleSize;
				$similarity = Cache::remember($pairKey, 60 * 60 * 24, function() use ($jaccard, $shingleSets, $i, $j) {
					return $jaccard->calculateSimilarity($shingleSets[$i], $shingleSets[$j]);
				});
				$percentage = round($similarity * 100, 4);
				$results[] = [
					'file1' => $assignmentFiles[$i]->getClientOriginalName(),
					'file2' => $assignmentFiles[$j]->getClientOriginalName(),
					'similarity' => round($similarity, 4),
					'similarity_score' => $percentage . '%',
				];
			}
		}

		$endTime = microtime(true);
		$executionTime = $endTime - $startTime;

		$summary = AssignmentCheckResultSummary::create([
			'assignment_title' => $request->input('title'),
			'assignment_date' => Carbon::parse($request->input('date')),
			'shingle_size' => $shingleSize,
			'total_files' => $totalAssignments,
			'total_comparisons' => count($results),
			'threshold' => $request->input('threshold', 0),
			'execution_time' => round($executionTime, 4),
			'checked_at' => now(),
			'average_similarity' => count($results) > 0 ? round(array_sum(array_column($results, 'similarity')) / count($results), 4) : 0,
			'highest_similarity' => count($results) > 0 ? round(max(array_column($results, 'similarity')), 4) : 0,
			'lowest_similarity' => count($results) > 0 ? round(min(array_column($results, 'similarity')), 4) : 0,
		]);

		foreach ($results as $result) {
			AssignmentCheckResultDetail::create([
				'summary_id' => $summary->id,
				'file1' => $result['file1'],
				'file2' => $result['file2'],
				'similarity' => $result['similarity'],
				'similarity_score' => $result['similarity_score'],
			]);
		}

		return $summary;
	}
}