<?php
$conn = new mysqli("localhost", "root", "", "aa_04_krcrm");
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$query = "SELECT id, descricao FROM tipo_pagamento";
$result = $conn->query($query);

$tipos_pagamento = [];
while ($row = $result->fetch_assoc()) {
    $tipos_pagamento[] = $row;
}

echo json_encode($tipos_pagamento);
$conn->close();
?>