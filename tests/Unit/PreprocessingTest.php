<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\Preprocessing;

class PreprocessingTest extends TestCase
{
    public function test_to_lowercase_converts_text_to_lowercase()
    {
        $pre = new Preprocessing();
        $this->assertEquals('hello world', $pre->toLowercase('Hello World'));
    }

    public function test_punctuation_removal_removes_punctuation()
    {
        $pre = new Preprocessing();
        $this->assertEquals('Hello World', $pre->punctuationRemoval('Hello, World!'));
    }

    public function test_whitespace_standarization_reduces_whitespace()
    {
        $pre = new Preprocessing();
        $this->assertEquals('Hello World', $pre->whitespaceStandarization("Hello   World\n\t"));
    }
}
