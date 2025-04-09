<?php
include 'session_check.php';

// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "", "aa_04_krcrm");
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Verifica se o dependente existe
    $sql = "SELECT id FROM dependentes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Exclui o dependente
        $sql_delete = "DELETE FROM dependentes WHERE id = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("i", $id);
        if ($stmt_delete->execute()) {
            echo "Dependente excluído com sucesso.";
        } else {
            echo "Erro ao excluir dependente.";
        }
        $stmt_delete->close();
    } else {
        echo "Dependente não encontrado.";
    }
    $stmt->close();
} else {
    echo "ID do dependente não fornecido.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Dependente</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="content">
        <a href="manutencao_dependentes.php" class="voltar">Voltar</a>
    </div>
</body>
</html>