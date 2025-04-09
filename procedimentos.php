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
            <h1>Procedimentos</h1>
            <div class="button-container">
                <a class="voltar" href="menu.php">Voltar</a>
                <a class="novo" href="adicionar_procedimento.php">Novo</a>
            </div>
            <br>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $conn = new mysqli("localhost", "root", "", "aa_04_krcrm");
                    if ($conn->connect_error) {
                        die("Conexão falhou: " . $conn->connect_error);
                    }
                    $sql = "SELECT id, nome FROM procedimentos";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["nome"]) . "</td>";
                            echo "<td><a href='editar_procedimento.php?id=" . urlencode($row["id"]) . "'>Editar</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>Nenhum procedimento encontrado</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>