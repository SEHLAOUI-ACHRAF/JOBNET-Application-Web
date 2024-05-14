CREATE TABLE IF NOT EXISTS utilisateur (
    id_utilisateur int NOT NULL AUTO_INCREMENT UNIQUE,
    Nom varchar(255) NOT NULL DEFAULT '',
    Prenom varchar(255) NOT NULL DEFAULT '',
    datenaissance date NOT NULL,
    telephone int NOT NULL,
    ville varchar(255) NOT NULL DEFAULT '',
    adresse varchar(255) NOT NULL DEFAULT '',
    email varchar(255) NOT NULL DEFAULT '',
    password varchar(255) NOT NULL DEFAULT '',
    type varchar(255) NOT NULL DEFAULT '',
    sexe varchar(255) NOT NULL DEFAULT '',
    PRIMARY KEY (id_utilisateur)
);

CREATE TABLE IF NOT EXISTS Cv (
    idCv int NOT NULL AUTO_INCREMENT UNIQUE,
    id_utilisateur int,
    PRIMARY KEY (idCv),
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS informations (
    id int NOT NULL AUTO_INCREMENT UNIQUE,
    profession varchar(255) NOT NULL DEFAULT '',
    domaine varchar(255) NOT NULL DEFAULT '',
    etablissement varchar(255) NOT NULL DEFAULT '',
    idCv int,
    PRIMARY KEY (id),
    FOREIGN KEY (idCv) REFERENCES Cv(idCv) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS diplome (
    idDiplome int NOT NULL AUTO_INCREMENT UNIQUE,
    diplomeName varchar(255) NOT NULL DEFAULT '',
    diplomeDuree varchar(255) NOT NULL DEFAULT '',
    idCv int,
    PRIMARY KEY (idDiplome),
    FOREIGN KEY (idCv) REFERENCES Cv(idCv) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS stage (
    idStage int NOT NULL AUTO_INCREMENT UNIQUE,
    nomStage varchar(255) NOT NULL DEFAULT '',
    stageDuree varchar(255) NOT NULL DEFAULT '',
    entrepriseStage varchar(255) NOT NULL DEFAULT '',
    sujet varchar(255) NOT NULL DEFAULT '',
    idCv int,
    PRIMARY KEY (idStage),
    FOREIGN KEY (idCv) REFERENCES Cv(idCv) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS experPro (
    idEx int NOT NULL AUTO_INCREMENT UNIQUE,
    poste varchar(255) NOT NULL DEFAULT '',
    dureeEx varchar(255) NOT NULL DEFAULT '',
    entrepriseExp varchar(255) NOT NULL DEFAULT '',
    idCv int,
    PRIMARY KEY (idEx),
    FOREIGN KEY (idCv) REFERENCES Cv(idCv) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS certificats (
    idCertif int NOT NULL AUTO_INCREMENT UNIQUE,
    certifNom varchar(255) NOT NULL DEFAULT '',
    idCv int,
    PRIMARY KEY (idCertif),
    FOREIGN KEY (idCv) REFERENCES Cv(idCv) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Autre (
    idAutre int NOT NULL AUTO_INCREMENT UNIQUE,
    interet varchar(255) NOT NULL DEFAULT '',
    idCv int,
    PRIMARY KEY (idAutre),
    FOREIGN KEY (idCv) REFERENCES Cv(idCv) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `message` (
	`id` int NOT NULL AUTO_INCREMENT UNIQUE,
	`contenu` varchar(500) NOT NULL DEFAULT '',
	`receiver` int NOT NULL DEFAULT '0',
	`sender` int NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `annonce` (
    `id` int NOT NULL AUTO_INCREMENT,
    `IdRecruteur` int NOT NULL DEFAULT 0,
    `Titre` varchar(255) NOT NULL DEFAULT '',
    `profil` varchar(255) NOT NULL DEFAULT '',
    `lieu` varchar(255) NOT NULL DEFAULT '',
    `type_contrat` varchar(255) NOT NULL DEFAULT '',
    `entreprise` varchar(255) NOT NULL DEFAULT '',
    `Description` varchar(1500) NOT NULL DEFAULT '',
    `Date_Pub` date NOT NULL DEFAULT '1970-01-01',
    PRIMARY KEY (`id`)
);

ALTER TABLE `message` ADD CONSTRAINT `message_fk2` FOREIGN KEY (`receiver`) REFERENCES `utilisateur`(`id_utilisateur`);
ALTER TABLE `message` ADD CONSTRAINT `message_fk3` FOREIGN KEY (`sender`) REFERENCES `utilisateur`(`id_utilisateur`);
ALTER TABLE `annonce` ADD CONSTRAINT `annonce_fk1` FOREIGN KEY (`IdRecruteur`) REFERENCES `utilisateur`(`id_utilisateur`);
