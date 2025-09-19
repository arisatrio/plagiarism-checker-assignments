<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\PdfToTextService;

class PdfToTextServiceTest extends TestCase
{
    public function test_convert_returns_text_from_pdf()
    {
        $service = new PdfToTextService();
        $pdfPath = __DIR__ . '/../../public/sample-docs/TUGAS_0920240001_KRPL2425_-_Sistem_Operasi_2425191B.pdf';
        $text = $service->convert($pdfPath);
        $this->assertIsString($text);
        $this->assertNotEmpty($text, 'Extracted text should not be empty');
        // Optionally, check for a known word or phrase in the PDF
        // $this->assertStringContainsString('expected phrase', $text);
    }
}
