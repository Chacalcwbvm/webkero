<?php
include 'session_check.php';
$conn = new mysqli("localhost", "root", "", "aa_04_krcrm");
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Atendimento</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <?php include 'topbar_menu.php'; ?>

    <div class="content">
        <div class="form-container">
            <div class="container">
                <h1>Cadastrar Atendimento</h1>
                <form action="processar_atendimento.php" method="post" id="atendimentoForm">
                    <label for="tipo_atendimento">Tipo de Atendimento:</label>
                    <select name="tipo_atendimento" id="tipo_atendimento" required>
                        <option value="">Selecione</option>
                        <option value="cliente">Cliente</option>
                        <option value="dependente">Dependente</option>
                    </select><br>

                    <label for="cliente_id">Cliente:</label>
                    <select name="cliente_id" id="cliente_id" required>
                        <option value="">Selecione um Cliente</option>
                        <?php
                        $sql = "SELECT id, nome FROM clientes";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['id'] . "'>" . $row['nome'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>Nenhum cliente encontrado</option>";
                        }
                        ?>
                    </select><br>

                    <label for="dependente_id" id="dependente_label" style="display: none;">Dependente:</label>
                    <select name="dependente_id" id="dependente_id" style="display: none;">
                        <option value="">Selecione um Dependente</option>
                    </select><br>

                    <label for="data_atendimento">Data de Atendimento:</label>
                    <input type="date" name="data_atendimento" id="data_atendimento" required><br>

                    <label for="hora_atendimento">Hora de Atendimento:</label>
                    <input type="time" name="hora_atendimento" id="hora_atendimento" required><br>

                    <label for="procedimento_id">Procedimento:</label>
                    <select name="procedimento_id" id="procedimento_id" required>
                        <option value="">Selecione um Procedimento</option>
                        <?php
                        $sql = "SELECT id, nome FROM procedimentos";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['id'] . "'>" . $row['nome'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>Nenhum procedimento encontrado</option>";
                        }
                        ?>
                    </select><br>

                    <label for="tipo_pagamento_id">Tipo de Pagamento:</label>
                    <select name="tipo_pagamento_id" id="tipo_pagamento_id" required>
                        <option value="">Selecione um Tipo de Pagamento</option>
                        <?php
                        $sql = "SELECT id, descricao FROM tipo_pagamento";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['id'] . "'>" . $row['descricao'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>Nenhum tipo de pagamento encontrado</option>";
                        }
                        ?>
                    </select><br>

                    <label for="numero_parcelas">Número de Parcelas:</label>
                    <input type="number" name="numero_parcelas" id="numero_parcelas" value="1" min="1" required><br>

                    <label for="valor_total">Valor Total:</label>
                    <input type="number" name="valor_total" id="valor_total" step="0.01" required><br>

                    <input type="submit" value="Registrar Atendimento">
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#tipo_atendimento').change(function() {
            var tipo = $(this).val();
            if (tipo === 'dependente') {
                $('#dependente_label').show();
                $('#dependente_id').show();
                $('#cliente_id').change();
            } else {
                $('#dependente_label').hide();
                $('#dependente_id').hide();
            }
        });

        $('#cliente_id').change(function() {
            if ($('#tipo_atendimento').val() === 'dependente') {
                var cliente_id = $(this).val();
                $.ajax({
                    url: 'get_dependentes.php',
                    type: 'GET',
                    data: { cliente_id: cliente_id },
                    success: function(data) {
                        $('#dependente_id').html(data);
                    }
                });
            }
        });
    });
    </script>
</body>
</html>