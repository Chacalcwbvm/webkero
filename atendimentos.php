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
            <h1>Alterar Atendimento</h1>
            <input type="text" id="buscarAtendimento" placeholder="Buscar Atendimento..."><br><br>
            
            <table id="listaAtendimentos">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Dependente</th>
                        <th>Data Atendimento</th>
                        <th>Hora</th>
                        <th>Procedimento</th>
                        <th>Forma Pagamento</th>
                        <th>N. Parcelas</th>
                        <th>Valor Total</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $conn = new mysqli("localhost", "root", "", "aa_04_krcrm");
                    if ($conn->connect_error) {
                        die("Conexão falhou: " . $conn->connect_error);
                    }
                    $sql = "SELECT a.*, 
                                   c.nome AS cliente_nome, 
                                   d.nome AS dependente_nome, 
                                   p.nome AS procedimento_nome, 
                                   t.descricao AS tipo_pagamento_nome 
                            FROM atendimentos a 
                            LEFT JOIN clientes c ON a.cliente_id = c.id 
                            LEFT JOIN dependentes d ON a.dependente_id = d.id 
                            LEFT JOIN procedimentos p ON a.procedimento_id = p.id 
                            LEFT JOIN tipo_pagamento t ON a.tipo_pagamento_id = t.id";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["cliente_nome"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["dependente_nome"]) . "</td>";
                            echo "<td>" . htmlspecialchars(date('d/m/Y', strtotime($row["data_atendimento"]))) . "</td>";
                            echo "<td>" . htmlspecialchars($row["hora_atendimento"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["procedimento_nome"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["tipo_pagamento_nome"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["numero_parcelas"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["valor_total"]) . "</td>";
                            echo "<td><a href='editar_atendimento.php?id=" . urlencode($row["id"]) . "'>Editar</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10'>Nenhum atendimento encontrado</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
            <br>
            <a class="voltar" href="../new/topbar_menu.php">Voltar</a>
        </div>
    </div>
</body>
</html>