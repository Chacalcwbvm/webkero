<?php
$conn = new mysqli("localhost", "root", "", "aa_04_krcrm");
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if (isset($_GET['cliente_id'])) {
    $cliente_id = $_GET['cliente_id'];
    $sql = "SELECT id, nome FROM dependentes WHERE cliente_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cliente_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['id'] . "'>" . $row['nome'] . "</option>";
    }
    $stmt->close();
}

$conn->close();
?>