<?php
function dbconnect(){
    $bdd= mysqli_connect('localhost','root','','exams2');
    if(!$bdd){
        die("erreur");
    }
    return $bdd;
}

function miexiste($email, $nom) {
    $db = dbconnect();
    $sql = "SELECT id_membre FROM exams2_membre WHERE email = '$email' AND nom = '$nom'";
    $result = mysqli_query($db, $sql);

    if (!$result) {
        die("Erreur SQL dans miexiste: " . mysqli_error($db));
    }

    if ($row = mysqli_fetch_assoc($result)) {
        mysqli_free_result($result);
        return $row['id_membre'];
    }
    return false; 
}

function nouveau($nom, $birth_date, $genre, $email, $ville, $mdp) {
    $db = dbconnect();
    
    $sql = "INSERT INTO exams2_membre (nom, birth_date, genre, email, ville, mdp)
            VALUES ('$nom', '$birth_date', '$genre', '$email', '$ville', '$mdp')";

    $result = mysqli_query($db, $sql);

    if (!$result) {
        die("Erreur SQL dans nouveau: " . mysqli_error($db));
    }

    return mysqli_insert_id($db);
}


function afficher_liste_objet(){
    $db = dbconnect();

    $sql = "SELECT 
                o.id_objet,
                o.nom_objet,
                m.nom AS proprietaire,
                e.date_retour,
                i.nom_image
            FROM exams2_objet o
            JOIN exams2_membre m ON o.id_membre = m.id_membre
            LEFT JOIN exams2_emprunt e ON o.id_objet = e.id_objet
            LEFT JOIN exams2_images_objet i ON o.id_objet = i.id_objet";

    $result = mysqli_query($db, $sql);

    $reponse = [];

    while($row = mysqli_fetch_assoc($result)) {
        $reponse[] = $row;
    }

    return !empty($reponse) ? $reponse : null;
}

function get_all_categories() {
    $db = dbconnect();
    $sql = "SELECT id_categorie, nom_categorie FROM exams2_categorie_objet";
    $result = mysqli_query($db, $sql);

    $categories = [];
    while($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }
    return $categories;
}

function get_objets_par_categorie($id_categorie) {
    $db = dbconnect();

    $sql = "SELECT 
                o.id_objet,
                o.nom_objet,
                m.nom AS proprietaire,
                e.date_retour,
                i.nom_image
            FROM exams2_objet o
            JOIN exams2_membre m ON o.id_membre = m.id_membre
            LEFT JOIN exams2_emprunt e ON o.id_objet = e.id_objet
            LEFT JOIN exams2_images_objet i ON o.id_objet = i.id_objet
            WHERE o.id_categorie = $id_categorie";

    $result = mysqli_query($db, $sql);
    $objets = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $objets[] = $row;
    }

    return $objets;
}
function get_images_supplementaires($id_objet) {
    $db = dbconnect();
    $id_objet = (int)$id_objet;

    $sql = "SELECT nom_image, lien_image 
            FROM exams2_autreImage 
            WHERE id_objet = $id_objet";

    $res = mysqli_query($db, $sql);

    if (!$res) {
        die("Erreur SQL : " . mysqli_error($db));
    }

    $images = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $images[] = $row;
    }
    return $images;
}


function supprimer_images_objet($id_objet) {
    $db = dbconnect();

    $sql = "SELECT nom_image FROM exams2_images_objet WHERE id_objet = $id_objet";
    $res = mysqli_query($db, $sql);

    if (!$res) {
        return false;
    }

    $upload_dir = __DIR__ . '/../assets/img/';

    while ($row = mysqli_fetch_assoc($res)) {
        $filepath = $upload_dir . $row['nom_image'];
        if (file_exists($filepath)) {
            unlink($filepath);
        }
    }

    $sql_delete = "DELETE FROM exams2_images_objet WHERE id_objet = $id_objet";
    $res_delete = mysqli_query($db, $sql_delete);

    return $res_delete !== false;
}


function get_membres_avec_objets() {
    $db = dbconnect();
    $sql = "SELECT 
                m.id_membre, m.nom, m.email, m.ville, m.birth_date, m.genre, m.image_profil,
                o.nom_objet, o.id_categorie, c.nom_categorie
            FROM exams2_membre m
            LEFT JOIN exams2_objet o ON m.id_membre = o.id_membre
            LEFT JOIN exams2_categorie_objet c ON o.id_categorie = c.id_categorie
            ORDER BY m.id_membre, o.id_categorie";

    $result = mysqli_query($db, $sql);
    $data = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id_membre'];
        if (!isset($data[$id])) {
            $data[$id] = [
                'nom' => $row['nom'],
                'email' => $row['email'],
                'ville' => $row['ville'],
                'birth_date' => $row['birth_date'],
                'genre' => $row['genre'],
                'image_profil' => $row['image_profil'],
                'objets' => []
            ];
        }

        if ($row['nom_objet']) {
            $cat = $row['nom_categorie'] ?? 'Autre';
            $data[$id]['objets'][$cat][] = $row['nom_objet'];
        }
    }

    return $data;
}

function rechercher_objets($categorie = '', $nom_objet = '', $disponible = false) {
    $db = dbconnect();

    $sql = "SELECT 
                o.id_objet,
                o.nom_objet,
                m.nom AS proprietaire,
                e.date_retour,
                i.nom_image
            FROM exams2_objet o
            JOIN exams2_membre m ON o.id_membre = m.id_membre
            LEFT JOIN exams2_emprunt e ON o.id_objet = e.id_objet
            LEFT JOIN exams2_images_objet i ON o.id_objet = i.id_objet
            WHERE 1"; 

    if (!empty($categorie)) {
        $categorie = (int)$categorie;
        $sql .= " AND o.id_categorie = $categorie";
    }

    if (!empty($nom_objet)) {
        $nom_objet = mysqli_real_escape_string($db, $nom_objet);
        $sql .= " AND o.nom_objet LIKE '%$nom_objet%'";
    }

    if ($disponible) {
        $sql .= " AND (e.date_retour IS NULL OR e.date_retour < CURDATE())";
    }

    $result = mysqli_query($db, $sql);
    $objets = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $objets[] = $row;
    }

    return $objets;
}

function get_fiche_objet($id_objet) {
    $db = dbconnect();
    $id = (int)$id_objet;

    $sql = "
        SELECT 
            o.id_objet,
            o.nom_objet,
            o.id_categorie,
            o.id_membre,
            i.nom_image
        FROM exams2_objet o
        LEFT JOIN exams2_images_objet i ON o.id_objet = i.id_objet
        WHERE o.id_objet = $id
    ";

    $res = mysqli_query($db, $sql);

    if (!$res) {
        die("Erreur SQL : " . mysqli_error($db));
    }

    // S’il y a plusieurs images, on regroupe les résultats
    $objet = null;
    $images = [];

    while ($row = mysqli_fetch_assoc($res)) {
        if (!$objet) {
            $objet = [
                'id_objet' => $row['id_objet'],
                'nom_objet' => $row['nom_objet'],
                'id_categorie' => $row['id_categorie'],
                'id_membre' => $row['id_membre'],
                'images' => []
            ];
        }

        if (!empty($row['nom_image'])) {
            $images[] = $row['nom_image'];
        }
    }

    if ($objet) {
        $objet['images'] = $images;
    }

    return $objet;
}


function get_historique_emprunt($id_objet) {
    $db = dbconnect();
    $id = (int)$id_objet;

    $sql = "SELECT e.date_emprunt, e.date_retour, m.nom AS emprunteur
            FROM exams2_emprunts e
            LEFT JOIN exams2_membres m ON m.id_membre = e.id_membre_emprunteur
            WHERE e.id_objet = $id
            ORDER BY e.date_emprunt DESC";

    $res = mysqli_query($db, $sql);
    $historique = [];

    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $historique[] = $row;
        }
    }

    return $historique;
}

function get_photo_principale($id_objet) {
    $bdd = dbconnect(); 
    $id_objet = (int)$id_objet;

    $sql = "SELECT nom_image FROM exams2_images_objet WHERE id_objet = $id_objet ORDER BY id_image ASC LIMIT 1";
    $res = $bdd->query($sql);

    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
        return $row['nom_image'];
    }

    return null; }


?>