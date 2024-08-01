<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (isset($_FILES['datFile']) && $_FILES['datFile']['error'] == UPLOAD_ERR_OK) {
        $inputDat = $_FILES['datFile']['tmp_name'];
        $outputCsv = 'output.csv';

        function convertDatToCsv($inputDat, $outputCsv) {
            if (($handle = fopen($inputDat, "r")) !== FALSE) {
                $outputHandle = fopen($outputCsv, "w");

                if ($outputHandle === FALSE) {
                    die("Error: Unable to open output file for writing.");
                }

                while (($line = fgets($handle)) !== FALSE) {
                    $csvLine = preg_replace('/\s+/', ',', trim($line));
                    fwrite($outputHandle, $csvLine . PHP_EOL);
                }

                fclose($handle);
                fclose($outputHandle);

                header('Content-Type: text/csv');
                header('Content-Disposition: attachment; filename="' . basename($outputCsv) . '"');
                header('Content-Length: ' . filesize($outputCsv));
                readfile($outputCsv);
                unlink($outputCsv); 
                exit;
            } else {
                die("Error: Unable to open input DAT file for reading.");
            }
        }

        convertDatToCsv($inputDat, $outputCsv);
    } else {
        echo "Error: No file uploaded or there was an upload error.";
    }
} else {
    echo "Error: Invalid request method.";
}
?>
