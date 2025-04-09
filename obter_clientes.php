<?php
include 'session_check.php';
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aa_04_krcrm";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$sql = "SELECT id, nome FROM clientes";
$result = $conn->query($sql);

$clientes = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $clientes[] = $row;
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($clientes);
?>