<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "portal_paginas";

// Criando conexão
$conn = new mysqli($servidor, $usuario, $senha, $banco);

// Verificando erro
if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados.");
}

// Força UTF-8 para evitar caracteres bugados
$conn->set_charset("utf8");
?>
