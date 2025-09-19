<?php

namespace App\Services;

class JaccardAlgorithm
{
    public function calculateSimilarity(array $shingles1, array $shingles2) : float
    {
        $intersection = count(array_intersect($shingles1, $shingles2));
        $union = count(array_unique(array_merge($shingles1, $shingles2)));

        return $union === 0 ? 0 : $intersection / $union;
    }
}
