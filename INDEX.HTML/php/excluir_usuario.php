<?php
session_start();
require_once "protecao_admin.php";
require_once "conexao.php";

// 🔒 Proteção: usuário precisa estar logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.html");
    exit();
}

// 🔒 Proteção: somente administrador pode excluir
if ($_SESSION['usuario_tipo'] !== 'admin') {
    echo "<script>alert('Você não tem permissão para excluir usuários!'); window.location.href='listar_usuarios.php';</script>";
    exit();
}

// Verifica se recebeu ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>alert('ID inválido!'); window.location.href='listar_usuarios.php';</script>";
    exit();
}

$id = intval($_GET['id']);

try {
    // Verifica se o usuário existe
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE id = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() === 0) {
        echo "<script>alert('Usuário não encontrado!'); window.location.href='listar_usuarios.php';</script>";
        exit();
    }

    // Excluir usuário
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    echo "<script>alert('Usuário excluído com sucesso!'); window.location.href='listar_usuarios.php';</script>";
    exit();

} catch (PDOException $e) {
    echo "<script>alert('Erro ao excluir usuário!'); window.location.href='listar_usuarios.php';</script>";
    exit();
}
?>
