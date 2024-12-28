<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
<?php
// Conexão com o banco de dados
$servidor = "localhost";
$usuario = "root"; 
$senha = "";       
$banco = "construcao";

$conn = new mysqli($servidor, $usuario, $senha, $banco);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verificar se o ID foi enviado via GET
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitizar o ID para evitar injeção de SQL

    // Preparar a consulta SQL para exclusão
    $sql = "DELETE FROM contas WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Conta excluída com sucesso!'); window.location.href = 'gestao_contas.php';</script>";
    } else {
        echo "<script>alert('Erro ao tentar excluir conta!'); window.location.href = 'gestao_contas.php';</script>" . $conn->error . "</p>";
    }

    $stmt->close();
} else {
    echo "<p class='text-warning'>Nenhuma conta foi selecionada para exclusão.</p>";
}

// Fechar a conexão com o banco
$conn->close();
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
