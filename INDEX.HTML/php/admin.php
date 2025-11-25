<?php
require_once "protecao_admin.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/index.css">
    <title>Administração</title>
</head>

<body>

<header>
    <img src="../Imagem/logo.png" class="logofaixa">

    <div class="right-section">
        <span style="color:white; font-weight:bold;">Administrador</span>
        <a href="logout.php" class="logout-btn">Sair</a>
    </div>
</header>

<div class="home-container">
    
    <h2>Painel Administrativo</h2>

    <div style="display:flex; flex-direction:column; gap:20px; text-align:center;">

        <a href="listar_usuario.php" class="login-b" style="text-decoration:none; width:200px; margin:auto;">
            Gerenciar Usuários
        </a>

    </div>

</div>

</body>
</html>
