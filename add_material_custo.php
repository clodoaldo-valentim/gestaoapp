<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "construcao";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obter dados do formulário
$material = $_POST['material'];
$custo = $_POST['custo'];

// Inserir dados na tabela "materiais"
$query = "INSERT INTO materiais_custos (nome, custo_unidade) VALUES (?, ?)";
$stmt = $conn->prepare($query);

if ($stmt) {
    $stmt->bind_param("sd", $material, $custo); // "sd" indica string e double
    if ($stmt->execute()) {
        echo "Material cadastrado com sucesso! <a href='gestao_custos.html'>Voltar</a>";
    } else {
        echo "Erro ao cadastrar material: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Erro na preparação da consulta: " . $conn->error;
}

// Fechar conexão
$conn->close();
?>

