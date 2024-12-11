<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta por Parceiro</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <style>
      body {
        background-color: #F0FFF0;
        font-family: Arial, sans-serif;
        line-height: 1.5;
      }
      .container {
        margin-top: 30px;
        background-color: #ffffff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      }
      .btn-danger {
        background-color: #dc3545;
        border: none;
      }
      .btn-danger:hover {
        background-color: #c82333;
      }
      .table {
        margin-top: 20px;
      }
    </style>
</head>
<body>
<div class="container">
<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "gestao";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
}

$query = "SELECT * FROM entradas";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) > 0) {
    echo "<h1 class='text-center'>Resultado da Consulta</h1>";
    echo "<table class='table table-hover table-bordered'>";
    echo "<thead class='table-dark'>";
    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>Detalhe</th>";
    echo "<th>Valor</th>";
    echo "<th>Data</th>";
    echo "<th>Mês</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    while($row = mysqli_fetch_assoc($result)){
        echo "<tr>";
        echo "<td>".$row["id"]."</td>";
        echo "<td>".$row["detalhe"]."</td>";
        echo "<td>".'R$ '.number_format($row["valor"], 2, ',', '.')."</td>";
        echo "<td>".$row["data"]."</td>";
        echo "<td>".$row["mes"]."</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo '<a href="painel.html" class="btn btn-danger mt-3">Painel</a>';
} else {
    echo "<h1 class='text-center'>Nenhum resultado encontrado.</h1>";
}

mysqli_close($conn);
?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
