<?php
session_start();
require_once "conexao.php"; // já usando MySQLi

// Pegando dados enviados
$usuario = $_POST['usuario'];
$senha = $_POST['senha'];

// Usando consulta preparada para segurança
$sql = $conn->prepare("SELECT * FROM usuarios WHERE login = ?");
$sql->bind_param("s", $usuario);
$sql->execute();
$result = $sql->get_result();
$user = $result->fetch_assoc();

// Se encontrou usuário
if($user){

    // Verifica se a senha salva é criptografada
    if(strlen($user['senha']) > 20){
        $senhaCorreta = password_verify($senha, $user['senha']);
    } else {
        // Senha salva sem criptografia
        $senhaCorreta = ($senha === $user['senha']);
    }

    if($senhaCorreta){

        $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['usuario_tipo'] = $user['tipo'];

        // Redirecionamento por tipo
        if($user['tipo'] === 'admin'){
            header("Location: ../admin/admin.php");
            exit;
        }

        header("Location: ../usuario/home.php");
        exit;

    } else {
        header("Location: ../login.php?erro=1");
        exit;
    }

} else {
    header("Location: ../login.php?erro=1");
    exit;
}

?>
