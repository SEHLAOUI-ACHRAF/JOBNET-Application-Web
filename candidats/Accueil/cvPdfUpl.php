<?php

    $pdfText = '';
    if (isset($_POST['pdfUpload'])) {
        // If file is selected 
        if (!empty($_FILES["pdf_file"]["name"])) {
            // File upload path 
            $fileName = basename($_FILES["pdf_file"]["name"]);
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

            // Allow certain file formats 
            $allowTypes = array('pdf');
            if (in_array($fileType, $allowTypes)) {
                // Include autoloader file 
                include 'pdfparser-1.0.0/alt_autoload.php-dist';

                // Initialize and load PDF Parser library 
                $parser = new \Smalot\PdfParser\Parser();

                // Source PDF file to extract text 
                $file = $_FILES["pdf_file"]["tmp_name"];

                // Parse pdf file using Parser library 
                $pdf = $parser->parseFile($file);

                // Extract text from PDF 
                $text = $pdf->getText();

                // Add line break 
                $pdfText = nl2br($text);
            } else {
                $statusMsg = '<p>Sorry, only PDF file is allowed to upload.</p>';
                echo $statusMsg;
            }
        } else {
            $statusMsg = '<p>Please select a PDF file to extract text.</p>';
            echo $statusMsg;
        }

        // Extract information
        include 'data.php';
        $cv = extractCVInfo($pdfText);
        $profession = isset($cv->infoInstance->profession) ? $cv->infoInstance->profession : '';
        $domaine = isset($cv->infoInstance->domaine) ? $cv->infoInstance->domaine : '';
        $etablissement = isset($cv->infoInstance->etablissement) ? $cv->infoInstance->etablissement : '';
        $diplomeName = isset($cv->diplomes[0]->nom) ? $cv->diplomes[0]->nom : '';
        $diplomeDuree = isset($cv->diplomes[0]->duree) ? $cv->diplomes[0]->duree : '';
        $nomStage = isset($cv->stages[0]->nom) ? $cv->stages[0]->nom : '';
        $stageDuree = isset($cv->stages[0]->duree) ? $cv->stages[0]->duree : '';
        $entrepriseStage = isset($cv->stages[0]->entreprise) ? $cv->stages[0]->entreprise : '';
        $sujet = isset($cv->stages[0]->sujet) ? $cv->stages[0]->sujet : '';
        $poste = isset($cv->experiencesPro[0]->nom) ? $cv->experiencesPro[0]->nom : '';
        $dureeEx = isset($cv->experiencesPro[0]->duree) ? $cv->experiencesPro[0]->duree : '';
        $entrepriseExp = isset($cv->experiencesPro[0]->entreprise) ? $cv->experiencesPro[0]->entreprise : '';
        $certifNom = isset($cv->certificats[0]->nom) ? $cv->certificats[0]->nom : '';
        $interet = isset($cv->autres[0]->interet) ? $cv->autres[0]->interet : '';        
    }

    ?>