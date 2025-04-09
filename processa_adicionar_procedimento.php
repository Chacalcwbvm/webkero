<?php include 'session_check.php'; ?>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aa_04_krcrm";

// Cria conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $conn->real_escape_string($_POST["nome"]);

    // Insere o novo procedimento no banco de dados
    $sql = "INSERT INTO procedimentos (nome) VALUES ('$nome')";

    if ($conn->query($sql) === TRUE) {
        echo "Procedimento adicionado com sucesso.";
    } else {
        echo "Erro ao adicionar o procedimento: " . $conn->error;
    }

    $conn->close();

    // Redireciona de volta para a página de procedimentos
    header("Location: procedimentos.php");
    exit();
} else {
    echo "Método de requisição inválido.";
}
?>