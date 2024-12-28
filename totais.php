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
        background-color: #f8f9fa;
      }
      /* Navbar */
    .navbar {
      background-color: #007bff;
    }

    .navbar-brand,
    .nav-link {
      color: #fff !important;
    }

      .container {
        max-width: 600px;
        background-color: #fff;
        padding: 20px;
        margin-top: 5%;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      }
      .btn-primary {
        background-color: #007bff;
        border: none;
      }
      .btn-primary:hover {
        background-color: #0056b3;
      }
      .btn-danger {
        margin-top: 10px;
      }
      /* Cards */
    .card {
      border: none;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: transform 0.2s ease-in-out;
    }

    .card:hover {
      transform: scale(1.02);
    }

    .card-title {
      font-weight: bold;
      color: #007bff;
    }

    /* Dropdown Menu */
    .dropdown-header {
      font-weight: bold;
      font-size: 0.9rem;
    }
    </style>
</head>
<body>
   <!-- Navbar Superior -->
   <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">CS Construções</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="cadastro.html">Cadastro</a></li>
          <li class="nav-item"><a class="nav-link" href="lista_tarefas.php">Minhas Tarefas</a></li>
          <li class="nav-item"><a class="nav-link" href="consultas_entradas.html">Entradas</a></li>
          <li class="nav-item"><a class="nav-link" href="consultas_saidas.html">Saídas</a></li>
          <li class="nav-item"><a class="nav-link" href="totais.php">Totais</a></li>
          <!-- Dropdown Menu -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="inventariosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Inventários
            </a>
            <ul class="dropdown-menu" aria-labelledby="inventariosDropdown">
              <!-- Seção Materiais -->
              <li><h6 class="dropdown-header">Materiais</h6></li>
              <li><a class="dropdown-item" href="add_material.php"><i class="bi bi-plus-circle"></i> Adicionar Material</a></li>
              <li><a class="dropdown-item" href="lista_materiais.php"><i class="bi bi-list-ul"></i> Listar Materiais</a></li>
              <li><hr class="dropdown-divider"></li>
              <!-- Seção Estoque -->
              <li><h6 class="dropdown-header">Estoque</h6></li>
              <li><a class="dropdown-item" href="add_material_estoque.php"><i class="bi bi-box-seam"></i> Adicionar Estoque</a></li>
              <li><a class="dropdown-item" href="listar_estoque.php"><i class="bi bi-boxes"></i> Listar Estoque</a></li>
              <li><hr class="dropdown-divider"></li>
              <!-- Seção Produtos -->
              <li><h6 class="dropdown-header">Produtos</h6></li>
              <li><a class="dropdown-item" href="add_produto.php"><i class="bi bi-cart-plus"></i> Adicionar Produto</a></li>
              <li><a class="dropdown-item" href="lista_produtos.php"><i class="bi bi-cart4"></i> Listar Produtos</a></li>
              <!-- Seção Ativos -->
              <li><h6 class="dropdown-header">Ativos</h6></li>
              <li><a class="dropdown-item" href="add_ativo.php"><i class="bi bi-cart-plus"></i> Adicionar Ativos</a></li>
              <li><a class="dropdown-item" href="lista_ativos.php"><i class="bi bi-cart4"></i> Listar Ativos</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
<div class="container">
<h1 class="text-primary mb-4">Resultado da consulta</h1>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
