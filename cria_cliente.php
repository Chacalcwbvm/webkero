<?php include 'session_check.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Cadastro de Cliente</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <?php include 'topbar_menu.php'; ?>

    <div class="content">
        <h1>Cadastro de Cliente</h1>

        <?php
        // Conexão com o banco de dados
        $conn = new mysqli("localhost", "root", "", "aa_04_krcrm");
        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        }

        // Inicialização das variáveis estado e cidade
        $estadoId = isset($_POST['estado']) ? $_POST['estado'] : '';
        $cidadeId = isset($_POST['cidade']) ? $_POST['cidade'] : '';

        // Carregar estados
        $sql_estado = "SELECT id, enome FROM estados";
        $result_estado = $conn->query($sql_estado);

        // Carregar cidades se um estado foi selecionado
        if ($estadoId) {
            $sql_cidade = "SELECT id, cidade FROM cidade WHERE estado_id = $estadoId";
            $result_cidade = $conn->query($sql_cidade);
        }
        ?>

        <!-- Formulário de seleção de estado -->
        <form action="cria_cliente.php" method="post">
            <div class="form-group">
                <label for="estado">Estado:</label>
                <select id="estado" name="estado" required onchange="this.form.submit()">
                    <option value="">Selecione um estado</option>
                    <?php
                    if ($result_estado->num_rows > 0) {
                        while($row = $result_estado->fetch_assoc()) {
                            $selected = ($estadoId == $row["id"]) ? 'selected' : '';
                            echo "<option value='" . $row["id"] . "' $selected>" . $row["enome"] . "</option>";
                        }
                    } else {
                        echo "<option value=''>Nenhum estado encontrado</option>";
                    }
                    ?>
                </select>
            </div>
        </form>

        <!-- Formulário de cadastro de cliente -->
        <form action="processa_cliente.php" method="post">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="data_nascimento">Data de Nascimento:</label>
                <input type="date" id="data_nascimento" name="data_nascimento" required>
            </div>
            <div class="form-group">
                <label for="telefone">Telefone:</label>
                <input type="text" id="telefone" name="telefone">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email"><p>
            </div>
            <div class="form-group">
                <label for="pais">País:</label>
                <input type="text" id="pais" name="pais">
            </div>
            <div class="form-group">
                <label for="cidade">Cidade:</label>
                <select id="cidade" name="cidade" required>
                    <option value="">Selecione uma cidade</option>
                    <?php
                    if (isset($result_cidade) && $result_cidade->num_rows > 0) {
                        while($row = $result_cidade->fetch_assoc()) {
                            $selected = ($cidadeId == $row["id"]) ? 'selected' : '';
                            echo "<option value='" . $row["id"] . "' $selected>" . $row["cidade"] . "</option>";
                        }
                    } else {
                        echo "<option value=''>Nenhuma cidade encontrada</option>";
                    }
                    ?>
                </select>
            </div>
            <input type="hidden" id="tipo" name="tipo" value="C">
            <input type="hidden" id="estado" name="estado" value="<?php echo $estadoId; ?>">
            <div class="button-group">
                <input type="submit" value="Cadastrar">
                <button type="button" onclick="window.location.href='topbar_menu.php'">Voltar</button>
            </div>
        </form>

        <?php $conn->close(); ?>
    </div>
</body>
</html>