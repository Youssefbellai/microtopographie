<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (isset($_FILES['txtFile']) && $_FILES['txtFile']['error'] == UPLOAD_ERR_OK) {
        $inputTxt = $_FILES['txtFile']['tmp_name'];
        $outputCsv = 'output.csv';

        function convertTxtToCsv($inputTxt, $outputCsv) {
            if (($handle = fopen($inputTxt, "r")) !== FALSE) {
                $outputHandle = fopen($outputCsv, "w");

                if ($outputHandle === FALSE) {
                    die("Error: Unable to open output file for writing.");
                }

                while (($line = fgets($handle)) !== FALSE) {
                    $data = explode("\t", trim($line));
                    fputcsv($outputHandle, $data);
                }

                fclose($handle);
                fclose($outputHandle);

                header('Content-Type: text/csv');
                header('Content-Disposition: attachment; filename="' . basename($outputCsv) . '"');
                header('Content-Length: ' . filesize($outputCsv));
                readfile($outputCsv);
                unlink($outputCsv); // Optionally delete the file after download
                exit;
            } else {
                die("Error: Unable to open input TXT file for reading.");
            }
        }

        convertTxtToCsv($inputTxt, $outputCsv);
    } else {
        echo "Error: No file uploaded or there was an upload error.";
    }
} else {
    echo "Error: Invalid request method.";
}
?>
