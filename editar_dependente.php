<?php include 'session_check.php'; ?>
<?php include 'topbar_menu.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Editar Dependente</title>
    
    

</head>
<body>

    
    <div class="main-content">
        <div class="container">
            <h1>Editar Dependente</h1>
            <a href="dependentes.php" class="voltar">Voltar</a><br><br>
            <?php
            $conn = new mysqli("localhost", "root", "", "aa_04_krcrm");
            if ($conn->connect_error) {
                die("Conexão falhou: " . $conn->connect_error);
            }

            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $sql = "SELECT * FROM dependentes WHERE id = $id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo "<form action='processa_editar_dependente.php' method='post'>";
                    echo "<input type='hidden' name='id' value='" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "'>";
                    echo "<label for='nome'>Nome:</label>";
                    echo "<input type='text' name='nome' value='" . htmlspecialchars($row['nome'], ENT_QUOTES, 'UTF-8') . "' required><br>";
                    echo "<label for='data_nascimento'>Data de Nascimento:</label>";
                    echo "<input type='date' name='data_nascimento' value='" . htmlspecialchars(date('Y-m-d', strtotime($row['data_nascimento'])), ENT_QUOTES, 'UTF-8') . "' required><br>";
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
                    echo "<input type='submit' value='Salvar'>";
                    echo "</form>";
                } else {
                    echo "Dependente não encontrado.";
                }
            } else {
                echo "ID do dependente não fornecido.";
            }

            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>