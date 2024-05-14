<?php 
    session_start();
    $id = $_SESSION['id'];
    $nom = $_SESSION['nom'];
    $prenom = $_SESSION['prenom'];
    include("cv-official.php");
    include("cv-form.html");
?>