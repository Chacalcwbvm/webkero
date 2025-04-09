<?php
include 'session_check.php'; 
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <?php include 'topbar_menu.php'; ?>

    <div class="content">
        <div class="form-container">
            <div class="container">
                <h1>Editar Cliente</h1>
                <a href="clientes.php" class="voltar">Voltar</a><br><br>
                <?php
                $conn = new mysqli("localhost", "root", "", "aa_04_krcrm");
                if ($conn->connect_error) {
                    die("Conexão falhou: " . $conn->connect_error);
                }

                if (isset($_POST['id'])) {
                    $id = $_POST['id'];
                    $nome = $_POST['nome'];
                    $email = $_POST['email'];
                    $telefone = $_POST['telefone'];
                    $pais = $_POST['pais'];
                    $cidade = $_POST['cidade'];
                    $estado = $_POST['estado'];
                    $data_nascimento = $_POST['data_nascimento'];

                    $sql_update = "UPDATE clientes SET nome=?, email=?, telefone=?, pais=?, cidade=?, estado=?, data_nascimento=? WHERE id=?";
                    $stmt = $conn->prepare($sql_update);
                    $stmt->bind_param("sssssssi", $nome, $email, $telefone, $pais, $cidade, $estado, $data_nascimento, $id);
                    if ($stmt->execute()) {
                        echo "Cliente atualizado com sucesso.";
                    } else {
                        echo "Erro ao atualizar cliente.";
                    }
                    $stmt->close();
                }

                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $sql = "SELECT * FROM clientes WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo "<form action='editar_cliente.php' method='post'>";
                        echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                        echo "<label for='nome'>Nome:</label>";
                        echo "<input type='text' name='nome' value='" . $row['nome'] . "' required><br>";
                        echo "<label for='email'>Email:</label>";
                        echo "<input type='email' name='email' value='" . $row['email'] . "' required><br>";
                        echo "<label for='telefone'>Telefone:</label>";
                        echo "<input type='text' name='telefone' value='" . $row['telefone'] . "' required><br>";
                        echo "<label for='pais'>País:</label>";
                        echo "<input type='text' name='pais' value='" . $row['pais'] . "' required><br>";
                        
                        // Fetch cities and states
                        echo "<label for='estado'>Estado:</label>";
                        echo "<select name='estado' id='estado' required>";
                        $estado_sql = "SELECT id, enome FROM estados";
                        $estado_result = $conn->query($estado_sql);
                        while ($estado_row = $estado_result->fetch_assoc()) {
                            $selected = ($estado_row['id'] == $row['estado']) ? 'selected' : '';
                            echo "<option value='" . $estado_row['id'] . "' $selected>" . $estado_row['enome'] . "</option>";
                        }
                        echo "</select><br>";

                        echo "<label for='cidade'>Cidade:</label>";
                        echo "<select name='cidade' id='cidade' required>";
                        $cidade_sql = "SELECT id, cidade FROM cidade WHERE estado_id = ?";
                        $cidade_stmt = $conn->prepare($cidade_sql);
                        $cidade_stmt->bind_param("i", $row['estado']);
                        $cidade_stmt->execute();
                        $cidade_result = $cidade_stmt->get_result();
                        while ($cidade_row = $cidade_result->fetch_assoc()) {
                            $selected = ($cidade_row['id'] == $row['cidade']) ? 'selected' : '';
                            echo "<option value='" . $cidade_row['id'] . "' $selected>" . $cidade_row['cidade'] . "</option>";
                        }
                        echo "</select><br>";

                        echo "<label for='data_nascimento'>Data de Nascimento:</label>";
                        echo "<input type='date' name='data_nascimento' value='" . date('Y-m-d', strtotime($row['data_nascimento'])) . "' required><br>";
                        echo "<input type='submit' value='Salvar'>";
                        echo "</form>";
                    } else {
                        echo "Cliente não encontrado.";
                    }
                    $stmt->close();
                } else {
                    echo "ID do cliente não fornecido.";
                }

                $conn->close();
                ?>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#estado').change(function() {
            var estado_id = $(this).val();
            $.ajax({
                url: 'get_cidades.php',
                type: 'GET',
                data: { estado_id: estado_id },
                success: function(data) {
                    $('#cidade').html(data);
                }
            });
        });
    });
    </script>
</body>
</html>