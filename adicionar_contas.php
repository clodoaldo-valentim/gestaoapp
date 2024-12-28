<?php
// Configurações do banco de dados
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "construcao";

// Conexão com o banco de dados
$conn = new mysqli($servidor, $usuario, $senha, $banco);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificar se os dados foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descricao = isset($_POST['descricao']) ? trim($_POST['descricao']) : '';
    $data_vencimento = isset($_POST['vencimento']) ? $_POST['vencimento'] : '';
    $valor = isset($_POST['valor']) ? (float)$_POST['valor'] : 0;
    $situacao = isset($_POST['situacao']) ? trim($_POST['situacao']) : '';
    $tipo = isset($_POST['tipo']) ? trim($_POST['tipo']) : '';

    // Validar dados obrigatórios
    if (empty($descricao) || empty($data_vencimento) || $valor <= 0 || empty($situacao)) {
        echo "<script>alert('Por favor, preencha todos os campos corretamente.'); window.history.back();</script>";
        exit;
    }

    // Inserir a conta no banco de dados
    $sql = "INSERT INTO contas (descricao, vencimento, valor, situacao, tipo) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdss", $descricao, $data_vencimento, $valor, $situacao, $tipo);

    if ($stmt->execute()) {
        echo "<script>alert('Conta adicionada com sucesso!'); window.location.href = 'gestao_contas.php';</script>";
    } else {
        echo "<script>alert('Erro ao adicionar conta: " . $stmt->error . "'); window.history.back();</script>";
    }

    $stmt->close();
}

$conn->close();
?>
