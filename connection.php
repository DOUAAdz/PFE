<?php 
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "crud";  
$port = 3306;

$conn = new mysqli($servername, $username, $password, $db_name, $port);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}
?>
