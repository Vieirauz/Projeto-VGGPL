<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Administrador</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            padding: 20px;
        }
        form {
            background: white;
            width: 400px;
            margin: auto;
            padding: 20px;
            border-radius: 8px;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 6px;
            margin-bottom: 15px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: blue;
            color: white;
            border: none;
            border-radius: 6px;
        }
    </style>
</head>
<body>

    <h2 style="text-align:center;">Cadastro de Administrador</h2>

    <form action="processa_admin.php" method="POST">

        <label>Nome:</label>
        <input type="text" name="nome" required>

        <label>Login:</label>
        <input type="text" name="login" required>

        <label>Senha:</label>
        <input type="password" name="senha" required>

        <button type="submit">Cadastrar Administrador</button>
    </form>

</body>
</html>
