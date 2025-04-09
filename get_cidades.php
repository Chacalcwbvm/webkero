<?php
$conn = new mysqli("localhost", "root", "", "aa_04_krcrm");
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if (isset($_GET['estado_id'])) {
    $estado_id = $_GET['estado_id'];
    $sql = "SELECT id, cidade FROM cidade WHERE estado_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $estado_id);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<option value=''>Selecione uma Cidade</option>";
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['id'] . "'>" . $row['cidade'] . "</option>";
    }
    $stmt->close();
}

$conn->close();
?>