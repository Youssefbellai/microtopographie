<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (isset($_FILES['datFile']) && $_FILES['datFile']['error'] == UPLOAD_ERR_OK) {
        $inputDat = $_FILES['datFile']['tmp_name'];
        $outputTxt = 'output.txt';

        function convertDatToTxt($inputDat, $outputTxt) {
            if (($handle = fopen($inputDat, "r")) !== FALSE) {
                $outputHandle = fopen($outputTxt, "w");

                if ($outputHandle === FALSE) {
                    die("Error: Unable to open output file for writing.");
                }

                while (($line = fgets($handle)) !== FALSE) {
                    $tabLine = preg_replace('/\s+/', "\t", trim($line));
                    fwrite($outputHandle, $tabLine . PHP_EOL);
                }

                fclose($handle);
                fclose($outputHandle);

                header('Content-Type: text/plain');
                header('Content-Disposition: attachment; filename="' . basename($outputTxt) . '"');
                header('Content-Length: ' . filesize($outputTxt));
                readfile($outputTxt);
                unlink($outputTxt); 
                exit;
            } else {
                die("Error: Unable to open input DAT file for reading.");
            }
        }
        


        convertDatToTxt($inputDat, $outputTxt);
    } else {
        echo "Error: No file uploaded or there was an upload error.";
    }
} else {
    echo "Error: Invalid request method.";
}
?>
