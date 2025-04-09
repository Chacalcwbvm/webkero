<?php
$conn = new mysqli("localhost", "root", "", "aa_04_krcrm");
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$procedimento_id = isset($_POST['procedimento_id']) ? $_POST['procedimento_id'] : '';
$tipo_pagamento_id = isset($_POST['tipo_pagamento_id']) ? $_POST['tipo_pagamento_id'] : '';
$cliente_dependente = isset($_POST['cliente_dependente']) ? $_POST['cliente_dependente'] : '';
$data_inicio = isset($_POST['data_inicio']) ? $_POST['data_inicio'] : '';
$data_fim = isset($_POST['data_fim']) ? $_POST['data_fim'] : '';
$relatorio_tipo = isset($_POST['relatorio_tipo']) ? $_POST['relatorio_tipo'] : 'diario';
$detalhamento = isset($_POST['detalhamento']) ? $_POST['detalhamento'] : 'resumido';

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

if (!empty($procedimento_id)) {
    $query_base .= " AND a.procedimento_id = '$procedimento_id'";
}

if (!empty($tipo_pagamento_id)) {
    $query_base .= " AND a.tipo_pagamento_id = '$tipo_pagamento_id'";
}

if (!empty($cliente_dependente)) {
    $query_base .= " AND (a.cliente_id = '$cliente_dependente' OR a.dependente_id = '$cliente_dependente')";
}

if (!empty($data_inicio)) {
    $query_base .= " AND a.data_atendimento >= '$data_inicio'";
}

if (!empty($data_fim)) {
    $query_base .= " AND a.data_atendimento <= '$data_fim'";
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

if ($result->num_rows > 0) {
    if ($detalhamento == 'resumido') {
        echo "<table>";
        echo "<tr><th>Procedimento</th><th>Tipo de Pagamento</th><th>Cliente/Dependente</th><th>Total</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['procedimento'] . "</td>";
            echo "<td>" . $row['tipo_pagamento'] . "</td>";
            echo "<td>" . $row['cliente_dependente'] . "</td>";
            echo "<td>" . $row['total'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<table>";
        echo "<tr><th>Data de Atendimento</th><th>Procedimento</th><th>Tipo de Pagamento</th><th>Cliente/Dependente</th><th>Total</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['data_atendimento'] . "</td>";
            echo "<td>" . $row['procedimento'] . "</td>";
            echo "<td>" . $row['tipo_pagamento'] . "</td>";
            echo "<td>" . $row['cliente_dependente'] . "</td>";
            echo "<td>" . $row['total'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
} else {
    echo "Nenhum atendimento encontrado.";
}

$conn->close();
?>