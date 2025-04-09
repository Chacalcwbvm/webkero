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

<html>

<!DOCTYPE html>
<html>
<head>
            <h1>Manutenção Cadastro de Dependentes</h1>
            <button class="add-button" onclick="window.location.href='cadastro_dependente.php'">Adicionar Dependente</button>
            <button class="voltar" onclick="window.location.href='topbar_menu.php'">Voltar</button>
            <br><br>
<body>           
		   <table>
                <thead>
                    <tr>
                        <!-- <th>ID</th> -->
                        <th>Dependente</th>
                        <th>Cliente</th>
                        <th>Data de Nascimento</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <form>
                    <?php
                    $conn = new mysqli("localhost", "root", "", "aa_04_krcrm");
                    if ($conn->connect_error) {
                        die("Conexão falhou: " . $conn->connect_error);
                    }

                    $sql = "SELECT d.id, d.nome, d.data_nascimento, c.nome AS cliente_nome 
                            FROM dependentes d 
                            LEFT JOIN clientes c ON d.cliente_id = c.id";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            // echo "<td>" . htmlspecialchars($row["id"], ENT_QUOTES, 'UTF-8') . "</td>"; // Ocultar a coluna ID
                            echo "<td>" . htmlspecialchars($row["nome"], ENT_QUOTES, 'UTF-8') . "</td>";
                            echo "<td>" . htmlspecialchars($row["cliente_nome"], ENT_QUOTES, 'UTF-8') . "</td>";
                            echo "<td>" . htmlspecialchars(date('d/m/Y', strtotime($row["data_nascimento"])), ENT_QUOTES, 'UTF-8') . "</td>";
                            echo "<td><a href='editar_dependente.php?id=" . urlencode($row["id"]) . "'>Editar</a> | <a href='excluir_dependente.php?id=" . urlencode($row["id"]) . "'>Excluir</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>Nenhum dependente encontrado.</td></tr>";
                    }
                    $conn->close();
                    ?>
                
            </form>
        </div>
    </div>
</body>
</html>