<?php include 'session_check.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <?php include 'topbar_menu.php'; ?>
<style>
    body {
            font-family: hgl;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            background-image: url('back.jpg');
            background-size: cover;
            background-attachment: fixed;
        }
		</style>
		
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
</html>