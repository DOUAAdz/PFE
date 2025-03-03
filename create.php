<?php
include "connection.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $phone = htmlspecialchars(trim($_POST["phone"]));

    if (empty($name) || empty($email) || empty($phone)) {
        $error = "Tous les champs sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "L'email n'est pas valide.";
    } elseif (!preg_match("/^[0-9+\s()-]+$/", $phone)) {
        $error = "Le numéro de téléphone est invalide.";
    } else {
        $sql = "INSERT INTO crud2 (name, email, phone) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sss", $name, $email, $phone);
            if ($stmt->execute()) {
                $success = "Utilisateur ajouté avec succès !";
            } else {
                $error = "Erreur lors de l'ajout : " . $stmt->error;
            }
            $stmt->close();
        } else {
            $error = "Erreur de préparation de la requête.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un membre</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">r
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Ajouter</a>
    </div>
</nav>

<div class="container mt-5 form-container">
    <h2 class="text-center">Ajouter un membre</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger fade-in"><?= $error; ?></div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success fade-in"><?= $success; ?></div>
    <?php endif; ?>

    <form method="post" class="mt-4">
        <div class="form-group">
            <label>Nom :</label>
            <input type="text" name="name" class="form-control" required autofocus>
        </div>

        <div class="form-group">
            <label>Email :</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Téléphone :</label>
            <input type="text" name="phone" class="form-control" required pattern="[0-9+\s()-]+" title="Seuls les chiffres et symboles +, (), - sont autorisés.">
        </div>

        <button class="btn btn-primary btn-lg mt-3" type="submit">Ajouter</button>
        <a class="btn btn-secondary btn-lg mt-3" href="index.php">Annuler</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
