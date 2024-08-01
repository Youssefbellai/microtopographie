<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['files'])) {
    $files = $_FILES['files'];

  
    if (count($files['name']) > 0) {
      
        $mergedContent = '';
        $fileType = pathinfo($files['name'][0], PATHINFO_EXTENSION); 

        for ($i = 0; $i < count($files['name']); $i++) {
          
            if (pathinfo($files['name'][$i], PATHINFO_EXTENSION) != $fileType) {
                echo "Tous les fichiers doivent être du même type.";
                exit;
            }

            $filePath = $files['tmp_name'][$i];
            $mergedContent .= file_get_contents($filePath) . PHP_EOL;
        }


        $mergedFileName = 'fichiers_fusionnes.' . $fileType;
        file_put_contents($mergedFileName, $mergedContent);

    
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($mergedFileName) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($mergedFileName));
        readfile($mergedFileName);

      
        unlink($mergedFileName);
        exit;
    } else {
        echo "Aucun fichier téléchargé.";
    }
}
?>
