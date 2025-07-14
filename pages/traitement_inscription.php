<?php
require('../inc/function.php');
session_start();

$nom = $_POST['nom'];
$email = $_POST['email'];
$birth_date = $_POST['birth_date'];
$genre = $_POST['genre'];
$ville = $_POST['ville'];
$mdp = $_POST['mdp'];
$image_profil = $_POST['image_profil'];

$id_membre = nouveau($nom, $birth_date, $genre, $email, $ville, $mdp, $image_profil);

$_SESSION['id_membre'] = $id_membre;
$_SESSION['email'] = $email;
$_SESSION['nom'] = $nom;

header("Location: accueil.php");
exit;
?>
