<?php
// Dados do Render
$host = "dpg-d3gajhb3fgac738r5o3g-a"; 
$port = "5432"; 
$dbname = "jogosvoid_db";
$user = "jogosvoid_user";
$password = "0JDBA4zXNegSQdIYI6zTd5ikvtPKoxuA";

try {
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "✅ Conexão bem-sucedida!";
} catch (PDOException $e) {
    echo "❌ Erro na conexão: " . $e->getMessage();
}
?>
