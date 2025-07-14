<?php
session_start();
$nom = $_SESSION['nom'] ?? '';
$email = $_SESSION['email'] ?? '';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Inscription</title>
  <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/style.css" rel="stylesheet">
</head>
<body>

<div class="container d-flex justify-content-center align-items-center vh-100">
  <div class="card shadow p-4 w-100" style="max-width: 600px;">
    <h2 class="text-center mb-4">Inscription</h2>
    <form action="traitement_inscription.php" method="post">
      <div class="mb-3">
        <label>Nom :</label>
        <input type="text" name="nom" class="form-control" value="<?= $nom ?>" required>
      </div>
      <div class="mb-3">
        <label>Email :</label>
        <input type="email" name="email" class="form-control" value="<?= $email ?>" required>
      </div>
      <div class="mb-3">
        <label>Date de naissance :</label>
        <input type="datetime-local" name="birth_date" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Genre :</label>
        <select name="genre" class="form-select" required>
          <option value="M">Homme</option>
          <option value="F">Femme</option>
        </select>
      </div>
      <div class="mb-3">
        <label>Ville :</label>
        <input type="text" name="ville" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Mot de passe :</label>
        <input type="password" name="mdp" class="form-control" required>
      </div>
     
      <button type="submit" class="btn btn-success w-100">S'inscrire</button>
    </form>
  </div>
</div>

</body>
</html>
