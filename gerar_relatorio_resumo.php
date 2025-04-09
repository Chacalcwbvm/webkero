<?php
include 'session_check.php';
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aa_04_krcrm";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$cliente = isset($_POST['cliente']) ? $_POST['cliente'] : '';
$dependente = isset($_POST['dependente']) ? $_POST['dependente'] : '';
$data_inicio = isset($_POST['data_inicio']) ? $_POST['data_inicio'] : '';
$data_fim = isset($_POST['data_fim']) ? $_POST['data_fim'] : '';
$procedimentos = isset($_POST['procedimentos']) ? $_POST['procedimentos'] : [];
$tipo_pagamento = isset($_POST['tipo_pagamento']) ? $_POST['tipo_pagamento'] : [];
$relatorio_tipo = isset($_POST['relatorio_tipo']) ? $_POST['relatorio_tipo'] : 'diario';

$query_base = "SELECT 
               SUM(a.valor_total) as total, 
               p.nome as procedimento, 
               t.descricao as tipo_pagamento, 
               IFNULL(CONCAT(c.nome, ' / ', d.nome), c.nome) as cliente_dependente,
               a.data_atendimento
               FROM atendimentos a 
               LEFT JOIN procedimentos p ON a.procedimento_id = p.id 
               LEFT JOIN tipo_pagamento t ON a.tipo_pagamento_id = t.id 
               LEFT JOIN clientes c ON a.cliente_id = c.id 
               LEFT JOIN dependentes d ON a.dependente_id = d.id 
               WHERE 1=1";

if (!empty($cliente)) {
    $query_base .= " AND a.cliente_id = '$cliente'";
}

if (!empty($dependente)) {
    $query_base .= " AND a.dependente_id = '$dependente'";
}

if (!empty($data_inicio)) {
    $query_base .= " AND a.data_atendimento >= '$data_inicio'";
}

if (!empty($data_fim)) {
    $query_base .= " AND a.data_atendimento <= '$data_fim'";
}

if (!empty($procedimentos)) {
    $procedimentos_list = implode(",", $procedimentos);
    $query_base .= " AND a.procedimento_id IN ($procedimentos_list)";
}

if (!empty($tipo_pagamento)) {
    $tipo_pagamento_list = implode(",", $tipo_pagamento);
    $query_base .= " AND a.tipo_pagamento_id IN ($tipo_pagamento_list)";
}

switch ($relatorio_tipo) {
    case 'mensal':
        $query_base .= " GROUP BY YEAR(a.data_atendimento), MONTH(a.data_atendimento)";
        break;
    case 'anual':
        $query_base .= " GROUP BY YEAR(a.data_atendimento)";
        break;
    case 'semanal':
        $query_base .= " GROUP BY YEAR(a.data_atendimento), WEEK(a.data_atendimento)";
        break;
    case 'diario':
    default:
        $query_base .= " GROUP BY YEAR(a.data_atendimento), MONTH(a.data_atendimento), DAY(a.data_atendimento)";
        break;
}

$query_base .= " ORDER BY a.data_atendimento DESC";

$result = $conn->query($query_base);

$total_rows = $result->num_rows;
$current_row = 0;

if ($total_rows > 0) {
    echo "<table>";
    switch ($relatorio_tipo) {
        case 'mensal':
            echo "<tr><th>Mês</th><th>Total</th></tr>";
            break;
        case 'anual':
            echo "<tr><th>Ano</th><th>Total</th></tr>";
            break;
        case 'semanal':
            echo "<tr><th>Semana</th><th>Total</th></tr>";
            break;
        case 'diario':
        default:
            echo "<tr><th>Data de Atendimento</th><th>Total</th></tr>";
            break;
    }
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        switch ($relatorio_tipo) {
            case 'mensal':
                echo "<td>" . date('M/Y', strtotime($row['data_atendimento'])) . "</td>";
                break;
            case 'anual':
                echo "<td>" . date('Y', strtotime($row['data_atendimento'])) . "</td>";
                break;
            case 'semanal':
                echo "<td>" . date('W/Y', strtotime($row['data_atendimento'])) . "</td>";
                break;
            case 'diario':
            default:
                echo "<td>" . date('d/m/Y', strtotime($row['data_atendimento'])) . "</td>";
                break;
        }
        echo "<td>" . $row['total'] . "</td>";
        echo "</tr>";
        $current_row++;
        $progress = ($current_row / $total_rows) * 100;
        echo "id: $current_row\ndata: {\"progress\": \"$progress\"}\n\n";
        ob_flush();
        flush();
    }
    echo "</table>";
} else {
    echo "Nenhum atendimento encontrado.";
}

$conn->close();
?>