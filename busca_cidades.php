<?php include 'session_check.php'; ?>
<?php
if (isset($_POST['estado'])) {
    $estadoId = $_POST['estado'];

    $conn = new mysqli("localhost", "root", "", "aa_04_krcrm");
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    $sql = "SELECT id, nome FROM cidades WHERE estado_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $estadoId);
    $stmt->execute();
    $result = $stmt->get_result();

    $cidades = array();
    while ($row = $result->fetch_assoc()) {
        $cidades[] = $row;
    }

    $stmt->close();
    $conn->close();

    echo json_encode($cidades);
}
?>