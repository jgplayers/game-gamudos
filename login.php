<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "conexao.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $senha   = $_POST['senha'];

    // Busca usuário no banco
    $stmt = $conn->prepare("SELECT id, usuario, senha FROM usuarios WHERE usuario=? OR email=? LIMIT 1");
    $stmt->bind_param("ss", $usuario, $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // Verifica a senha
        if (password_verify($senha, $row['senha'])) {
            // Salva sessão
            $_SESSION['usuario_id'] = $row['id'];
            $_SESSION['usuario']    = $row['usuario'];

            header("Location: index.php"); // redireciona para página inicial
            exit();
        } else {
            $erro = "Senha incorreta!";
        }
    } else {
        $erro = "Usuário ou email não encontrado!";
    }

    $stmt->close();
}

if (isset($conn)) {
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - Jogos do Void</title>
<link rel="icon" href="imagens/iconepc.png">
<style>
* { margin:0; padding:0; box-sizing:border-box; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; }
body { background:#050505; color:#eee; display:flex; justify-content:center; align-items:center; min-height:100vh; }
.container { background:#0f0f0f; padding:40px 30px; border-radius:15px; border:2px solid #ff1a1a; box-shadow:0 0 20px rgba(255,0,0,0.3); width:350px; text-align:center; }
h1 { color:#ff1a1a; margin-bottom:25px; text-shadow:0 0 10px #ff1a1a, 0 0 25px #ff3333; }
input { width:100%; padding:12px; margin:10px 0; border-radius:10px; border:2px solid #ff1a1a; background:#0a0a0a; color:#fff; outline:none; transition:0.3s; }
input:focus { border-color:#ff3333; box-shadow:0 0 12px #ff1a1a; }
button { width:100%; padding:12px; margin-top:15px; border:none; border-radius:10px; background:#ff1a1a; color:#fff; font-size:1rem; cursor:pointer; transition:0.3s; }
button:hover { background:#ff3333; box-shadow:0 0 15px #ff1a1a; transform:scale(1.03); }
p { margin-top:15px; font-size:0.9rem; color:#bbb; }
a { color:#ff3333; text-decoration:none; }
a:hover { text-shadow:0 0 8px #ff1a1a; }
.mensagem { margin-bottom:15px; font-weight:bold; }
.mensagem.erro { color:#ff4444; }
</style>
</head>
<body>
<div class="container">
    <h1>Entrar</h1>
    <?php if(isset($erro)) echo "<p class='mensagem erro'>$erro</p>"; ?>
    <form method="POST" action="">
        <input type="text" name="usuario" placeholder="Usuário ou Email" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <button type="submit">Login</button>
    </form>
    <p>Não tem conta? <a href="cadastro.php">Cadastre-se</a></p>
</div>
</body>
</html>
