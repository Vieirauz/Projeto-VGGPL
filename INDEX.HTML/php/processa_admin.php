<?php
include("conexao.php");

// Garante que veio por POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Verifica campos obrigatórios
    if (!isset($_POST['nome'], $_POST['login'], $_POST['senha'])) {
        echo "❌ Campos incompletos.";
        exit;
    }

    $nome = trim($_POST['nome']);
    $login = trim($_POST['login']);
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $tipo = "admin"; // define administrador

    // Prepara inserção
    $stmt = $conn->prepare(
        "INSERT INTO usuarios (nome, login, senha, tipo)
         VALUES (?, ?, ?, ?)"
    );

    $stmt->bind_param("ssss", $nome, $login, $senha, $tipo);

    if ($stmt->execute()) {
        echo "✅ Administrador cadastrado com sucesso!";
    } else {
        echo "❌ Erro ao cadastrar: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

} else {
    echo "❌ Requisição inválida.";
}
?>
