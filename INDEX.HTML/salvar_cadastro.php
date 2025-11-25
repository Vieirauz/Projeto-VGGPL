<?php
include("conexao.php");

// Garante que está recebendo via POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Campos obrigatórios
    $campos = [
        'nome','nascimento','sexo','nomeMaterno','cpf','email',
        'celular','fixo','cep','endereco','cidade','estado',
        'login','senha'
    ];

    foreach ($campos as $campo) {
        if (!isset($_POST[$campo]) || trim($_POST[$campo]) === '') {
            echo "❌ Campo '$campo' está vazio ou não foi enviado.";
            exit;
        }
    }

    // Captura os dados
    $nome = trim($_POST['nome']);
    $nascimento = trim($_POST['nascimento']);
    $sexo = trim($_POST['sexo']);
    $nomeMaterno = trim($_POST['nomeMaterno']);
    $cpf = trim($_POST['cpf']);
    $email = trim($_POST['email']);
    $celular = trim($_POST['celular']);
    $fixo = trim($_POST['fixo']);
    $cep = trim($_POST['cep']);
    $endereco = trim($_POST['endereco']);
    $cidade = trim($_POST['cidade']);
    $estado = trim($_POST['estado']);
    $login = trim($_POST['login']);

    // Criptografa a senha
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    // Define que esse cadastro é de usuário comum
    $tipo = "usuario";

    // Prepara a query
    $stmt = $conn->prepare("INSERT INTO usuarios 
        (nome, nascimento, sexo, nomeMaterno, cpf, email, celular, fixo, cep, endereco, cidade, estado, login, senha, tipo)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "sssssssssssssss",
        $nome, $nascimento, $sexo, $nomeMaterno, $cpf, $email,
        $celular, $fixo, $cep, $endereco, $cidade, $estado, $login, $senha, $tipo
    );

    if ($stmt->execute()) {
        echo "✅ Cadastro realizado com sucesso!";
    } else {
        echo "❌ Erro ao cadastrar: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

} else {
    echo "❌ Requisição inválida.";
}
?>
