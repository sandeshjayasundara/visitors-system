<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include("../includes/db.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM visitors WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: dashboard.php?msg=deleted");
        exit();
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
} else {
    header("Location: dashboard.php");
    exit();
}
?>
