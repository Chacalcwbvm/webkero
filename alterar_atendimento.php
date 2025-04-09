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
    die("Falha na conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $cliente_id = $_POST['cliente_id'];
    $procedimento_id = $_POST['procedimento_id'];
    $data_atendimento = $_POST['data_atendimento'];
    $hora_atendimento = $_POST['hora_atendimento'];
    $valor_total = $_POST['valor_total'];
    $tipo_pagamento_id = $_POST['tipo_pagamento_id'];
    $numero_parcelas = $_POST['numero_parcelas'];

    $sql = "UPDATE atendimentos SET 
            cliente_id = ?, 
            procedimento_id = ?, 
            data_atendimento = ?, 
            hora_atendimento = ?, 
            valor_total = ?, 
            tipo_pagamento_id = ?, 
            numero_parcelas = ? 
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iissdiii", $cliente_id, $procedimento_id, $data_atendimento, $hora_atendimento, $valor_total, $tipo_pagamento_id, $numero_parcelas, $id);

    if ($stmt->execute()) {
        echo "Atendimento atualizado com sucesso.";
        header("Location: atendimentos.php");
    } else {
        echo "Erro ao atualizar atendimento: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>