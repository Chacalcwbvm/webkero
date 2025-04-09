<?php include 'session_check.php'; ?>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aa_04_krcrm";

// Cria a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $data_nascimento = $_POST['data_nascimento'];
    $cliente_id = $_POST['cliente_id'];

    $sql = "UPDATE dependentes SET 
            nome = ?, 
            data_nascimento = ?, 
            cliente_id = ? 
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $nome, $data_nascimento, $cliente_id, $id);

    if ($stmt->execute()) {
        echo "Dependente atualizado com sucesso.";
        header("Location: dependentes.php");
    } else {
        echo "Erro ao atualizar dependente: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>