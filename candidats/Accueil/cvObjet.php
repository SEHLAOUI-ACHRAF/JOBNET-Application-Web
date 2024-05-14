<?php
    session_start();
    include("cvObjet1.php");
    
    if(isset($_POST)){
        $cvObjet = file_get_contents("php://input");
        $CV=json_decode($cvObjet);
        $_SESSION['cvObjet']=$CV;
    }
?>