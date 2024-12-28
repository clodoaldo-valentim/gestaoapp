<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "construcao";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Recebe os dados do formulário
$tipo = $_POST['tipo'];
$valor = $_POST['valor'];
$descricao = $_POST['descricao'];
$data_movimentacao = $_POST['data_movimentacao'];

// Inserção no banco de dados
$query = "INSERT INTO fluxo_caixa (tipo, valor, descricao, data_movimentacao) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("sdss", $tipo, $valor, $descricao, $data_movimentacao);

if ($stmt->execute()) {
    echo "Movimentação registrada com sucesso! <a href='gestao_financeira.html'>Voltar</a>";
} else {
    echo "Erro ao registrar movimentação: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
