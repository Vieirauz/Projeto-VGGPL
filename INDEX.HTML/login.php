<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/index.css">
</head>

<body>

<header>
    <img src="Imagem/logo.png" class="logofaixa">
</header>

<div class="home-container" style="max-width: 400px; padding: 40px; text-align:center;">
    <h2>Login</h2>

<form method="POST" action="php/valida_login.php" style="flex-direction:column; gap:20px;">
  <input type="text" name="usuario" placeholder="Usuário" required
         style="padding:10px; border:2px solid rgb(141,16,214); border-radius:10px; width:100%; font-weight:bold;">
  <input type="password" name="senha" placeholder="Senha" required
         style="padding:10px; border:2px solid rgb(141,16,214); border-radius:10px; width:100%; font-weight:bold;">
  <button class="login-b" type="submit" style="width:100%;">Entrar</button>
</form>
    

    <?php if(isset($_GET['erro'])): ?>
        <p style="color:red; margin-top:15px;">Usuário ou senha inválidos.</p>
    <?php endif; ?>

</div>

</body>
</html>
