<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "portal_paginas";  // coloque o nome do seu banco

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

$nome = $_POST['nome'];
$nascimento = $_POST['nascimento'];
$sexo = $_POST['sexo'];
$nomeMaterno = $_POST['nomeMaterno'];
$cpf = $_POST['cpf'];
$email = $_POST['email'];
$celular = $_POST['celular'];
$fixo = $_POST['fixo'];
$cep = $_POST['cep'];
$endereco = $_POST['endereco'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];
$login = $_POST['login'];
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios 
(nome, nascimento, sexo, nomeMaterno, cpf, email, celular, fixo, cep, endereco, cidade, estado, login, senha) 
VALUES 
('$nome', '$nascimento', '$sexo', '$nomeMaterno', '$cpf', '$email', '$celular', '$fixo', '$cep', '$endereco', '$cidade', '$estado', '$login', '$senha')";

if ($conn->query($sql) === TRUE) {
    echo "Cadastro realizado com sucesso!";
} else {
    echo "Erro: " . $conn->error;
}

$conn->close();
?>
