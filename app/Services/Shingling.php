<?php

namespace App\Services;

class Shingling
{
    public function getShingles(string $text, int $shingleSize) : array
    {
        $words = explode(' ', $text);
        $shingles = [];

        for ($i = 0; $i <= count($words) - $shingleSize; $i++) {
            $shingle = implode(' ', array_slice($words, $i, $shingleSize));
            $shingles[] = $shingle;
        }

        return array_unique($shingles);
    }
}