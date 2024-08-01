<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];

    if ($file['error'] == UPLOAD_ERR_OK) {
    
        $filePath = $file['tmp_name'];
        $lines = file($filePath, FILE_IGNORE_NEW_LINES);

        
        shuffle($lines);

       
        $permutedFileName = 'permuted_' . basename($file['name']);
        file_put_contents($permutedFileName, implode(PHP_EOL, $lines));

       
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($permutedFileName) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($permutedFileName));
        readfile($permutedFileName);

   
        unlink($permutedFileName);
        exit;
    } else {
        echo "Erreur lors du téléchargement du fichier.";
    }
} else {
    echo "Aucun fichier téléchargé.";
}
?>
