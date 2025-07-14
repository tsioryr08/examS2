<?php
session_start();
require('../inc/function.php');

if (!isset($_SESSION['id_membre'])) {
    die("Non autorisé.");
}

$db = dbconnect();
$id_objet = (int)$_POST['id_objet'];
$upload_dir = '../assets/img/';
$images = $_FILES['images'];

for ($i = 0; $i < count($images['name']); $i++) {
    $tmp = $images['tmp_name'][$i];
    $name = uniqid() . '_' . basename($images['name'][$i]);
    $path = $upload_dir . $name;

    if (move_uploaded_file($tmp, $path)) {
        $sql = "INSERT INTO exams2_images_objet (id_objet, nom_image) VALUES ($id_objet, '$name')";
        mysqli_query($db, $sql);
    }
}

header('Location: accueil.php');
exit;
