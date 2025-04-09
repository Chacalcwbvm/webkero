<?php include 'session_check.php'; ?>
<?php
session_start();
session_unset();
session_destroy();
header("Location: login.php");
exit();
?>