const form = document.getElementById('form');
const cvPdf = document.getElementById('cvPdf');

class Info {
    constructor(profession,domaine,etablissement,) {
        this.profession = profession;
        this.domaine = domaine;
        this.etablissement=etablissement;
        }

}
class Diplome {
    constructor(nom, duree) {
        this.nom = nom;
        this.duree = duree;
    }
}

class Stage {
    constructor(nom, duree, entreprise, sujet) {
        this.nom = nom;
        this.duree = duree;
        this.entreprise = entreprise;
        this.sujet = sujet;
    }
}

class ExperiencePro {
    constructor(poste, duree, entreprise) {
        this.poste = poste;
        this.duree = duree;
        this.entreprise = entreprise;
    }
}

class Certificats {
    constructor(nom){
        this.nom= nom;
    }
}

class Autre {
    constructor(interet) {
        this.interet = interet;
    }
}

class Cv {
    constructor(infoInstance) {
        this.infoInstance = infoInstance;
        this.diplomes = [];
        this.stages = [];
        this.experiencesPro = [];
        this.certificats = [];
        this.autres = [];
    }

    ajouterDiplome(diplomeInstance) {
        this.diplomes.push(diplomeInstance);
    }

    ajouterStage(stageInstance) {
        this.stages.push(stageInstance);
    }

    ajouterExperiencePro(experienceProInstance) {
        this.experiencesPro.push(experienceProInstance);
    }
    ajouterCertificat(certificatsInstance) {
        this.certificats.push(certificatsInstance);
    }

    ajouterAutre(autreInstance) {
        this.autres.push(autreInstance);
    }
}
function creeCv() {
    const infoInstance = new Info(
        document.getElementById("profession").value,
        document.getElementById("domaine").value,
        document.getElementById("etablissement").value
    );
    const cv = new Cv(infoInstance);

    // Récupérer les diplômes du formulaire
    const diplomeInputs = document.querySelectorAll('#diplomeBlock');
    diplomeInputs.forEach(input => {
        const diplomeInstance = new Diplome(
            input.querySelector('input[name="diplomeName[]"]').value,
            input.querySelector('select[name="diplomeDuree[]"]').value
        );
        cv.ajouterDiplome(diplomeInstance);
    });

    // Récupérer les stages du formulaire
    const stageInputs = document.querySelectorAll('#stageBlock');
    stageInputs.forEach(input => {
        const stageInstance = new Stage(
            input.querySelector('input[name="nomStage[]"]').value,
            input.querySelector('select[name="stageDuree[]"]').value,
            input.querySelector('input[name="entrepriseStage[]"]').value,
            input.querySelector('input[name="sujet[]"]').value
        );
        cv.ajouterStage(stageInstance);
    });

    // Récupérer les expériences professionnelles du formulaire
    const expProInputs = document.querySelectorAll('#experienceProBlock');
    expProInputs.forEach(input => {
        const expProInstance = new ExperiencePro(
            input.querySelector('input[name="poste[]"]').value,
            input.querySelector('select[name="dureeEx[]"]').value,
            input.querySelector('input[name="entrepriseExp[]"]').value
        );
        cv.ajouterExperiencePro(expProInstance);
    });

    // Récupérer les certificats du formulaire
    const certificatInputs = document.querySelectorAll('#certificatsBlock');
    certificatInputs.forEach(input => {
        const certificatsInstance = new Certificats(
            input.querySelector('input[name="certifNom[]"]').value
        );
        cv.ajouterCertificat(certificatsInstance);
    });

    // Récupérer les autres informations du formulaire
    const autreInputs = document.querySelectorAll('#interetBlock');
    autreInputs.forEach(input => {
        const autreInstance = new Autre(
            input.querySelector('input[name="interet[]"]').value
        );
        cv.ajouterAutre(autreInstance);
    });

    return cv;
}


let c = 1;
 function addSection(sectionId, blockId, buttonId) {
                    const section = document.getElementById(sectionId);
                    const block = document.getElementById(blockId);
                    const newBlock = block.cloneNode(true);
                    const inputs = newBlock.querySelectorAll('input, select');
                    inputs.forEach(input => {
                        input.value = ''; 
                    });
                    section.appendChild(newBlock);
                    c++;
                    if(c===3){
                        const button= document.getElementById(buttonId);
                        button.style.display="none";
                        c=1;
                    }
            }
function sendCv(){
                const cv = creeCv();
                console.log(cv.certificats);
                fetch('cvObjet.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(cv)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(data => {
                    console.log(data); // Handle response from PHP file
                })
                .catch(error => {
                    console.error('There was a problem with your fetch operation:', error);
                });
            }





