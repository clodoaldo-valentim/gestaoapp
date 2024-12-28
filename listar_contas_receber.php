<?php
// Configurações do banco de dados
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "construcao";

$conn = new mysqli($servidor, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$sql = "SELECT id, descricao, vencimento, valor FROM contas WHERE tipo = 'receber'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['id']}</td>";
        echo "<td>{$row['descricao']}</td>";
        echo "<td>{$row['vencimento']}</td>";
        echo "<td>R$ " . number_format($row['valor'], 2, ',', '.') . "</td>";
        echo "<td>
                <a href='editar_conta_receber.php?id={$row['id']}' class='btn btn-warning btn-sm'><i class='bi bi-pencil'></i> Editar</a>
                <a href='excluir_conta_receber.php?id={$row['id']}' class='btn btn-danger btn-sm'><i class='bi bi-trash'></i> Excluir</a>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5' class='text-center'>Nenhuma conta a receber encontrada</td></tr>";
}
$conn->close();
?>
