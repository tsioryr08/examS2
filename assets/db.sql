CREATE TABLE exams2_membre(
    id_membre INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    birth_date DATE NOT NULL,
    genre ENUM ('M','F') NOT NULL,
    email VARCHAR(100),
    ville VARCHAR(100),
    mdp VARCHAR(100),
    image_profil VARCHAR(200)
);

INSERT INTO exams2_membre (nom, birth_date, genre, email, ville, mdp, image_profil) VALUES
('Riana', '1995-06-15', 'F', 'riana@mail.com', 'Antananarivo', 'pass1', 'riana.jpg'),
('Tojo', '1992-04-22', 'M', 'tojo@mail.com', 'Fianarantsoa', 'pass2', 'tojo.jpg'),
('Malala', '1998-12-01', 'F', 'malala@mail.com', 'Toamasina', 'pass3', 'malala.jpg'),
('Hery', '1990-09-10', 'M', 'hery@mail.com', 'Mahajanga', 'pass4', 'hery.jpg');

CREATE TABLE exams2_categorie_objet(
    id_categorie INT AUTO_INCREMENT PRIMARY KEY,
    nom_categorie VARCHAR(100)

);

INSERT INTO exams2_categorie_objet (nom_categorie) VALUES
('esthetique'),
('bricolage'),
('mecanique'),
('cuisine');


CREATE TABLE exams2_objet(
    id_objet INT AUTO_INCREMENT PRIMARY KEY,
    nom_objet VARCHAR(100),
    id_categorie INT,
    id_membre INT
);

-- Objets de Riana (id_membre = 1)
INSERT INTO exams2_objet (nom_objet, id_categorie, id_membre) VALUES
('Seche-cheveux', 1, 1),
('Vernis a ongles', 1, 1),
('Creme visage', 1, 1),
('Tournevis', 2, 1),
('Perceuse', 2, 1),
('Cle anglaise', 3, 1),
('Pompe manuelle', 3, 1),
('Mixeur', 4, 1),
('Fouet electrique', 4, 1),
('Blender', 4, 1);

-- Objets de Tojo (id_membre = 2)
INSERT INTO exams2_objet (nom_objet, id_categorie, id_membre) VALUES
('Tondeuse', 1, 2),
('Fer a lisser', 1, 2),
('Pinceau maquillage', 1, 2),
('Marteau', 2, 2),
('Scie sauteuse', 2, 2),
('Crick', 3, 2),
('Cric hydraulique', 3, 2),
('Casserole', 4, 2),
('Marmite', 4, 2),
('Grille-pain', 4, 2);

-- Objets de Malala (id_membre = 3)
INSERT INTO exams2_objet (nom_objet, id_categorie, id_membre) VALUES
('Creme solaire', 1, 3),
('Brosse visage', 1, 3),
('Bain d huile', 1, 3),
('Pistolet a colle', 2, 3),
('Tournevis electrique', 2, 3),
('Pneu de secours', 3, 3),
('Cle dynamometrique', 3, 3),
('Batteur', 4, 3),
('Robot patissier', 4, 3),
('Planche a decouper', 4, 3);

-- Objets de Hery (id_membre = 4)
INSERT INTO exams2_objet (nom_objet, id_categorie, id_membre) VALUES
('Shampooing', 1, 4),
('Lotion tonique', 1, 4),
('eponge konjac', 1, 4),
('Niveau a bulle', 2, 4),
('Cloueuse', 2, 4),
('Pompe a air', 3, 4),
('Kit de reparation', 3, 4),
('Four micro-ondes', 4, 4),
('Rape a legumes', 4, 4),
('Mixeur plongeant', 4, 4);



CREATE TABLE exams2_images_objet (
  id_objet INT AUTO_INCREMENT PRIMARY KEY,
  id_image INT,
  nom_image VARCHAR(100)
);

INSERT INTO exams2_images_objet (id_image, nom_image) VALUES
(1, 'obj1.jpg'),
(2, 'obj2.jpg'),
(3, 'obj3.jpg'),
(4, 'obj4.jpg'),
(5, 'obj5.jpg'),
(6, 'obj6.jpg'),
(7, 'obj7.jpg'),
(8, 'obj8.jpg'),
(9, 'obj9.jpg'),
(10, 'obj10.jpg'),
(11, 'obj11.jpg'),
(12, 'obj12.jpg'),
(13, 'obj13.jpg'),
(14, 'obj14.jpg'),
(15, 'obj15.jpg'),
(16, 'obj16.jpg'),
(17, 'obj17.jpg'),
(18, 'obj18.jpg'),
(19, 'obj19.jpg'),
(20, 'obj20.jpg'),
(21, 'obj21.jpg'),
(22, 'obj22.jpg'),
(23, 'obj23.jpg'),
(24, 'obj24.jpg'),
(25, 'obj25.jpg'),
(26, 'obj26.jpg'),
(27, 'obj27.jpg'),
(28, 'obj28.jpg'),
(29, 'obj29.jpg'),
(30, 'obj30.jpg'),
(31, 'obj31.jpg'),
(32, 'obj32.jpg'),
(33, 'obj33.jpg'),
(34, 'obj34.jpg'),
(35, 'obj35.jpg'),
(36, 'obj36.jpg'),
(37, 'obj37.jpg'),
(38, 'obj38.jpg'),
(39, 'obj39.jpg'),
(40, 'obj40.jpg');


CREATE TABLE exams2_emprunt(
    id_emprunt INT,
    id_objet INT,
    id_membre INT,
    date_emprunt DATE NOT NULL,
    date_retour DATE NOT NULL
);
INSERT INTO exams2_emprunt (id_emprunt, id_objet, id_membre, date_emprunt, date_retour) VALUES
(1, 1, 2, '2025-07-01 ', '2025-07-10 '),
(2, 5, 3, '2025-07-03 ', '2025-07-08 '),
(3, 12, 1, '2025-07-05 ', '2025-07-12 '),
(4, 17, 4, '2025-07-06 ', '2025-07-13 '),
(5, 21, 2, '2025-07-07 ', '2025-07-14 '),
(6, 25, 1, '2025-07-08 ', '2025-07-15 '),
(7, 31, 3, '2025-07-09 ', '2025-07-16 '),
(8, 35, 2, '2025-07-10 ', '2025-07-17 '),
(9, 8, 3, '2025-07-11 ', '2025-07-20 '),
(10, 30, 4, '2025-07-12 ', '2025-07-19 ');



