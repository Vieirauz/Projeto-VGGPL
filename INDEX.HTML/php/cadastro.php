<?php
require_once "conexao.php"; // usa o arquivo PDO seguro

// Verifica se veio via POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Acesso inválido.");
}

// Recebe os dados com segurança
$nome         = $_POST['nome'] ?? null;
$nascimento   = $_POST['nascimento'] ?? null;
$sexo         = $_POST['sexo'] ?? null;
$nomeMaterno  = $_POST['nomeMaterno'] ?? null;
$cpf          = $_POST['cpf'] ?? null;
$email        = $_POST['email'] ?? null;
$celular      = $_POST['celular'] ?? null;
$fixo         = $_POST['fixo'] ?? null;
$cep          = $_POST['cep'] ?? null;
$endereco     = $_POST['endereco'] ?? null;
$cidade       = $_POST['cidade'] ?? null;
$estado       = $_POST['estado'] ?? null;
$login        = $_POST['login'] ?? null;
$senha        = password_hash($_POST['senha'], PASSWORD_DEFAULT);

// Query segura (prepared statement)
$sql = "INSERT INTO usuarios 
(nome, nascimento, sexo, nomeMaterno, cpf, email, celular, fixo, cep, endereco, cidade, estado, login, senha) 
VALUES 
(:nome, :nascimento, :sexo, :nomeMaterno, :cpf, :email, :celular, :fixo, :cep, :endereco, :cidade, :estado, :login, :senha)";

try {
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':nascimento', $nascimento);
    $stmt->bindParam(':sexo', $sexo);
    $stmt->bindParam(':nomeMaterno', $nomeMaterno);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':celular', $celular);
    $stmt->bindParam(':fixo', $fixo);
    $stmt->bindParam(':cep', $cep);
    $stmt->bindParam(':endereco', $endereco);
    $stmt->bindParam(':cidade', $cidade);
    $stmt->bindParam(':estado', $estado);
    $stmt->bindParam(':login', $login);
    $stmt->bindParam(':senha', $senha);

    $stmt->execute();

    echo "Cadastro realizado com sucesso!";

} catch (PDOException $e) {
    // Mensagem genérica para o usuário (não vaza info do servidor)
    echo "Erro ao cadastrar usuário.";

    // Para depuração (descomente apenas durante o desenvolvimento)
    // echo "Erro: " . $e->getMessage();
}
?>
