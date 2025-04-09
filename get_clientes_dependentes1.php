<?php
$conn = new mysqli("localhost", "root", "", "aa_04_krcrm");
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$query = "SELECT id, nome FROM clientes UNION SELECT id, nome FROM dependentes";
$result = $conn->query($query);

$clientes_dependentes = [];
while ($row = $result->fetch_assoc()) {
    $clientes_dependentes[] = $row;
}

echo json_encode($clientes_dependentes);
$conn->close();
?>