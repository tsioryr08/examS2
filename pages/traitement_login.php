<?php
ini_set('display_errors', '1');
require('../inc/function.php');
session_start();

if (empty($_POST['email'])) {
    die("nom requis");
}
 
$email = $_POST['email'];
$nom = $_POST['nom'];

$_SESSION['email'] = $email;
$_SESSION['nom']=$nom;

$id_membre = miexiste($email,$nom);

if ($id_membre !== false) {

    $_SESSION['id_membre'] = $id_membre;
    header ("Location: accueil.php");
} else {
    header('Location:inscription.php');

}

exit;
?>