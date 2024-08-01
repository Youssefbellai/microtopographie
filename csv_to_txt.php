<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (isset($_FILES['csvFile']) && $_FILES['csvFile']['error'] == UPLOAD_ERR_OK) {
        $inputCsv = $_FILES['csvFile']['tmp_name'];
        $outputTxt = 'output.txt';

        function convertCsvToTxt($inputCsv, $outputTxt) {
            if (($handle = fopen($inputCsv, "r")) !== FALSE) {
                $outputHandle = fopen($outputTxt, "w");

                if ($outputHandle === FALSE) {
                    die("Error: Unable to open output file for writing.");
                }

                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $line = implode("\t", $data);
                    fwrite($outputHandle, $line . PHP_EOL);
                }

                fclose($handle);
                fclose($outputHandle);

                header('Content-Type: text/plain');
                header('Content-Disposition: attachment; filename="' . basename($outputTxt) . '"');
                header('Content-Length: ' . filesize($outputTxt));
                readfile($outputTxt);
                unlink($outputTxt); // Optionally delete the file after download
                exit;
            } else {
                die("Error: Unable to open input CSV file for reading.");
            }
        }

        convertCsvToTxt($inputCsv, $outputTxt);
    } else {
        echo "Error: No file uploaded or there was an upload error.";
    }
} else {
    echo "Error: Invalid request method.";
}
?>
