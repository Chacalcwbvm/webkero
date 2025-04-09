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

$procedimento_id = $_POST['procedimento_id'] ?? '';
$tipo_pagamento_id = $_POST['tipo_pagamento_id'] ?? '';
$cliente_dependente = $_POST['cliente_dependente'] ?? '';
$data_inicio = $_POST['data_inicio'] ?? '';
$data_fim = $_POST['data_fim'] ?? '';
$relatorio_tipo = $_POST['relatorio_tipo'] ?? 'diario';

// Monta a consulta SQL com base nos filtros
$sql = "SELECT 
            a.id,
            c.nome AS cliente,
            d.nome AS dependente,
            p.nome AS procedimento,
            tp.descricao AS tipo_pagamento,
            a.data_atendimento,
            a.valor_total,
            pa.data_recebimento,
            pa.valor_parcela
        FROM atendimentos a
        LEFT JOIN clientes c ON c.id = a.cliente_id
        LEFT JOIN dependentes d ON d.id = a.dependente_id
        JOIN procedimentos p ON a.procedimento_id = p.id
        JOIN tipo_pagamento tp ON a.tipo_pagamento_id = tp.id
        JOIN parcelas pa ON pa.atendimento_id = a.id
        WHERE 1=1";

if (!empty($procedimento_id)) {
    $sql .= " AND p.id = '$procedimento_id'";
}

if (!empty($tipo_pagamento_id)) {
    $sql .= " AND tp.id = '$tipo_pagamento_id'";
}

if (!empty($cliente_dependente)) {
    $sql .= " AND (c.nome LIKE '%$cliente_dependente%' OR d.nome LIKE '%$cliente_dependente%')";
}

if (!empty($data_inicio) && !empty($data_fim)) {
    $sql .= " AND a.data_atendimento BETWEEN '$data_inicio' AND '$data_fim'";
}

$result = $conn->query($sql);

// Geração do relatório
$html = '';

if ($relatorio_tipo == 'diario') {
    $html .= '<h2>Relatório Diário</h2>';
    $html .= '<table>';
    $html .= '<tr><th>ID</th><th>Cliente/Dependente</th><th>Procedimento</th><th>Tipo Pagamento</th><th>Data Atendimento</th><th>Valor Total</th><th>Data Recebimento</th><th>Valor Parcela</th></tr>';

    $total = 0;

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $html .= '<tr>';
            $html .= '<td>' . $row['id'] . '</td>';
            $html .= '<td>' . $row['cliente'] . ' / ' . $row['dependente'] . '</td>';
            $html .= '<td>' . $row['procedimento'] . '</td>';
            $html .= '<td>' . $row['tipo_pagamento'] . '</td>';
            $html .= '<td>' . date('d/m/y', strtotime($row['data_atendimento'])) . '</td>';
            $html .= '<td>' . number_format($row['valor_total'], 2, ',', '.') . '</td>';
            $html .= '<td>' . date('d/m/y', strtotime($row['data_recebimento'])) . '</td>';
            $html .= '<td>' . number_format($row['valor_parcela'], 2, ',', '.') . '</td>';
            $html .= '</tr>';
            $total += $row['valor_parcela'];
        }
        $html .= '<tr class="total"><td colspan="7">Total</td><td>' . number_format($total, 2, ',', '.') . '</td></tr>';
    } else {
        $html .= '<tr><td colspan="8">Nenhum atendimento encontrado.</td></tr>';
    }

    $html .= '</table>';
} elseif ($relatorio_tipo == 'semanal') {
    $html .= '<h2>Relatório Semanal</h2>';
    // Aqui você implementa o relatório semanal com os filtros e opções desejadas
} elseif ($relatorio_tipo == 'mensal') {
    $html .= '<h2>Relatório Mensal</h2>';
    // Aqui você implementa o relatório mensal com os filtros e opções desejadas
} elseif ($relatorio_tipo == 'anual') {
    $html .= '<h2>Relatório Anual</h2>';
    // Aqui você implementa o relatório anual com os filtros e opções desejadas
}

$conn->close();

echo $html;
?>