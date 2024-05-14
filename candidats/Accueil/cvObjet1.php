<?php
    class Info {
        public $profession;
        public $domaine;
        public $etablissement;
    
        public function __construct($profession, $domaine, $etablissement) {
            $this->profession = $profession;
            $this->domaine = $domaine;
            $this->etablissement = $etablissement;
        }
    }
    
    class Diplome {
        public $nom;
        public $duree;
    
        public function __construct($nom, $duree) {
            $this->nom = $nom;
            $this->duree = $duree;
        }
    }
    
    class Stage {
        public $nom;
        public $duree;
        public $entreprise;
        public $sujet;
    
        public function __construct($nom, $duree, $entreprise, $sujet) {
            $this->nom = $nom;
            $this->duree = $duree;
            $this->entreprise = $entreprise;
            $this->sujet = $sujet;
        }
    }
    
    class ExperiencePro {
        public $poste;
        public $duree;
        public $entreprise;
    
        public function __construct($poste, $duree, $entreprise) {
            $this->poste = $poste;
            $this->duree = $duree;
            $this->entreprise = $entreprise;
        }
    }
    
    class Certificats {
        public $nom;
    
        public function __construct($nom) {
            $this->nom = $nom;
        }
    }
    
    class Autre {
        public $interet;
    
        public function __construct($interet) {
            $this->interet = $interet;
        }
    }
    
    class Cv {
        public $infoInstance;
        public $diplomes = [];
        public $stages = [];
        public $experiencesPro = [];
        public $certificats = [];
        public $autres = [];
    
        public function __construct($infoInstance) {
            $this->infoInstance = $infoInstance;
        }
    
        public function ajouterDiplome($diplomeInstance) {
            $this->diplomes[] = $diplomeInstance;
        }
    
        public function ajouterStage($stageInstance) {
            $this->stages[] = $stageInstance;
        }
    
        public function ajouterExperiencePro($experienceProInstance) {
            $this->experiencesPro[] = $experienceProInstance;
        }
    
        public function ajouterCertificat($certificatsInstance) {
            $this->certificats[] = $certificatsInstance;
        }
    
        public function ajouterAutre($autreInstance) {
            $this->autres[] = $autreInstance;
        }
    }
    class Cvs {
        public $cvs = [];
    
        public function __construct($cvInstances) {
            foreach ($cvInstances as $cvInstance) {
                $this->ajouterCv($cvInstance);
            }
        }
    
        public function ajouterCv($cvInstance) {
            $this->cvs[] = $cvInstance;
        }
    }
?>