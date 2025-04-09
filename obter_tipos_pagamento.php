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

$sql = "SELECT id, descricao FROM tipo_pagamento";
$result = $conn->query($sql);

$tipos_pagamento = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $tipos_pagamento[] = $row;
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($tipos_pagamento);
?>