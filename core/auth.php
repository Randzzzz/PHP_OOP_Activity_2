<?php
function require_login($role = null) {
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login.php");
        exit();
    }
    if ($role && (!isset($_SESSION['role']) || $_SESSION['role'] !== $role)) {
        if ($_SESSION['role'] === 'admin') {
            header("Location: ../admin/index.php");
        } else {
            header("Location: ../student/index.php");
        }
        exit();
    }
}
?>