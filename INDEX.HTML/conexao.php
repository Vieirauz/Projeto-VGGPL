<?php
$servidor = "localhost";
$usuario   = "root";
$senha     = "";
$banco     = "portal_paginas";

// Conexão MySQLi
$conn = new mysqli($servidor, $usuario, $senha, $banco);

// Verifica erro de conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Define charset para evitar erros com acentos
$conn->set_charset("utf8");
?>
