<?php
include("cvObjet1.php");

function extractCvInfo($cvText) {
  $profession = '';
  $domaine = '';
  $etablissement = '';
  $diplomeNom = '';
  $diplomeDuree = '';
  $stageNom = '';
  $stageDuree = '';
  $entrepriseStage = '';
  $sujet = '';
  $poste = '';
  $dureeExp = '';
  $entrepriseExp = '';
  $certification = '';
  $interet = '';

  $parts = preg_split('/\n\n/', $cvText);

  foreach ($parts as $part) {
      $lines = explode("\n", $part);
      foreach ($lines as $line) {
          $line = trim($line);
          if (strpos($line, 'Profession:') === 0) {
              $profession = trim(substr($line, strpos($line, ':') + 1));
              $profession = str_replace("<br />","\n", $profession);
          } elseif (strpos($line, 'Domaine:') === 0) {
              $domaine = trim(substr($line, strpos($line, ':') + 1));
              $domaine = str_replace("<br />","\n", $domaine);
          } elseif (strpos($line, 'Etablissement:') === 0) {
              $etablissement = trim(substr($line, strpos($line, ':') + 1));
              $etablissement = str_replace("<br />","\n", $etablissement);
          } elseif (strpos($line, 'Nom:') === 0 && strpos($part, 'Diplome:') !== false) {
              $diplomeNom = trim(substr($line, strpos($line, ':') + 1));
              $diplomeNom = str_replace("<br />","\n", $diplomeNom);
          } elseif (strpos($line, 'Durée:') === 0 && strpos($part, 'Diplome:') !== false) {
              $diplomeDuree = trim(substr($line, strpos($line, ':') + 1));
              $diplomeDuree = str_replace("<br />","\n", $diplomeDuree);
          } elseif (strpos($line, 'Nom:') === 0 && strpos($part, 'Stage:') !== false) {
              $stageNom = trim(substr($line, strpos($line, ':') + 1));
              $stageNom = str_replace("<br />","\n", $stageNom);
          } elseif (strpos($line, 'Durée:') === 0 && strpos($part, 'Stage:') !== false) {
              $stageDuree = trim(substr($line, strpos($line, ':') + 1));
              $stageDuree = str_replace("<br />","\n", $stageDuree);
          } elseif (strpos($line, 'Entreprise:') === 0) {
              $entrepriseStage = trim(substr($line, strpos($line, ':') + 1));
              $entrepriseStage = str_replace("<br />","\n", $entrepriseStage);
          } elseif (strpos($line, 'Sujet:') === 0) {
              $sujet = trim(substr($line, strpos($line, ':') + 1));
              $sujet = str_replace("<br />","\n", $sujet);
          } elseif (strpos($line, 'Poste:') === 0) {
              $poste = trim(substr($line, strpos($line, ':') + 1));
              $poste = str_replace("<br />","\n", $poste);
          } elseif (strpos($line, 'Durée:') === 0 && strpos($part, 'Expériences professionnelles:') !== false) {
              $dureeExp = trim(substr($line, strpos($line, ':') + 1));
              $dureeExp = str_replace("<br />","\n", $dureeExp);
          } elseif (strpos($line, 'Entreprise:') === 0) {
              $entrepriseExp = trim(substr($line, strpos($line, ':') + 1));
              $entrepriseExp = str_replace("<br />","\n", $entrepriseExp);
          } elseif (strpos($line, 'Cértification:') === 0) {
              $certification = trim(substr($line, strpos($line, ':') + 1));
              $certification = str_replace("<br />","\n", $certification);
          } elseif (strpos($line, 'Interet:') === 0) {
              $interet = trim(substr($line, strpos($line, ':') + 1));
              $interet = str_replace("<br />","\n", $interet);

          }
      }
  }

  $cv = new Cv(new Info($profession, $domaine, $etablissement));
  $cv->ajouterDiplome(new Diplome($diplomeNom, $diplomeDuree));
  $cv->ajouterStage(new Stage($stageNom, $stageDuree, $entrepriseStage, $sujet));
  $cv->ajouterExperiencePro(new ExperiencePro($poste, $dureeExp, $entrepriseExp));
  $cv->ajouterCertificat(new Certificats($certification));
  $cv->ajouterAutre(new Autre($interet));

  return $cv;
}
?>