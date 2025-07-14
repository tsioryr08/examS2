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
$filtre_categorie = $_GET['categorie'] ?? '';
$filtre_nom = $_GET['nom_objet'] ?? '';
$filtre_dispo = isset($_GET['disponible']) ? true : false;

require_once('../inc/function.php');
$objets = rechercher_objets($filtre_categorie, $filtre_nom, $filtre_dispo);

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
  <a class="navbar-brand" href="accueil.php">SHAROBJ</a>
  <div class="ms-auto text-white">
    <a href="membres.php" class="btn btn-outline-light btn-sm me-2">Membres</a>
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
  
  <form method="get" class="row mb-4">
    <div class="col-md-3">
      <label for="categorie" class="form-label">Catégorie</label>
      <select name="categorie" id="categorie" class="form-select">
        <option value="">Toutes</option>
        <?php foreach ($categories as $cat): ?>
          <option value="<?= $cat['id_categorie'] ?>" <?= (isset($_GET['categorie']) && $_GET['categorie'] == $cat['id_categorie']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($cat['nom_categorie']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-4">
      <label for="nom_objet" class="form-label">Nom de l'objet</label>
      <input type="text" name="nom_objet" id="nom_objet" class="form-control" value="<?= htmlspecialchars($_GET['nom_objet'] ?? '') ?>">
    </div>

    <div class="col-md-3 d-flex align-items-end">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="disponible" value="1" <?= isset($_GET['disponible']) ? 'checked' : '' ?>>
        <label class="form-check-label">Disponible uniquement</label>
      </div>
    </div>

    <div class="col-md-2 d-flex align-items-end">
      <button class="btn btn-primary w-100" type="submit">Rechercher</button>
    </div>
  </form>

  <h3>Objets disponibles</h3>
  <div class="row">
    <?php if ($objets): ?>
      <?php foreach ($objets as $objet): ?>
        <?php 
          $images_supplementaires = get_images_supplementaires($objet['id_objet']); 

          if (!empty($objet['nom_image'])) {
              array_unshift($images_supplementaires, ['nom_image' => $objet['nom_image'], 'lien_image' => '../assets/img/' . $objet['nom_image']]);
          }
        ?>
        
        <div class="col-md-4 mb-4">
          <div class="card h-100 shadow-sm">
            <?php if (!empty($objet['nom_image'])): ?>
              <img src="../assets/img/<?= htmlspecialchars($objet['nom_image']) ?>" class="card-img-top" alt="Image principale">
            <?php else: ?>
              <img src="../assets/img/default.jpg" class="card-img-top" alt="Pas d'image">
            <?php endif; ?>
            <div class="card-body">
              <h5 class="card-title">
                <a href="fiche_objet.php?id=<?= $objet['id_objet'] ?>">
                  <?= htmlspecialchars($objet['nom_objet']) ?>
                </a>
              </h5>

              <p class="card-text">
                <strong>Propriétaire:</strong> <?= htmlspecialchars($objet['proprietaire']) ?><br>
                <strong>Retour:</strong> <?= $objet['date_retour'] ? htmlspecialchars($objet['date_retour']) : "Pas emprunté" ?>
              </p>

              <form action="upload.php" method="post" enctype="multipart/form-data" class="mb-2">
                <input type="hidden" name="id_objet" value="<?= $objet['id_objet'] ?>">
                <input type="file" name="images[]" multiple required class="form-control form-control-sm mb-2">
                <button type="submit" class="btn btn-sm btn-outline-success">Uploader des images</button>
              </form>

              <?php if (!empty($images_supplementaires)): ?>
                <div class="mt-3">
                  <h6>Autres images :</h6>
                  <div class="d-flex flex-wrap gap-2">
                    <?php foreach ($images_supplementaires as $img): ?>
                      <?php if (!empty($img['lien_image'])): ?>
                        <img src="<?= htmlspecialchars($img['lien_image']) ?>" style="width: 80px; height: 80px; object-fit: cover; border: 1px solid #ccc;">
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </div>
                </div>
              <?php endif; ?>

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
