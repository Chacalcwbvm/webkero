
<?php
 include 'session_check.php'; 
include 'topbar_menu.php';

?>


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

<!-- topbar end -->

</head>
<!-- style end -->
<html>

    <div class="content">
        <div class="form-container">
            <div class="container">
                <h1>Manutenção de Cadastro de Clientes</h1>
                <a href="topbar_menu.php" class="voltar">Voltar</a><br><br>
                <input type="text" id="buscarCliente" placeholder="Buscar Cliente..."><br><br>
                <table id="listaClientes" border="1">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>País</th>
                            <th>Cidade</th>
                            <th>Estado</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <form>
                        <?php
                        $conn = new mysqli("localhost", "root", "", "aa_04_krcrm");
                        if ($conn->connect_error) {
                            die("Conexão falhou: " . $conn->connect_error);
                        }
                        $sql = "SELECT c.id, c.nome, c.email, c.telefone, c.pais, cid.cidade as cidade, est.enome as estados 
                                FROM clientes c 
                                LEFT JOIN cidade cid ON c.cidade = cid.id 
                                LEFT JOIN estados est ON cid.estado_id = est.id";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                // echo "<td>" . $row["id"] . "</td>"; // Ocultar a coluna ID
                                echo "<td>" . $row["nome"] . "</td>";
                                echo "<td>" . $row["email"] . "</td>";
                                echo "<td>" . $row["telefone"] . "</td>";
                                echo "<td>" . $row["pais"] . "</td>";
                                echo "<td>" . $row["cidade"] . "</td>";
                                echo "<td>" . $row["estados"] . "</td>";
                                echo "<td><a href='editar_cliente.php?id=" . $row["id"] . "'>Editar</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>Nenhum cliente encontrado</td></tr>";
                        }
                        $conn->close();
                        ?>
                    </form>
                </table>
            </div>
        </div>
    </div>
	</body>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#buscarCliente').on('input', function() {
            var search = $(this).val().toLowerCase();
            $('#listaClientes tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(search) > -1)
            });
        });
    });
    </script>
</body>
</html>