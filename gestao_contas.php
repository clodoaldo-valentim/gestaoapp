<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gestão de Contas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <style>
    body {
      background-color: #f8f9fa;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      min-height: 100vh;
    }
    .container {
      margin-top: 50px;
      max-width: 95%;
      background-color: #ffffff;
      padding: 20px;
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
    .card {
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: transform 0.2s;
    }
    .card:hover {
      transform: scale(1.02);
    }
    .table-hover tbody tr:hover {
      background-color: #f1f1f1;
    }
  </style>
</head>
<body>

<div class="container">
  <h1 class="text-center text-primary mb-4">Gestão de Contas</h1>
  <div class="d-flex justify-content-between mb-3">
    <a href="nova_conta.html" class="btn btn-success"><i class="bi bi-plus-circle"></i> Nova Conta</a>
    <a href="dashboard.php" class="btn btn-secondary"><i class="bi bi-pie-chart"></i> Dashboard</a>
  </div>
  
  <h3 class="mb-3">Contas a Pagar</h3>
  <div class="table-responsive">
    <table class="table table-hover table-bordered">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Descrição</th>
          <th>Vencimento</th>
          <th>Valor</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <!-- PHP para exibir contas a pagar -->
        <?php include 'listar_contas_pagar.php'; ?>
      </tbody>
    </table>
  </div>

  <h3 class="mt-5 mb-3">Contas a Receber</h3>
  <div class="table-responsive">
    <table class="table table-hover table-bordered">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Descrição</th>
          <th>Vencimento</th>
          <th>Valor</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <!-- PHP para exibir contas a receber -->
        <?php include 'listar_contas_receber.php'; ?>
      </tbody>
    </table>
  </div>
  <a href="painel.html" class="btn btn-danger mt-3">Painel</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
