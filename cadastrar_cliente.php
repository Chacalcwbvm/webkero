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

$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$telefone = $_POST['telefone'] ?? '';
$pais = $_POST['pais'] ?? '';
$cidade = $_POST['cidade'] ?? '';
$estado = $_POST['estado'] ?? '';
$data_nascimento = $_POST['data_nascimento'] ?? '';

if ($nome && $email && $telefone && $pais && $cidade && $estado && $data_nascimento) {
    // Verifica se o cliente já existe
    $sql = "SELECT id FROM clientes WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<div class='error-message'>Erro: Cliente já cadastrado.</div>";
    } else {
        // Inserção na tabela clientes
        $sql_insert = "INSERT INTO clientes (nome, email, telefone, pais, cidade, estado, data_nascimento) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("sssssss", $nome, $email, $telefone, $pais, $cidade, $estado, $data_nascimento);

        if ($stmt_insert->execute()) {
            echo "<div class='success-message'>Cliente cadastrado com sucesso.</div>";
        } else {
            echo "<div class='error-message'>Erro ao cadastrar cliente: " . $stmt_insert->error . "</div>";
        }
        $stmt_insert->close();
    }
    $stmt->close();
} else {
    echo "<div class='error-message'>Erro: Todos os campos são obrigatórios.</div>";
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cadastrar Cliente</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="content">
        <a href="cadastro_cliente_form.php" class="voltar">Voltar</a>
    </div>
    <script>
    setTimeout(function() {
        document.querySelector('.success-message').style.display = 'none';
        document.querySelector('.error-message').style.display = 'none';
    }, 5000);
    </script>
</body>
</html>