<?php

namespace App\Services;

use Spatie\PdfToText\Pdf;

class PdfToTextService
{
    public function convert(string $pdfFilePath): string
    {
        // $text = Pdf::getText($pdfFilePath);

        $parser =  new \Smalot\PdfParser\Parser();
        $pdf = $parser->parseFile($pdfFilePath);
        $text = $pdf->getText();
        // Ensure valid UTF-8 and filter out malformed characters
        $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8');

        return $text;
    }
}