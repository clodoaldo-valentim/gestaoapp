<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta por Parceiro</title>
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
  <!--menu-->
  <nav class="navbar navbar-expand-lg bg-white shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">CS Construções</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link active" aria-current="page" href="cadastro.html">Cadastro</a>
                <a class="nav-link" href="lista_tarefas.php">Minhas tarefas</a>
                <a class="nav-link" href="consultas_entradas.html">Entradas</a>
                <a class="nav-link" href="consultas_saidas.html">Saídas</a>
                <a class="nav-link" href="totais.php">Totais</a>

                <!-- Submenu (Dropdown) -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Inventários
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="add_material.php">Adicionar Material </a></li>
                        <li><a class="dropdown-item" href="lista_materiais.php">Listar materiais</a></li>
                        <li><a class="dropdown-item" href="add_material_estoque.php">Adicionar Estoque</a></li>
                        <li><a class="dropdown-item" href="lista_materiais_estoque.php">Listar Estoque</a></li>
                        <li><a class="dropdown-item" href="add_ativo.php">Adicionar Ativo</a></li>
                        <li><a class="dropdown-item" href="lista_ativos.php">Listar Ativos</a></li>
                        <li><a class="dropdown-item" href="add_produto.php">Adicionar Produto</a></li>
                        <li><a class="dropdown-item" href="lista_produtos.php">Listar Produtos</a></li>
                    </ul>
                </li>
            </div>
        </div>
    </div>
</nav>
<!--fim do menu-->
<div class="container">
<h1 class="text-center">Resultado da consulta</h1>
<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "construcao";
$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);
if (!$conexao) {
    die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
}
$total = "SELECT SUM(valor) AS total_soma FROM entradas";
$result = mysqli_query($conexao, $total);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $totalSum = $row['total_soma'];
        echo "<table class='table table-hover table-bordered'>";
        echo "<thead class='table-dark'>";
        echo "<tr>";
        echo "<th>DETALHE</th>";
        echo "<th>VALOR</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        echo "<tr>";
        echo "<td>Total de entradas</td>";
        echo "<td>R$ " . number_format($totalSum, 2, ',', '.') . "</td>";
        echo "</tr>";
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<h2 class='text-center'>A tabela não foi encontrada.</h2>";
    }
} else {
    echo "<h2 class='text-center'>Erro ao executar o SQL query.</h2>";
}

$totalsaida = "SELECT SUM(valor) AS total_somasaida FROM saidas";
$resultsaida = mysqli_query($conexao, $totalsaida);

if ($resultsaida) {
    if (mysqli_num_rows($resultsaida) > 0) {
        $row = mysqli_fetch_assoc($resultsaida);
        $totalsaida = $row['total_somasaida'];
        echo "<table class='table table-hover table-bordered'>";
        echo "<thead class='table-dark'>";
        echo "<tr>";
        echo "<th>DETALHE</th>";
        echo "<th>VALOR</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        echo "<tr>";
        echo "<td>Total de saída</td>";
        echo "<td>R$ " . number_format($totalsaida, 2, ',', '.') . "</td>";
        echo "</tr>";
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<h2 class='text-center'>A tabela não foi encontrada.</h2>";
    }
} else {
    echo "<h2 class='text-center'>Erro ao executar o SQL query.</h2>";
}
$saldo = $totalSum - $totalsaida;
echo "<table class='table table-hover table-bordered'>";
echo "<thead class='table-dark'>";
echo "<tr>";
echo "<th>DETALHE</th>";
echo "<th>VALOR</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";
echo "<tr>";
echo "<td>Seu saldo atual</td>";
echo "<td>R$ " . number_format($saldo, 2, ',', '.') . "</td>";
echo "</tr>";
echo "</tbody>";
echo "</table>";
?>
<a href="painel.html" class="btn btn-danger mt-3">Painel</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
