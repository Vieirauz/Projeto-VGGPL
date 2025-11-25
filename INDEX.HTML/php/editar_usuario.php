<?php
session_start();
require_once "protecao_admin.php";
require_once "conexao.php";

// 🔒 Proteção: usuário precisa estar logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.html");
    exit();
}

// 🔒 Proteção: somente administrador pode editar
if ($_SESSION['usuario_tipo'] !== 'admin') {
    echo "<h2>⚠ Você não tem permissão para editar usuários.</h2>";
    exit();
}

$user = null;

// 🔍 Buscar usuário pelo ID
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // segurança: evita injeção

    try {
        $stmt = $conn->prepare("SELECT id, nome, email, cpf FROM usuarios WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            die("Usuário não encontrado.");
        }

    } catch (PDOException $e) {
        die("Erro ao buscar usuário.");
    }
}

// ✏ Atualizar dados
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = intval($_POST['id']);
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $cpf = trim($_POST['cpf']);

    try {
        $stmt = $conn->prepare("
            UPDATE usuarios 
            SET nome = :nome, email = :email, cpf = :cpf 
            WHERE id = :id
        ");

        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":cpf", $cpf);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        $stmt->execute();

        echo "<script>
                alert('Usuário atualizado com sucesso!');
                window.location.href='listar_usuarios.php';
              </script>";
        exit();

    } catch (PDOException $e) {
        echo "❌ Erro ao atualizar usuário.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Usuário</title>
  <link rel="stylesheet" href="../css/cadastro.css">
</head>
<body>
  <header>
    <div id="MenuFixo" class="Menu">
      <a class="Logo" href="../indexfoundmanga.html">
        <img class="logofaixa" src="../imagem/LOGO.PP.jpeg" alt="Logo" />
      </a>
    </div>
  </header>

  <form method="POST" class="login-container">
    <h1>Editar Usuário</h1>

    <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">

    <input type="text" name="nome" value="<?= htmlspecialchars($user['nome']) ?>" placeholder="Nome Completo" required>

    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" placeholder="E-mail" required>

    <input type="text" name="cpf" value="<?= htmlspecialchars($user['cpf']) ?>" placeholder="CPF" maxlength="14" required>

    <div class="buttons">
      <button type="submit" class="submit-btn">Salvar Alterações</button>
      <a href="listar_usuarios.php" class="reset-btn" style="text-decoration:none; padding:10px;">Cancelar</a>
    </div>
  </form>

  <footer class="footer">
    <div class="footer-container">
      <p>© <span id="anoAtual"></span> Portal das Páginas</p>
    </div>
  </footer>

  <script>
    document.getElementById("anoAtual").textContent = new Date().getFullYear();
  </script>
</body>
</html>
