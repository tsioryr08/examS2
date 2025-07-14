<?php
session_start();
require('../inc/function.php');

if (!isset($_SESSION['id_membre'])) {
    header('Location: ../login.php'); 
    exit;
}

$nom = $_SESSION['nom'];
$email = $_SESSION['email'];
$categories = get_all_categories();
$objets = isset($_GET['categorie']) ? get_objets_par_categorie((int)$_GET['categorie']) : afficher_liste_objet();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Accueil</title>
  <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
  <a class="navbar-brand" href="accueil.php">Objets Partagés</a>
  <div class="ms-auto text-white">
    Bonjour, <?= htmlspecialchars($nom) ?> &nbsp;|&nbsp;
    <a href="deconnexion.php" class="btn btn-outline-light btn-sm">Déconnexion</a>
  </div>
</nav>

<div class="container mt-4">
  <h3>Catégories</h3>
  <div class="mb-4">
    <a href="accueil.php" class="btn btn-secondary btn-sm me-2">Toutes</a>
    <?php foreach ($categories as $cat): ?>
      <a href="accueil.php?categorie=<?= $cat['id_categorie'] ?>" class="btn btn-outline-primary btn-sm me-2">
        <?= htmlspecialchars($cat['nom_categorie']) ?>
      </a>
    <?php endforeach; ?>
  </div>

  <h3>Objets disponibles</h3>
  <div class="row">
    <?php if ($objets): ?>
      <?php foreach ($objets as $objet): ?>
        <div class="col-md-4 mb-4">
          <div class="card h-100 shadow-sm">
            <?php if (!empty($objet['nom_image'])): ?>
              <img src="../assets/img/<?= htmlspecialchars($objet['nom_image']) ?>" class="card-img-top" alt="Image">
            <?php else: ?>
              <img src="../assets/img/default.jpg" class="card-img-top" alt="Pas d'image">
            <?php endif; ?>
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($objet['nom_objet']) ?></h5>
              <p class="card-text">
                <strong>Propriétaire:</strong> <?= htmlspecialchars($objet['proprietaire']) ?><br>
                <strong>Retour:</strong> <?= $objet['date_retour'] ? htmlspecialchars($objet['date_retour']) : "Pas emprunté" ?>
              </p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="alert alert-info">Aucun objet trouvé pour cette catégorie.</div>
    <?php endif; ?>
  </div>
</div>

</body>
</html>
