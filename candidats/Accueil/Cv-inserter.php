<?php
    session_start();
    include("../../backend/database.php");
    $id=$_SESSION["id"];
    

    try {
    if (isset($_POST["cvFormulaire"])) {
        $CV=$_SESSION["cvObjet"];
        $stmtCv = $bdd->prepare("INSERT INTO Cv (id_utilisateur) VALUES (?)");
        $stmtCv->execute(array($id));
        $cvReq = "SELECT * FROM cv
                    WHERE id_utilisateur = ?";

        $getCv = $bdd->prepare($cvReq);
        $getCv->execute(array($id));

        $cv = $getCv->fetch(PDO::FETCH_ASSOC);
        $idCv=$cv["idCv"];
        $_SESSION["idCv"]=$idCv;

        $stmt1 = $bdd->prepare("INSERT INTO informations (profession, domaine, etablissement, idCv) VALUES (?, ?, ?, ?)");
        $stmt1->execute(array($CV->infoInstance->profession, $CV->infoInstance->domaine, $CV->infoInstance->etablissement, $idCv));
        
        foreach ($CV->diplomes as $diplome) {
            $stmtDiplome = $bdd->prepare("INSERT INTO diplome (diplomeName, diplomeDuree, idCv) VALUES (?, ?, ?)");
            $stmtDiplome->execute(array($diplome->nom, $diplome->duree, $idCv));
        }

        foreach ($CV->stages as $stage) {
            $stmtStage = $bdd->prepare("INSERT INTO stage (nomStage, stageDuree, entrepriseStage, sujet, idCv) VALUES (?, ?, ?, ?, ?)");
            $stmtStage->execute(array($stage->nom, $stage->duree, $stage->entreprise, $stage->sujet, $idCv));
        }

        foreach ($CV->experiencesPro as $experiencePro) {
            $stmtExperiencePro = $bdd->prepare("INSERT INTO experPro (poste, dureeEx, entrepriseExp, idCv) VALUES (?, ?, ?, ?)");
            $stmtExperiencePro->execute(array($experiencePro->poste, $experiencePro->duree, $experiencePro->entreprise, $idCv));
        }

        foreach ($CV->certificats as $certificat) {
            $stmtCertif = $bdd->prepare("INSERT INTO certificats(certifNom, idCv) VALUES (?, ?)");
            $stmtCertif->execute(array($certificat->nom, $idCv));
        }

        foreach ($CV->autres as $autre) {
            $stmtAutre = $bdd->prepare("INSERT INTO Autre(interet, idCv) VALUES (?, ?)");
            $stmtAutre->execute(array($autre->interet, $idCv));
        }
        header("Location: cv-info.php");
        }
    } catch (PDOException $e) {
            echo "An error occurred while inserting data: " . $e->getMessage();
    }
?>