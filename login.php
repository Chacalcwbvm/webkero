<?php
session_start();

// Verifica se o usuário já está logado
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}

// Processa o login quando o formulário é enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Conexão com o banco de dados
    $conn = new mysqli("localhost", "root", "", "aa_04_krcrm");
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Verificação das credenciais do usuário no banco de dados
    $sql = "SELECT id, username FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $username);
        $stmt->fetch();
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;
        header('Location: dashboard.php');
        exit();
    } else {
        $error = "Usuário ou senha incorretos.";
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        body {
            font-family: Helvetica, sans-serif;
			font-color: black;
            background-image: url('back2.jpg');
            background-image: cover;
			 background-attachment: cofixed;
			image: url('logo.png');
			image-align:center;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        
		
		.login-limtar{
			inline-size: 40px;
		}
		
		
		
		.login-container {
        	background-color: rgba(255, 255, 255, 0.2);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 430px;
            text-align: center;
        }
        .login-container h2 {
			margin-top: 20px;
			margin-bottom: 20px;
        }
        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 60%;
            padding: 10px;
            margin: 10px 0;
            border: 2px solid #ddd;
            border-radius: 5px;
			align: left;
        }
        .login-container input[type="submit"] {
            background-color: #6a0dad;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .login-container input[type="submit"]:hover {
            background-color: #5a0bab;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
		.overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: -999;
    
		}
    </style>
</head>
<body>

<div class="content">
	 <div class="content">
	
	 
	 </div>
    <div class="login-container">
 <img src='logo.png' width="400px" hight="200px" />; 
 <h2>Login</h2>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="login.php" method="post">
            <input type="text" name="username" placeholder="Usuário" required><br>
            <input type="password" name="password" placeholder="Senha" required><br>
            <input type="submit" value="Login">
        </form>
    </div>
	</div>
</body>
</html>