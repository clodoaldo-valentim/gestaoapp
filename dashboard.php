<?php
// Conexão com o banco de dados
$servidor = "localhost";
$usuario = "root"; // Substituir pelo usuário do banco
$senha = "";       // Substituir pela senha do banco
$banco = "construcao";

$conn = new mysqli($servidor, $usuario, $senha, $banco);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Consultas para obter os dados
$totalContasPagar = $conn->query("SELECT SUM(valor) as total FROM contas where tipo = 'pagar'")->fetch_assoc()['total'] ?? 0;
$totalContasReceber = $conn->query("SELECT SUM(valor) as total FROM contas where tipo = 'receber'")->fetch_assoc()['total'] ?? 0;
$totalPagas = $conn->query("SELECT COUNT(*) as total FROM contas WHERE situacao = 'paga'")->fetch_assoc()['total'] ?? 0;
$totalAPendentes = $conn->query("SELECT COUNT(*) as total FROM contas WHERE situacao = 'pendente'")->fetch_assoc()['total'] ?? 0;

$conn->close();
?>

<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Painel - CS Construções</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
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
      color:rgb(245, 247, 249);
    }

    /* Dropdown Menu */
    .dropdown-header {
      font-weight: bold;
      font-size: 0.9rem;
    }
  </style>
</head>
<<body>
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
    <div class="container my-5">
        <h1 class="text-center mb-4">Dashboard</h1>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <h5 class="card-title">Total Contas a Pagar</h5>
                        <p class="card-text fs-3">R$ <?= number_format($totalContasPagar, 2, ',', '.') ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h5 class="card-title">Total Contas a Receber</h5>
                        <p class="card-text fs-3">R$ <?= number_format($totalContasReceber, 2, ',', '.') ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <h5 class="card-title">Pagas</h5>
                        <p class="card-text fs-3"><?= $totalPagas ?> contas</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card text-white bg-danger">
                    <div class="card-body">
                        <h5 class="card-title">Pedentes</h5>
                        <p class="card-text fs-3"><?= $totalAPendentes ?> contas</p>
                    </div>
                </div>
            </div>
        </div>
        <a href="gestao_contas.php" class="btn btn-primary mt-3">Voltar</a>
        <a href="painel.html" class="btn btn-danger mt-3">Painel</a>

    </div>

    <footer class="text-center py-3 bg-light">
        <p class="mb-0">© <?= date('Y') ?> Gestão Financeira. Todos os direitos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
