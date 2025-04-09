<?php
session_start();
$conn = new mysqli("localhost", "root", "", "aa_04_krcrm");
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$action = $_GET['action'];

if ($action == 'create') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->close();
    header('Location: user_management.php');
    exit();
}

if ($action == 'edit') {
    $id = $_GET['id'];
    $sql = "SELECT id, username FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($id, $username);
    $stmt->fetch();
    $stmt->close();
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Editar Usuário</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <style>
            .form-container {
                background-color: rgba(255, 255, 255, 0.8);
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
                width: 400px;
                margin: auto;
            }
            .form-container h2 {
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
        </style>
    </head>
    <body>
        <div class="form-container">
            <h2>Editar Usuário</h2>
            <form action="process_user.php?action=update&id=<?php echo $id; ?>" method="post">
                <input type="text" name="username" placeholder="Usuário" value="<?php echo $username; ?>" required><br>
                <input type="password" name="password" placeholder="Senha" required><br>
                <input type="submit" value="Atualizar">
            </form>
        </div>
    </body>
    </html>
    <?php
    exit();
}

if ($action == 'update') {
    $id = $_GET['id'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "UPDATE users SET username = ?, password = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $username, $password, $id);
    $stmt->execute();
    $stmt->close();
    header('Location: user_management.php');
    exit();
}

if ($action == 'delete') {
    $id = $_GET['id'];

    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header('Location: user_management.php');
    exit();
}

$conn->close();
?>