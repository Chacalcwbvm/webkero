<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Cliente</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
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
                },
                error: function(xhr, status, error) {
                    console.error("Erro ao carregar cidades: " + error);
                }
            });
        });
    });
    </script>
</head>
<body>
    <?php include 'topbar_menu.php'; ?>

    <div class="content">
        <div class="form-container">
            <div class="container">
                <h1>Cadastro de Cliente</h1>
                <form action="cadastrar_cliente.php" method="post">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" id="nome" required><br>

                    <label for="data_nascimento">Data de Nascimento:</label>
                    <input type="date" name="data_nascimento" id="data_nascimento" required><br>

                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" required><br>

                    <label for="telefone">Telefone:</label>
                    <input type="text" name="telefone" id="telefone" required><br>

                    <label for="pais">País:</label>
                    <input type="text" name="pais" id="pais" required><br>

                    <label for="estado">Estado:</label>
                    <select name="estado" id="estado" required>
                        <option value="">Selecione um Estado</option>
                        <?php
                        $conn = new mysqli("localhost", "root", "", "aa_04_krcrm");
                        if ($conn->connect_error) {
                            die("Conexão falhou: " . $conn->connect_error);
                        }
                        $sql = "SELECT id, enome FROM estados";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['id'] . "'>" . $row['enome'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>Nenhum estado encontrado</option>";
                        }
                        $conn->close();
                        ?>
                    </select><br>

                    <label for="cidade">Cidade:</label>
                    <select name="cidade" id="cidade" required>
                        <option value="">Selecione um Estado primeiro</option>
                    </select><br>

                    <input type="submit" value="Cadastrar Cliente">
                </form>
            </div>
        </div>
    </div>
</body>
</html>