<?php
function dbconnect(){
    $bdd= mysqli_connect('localhost', 'ETU004184', 'pBksnNTa', 'db_s2_ETU004184');
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


?>