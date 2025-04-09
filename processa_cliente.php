
<?php
include 'log_action.php';

$conn = new mysqli("localhost", "root", "", "aa_04_krcrm");
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$nome = $conn->real_escape_string($_POST['nome']);
$data_nascimento = $conn->real_escape_string($_POST['data_nascimento']);
$telefone = $conn->real_escape_string($_POST['telefone']);
$email = $conn->real_escape_string($_POST['email']);
$pais = $conn->real_escape_string($_POST['pais']);
$estado = intval($_POST['estado']);
$cidade = intval($_POST['cidade']);
$tipo = $conn->real_escape_string($_POST['tipo']);
$user_id = 1; // ID do usuário logado (deve ser obtido dinamicamente)

// Verificar se o estado é válido
$sql_estado = "SELECT id FROM estados WHERE id = $estado";
$result_estado = $conn->query($sql_estado);
if ($result_estado->num_rows == 0) {
    die("Estado inválido.");
}

// Verificar se a cidade é válida e pertence ao estado selecionado
$sql_cidade = "SELECT id FROM cidade WHERE id = $cidade AND estado_id = $estado";
$result_cidade = $conn->query($sql_cidade);
if ($result_cidade->num_rows == 0) {
    die("Cidade inválida ou não pertence ao estado selecionado.");
}

$sql = "INSERT INTO clientes (nome, data_nascimento, telefone, email, pais, estado, cidade, tipo) 
        VALUES ('$nome', '$data_nascimento', '$telefone', '$email', '$pais', $estado, $cidade, '$tipo')";

if ($conn->query($sql) === TRUE) {
    $cliente_id = $conn->insert_id;
    log_action($conn, $user_id, 'INSERT', 'clientes', $cliente_id, "Cadastro de novo cliente: $nome");
    header("Location: cria_cliente.php?status=success");
} else {
    header("Location: cria_cliente.php?status=error");
}

$conn->close();
?>