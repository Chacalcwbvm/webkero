<?php include 'session_check.php'; ?>
<?php include 'topbar_menu.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Adicionar Procedimento</title>
    

</head>
<body>

    <
    <div class="form-container">
        <div class="container">
            <h1>Adicionar Procedimento</h1>
            <form action="processa_adicionar_procedimento.php" method="post">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required><br><br>
                <input type="submit" value="Salvar">
            </form>
            <br>
            <a class="voltar" href="procedimentos.php">Voltar</a>
        </div>
    </div>
</body>
</html>