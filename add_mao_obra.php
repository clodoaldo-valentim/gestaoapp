<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "construcao";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$colaborador = $_POST['colaborador'];
$custo_hora = $_POST['custo_hora'];

$query = "INSERT INTO mao_obra (nome, custo_hora) VALUES ('$colaborador', $custo_hora)";
if (mysqli_query($conn, $query)) {
    echo "Colaborador cadastrado com sucesso! <a href='index.html'>Voltar</a>";
} else {
    echo "Erro ao cadastrar colaborador: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
