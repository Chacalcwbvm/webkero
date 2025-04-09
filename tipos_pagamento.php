<?php include 'session_check.php'; ?>
<?php include 'topbar_menu.php'; ?>
<!-- topbar start-->
<!DOCTYPE html>
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
<head>
    
    

</head>
<!-- style end -->
    <title>Edição de Tipos de Pagamento</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#buscarTipoPagamento').on('input', function() {
            var search = $(this).val().toLowerCase();
            $('#listaTipoPagamento tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(search) > -1)
            });
        });
    });
    </script>

<html>

   <h1>Editar Formas de Pagamento</h1>
    <input type="text" id="buscarTipoPagamento" placeholder="Buscar Tipo de Pagamento..."><br><br>
    
    <table id="listaTipoPagamento" border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Ação</th>
            </tr>
        </thead>
        <body>

            <?php
            $conn = new mysqli("localhost", "root", "", "aa_04_krcrm");
            if ($conn->connect_error) {
                die("Conexão falhou: " . $conn->connect_error);
            }
            $sql = "SELECT id, descricao FROM tipo_pagamento";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["descricao"] . "</td>";
                    echo "<td><a href='editar_tipo_pagamento.php?id=" . $row["id"] . "'>Editar</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>Nenhum tipo de pagamento encontrado</td></tr>";
            }
            $conn->close();
            ?>
        </body>
    </table>
    <br>
    <a href="../topbar_menu.php">Voltar</a>
</body>
</html>