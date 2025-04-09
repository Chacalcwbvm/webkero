<?php include 'session_check.php'; ?>
<?php
function log_action($conn, $user_id, $action, $table_name, $record_id, $description) {
    $stmt = $conn->prepare("INSERT INTO logs (user_id, action, table_name, record_id, description) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isssi", $user_id, $action, $table_name, $record_id, $description);
    $stmt->execute();
    $stmt->close();
}
?>