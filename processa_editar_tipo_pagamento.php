<?php include 'session_check.php'; ?>
<?php include 'topbar_menu.php'; ?>
<html>
<Body>
<p>
<p>
  
        <div class="container">
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new mysqli("localhost", "root", "", "aa_04_krcrm");
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $descricao = isset($_POST['descricao']) ? $conn->real_escape_string($_POST['descricao']) : '';

    if ($id > 0 && !empty($descricao)) {
        $sql = "UPDATE tipo_pagamento SET descricao='$descricao' WHERE id='$id'";

        if ($conn->query($sql) === TRUE) {

		   echo "Tipo de pagamento atualizado com sucesso.";
        } else {
            echo "Erro ao atualizar tipo de pagamento: " . $conn->error;
        }
    } else {
        echo "ID ou descrição inválidos.";
    }

    $conn->close();
}
?>
<br>
<button onclick="window.location.href='tipos_pagamento.php'">Voltar</button>
</div>
</div>
</body>
</html>