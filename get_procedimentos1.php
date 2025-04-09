<?php
$conn = new mysqli("localhost", "root", "", "aa_04_krcrm");
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$query = "SELECT id, nome FROM procedimentos";
$result = $conn->query($query);

$procedimentos = [];
while ($row = $result->fetch_assoc()) {
    $procedimentos[] = $row;
}

echo json_encode($procedimentos);
$conn->close();
?>