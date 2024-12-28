<?php
// Conexão com o banco de dados
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "construcao";

$conn = new mysqli($servidor, $usuario, $senha, $banco);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Receber os dados do formulário
$id = $_POST['id'];
$descricao = $_POST['descricao'];
$valor = $_POST['valor'];
$vencimento = $_POST['vencimento'];
$situacao = $_POST['situacao'];

// Atualizar os dados no banco
$sql = "UPDATE contas_pagar SET descricao = ?, valor = ?, vencimento = ?, situacao = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sdssi", $descricao, $valor, $vencimento, $situacao, $id);

if ($stmt->execute()) {
    echo "<div class='alert alert-success text-center mt-4'>Conta a pagar atualizada com sucesso!</div>";
    echo '<div class="text-center"><a href="listar_contas_pagar.php" class="btn btn-primary mt-3">Voltar</a></div>';
} else {
    echo "<div class='alert alert-danger text-center mt-4'>Erro ao atualizar a conta: " . $stmt->error . "</div>";
    echo '<div class="text-center"><a href="listar_contas_pagar.php" class="btn btn-danger mt-3">Voltar</a></div>';
}

// Fechar a conexão
$stmt->close();
$conn->close();
?>
