<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\Shingling;

class ShinglingTest extends TestCase
{
    public function test_get_shingles_returns_expected_shingles()
    {
        $shingling = new Shingling();
        $text = 'the quick brown fox jumps';
        $shingleSize = 2;
        $expected = [
            'the quick',
            'quick brown',
            'brown fox',
            'fox jumps',
        ];
        $result = $shingling->getShingles($text, $shingleSize);
        $this->assertEqualsCanonicalizing($expected, $result);
    }
}
