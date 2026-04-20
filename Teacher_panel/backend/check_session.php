<?php
session_start();
header('Content-Type: application/json');

if (isset($_SESSION['teacher_id'])) {
    echo json_encode([
        "status" => "success",
        "teacher_id" => $_SESSION['teacher_id'],
        "teacher_name" => $_SESSION['teacher_name']
    ]);
} else {
    echo json_encode(["status" => "error", "message" => "Teacher not logged in"]);
}
?>
