<?php

namespace App\Services;

class Preprocessing
{

    public function process(string $text, string $templateText = ''): string
    {
        $text = $this->toLowercase($text);
        $text = $this->punctuationRemoval($text);
        $text = $this->whitespaceStandarization($text);
        if ($templateText) {
            $text = $this->removeTemplateText($text, $templateText);
        }
        return $text;
    }

    public function toLowercase(string $text) : string
    {
        return strtolower($text);
    }

    public function punctuationRemoval(string $text) : string
    {
        return preg_replace('/[^\w\s]/', '', $text);
    }

    public function whitespaceStandarization(string $text) : string
    {
        return trim(preg_replace('/\s+/', ' ', $text));
    }

    public function removeTemplateText(string $targetText, string $templateText) : string
    {
        // Escape special regex characters in the template text
        $escapedTemplate = preg_quote($templateText, '/');

        // Create a regex pattern to match the template text
        $pattern = '/' . $escapedTemplate . '/';

        // Remove the template text from the target text
        return preg_replace($pattern, '', $targetText);
    }
}