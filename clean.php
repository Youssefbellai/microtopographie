<?php
if (isset($_POST['submit'])) {
    if ($_FILES['datFile']['error'] == UPLOAD_ERR_OK) {
        $tmpName = $_FILES['datFile']['tmp_name'];
        $fileName = $_FILES['datFile']['name'];
        $cleanedFileName = 'cleaned_' . $fileName;

        $file = fopen($tmpName, 'r');
        $cleanedFile = fopen($cleanedFileName, 'w');

        if ($file && $cleanedFile) {
            $lineNumber = 0;

            // Skip the first 5 lines
            while ($lineNumber < 5 && !feof($file)) {
                fgets($file);
                $lineNumber++;
            }

            // Process the remaining lines
            while (($line = fgets($file)) !== false) {
             
                if (strpos($line, '.') !== false) {
                    fwrite($cleanedFile, $line);
                }
            }
// 
            fclose($file);
            fclose($cleanedFile);

            header('Content-Type: text/plain');
            header('Content-Disposition: attachment; filename="' . basename($cleanedFileName) . '"');
            header('Content-Length: ' . filesize($cleanedFileName));
            readfile($cleanedFileName);
            unlink($cleanedFileName); // Optionally delete the file after download
            exit;
        } else {
            echo "Error opening file.";
        }
    } else {
        echo "Error uploading file.";
    }
} else {
    echo "No file uploaded.";
}
?>
