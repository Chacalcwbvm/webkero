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
    $id = intval($_POST["id"]);
    $nome = $conn->real_escape_string($_POST["nome"]);

    // Atualiza o procedimento no banco de dados
    $sql = "UPDATE procedimentos SET nome='$nome' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Procedimento atualizado com sucesso.";
    } else {
        echo "Erro ao atualizar o procedimento: " . $conn->error;
    }

    $conn->close();

    // Redireciona de volta para a página de procedimentos
    header("Location: procedimentos.php");
    exit();
} else {
    echo "Método de requisição inválido.";
}
?>