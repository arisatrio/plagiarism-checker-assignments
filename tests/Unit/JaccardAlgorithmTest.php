<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\JaccardAlgorithm;

class JaccardAlgorithmTest extends TestCase
{
    public function test_calculate_similarity_returns_expected_value()
    {
        $jaccard = new JaccardAlgorithm();
        $shingles1 = ['a', 'b', 'c'];
        $shingles2 = ['b', 'c', 'd'];
        // intersection: ['b', 'c'] => 2, union: ['a', 'b', 'c', 'd'] => 4
        $expected = 2 / 4;
        $result = $jaccard->calculateSimilarity($shingles1, $shingles2);
        $this->assertEquals($expected, $result);
    }

    public function test_calculate_similarity_with_no_union_returns_zero()
    {
        $jaccard = new JaccardAlgorithm();
        $shingles1 = [];
        $shingles2 = [];
        $this->assertEquals(0, $jaccard->calculateSimilarity($shingles1, $shingles2));
    }
}
