<?php include 'session_check.php'; ?>
<?php
include 'topbar_menu.php';

?>
<html>
<head>
    <title>Dashboard</title>
 
    

</head>
<body>

    <div class="overlay"></div>
    

    <div class="content">
        <?php
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            include $page;
        } else {
            echo '<h2></h2>';
        }
        ?>
    </div>
</body>
<!-- topbar end -->
<!-- style start -->
<!DOCTYPE html>
    <title>Editar Atendimento</title>
    
    

</head>
<body>

    

    <div class="content">
        <div class="form-container">
            <div class="container">
                <h1>Editar Atendimento</h1>
                <?php
                $conn = new mysqli("localhost", "root", "", "aa_04_krcrm");
                if ($conn->connect_error) {
                    die("Conexão falhou: " . $conn->connect_error);
                }

                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $sql = "SELECT * FROM atendimentos WHERE id = $id";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo "<form action='alterar_atendimento.php' method='post'>";
                        echo "<input type='hidden' name='id' value='" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "'>";
                        echo "<label for='cliente_id'>Cliente:</label>";
                        echo "<select name='cliente_id' required>";
                        $clientes_sql = "SELECT id, nome FROM clientes";
                        $clientes_result = $conn->query($clientes_sql);
                        if ($clientes_result->num_rows > 0) {
                            while ($cliente_row = $clientes_result->fetch_assoc()) {
                                $selected = $cliente_row['id'] == $row['cliente_id'] ? 'selected' : '';
                                echo "<option value='" . htmlspecialchars($cliente_row['id'], ENT_QUOTES, 'UTF-8') . "' $selected>" . htmlspecialchars($cliente_row['nome'], ENT_QUOTES, 'UTF-8') . "</option>";
                            }
                        }
                        echo "</select><br>";
                        echo "<label for='procedimento_id'>Procedimento:</label>";
                        echo "<select name='procedimento_id' required>";
                        $procedimentos_sql = "SELECT id, nome FROM procedimentos";
                        $procedimentos_result = $conn->query($procedimentos_sql);
                        if ($procedimentos_result->num_rows > 0) {
                            while ($procedimento_row = $procedimentos_result->fetch_assoc()) {
                                $selected = $procedimento_row['id'] == $row['procedimento_id'] ? 'selected' : '';
                                echo "<option value='" . htmlspecialchars($procedimento_row['id'], ENT_QUOTES, 'UTF-8') . "' $selected>" . htmlspecialchars($procedimento_row['nome'], ENT_QUOTES, 'UTF-8') . "</option>";
                            }
                        }
                        echo "</select><br>";
                        echo "<label for='data_atendimento'>Data do Atendimento:</label>";
                        echo "<input type='date' name='data_atendimento' value='" . htmlspecialchars(date('Y-m-d', strtotime($row['data_atendimento'])), ENT_QUOTES, 'UTF-8') . "' required><br>";
                        echo "<label for='hora_atendimento'>Hora do Atendimento:</label>";
                        echo "<input type='time' name='hora_atendimento' value='" . htmlspecialchars($row['hora_atendimento'], ENT_QUOTES, 'UTF-8') . "' required><br>";
                        echo "<label for='valor_total'>Valor Total:</label>";
                        echo "<input type='number' name='valor_total' value='" . htmlspecialchars($row['valor_total'], ENT_QUOTES, 'UTF-8') . "' step='0.01' required><br>";
                        echo "<label for='tipo_pagamento_id'>Tipo de Pagamento:</label>";
                        echo "<select name='tipo_pagamento_id' required>";
                        $tipo_pagamento_sql = "SELECT id, descricao FROM tipo_pagamento";
                        $tipo_pagamento_result = $conn->query($tipo_pagamento_sql);
                        if ($tipo_pagamento_result->num_rows > 0) {
                            while ($tipo_pagamento_row = $tipo_pagamento_result->fetch_assoc()) {
                                $selected = $tipo_pagamento_row['id'] == $row['tipo_pagamento_id'] ? 'selected' : '';
                                echo "<option value='" . htmlspecialchars($tipo_pagamento_row['id'], ENT_QUOTES, 'UTF-8') . "' $selected>" . htmlspecialchars($tipo_pagamento_row['descricao'], ENT_QUOTES, 'UTF-8') . "</option>";
                            }
                        }
                        echo "</select><br>";
                        echo "<label for='numero_parcelas'>Número de Parcelas:</label>";
                        echo "<input type='number' name='numero_parcelas' value='" . htmlspecialchars($row['numero_parcelas'], ENT_QUOTES, 'UTF-8') . "' min='1' required><br>";
                        echo "<input type='submit' value='Salvar'>";
                        echo "</form>";
                    } else {
                        echo "Atendimento não encontrado.";
                    }
                } else {
                    echo "ID do atendimento não fornecido.";
                }

                $conn->close();
                ?>
                <button class="voltar" onclick="window.location.href='atendimentos.php'">Voltar</button>
            </div>
        </div>
    </div>
</body>
</html>