<?php include 'session_check.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Fluxo de Caixa</title>
    

</head>
<body>

    <div class="topbar">
        <h1>Relatório de Fluxo de Caixa</h1>
        <nav>
            <ul>
                <li><a href="form_atendimentos.php">Formulário de Atendimentos</a></li>
                <li><a href="relatorio_fluxo_caixa.php">Relatório de Fluxo de Caixa</a></li>
                <!-- Adicione outros links de navegação conforme necessário -->
            </ul>
        </nav>
    </div>
    <div class="content">
        <h2>Filtrar Relatório</h2>
        <form id="filtroForm">
            <label for="tipo_atendimento">Tipo de Atendimento:</label>
            <select name="tipo_atendimento" id="tipo_atendimento">
                <option value="">Selecione um Tipo de Atendimento</option>
            </select>
            <label for="cliente">Cliente:</label>
            <select name="cliente" id="cliente">
                <option value="">Selecione um Cliente</option>
            </select>
            <label for="dependente">Dependente:</label>
            <select name="dependente" id="dependente">
                <option value="">Selecione um Dependente</option>
            </select>
            <label for="data_inicio">Data Início:</label>
            <input type="date" name="data_inicio" id="data_inicio">
            <label for="data_fim">Data Fim:</label>
            <input type="date" name="data_fim" id="data_fim">
            <div class="radio-group">
                <span>Tipo de Relatório:</span>
                <label><input type="radio" name="relatorio_tipo" value="analitico" checked> Relatório Analítico</label>
                <label><input type="radio" name="relatorio_tipo" value="fluxo"> Relatório de Fluxo</label>
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
    <script src="relatorio_fluxo_caixa.js"></script>
</body>
</html>