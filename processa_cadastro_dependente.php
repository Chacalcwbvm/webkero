<?php include 'session_check.php'; ?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "aa_04_krcrm");
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    $nome = $_POST['nome'];
    $data_nascimento = $_POST['data_nascimento'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $cliente_id = $_POST['cliente_id'];
    $tipo = $_POST['tipo'];

    $sql = "INSERT INTO dependentes (nome, data_nascimento, telefone, email, cliente_id, tipo)
    VALUES ('$nome', '$data_nascimento', '$telefone', '$email', '$cliente_id', '$tipo')";

    if ($conn->query($sql) === TRUE) {
        header("Location: cadastro_dependente.php?status=success");
        exit();
    } else {
        header("Location: cadastro_dependente.php?status=error");
        exit();
    }

    $conn->close();
}
?>