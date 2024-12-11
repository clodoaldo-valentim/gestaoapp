<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "construcao";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}


$produto = $_POST['produto'];
$materiais_usados = $_POST['materiais_usados'];
$horas_trabalhadas = $_POST['horas_trabalhadas'];

// Custo de materiais
$query_materiais = "SELECT SUM(custo_unidade) AS total_materiais FROM materiais_custos";
$result_materiais = mysqli_query($conn, $query_materiais);
$total_materiais = mysqli_fetch_assoc($result_materiais)['total_materiais'];

// Custo de mão de obra
$query_mao_obra = "SELECT SUM(custo_hora) AS total_mao_obra FROM mao_obra";
$result_mao_obra = mysqli_query($conn, $query_mao_obra);
$total_mao_obra = mysqli_fetch_assoc($result_mao_obra)['total_mao_obra'];

// Cálculo final
$custo_total = ($materiais_usados * $total_materiais) + ($horas_trabalhadas * $total_mao_obra);

$query_custo = "INSERT INTO custos (produto, materiais_usados, horas_trabalhadas, custo_total) 
                VALUES ('$produto', $materiais_usados, $horas_trabalhadas, $custo_total)";
if (mysqli_query($conn, $query_custo)) {
    echo "Custo calculado com sucesso! Custo total: R$ $custo_total <a href='index.html'>Voltar</a>";
} else {
    echo "Erro ao calcular custo: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
