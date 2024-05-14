<?php
    include("../../backend/database.php");
    try {
        $cvReq = "SELECT * FROM cv
                    WHERE id_utilisateur = ?";

        // Préparation et exécution de la première requête
        $getCv = $bdd->prepare($cvReq);
        $getCv->execute(array($id));

        // Récupération des résultats
        $cv = $getCv->fetch(PDO::FETCH_ASSOC);
        if ($cv) {
            $formButton="Nouveau CV";
            //requete de suppression du CV et ses associé
            $idCv=$cv['idCv'];
            $stmtDeleteInfo = $bdd->prepare("DELETE FROM informations WHERE idCv = ?");
            $stmtDeleteInfo->execute(array($idCv));

        // Supprimer les diplômes du CV
        $stmtDeleteDiplome = $bdd->prepare("DELETE FROM diplome WHERE idCv = ?");
        $stmtDeleteDiplome->execute(array($idCv));

        // Supprimer les stages du CV
        $stmtDeleteStage = $bdd->prepare("DELETE FROM stage WHERE idCv = ?");
        $stmtDeleteStage->execute(array($idCv));

        // Supprimer les expériences professionnelles du CV
        $stmtDeleteExpPro = $bdd->prepare("DELETE FROM experPro WHERE idCv = ?");
        $stmtDeleteExpPro->execute(array($idCv));

        // Supprimer les certificats du CV
        $stmtDeleteCertif = $bdd->prepare("DELETE FROM certificats WHERE idCv = ?");
        $stmtDeleteCertif->execute(array($idCv));

        // Supprimer les autres informations du CV
        $stmtDeleteAutre = $bdd->prepare("DELETE FROM Autre WHERE idCv = ?");
        $stmtDeleteAutre->execute(array($idCv));

        // Supprimer le CV lui-même
        $stmtDeleteCv = $bdd->prepare("DELETE FROM cv WHERE idCv = ?");
        $stmtDeleteCv->execute(array($idCv));
        }
        else {
            $formButton="Soumettre";
        }

            $profession = "";
            $domaine = "";
            $etablissement = "";
            $diplomeName = "";
            $diplomeDurée = "";
            $nomStage = "";
            $stageDuree = "";
            $entrepriseStage = "";
            $sujet = "";
            $poste = "";
            $dureeEx = "";
            $entrepriseExp = "";
            $certifNom = "";
            $interet = "";
            include("cvPdfUpl.php");
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
?>