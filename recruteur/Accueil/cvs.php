<?php
session_start();
include 'cvObjets.php';
include("../../backend/database.php");

$id = $_SESSION['id'];
if (isset($_POST["filtreCv"])) {
    $ville = htmlspecialchars($_POST["ville"]);
    $age = htmlspecialchars($_POST["age"]);
    $domaine = htmlspecialchars($_POST["domaine"]);
    $sexe = htmlspecialchars($_POST["sexe"]);
    $diplome = htmlspecialchars($_POST["diplome"]);
    $diplomeScore = $_POST["diplomeScore"];
    $stageScore = $_POST["stageScore"];
    $experienceScore = $_POST["experienceScore"];
    $certifScore = $_POST["certifScore"];
    try {
        // Assuming you have a PDO connection named $bdd established previously
    
    $candidat = "SELECT * FROM utilisateur
    WHERE ville = ?
    AND YEAR(NOW()) - YEAR(datenaissance) = ?
    AND sexe = ?
    AND type ='candidat' ";
    
    // Prepare and execute the query
    $getcandidatIds = $bdd->prepare($candidat);
    $getcandidatIds->execute(array($ville, $age, $sexe));
    
    // Fetch all rows as an associative array
    $candidatIds = $getcandidatIds->fetchAll(PDO::FETCH_ASSOC);
    
    // Create an array to hold Cv objects
    $cvInstances = [];
    
    // Check if any results were found
    if ($candidatIds) {
            // Loop through each row
            foreach ($candidatIds as $candidatId) {
            $id_utilisateur = $candidatId['id_utilisateur'];
            $nomCandidat = $candidatId['Nom'];
            $prenomCandidat = $candidatId['Prenom'];
            // Prepare and execute the second query
            $cvQuery = "SELECT * FROM Cv
                   WHERE id_utilisateur = ?
                   AND idCv IN (
                       SELECT idCv
                       FROM informations
                       WHERE domaine = ?
                       AND idCv IN (
                           SELECT idCv
                           FROM diplome
                           WHERE diplomeName = ?
                       )
                   )
                   LIMIT 1";
    
            // Prepare and execute the query
            $getCvInfo = $bdd->prepare($cvQuery);
            $getCvInfo->execute(array($id_utilisateur, $domaine, $diplome));
                    
            // Fetch all rows as an associative array
            $cvInfo = $getCvInfo->fetch(PDO::FETCH_ASSOC);
            // Loop through each CV info row
            if($cvInfo){
                $idCv=$cvInfo['idCv'];
                $cvDetailsQuery = "SELECT 
                            informations.profession, 
                            informations.domaine, 
                            informations.etablissement,
                            diplome.diplomeName, 
                            diplome.diplomeDuree,
                            stage.nomStage, 
                            stage.stageDuree, 
                            stage.entrepriseStage, 
                            stage.sujet,
                            experPro.poste AS nomExp, 
                            experPro.dureeEx, 
                            experPro.entrepriseExp,
                            certificats.certifNom,
                            Autre.interet
                      FROM Cv
                      LEFT JOIN informations ON Cv.idCv = informations.idCv
                      LEFT JOIN diplome ON Cv.idCv = diplome.idCv
                      LEFT JOIN stage ON Cv.idCv = stage.idCv
                      LEFT JOIN experPro ON Cv.idCv = experPro.idCv
                      LEFT JOIN certificats ON Cv.idCv = certificats.idCv
                      LEFT JOIN Autre ON Cv.idCv = Autre.idCv
                      WHERE Cv.idCv = ?";
    
    // Prepare and execute the query
    $getCvDetails = $bdd->prepare($cvDetailsQuery);
    $getCvDetails->execute(array($idCv));
    
    // Fetch all rows as an associative array
    $cvDetails = $getCvDetails->fetchAll(PDO::FETCH_ASSOC);
    
    // Initialize Cv object
    
    $cvInstance = new Cv(new Info($cvDetails[0]['profession'], $cvDetails[0]['domaine'], $cvDetails[0]['etablissement']));
    
    $cvInstance->idCandidat = $id_utilisateur;
    $cvInstance->nom = $nomCandidat;
    $cvInstance->prenom = $prenomCandidat;
    
    // Loop through each row of CV details
    foreach ($cvDetails as $detail) {
        // Add Diplome instance to Cv object
        $cvInstance->ajouterDiplome(new Diplome($detail['diplomeName'], $detail['diplomeDuree']));
        $countDiplomesQuery = "SELECT COUNT(*) AS count FROM diplome WHERE idCv = ?";
        $countDiplomesStmt = $bdd->prepare($countDiplomesQuery);
        $countDiplomesStmt->execute(array($idCv));
        $countDiplomesResult = $countDiplomesStmt->fetch(PDO::FETCH_ASSOC);
        $nbrDiplomes = $countDiplomesResult['count'];
    
        // Add Stage instance to Cv object
        $cvInstance->ajouterStage(new Stage($detail['nomStage'], $detail['stageDuree'], $detail['entrepriseStage'], $detail['sujet']));
        $countStagesQuery = "SELECT COUNT(*) AS count FROM stage WHERE idCv = ?";
        $countStagesStmt = $bdd->prepare($countStagesQuery);
        $countStagesStmt->execute(array($idCv));
        $countStagesResult = $countStagesStmt->fetch(PDO::FETCH_ASSOC);
        $nbrStages = $countStagesResult['count'];
        // Add ExperiencePro instance to Cv object
        $cvInstance->ajouterExperiencePro(new ExperiencePro($detail['nomExp'], $detail['dureeEx'], $detail['entrepriseExp']));
        $countExperiencesQuery = "SELECT COUNT(*) AS count FROM experPro WHERE idCv = ?";
        $countExperiencesStmt = $bdd->prepare($countExperiencesQuery);
        $countExperiencesStmt->execute(array($idCv));
        $countExperiencesResult = $countExperiencesStmt->fetch(PDO::FETCH_ASSOC);
        $nbrExperiences = $countExperiencesResult['count'];
    
        // Add Certificats instance to Cv object
        $cvInstance->ajouterCertificat(new Certificats($detail['certifNom']));
        $countCertificatsQuery = "SELECT COUNT(*) AS count FROM certificats WHERE idCv = ?";
        $countCertificatsStmt = $bdd->prepare($countCertificatsQuery);
        $countCertificatsStmt->execute(array($idCv));
        $countCertificatsResult = $countCertificatsStmt->fetch(PDO::FETCH_ASSOC);
        $nbrCertificats = $countCertificatsResult['count'];
        // Add Autre instance to Cv object
        $cvInstance->ajouterAutre(new Autre($detail['interet']));
    }
    $cvInstance->score = $diplomeScore * $nbrDiplomes + $nbrCertificats * $certifScore + $nbrStages * $stageScore + $nbrExperiences * $experienceScore; 
    
    // Add Cv instance to array
    $cvInstances[] = $cvInstance;
            }else{
                echo "Cvs n'existe pas";
                }
            }
    $cvs = new Cvs($cvInstances);
    
    }
        else{
            echo "utilisateurs n'existe pas";
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}


// if(isset($cvs)){
//     if (!empty($cvs->cvs)) {
//         // Boucle à travers chaque CV
//         foreach ($cvs->cvs as $cv) {
//             // Affichage des informations du CV
//             echo "Profession: " . $cv->infoInstance->profession . "<br>";
//             echo "Domaine: " . $cv->infoInstance->domaine . "<br>";
//             echo "Etablissement: " . $cv->infoInstance->etablissement . "<br>";

//             // Affichage des diplômes
//             echo "Diplômes:<br>";
//             foreach ($cv->diplomes as $diplome) {
//                 echo "- " . $diplome->nom . "<br>";
//             }

//             // Affichage des stages
//             echo "Stages:<br>";
//             foreach ($cv->stages as $stage) {
//                 echo "- " . $stage->nom . "<br>";
//             }

//             // Affichage des expériences professionnelles
//             echo "Expériences professionnelles:<br>";
//             foreach ($cv->experiencesPro as $experiencePro) {
//                 echo "- " . $experiencePro->poste . "<br>";
//             }

//             // Affichage des certificats
//             echo "Certificats:<br>";
//             foreach ($cv->certificats as $certificat) {
//                 echo "- " . $certificat->nom . "<br>";
//             }

//             // Affichage des autres informations
//             echo "Autres:<br>";
//             foreach ($cv->autres as $autre) {
//                 echo "- " . $autre->interet . "<br>";
//             }

//             echo "<br>"; // Ajout d'une ligne vide entre chaque CV
//         }
//     } else {
//         echo "Aucun CV trouvé dans l'objet Cvs.";
//     }
// }
// else{
//     echo "accune cv trouvée";
// }
include 'cvFiltre.php';
?>
