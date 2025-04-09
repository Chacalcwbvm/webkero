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

$tipo_atendimento = $_POST['tipo_atendimento'] ?? '';
$cliente_id = $_POST['cliente_id'] ?? '';
$dependente_id = $_POST['dependente_id'] ?? '';
$data_atendimento = $_POST['data_atendimento'] ?? '';
$hora_atendimento = $_POST['hora_atendimento'] ?? '';
$procedimento_id = $_POST['procedimento_id'] ?? '';
$tipo_pagamento_id = $_POST['tipo_pagamento_id'] ?? '';
$numero_parcelas = $_POST['numero_parcelas'] ?? 1;
$valor_total = $_POST['valor_total'] ?? '';

$errores = [];

if (empty($cliente_id)) {
    $errores[] = "O campo Cliente é obrigatório.";
}

if ($tipo_atendimento === 'dependente' && empty($dependente_id)) {
    $errores[] = "O campo Dependente é obrigatório.";
}

if (empty($data_atendimento)) {
    $errores[] = "O campo Data de Atendimento é obrigatório.";
}

if (empty($hora_atendimento)) {
    $errores[] = "O campo Hora de Atendimento é obrigatório.";
}

if (empty($procedimento_id)) {
    $errores[] = "O campo Procedimento é obrigatório.";
}

if (empty($tipo_pagamento_id)) {
    $errores[] = "O campo Tipo de Pagamento é obrigatório.";
}

if (empty($valor_total)) {
    $errores[] = "O campo Valor Total é obrigatório.";
}

if (empty($errores)) {
    // Verifica se o tipo_pagamento_id existe na tabela tipo_pagamento
    $tipo_pagamento_check = $conn->prepare("SELECT id FROM tipo_pagamento WHERE id = ?");
    $tipo_pagamento_check->bind_param("i", $tipo_pagamento_id);
    $tipo_pagamento_check->execute();
    $tipo_pagamento_result = $tipo_pagamento_check->get_result();
    
    if ($tipo_pagamento_result->num_rows > 0) {
        // Inserção na tabela atendimentos
        $stmt = $conn->prepare("INSERT INTO atendimentos (cliente_id, dependente_id, data_atendimento, hora_atendimento, procedimento_id, tipo_pagamento_id, numero_parcelas, valor_total) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iissiiid", $cliente_id, $dependente_id, $data_atendimento, $hora_atendimento, $procedimento_id, $tipo_pagamento_id, $numero_parcelas, $valor_total);
        
        if ($stmt->execute()) {
            $atendimento_id = $stmt->insert_id;
            $valor_parcela = $valor_total / $numero_parcelas;

            // Inserção na tabela parcelas
            for ($i = 0; $i < $numero_parcelas; $i++) {
                $data_recebimento = date('Y-m-d', strtotime("+".($i*30 + 2)." days", strtotime($data_atendimento)));
                $numero_parcela = $i + 1;

                $stmt_parcela = $conn->prepare("INSERT INTO parcelas (atendimento_id, numero_parcela, data_recebimento, valor_parcela) VALUES (?, ?, ?, ?)");
                $stmt_parcela->bind_param("iisd", $atendimento_id, $numero_parcela, $data_recebimento, $valor_parcela);
                $stmt_parcela->execute();
            }

            echo "<div class='success-message'>Atendimento registrado com sucesso.</div>";
        } else {
            $errores[] = "Erro ao registrar atendimento: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        $errores[] = "Erro: Tipo de pagamento inválido.";
    }
} else {
    echo "<div class='error-message'><ul>";
    foreach ($errores as $erro) {
        echo "<li>$erro</li>";
    }
    echo "</ul></div>";
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Processar Atendimento</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="content">
        <a href="atendimento_form.php" class="voltar">Voltar</a>
    </div>
    <script>
    setTimeout(function() {
        document.querySelector('.success-message').style.display = 'none';
        document.querySelector('.error-message').style.display = 'none';
    }, 5000);
    </script>
</body>
</html>