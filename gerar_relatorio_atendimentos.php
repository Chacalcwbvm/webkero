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

$cliente = $_POST['cliente'] ?? '';
$dependente = $_POST['dependente'] ?? '';
$data_inicio = $_POST['data_inicio'] ?? '';
$data_fim = $_POST['data_fim'] ?? '';
$procedimentos = $_POST['procedimento'] ?? [];
$tipos_pagamento = $_POST['tipo_pagamento'] ?? [];

// Monta a consulta SQL com base nos filtros
$sql = "SELECT 
            a.id,
            c.nome AS cliente,
            d.nome AS dependente,
            a.data_atendimento,
            a.hora_atendimento,
            p.nome AS procedimento,
            tp.descricao AS tipo_pagamento,
            a.numero_parcelas,
            a.valor_total,
            (a.valor_total / a.numero_parcelas) AS valor_parcela
        FROM atendimentos a
        LEFT JOIN clientes c ON c.id = a.cliente_id
        LEFT JOIN dependentes d ON d.id = a.dependente_id
        JOIN procedimentos p ON a.procedimento_id = p.id
        JOIN tipo_pagamento tp ON a.tipo_pagamento_id = tp.id
        WHERE 1=1";

if (!empty($cliente)) {
    $sql .= " AND c.nome LIKE '%$cliente%'";
}

if (!empty($dependente)) {
    $sql .= " AND d.nome LIKE '%$dependente%'";
}

if (!empty($data_inicio) && !empty($data_fim)) {
    $sql .= " AND a.data_atendimento BETWEEN '$data_inicio' AND '$data_fim'";
}

if (!empty($procedimentos)) {
    $procedimentos = implode("','", $procedimentos);
    $sql .= " AND p.nome IN ('$procedimentos')";
}

if (!empty($tipos_pagamento)) {
    $tipos_pagamento = implode(",", $tipos_pagamento);
    $sql .= " AND tp.id IN ($tipos_pagamento)";
}

$sql .= " ORDER BY a.data_atendimento, a.hora_atendimento";

$result = $conn->query($sql);

// Inicia a geração do relatório em HTML
$html = '<table>';
$html .= '<tr><th>ID</th><th>Cliente</th><th>Dependente</th><th>Data Atendimento</th><th>Hora Atendimento</th><th>Procedimento</th><th>Tipo Pagamento</th><th>Número de Parcelas</th><th>Valor Parcela</th><th>Valor Total</th></tr>';

$total = 0;

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $html .= '<tr>';
        $html .= '<td>' . $row['id'] . '</td>';
        $html .= '<td>' . $row['cliente'] . '</td>';
        $html .= '<td>' . $row['dependente'] . '</td>';
        $html .= '<td>' . date('d/m/y', strtotime($row['data_atendimento'])) . '</td>';
        $html .= '<td>' . $row['hora_atendimento'] . '</td>';
        $html .= '<td>' . $row['procedimento'] . '</td>';
        $html .= '<td>' . $row['tipo_pagamento'] . '</td>';
        $html .= '<td>' . $row['numero_parcelas'] . '</td>';
        $html .= '<td>' . number_format($row['valor_parcela'], 2, ',', '.') . '</td>';
        $html .= '<td>' . number_format($row['valor_total'], 2, ',', '.') . '</td>';
        $html .= '</tr>';
        $total += $row['valor_total'];
    }
    $html .= '<tr class="total"><td colspan="9">Total</td><td>' . number_format($total, 2, ',', '.') . '</td></tr>';
} else {
    $html .= '<tr><td colspan="10">Nenhum atendimento encontrado.</td></tr>';
}

$html .= '</table>';

$conn->close();

echo $html;
?>