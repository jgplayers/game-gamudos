<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "conexao.php";

$erro = "";
$sucesso = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = trim($_POST['usuario']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $confSenha = $_POST['confSenha'];

    if ($senha !== $confSenha) {
        $erro = "As senhas não coincidem!";
    } else {
        try {
            // Verifica se o usuário ou email já existem
            $stmt = $conn->prepare("SELECT id FROM usuarios WHERE usuario = :usuario OR email = :email");
            $stmt->execute(['usuario' => $usuario, 'email' => $email]);

            if ($stmt->rowCount() > 0) {
                $erro = "Usuário ou email já cadastrado!";
            } else {
                // Insere o novo usuário
                $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
                $stmtInsert = $conn->prepare("INSERT INTO usuarios (usuario, email, senha) VALUES (:usuario, :email, :senha)");
                $stmtInsert->execute([
                    'usuario' => $usuario,
                    'email' => $email,
                    'senha' => $senhaHash
                ]);
                $sucesso = "Cadastro realizado com sucesso! <a href='login.php'>Ir para Login</a>";
            }
        } catch (PDOException $e) {
            $erro = "Erro no banco de dados: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cadastro - Jogos do Void</title>
<link rel="icon" href="imagens/iconepc.png">
<style>
* { margin:0; padding:0; box-sizing:border-box; font-family:"Segoe UI", Tahoma, Geneva, Verdana, sans-serif; }
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
.mensagem.sucesso { color:#00ff66; }
</style>
</head>
<body>
<div class="container">
    <h1>Criar Conta</h1>
    <?php if($erro) echo "<p class='mensagem erro'>$erro</p>"; ?>
    <?php if($sucesso) echo "<p class='mensagem sucesso'>$sucesso</p>"; ?>
    <form method="POST" action="">
        <input type="text" name="usuario" placeholder="Usuário" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <input type="password" name="confSenha" placeholder="Confirmar Senha" required>
        <button type="submit">Cadastrar</button>
    </form>
    <p>Já tem conta? <a href="login.php">Entrar</a></p>
</div>
</body>
</html>
