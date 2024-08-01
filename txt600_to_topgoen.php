<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (isset($_FILES['txt600File']) && $_FILES['txt600File']['error'] == UPLOAD_ERR_OK) {
        $inputTxt600 = $_FILES['txt600File']['tmp_name'];
        $outputTopGoen = 'output.topgoen';

        function convertTxt600ToTopGoen($inputTxt600, $outputTopGoen) {
            if (($handle = fopen($inputTxt600, "r")) !== FALSE) {
                $outputHandle = fopen($outputTopGoen, "w");

                if ($outputHandle === FALSE) {
                    die("Error: Unable to open output file for writing.");
                }

                while (($line = fgets($handle)) !== FALSE) {
                    $topGoenLine = preg_replace('/\s+/', ';', trim($line));
                    fwrite($outputHandle, $topGoenLine . PHP_EOL);
                }

                fclose($handle);
                fclose($outputHandle);

                header('Content-Type: text/plain');
                header('Content-Disposition: attachment; filename="' . basename($outputTopGoen) . '"');
                header('Content-Length: ' . filesize($outputTopGoen));
                readfile($outputTopGoen);
                unlink($outputTopGoen); 
                exit;
            } else {
                die("Error: Unable to open input TXT600 file for reading.");
            }
        }

        convertTxt600ToTopGoen($inputTxt600, $outputTopGoen);
    } else {
        echo "Error: No file uploaded or there was an upload error.";
    }
} else {
    echo "Error: Invalid request method.";
}
?>
