<?php
// Inclure la connexion à la base de données en haut du fichier
include "connection.php";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Gestion de l'équipe</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fichier CSS personnalisé -->
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>

    <div class="container my-4">
        <h2 class="text-center"> Liste de l'équipe</h2>

        <!-- Bouton Ajouter -->
        <div class="d-flex justify-content-between mb-3">
            <input type="text" id="searchInput" class="form-control w-50" placeholder="Rechercher un membre..." onkeyup="searchMember()">
            <a class="btn btn-primary rounded-pill" href="create.php"> Ajouter</a>
        </div>

        <!-- Tableau des membres -->
        <div class="table-responsive">
            <table class="table table-hover align-middle shadow-sm">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Date d'adhésion</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="teamTable">
                    <?php
                    $sql = "SELECT * FROM crud2 ORDER BY id DESC";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "
                            <tr id='row_{$row['id']}'>
                                <td>{$row['id']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['phone']}</td>
                                <td>{$row['join_date']}</td>
                                <td>
                                    <a class='btn btn-outline-success btn-sm' href='edit.php?id={$row['id']}'> Modifier</a>
                                    <button class='btn btn-outline-danger btn-sm delete-btn' data-id='{$row['id']}'> Supprimer</button>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>Aucun membre trouvé.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Fichier JavaScript -->
    <script src="script.js"></script>
</body>
</html>
