<?php include 'session_check.php'; ?>
<?php
include 'topbar_menu.php';

?>
<!DOCTYPE html>
<html>
<head>
    <title>Editar Procedimento</title>
    

</head>
<body>

    
    <div class="form-container">
        <div class="container">
            <h1>Editar Procedimento</h1>
            <?php
            if (isset($_GET['id'])) {
                $conn = new mysqli("localhost", "root", "", "aa_04_krcrm");
                if ($conn->connect_error) {
                    die("Conexão falhou: " . $conn->connect_error);
                }

                $procedimento_id = intval($_GET['id']);
                $sql = "SELECT * FROM procedimentos WHERE id='$procedimento_id'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    ?>
                    <form action="processa_editar_procedimento.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <label for="nome">Nome:</label>
                        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($row['nome'], ENT_QUOTES, 'UTF-8'); ?>" required><br><br>

                        <input type="submit" value="Salvar">
                    </form>
                    <?php
                } else {
                    echo "Procedimento não encontrado.";
                }
                $conn->close();
            } else {
                echo "ID do procedimento não fornecido.";
            }
            ?>
            <br>
            <button class="voltar" onclick="window.location.href='procedimentos.php'">Voltar</button>
        </div>
    </div>
</body>
</html>