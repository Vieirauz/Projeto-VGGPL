<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['tipo'] != 'admin') {
    header("Location: login.php");
    exit;
}
?>
