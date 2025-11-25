<?php
session_start();
require_once "protecao_admin.php";
require_once "conexao.php";

// 🔒 Proteção: verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.html");
    exit();
}

// 🔒 Proteção: verifica se é administrador
if ($_SESSION['usuario_tipo'] !== 'admin') {
    echo "<h2>⚠ Você não tem permissão para acessar esta página.</h2>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Usuários Cadastrados</title>
  <link rel="stylesheet" href="../css/cadastro.css">
</head>
<body>
  <header>
    <div id="MenuFixo" class="Menu">
      <a class="Logo" href="../indexfoundmanga.html">
        <img class="logofaixa" src="../imagem/LOGO.PP.jpeg" alt="Logo" />
      </a>
    </div>
    <div class="right-section">
      <a href="../cadastro.html" class="login-b">Novo Cadastro</a>
      <a href="../login.html" class="login-b">Login</a>
    </div>
  </header>

  <div class="login-container">
    <h1>Usuários Cadastrados</h1>

    <table border="1" width="100%" style="text-align:center; border-collapse:collapse;">
      <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Email</th>
        <th>CPF</th>
        <th>Ações</th>
      </tr>

      <?php
      try {
          $sql = "SELECT id, nome, email, cpf FROM usuarios ORDER BY id DESC";
          $stmt = $conn->prepare($sql);
          $stmt->execute();

          if ($stmt->rowCount() > 0) {
              while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  echo "<tr>
                          <td>{$row['id']}</td>
                          <td>{$row['nome']}</td>
                          <td>{$row['email']}</td>
                          <td>{$row['cpf']}</td>
                          <td>
                            <a href='editar_usuario.php?id={$row['id']}'>Editar</a> |
                            <a href='excluir_usuario.php?id={$row['id']}' onclick=\"return confirm('Tem certeza que deseja excluir?')\">Excluir</a>
                          </td>
                        </tr>";
              }
          } else {
              echo "<tr><td colspan='5'>Nenhum usuário cadastrado.</td></tr>";
          }

      } catch (PDOException $e) {
          echo "<tr><td colspan='5'>Erro ao carregar usuários.</td></tr>";
      }
      ?>
    </table>
  </div>

  <footer class="footer">
    <div class="footer-container">
      <p>© <span id="anoAtual"></span> Portal das Páginas - Todos os direitos reservados.</p>
      <p>Email: <a href=""></a> | Telefone: <a href=""></a></p>
    </div>
  </footer>

  <script>
    document.getElementById("anoAtual").textContent = new Date().getFullYear();
  </script>
</body>
</html>
