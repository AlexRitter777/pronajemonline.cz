<?php

namespace pronajem\libs;

use Mpdf\Mpdf;

/**
 * Class PdfCreator serves as a wrapper for generating PDF documents using the mPDF library.
 * It provides a static method to render PDFs from PHP view files, optionally applying CSS styles.
 */

class PdfCreator
{
    /**
     * Renders a PDF document from a specified PHP view file, with optional data and CSS styles.
     *
     * This method leverages the mPDF library to generate a PDF document based on the content
     * of a PHP view file. It supports optional data that can be passed to the view, allowing for
     * dynamic content generation within the PDF. Additionally, CSS styles can be specified to customize
     * the appearance of the PDF content. The method provides flexibility in outputting the generated PDF,
     * including inline display in the browser, downloading, saving to a server path, or returning as a string.
     *
     * @param array $data Optional data to be extracted and made available in the view file. If no data is provided,
     *                    the view will be rendered without injected data, making this parameter suitable for static views.
     * @param string $view The relative path to the view file within the "/views" directory, excluding the ".php" extension.
     *                     This path should be specified relative to the views directory and without the file extension.
     * @param string $styles Optional CSS styles to be applied to the PDF content, enhancing the document's appearance.
     * @param string $fileName The name of the generated PDF file. Defaults to 'document.pdf'. This name is used when
     *                         the PDF is downloaded or saved to the server.
     * @param string $outputMode Determines the output mode of the PDF document:
     *                           'I' - sends the PDF inline to the browser,
     *                           'D' - forces download of the PDF,
     *                           'F' - saves the PDF to a server file (path specified in $fileName),
     *                           'S' - returns the PDF document as a string.
     *                           Defaults to 'I' for inline display.
     * @throws \Exception If the view file cannot be found, an exception is thrown, indicating the issue.
     */
    public static function pdfRender($data = [], $view, $styles = '', $fileName = 'document.pdf',  $outputMode = 'I'){

        if (is_array($data)) extract($data);
        $viewFile = APP . "/views/{$view}.php";
        if (is_file($viewFile)) {
            ob_start();
            require_once $viewFile;
            $content = ob_get_clean();
            $mpdf = new Mpdf();
            if (!empty($styles)) {
                $mpdf->WriteHTML($styles, 1);
            }
            $mpdf->WriteHTML($content, 2);
            $mpdf->Output($fileName, $outputMode);
        } else {
            throw new \Exception("View {$viewFile} not found", 500);
        }

    }

    
}