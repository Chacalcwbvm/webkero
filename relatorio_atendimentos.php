<?php include 'session_check.php'; ?>
<?php include 'topbar_menu.php';?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Atendimentos</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="content">
        <div class="container">
            <h2>Relatório de Atendimentos</h2>
            <form id="filtroForm">
                <label for="cliente">Cliente:</label>
                <select name="cliente" id="cliente">
                    <option value="">Selecione um Cliente</option>
                    <?php
                    // Conexão com o banco de dados
                    $conn = new mysqli("localhost", "root", "", "aa_04_krcrm");
                    if ($conn->connect_error) {
                        die("Conexão falhou: " . $conn->connect_error);
                    }

                    // Carregar clientes
                    $sql_clientes = "SELECT id, nome FROM clientes";
                    $result_clientes = $conn->query($sql_clientes);
                    if ($result_clientes->num_rows > 0) {
                        while($row = $result_clientes->fetch_assoc()) {
                            echo "<option value='" . $row["id"] . "'>" . $row["nome"] . "</option>";
                        }
                    }
                    ?>
                </select>
                <label for="dependente">Dependente:</label>
                <select name="dependente" id="dependente">
                    <option value="">Selecione um Dependente</option>
                    <?php
                    // Carregar dependentes
                    $sql_dependentes = "SELECT id, nome FROM dependentes";
                    $result_dependentes = $conn->query($sql_dependentes);
                    if ($result_dependentes->num_rows > 0) {
                        while($row = $result_dependentes->fetch_assoc()) {
                            echo "<option value='" . $row["id"] . "'>" . $row["nome"] . "</option>";
                        }
                    }
                    ?>
                </select>
                <label for="data_inicio">Data Início:</label>
                <input type="date" name="data_inicio" id="data_inicio">
                <label for="data_fim">Data Fim:</label>
                <input type="date" name="data_fim" id="data_fim">
                <div class="checkbox-group" id="procedimentos">
                    <span>Procedimentos:</span>
                    <?php
                    // Carregar procedimentos
                    $sql_procedimentos = "SELECT id, nome FROM procedimentos";
                    $result_procedimentos = $conn->query($sql_procedimentos);
                    if ($result_procedimentos->num_rows > 0) {
                        while($row = $result_procedimentos->fetch_assoc()) {
                            echo "<label><input type='checkbox' name='procedimentos[]' value='" . $row["id"] . "'> " . $row["nome"] . "</label><br>";
                        }
                    }
                    ?>
                </div>
                <div class="checkbox-group" id="tipo_pagamento">
                    <span>Forma de Pagamento:</span>
                    <?php
                    // Carregar formas de pagamento
                    $sql_pagamentos = "SELECT id, descricao FROM tipo_pagamento";
                    $result_pagamentos = $conn->query($sql_pagamentos);
                    if ($result_pagamentos->num_rows > 0) {
                        while($row = $result_pagamentos->fetch_assoc()) {
                            echo "<label><input type='checkbox' name='tipo_pagamento[]' value='" . $row["id"] . "'> " . $row["descricao"] . "</label><br>";
                        }
                    }
                    ?>
                </div>
                <div class="radio-group">
                    <span>Tipo de Relatório:</span>
                    <label><input type="radio" name="relatorio_tipo" value="diario" checked> Diário</label>
                    <label><input type="radio" name="relatorio_tipo" value="semanal"> Semanal</label>
                    <label><input type="radio" name="relatorio_tipo" value="mensal"> Mensal</label>
                    <label><input type="radio" name="relatorio_tipo" value="anual"> Anual</label>
                    <label><input type="radio" name="relatorio_tipo" value="resumo"> Resumo</label>
                </div>
                <div class="buttons">
                    <input type="submit" value="Filtrar">
                    <input type="button" value="Limpar" onclick="limparFiltros()">
                </div>
            </form>
            <div class="progress">
                <div class="progress-bar" id="progress-bar" style="width: 0%;"></div>
            </div>
            <div class="report" id="report">
                <!-- Relatório será gerado aqui -->
            </div>
            <div class="buttons">
                <button onclick="voltar()">Voltar</button>
                <button onclick="printReport()">Imprimir</button>
            </div>
        </div>
    </div>
    <script src="relatorio_atendimentos.js"></script>
</body>
</html>