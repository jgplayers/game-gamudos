<?php
$host = "dpg-xxxxx.us-west-2.render.com"; // troque pelo seu host real
$db   = "jogosvoid_db";
$user = "jogosvoid_user";
$pass = "senha123";
$port = "5432"; // porta padrão do Postgres

try {
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Erro de conexão: " . $e->getMessage());
}
?>
