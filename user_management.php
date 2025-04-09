<?php include 'session_check.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Gerenciamento de Usuários</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        .form-container {
			margin-top: 150px;
		   background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            margin: auto;
        }
        .form-container h2 {
            margin-top:120px;
			margin-bottom: 20px;
        }
        .form-container input[type="text"],
        .form-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-container input[type="submit"],
        .form-container button {
            background-color: #6a0dad;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-container input[type="submit"]:hover,
        .form-container button:hover {
            background-color: #5a0bab;
        }
        .user-list {
            margin: 20px auto;
            width: 80%;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .user-list table {
            width: 100%;
            border-collapse: collapse;
        }
        .user-list table, th, td {
            border: 1px solid #ddd;
        }
        .user-list th, td {
            padding: 15px;
            text-align: left;
        }
        .user-list th {
            background-color: #6a0dad;
            color: white;
        }
        .user-list tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <?php include 'topbar_menu.php'; ?>

    <div class="form-container">
        <h2>Cadastrar Novo Usuário</h2>
        <form action="process_user.php?action=create" method="post">
            <input type="text" name="username" placeholder="Usuário" required><br>
            <input type="password" name="password" placeholder="Senha" required><br>
            <input type="submit" value="Cadastrar">
        </form>
    </div>

    <div class="user-list">
        <h2>Lista de Usuários</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuário</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $conn = new mysqli("localhost", "root", "", "aa_04_krcrm");
                if ($conn->connect_error) {
                    die("Conexão falhou: " . $conn->connect_error);
                }
                $sql = "SELECT id, username FROM users";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["username"] . "</td>";
                        echo "<td>
                                <a href='process_user.php?action=edit&id=" . $row["id"] . "'>Editar</a> | 
                                <a href='process_user.php?action=delete&id=" . $row["id"] . "'>Excluir</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Nenhum usuário encontrado</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>