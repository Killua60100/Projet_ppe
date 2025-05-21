USE database_ppe;

-- Table des artistes
CREATE TABLE IF NOT EXISTS artistes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL,
    image VARCHAR(255)
);

-- Table des musiques
CREATE TABLE IF NOT EXISTS musiques (
    id INT PRIMARY KEY AUTO_INCREMENT,
    titre VARCHAR(255) NOT NULL,
    artiste_id INT,
    image VARCHAR(255),
    fichier VARCHAR(255),
    FOREIGN KEY (artiste_id) REFERENCES artistes(id)
);

-- Table des favoris
CREATE TABLE IF NOT EXISTS favoris (
    id INT PRIMARY KEY AUTO_INCREMENT,
    utilisateur_id INT,
    musique_id INT,
    date_ajout DATETIME,
    FOREIGN KEY (musique_id) REFERENCES musiques(id)
);

-- Insertion de quelques données de test
INSERT INTO artistes (nom, image) VALUES 
('Gims', 'gims-ciel.jpg'),
('Naps', 'naps-la-kiffance.jpg'),
('Ninho', 'ninho-vrais.jpg'),
('SDM', 'sdm-cartier-santos.jpg'),
('13 Organisé', '13organise-bande-organise.jpg');

-- Insertion de quelques musiques
INSERT INTO musiques (titre, artiste_id, image) VALUES 
('Ciel', 1, 'gims-ciel.jpg'),
('La Kiffance', 2, 'naps-la-kiffance.jpg'),
('Vrais', 3, 'ninho-vrais.jpg'),
('Cartier Santos', 4, 'sdm-cartier-santos.jpg'),
('Bande Organisée', 5, '13organise-bande-organise.jpg');