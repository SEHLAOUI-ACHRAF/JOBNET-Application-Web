<?php
session_start();

include("../../backend/database.php");

$email = $_SESSION['emailCandidat'];

try {

    $getUserInfo = $bdd->prepare("SELECT id_utilisateur, Nom, Prenom, datenaissance, telephone, ville, adresse, sexe FROM utilisateur WHERE email = ?");
    $getUserInfo->execute([$email]);
    $userInfo = $getUserInfo->fetch();

    if ($userInfo) {

        $id = $userInfo['id_utilisateur'];
        $Nom = $userInfo['Nom'];
        $Prenom = $userInfo['Prenom'];
        $datenaissance = $userInfo['datenaissance'];
        $telephone = $userInfo['telephone'];
        $ville = $userInfo['ville'];
        $adresse = $userInfo['adresse'];
        $sexe = $userInfo['sexe'];

        include("profile.html");
        
    } else {

        echo "User information not found.";
    }
} catch (PDOException $e) {
    echo "Error fetching user information: " . $e->getMessage();
}

if (isset($_POST["Enregistrer"])) {

    $newNom = $_POST["nom"];
    $newPrenom = $_POST["prenom"];
    $newdatenaissance = $_POST['daten'];
    $newtelephone = $_POST['telephone'];
    $newville = $_POST['ville'];
    $newadresse = $_POST['adresse'];
    $newsexe = $_POST['sexe'];
    $newemail = $_POST['Email'];

    try {
        $stmt = $bdd->prepare("UPDATE utilisateur SET Nom = ?, Prenom = ?, datenaissance = ?, telephone = ?, ville = ?, adresse = ?, email = ?, sexe = ?  WHERE id_utilisateur = ?");
        
        $stmt->execute(array($newNom, $newPrenom, $newdatenaissance, $newtelephone, $newville, $newadresse, $newemail, $newsexe, $id));

        $_SESSION['emailCandidat'] = $newemail;

        echo '<script type="text/javascript">';
        echo 'window.location.href = window.location.href;';
        echo '</script>';

    } catch (PDOException $e) {
        echo "Error updating user information: " . $e->getMessage();
    } finally {
        $stmt = null;
    }    
}
$bdd = null;
?>