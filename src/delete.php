<?php
require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    exit('Method not allowed.');
}

session_start();
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$token = $_POST['csrf_token'] ?? '';
if (!$id || $id < 1 || empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
    http_response_code(400);
    exit('Invalid deletion request.');
}

$stmt = mysqli_prepare($conn, 'DELETE FROM students WHERE id = ?');
if (!$stmt) {
    http_response_code(500);
    exit('Unable to prepare delete request.');
}
mysqli_stmt_bind_param($stmt, 'i', $id);
if (!mysqli_stmt_execute($stmt)) {
    http_response_code(500);
    exit('Unable to delete student.');
}
mysqli_stmt_close($stmt);
header('Location: index.php?deleted=1');
exit;
