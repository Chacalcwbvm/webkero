<?php include 'session_check.php'; ?>
<?php include 'topbar_menu.php'; ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Dependente</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        <?php if (isset($_GET['status']) && $_GET['status'] == 'success') { ?>
            alert("Novo dependente cadastrado com sucesso!");
            setTimeout(function() {
                window.location.href = 'cadastro_dependente.php';
            }, 5000);
        <?php } else if (isset($_GET['status']) && $_GET['status'] == 'error') { ?>
            alert("Erro ao cadastrar dependente. Por favor, tente novamente.");
        <?php } ?>
    });
    </script>
</head>
<body>
    <div class="content">
        <h1>Cadastro de Dependente</h1>
        <form action="processa_cadastro_dependente.php" method="post">
            <label for="cliente_id">Selecione o Cliente Titular:</label>
            <select id="cliente_id" name="cliente_id" required>
                <?php
                $conn = new mysqli("localhost", "root", "", "aa_04_krcrm");
                if ($conn->connect_error) {
                    die("Conexão falhou: " . $conn->connect_error);
                }
                $sql = "SELECT id, nome FROM clientes";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $selected = (isset($_POST['cliente_id']) && $_POST['cliente_id'] == $row["id"]) ? 'selected' : '';
                        echo "<option value='" . $row["id"] . "' $selected>" . $row["nome"] . "</option>";
                    }
                } else {
                    echo "<option value=''>Nenhum cliente encontrado</option>";
                }
                $conn->close();
                ?>
            </select><br><br>

            <label for="nome">Dependente:</label>
            <input type="text" id="nome" name="nome" required value="<?php echo isset($_POST['nome']) ? $_POST['nome'] : ''; ?>"><br><br>

            <label for="data_nascimento">Data de Nascimento:</label>
            <input type="date" id="data_nascimento" name="data_nascimento" required value="<?php echo isset($_POST['data_nascimento']) ? $_POST['data_nascimento'] : ''; ?>"><br><br>

           

            <input type="hidden" id="tipo" name="tipo" value="D">

            <input type="submit" value="Cadastrar">
            <button type="button" onclick="window.location.href='dashboard.php'">Voltar</button>
        </form>
    </div>
</body>
</html>