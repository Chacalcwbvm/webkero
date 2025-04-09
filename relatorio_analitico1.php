<?php include 'session_check.php'; ?>
<?php include 'topbar_menu.php';?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório Analítico</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="content">
        <h2>Filtrar Relatório</h2>
        <form id="filtroForm">
            <label for="procedimento_id">Procedimento:</label>
            <select name="procedimento_id" id="procedimento_id">
                <option value="">Selecione um Procedimento</option>
            </select>
            <label for="tipo_pagamento_id">Tipo de Pagamento:</label>
            <select name="tipo_pagamento_id" id="tipo_pagamento_id">
                <option value="">Selecione um Tipo de Pagamento</option>
            </select>
            <label for="cliente_dependente">Cliente/Dependente:</label>
            <select name="cliente_dependente" id="cliente_dependente">
                <option value="">Selecione um Cliente ou Dependente</option>
            </select>
            <label for="data_inicio">Data Início:</label>
            <input type="date" name="data_inicio" id="data_inicio">
            <label for="data_fim">Data Fim:</label>
            <input type="date" name="data_fim" id="data_fim">
            <div class="radio-group">
                <span>Tipo de Relatório:</span>
                <label><input type="radio" name="relatorio_tipo" value="diario" checked> Diário</label>
                <label><input type="radio" name="relatorio_tipo" value="semanal"> Semanal</label>
                <label><input type="radio" name="relatorio_tipo" value="mensal"> Mensal</label>
                <label><input type="radio" name="relatorio_tipo" value="anual"> Anual</label>
                <label><input type="radio" name="relatorio_tipo" value="geral"> Geral</label>
            </div>
            <div class="radio-group">
                <span>Detalhamento:</span>
                <label><input type="radio" name="detalhamento" value="resumido" checked> Resumido</label>
                <label><input type="radio" name="detalhamento" value="detalhado"> Detalhado</label>
            </div>
            <div class="buttons">
                <input type="submit" value="Gerar Relatório">
                <input type="button" value="Limpar" onclick="limparFiltros()">
            </div>
        </form>
        <div class="report" id="report">
            <!-- Relatório será gerado aqui -->
        </div>
        <div class="buttons">
            <button onclick="voltar()">Voltar</button>
            <button onclick="printReport()">Imprimir</button>
        </div>
    </div>
    <script src="rel_analitico1.js"></script>
</body>
</html>