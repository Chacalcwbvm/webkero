<?php include 'session_check.php'; ?>
<?php include 'topbar_menu.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Editar Forma Pagamento</title>
    

</head>
<body>

    
    </div>
    <div class="form-container">
        <div class="container">
            <h1>Editar Tipo de Pagamento</h1>
            <?php
            if (isset($_GET['id'])) {
                $conn = new mysqli("localhost", "root", "", "aa_04_krcrm");
                if ($conn->connect_error) {
                    die("Conexão falhou: " . $conn->connect_error);
                }

                $tipo_pagamento_id = intval($_GET['id']);
                $sql = "SELECT * FROM tipo_pagamento WHERE id='$tipo_pagamento_id'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    ?>
                    <form action="processa_editar_tipo_pagamento.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <label for="descricao">Descrição:</label>
                        <input type="text" id="descricao" name="descricao" value="<?php echo htmlspecialchars($row['descricao'], ENT_QUOTES, 'UTF-8'); ?>" required><br><br>
                        <input type="submit" value="Salvar">
                    </form>
                    <?php
                } else {
                    echo "Tipo de pagamento não encontrado.";
                }
                $conn->close();
            } else {
                echo "ID do tipo de pagamento não fornecido.";
            }
            ?>
            <br>
            <button class="voltar" onclick="window.location.href='tipos_pagamento.php'">Voltar</button>
        </div>
    </div>
</body>
</html>