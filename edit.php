<?php
include "connection.php";

$id = $name = $email = $phone = "";
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        header("Location: index.php");
        exit;
    }

    $id = intval($_GET['id']);
    $sql = "SELECT * FROM crud2 WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        header("Location: index.php");
        exit;
    }

    $name = htmlspecialchars($row["name"]);
    $email = htmlspecialchars($row["email"]);
    $phone = htmlspecialchars($row["phone"]);
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST["id"]);
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);

    if (!empty($name) && !empty($email) && !empty($phone)) {
        $sql = "UPDATE crud2 SET name=?, email=?, phone=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $name, $email, $phone, $id);

        if ($stmt->execute()) {
            $success = "Mise à jour réussie !";
        } else {
            $error = "Erreur lors de la mise à jour.";
        }
    } else {
        $error = "Tous les champs sont obligatoires.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modifier un membre</title>
    
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <!-- Fichier CSS personnalisé -->
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Modifier</a>
    </div>
</nav>

<!-- Formulaire de modification -->
<div class="container mt-4">
    <h2 class="text-center">Modifier un membre</h2>
    
    <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <?php if (!empty($success)) echo "<div class='alert alert-success'>$success</div>"; ?>

    <form method="post">
        <input type="hidden" name="id" value="<?= $id ?>">
        
        <div class="form-group">
            <label>Nom :</label>
            <input type="text" name="name" class="form-control" value="<?= $name ?>" required>
        </div>
        
        <div class="form-group">
            <label>Email :</label>
            <input type="email" name="email" class="form-control" value="<?= $email ?>" required>
        </div>
        
        <div class="form-group">
            <label>Téléphone :</label>
            <input type="text" name="phone" class="form-control" value="<?= $phone ?>" required>
        </div>
        
        <button class="btn btn-success w-100" type="submit">Mettre à jour</button>
        <a class="btn btn-secondary w-100 mt-2" href="index.php">Annuler</a>
    </form>
</div>

</body>
</html>
