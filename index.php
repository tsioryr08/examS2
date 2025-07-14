<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion</title>
  <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/style.css" rel="stylesheet">
</head>
<body>

<div class="login-container">
  <h2 class="text-center mb-4">Connexion</h2>
  <form action="pages/traitement_login.php" method="post">
    <div class="mb-3">
      <label for="email" class="form-label">Adresse e-mail</label>
      <input type="email" name="email" class="form-control" placeholder="exemple@email.com" required>
    </div>

    <div class="mb-3">
      <label for="nom" class="form-label">Nom</label>
      <input type="text" name="nom" class="form-control" placeholder="Entrez votre nom" required>
    </div>

    <button type="submit" class="btn btn-primary w-100">Se connecter</button>
  </form>
</div>

</body>
</html>
