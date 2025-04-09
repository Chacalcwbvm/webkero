<?php
include 'session_check.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aa_04_krcrm";

// Cria a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$cliente_id = $_POST['cliente_id'] ?? '';
$nome = $_POST['nome'] ?? '';
$data_nascimento = $_POST['data_nascimento'] ?? '';

if ($cliente_id && $nome && $data_nascimento) {
    // Verifica se o dependente já existe para o cliente
    $sql = "SELECT id FROM dependentes WHERE cliente_id = ? AND nome = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $cliente_id, $nome);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "Erro: Dependente já cadastrado para este cliente.";
    } else {
        // Inserção na tabela dependentes
        $sql_insert = "INSERT INTO dependentes (cliente_id, nome, data_nascimento) VALUES (?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("iss", $cliente_id, $nome, $data_nascimento);

        if ($stmt_insert->execute()) {
            echo "Dependente cadastrado com sucesso.";
        } else {
            echo "Erro ao cadastrar dependente: " . $stmt_insert->error;
        }
        $stmt_insert->close();
    }
    $stmt->close();
} else {
    echo "Erro: Todos os campos são obrigatórios.";
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cadastrar Dependente</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="content">
        <a href="cadastro_dependente_form.php" class="voltar">Voltar</a>
    </div>
    <script>
    setTimeout(function() {
        document.querySelector('.success-message').style.display = 'none';
        document.querySelector('.error-message').style.display = 'none';
    }, 5000);
    </script>
</body>
</html>