<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\Preprocessing;
use App\Services\JaccardAlgorithm;
use App\Services\Shingling;

class PlagiarismPipelineTest extends TestCase
{
    public function test_full_pipeline_similarity()
    {
        $pre = new Preprocessing();
        $shingling = new Shingling();
        $jaccard = new JaccardAlgorithm();

        $text1 = "Hello,   world! This is a test.";
        $text2 = "hello world this is a test";

        // Preprocessing
        $text1 = $pre->toLowercase($text1);
        $text1 = $pre->punctuationRemoval($text1);
        $text1 = $pre->whitespaceStandarization($text1);
        $text2 = $pre->toLowercase($text2);
        $text2 = $pre->punctuationRemoval($text2);
        $text2 = $pre->whitespaceStandarization($text2);

        // Shingling
        $shingleSize = 2;
        $shingles1 = $shingling->getShingles($text1, $shingleSize);
        $shingles2 = $shingling->getShingles($text2, $shingleSize);

        // Jaccard Similarity
        $similarity = $jaccard->calculateSimilarity($shingles1, $shingles2);

        $this->assertEquals(1.0, $similarity);
    }

    public function test_full_pipeline_similarity_with_complex_long_text()
    {
        $pre = new Preprocessing();
        $shingling = new Shingling();
        $jaccard = new JaccardAlgorithm();

        $text1 = "Plagiarism detection is a process of locating instances of plagiarism within a work or document. It is widely used in academia and publishing.";
        $text2 = "The process of detecting plagiarism involves finding copied or closely paraphrased content in documents. Plagiarism detection is common in academic and publishing fields.";

        // Preprocessing
        $text1 = $pre->toLowercase($text1);
        $text1 = $pre->punctuationRemoval($text1);
        $text1 = $pre->whitespaceStandarization($text1);
        $text2 = $pre->toLowercase($text2);
        $text2 = $pre->punctuationRemoval($text2);
        $text2 = $pre->whitespaceStandarization($text2);

        // Shingling
        $shingleSize = 3;
        $shingles1 = $shingling->getShingles($text1, $shingleSize);
        $shingles2 = $shingling->getShingles($text2, $shingleSize);

        // Jaccard Similarity
        $similarity = $jaccard->calculateSimilarity($shingles1, $shingles2);

        // Assert similarity is reasonable (not 1, not 0, but some overlap)
        $this->assertTrue($similarity > 0.01 && $similarity < 0.9, 'Similarity should be between 0.01 and 0.9 for complex, partially overlapping texts. Actual: ' . $similarity);
    }
}
