
<!--Copia para edição -->
<?php
require 'db.php';

// Verificar se o ID da tarefa foi passado
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID da conta não fornecido!";
    exit;
}

$id = (int) $_GET['id'];

// Buscar a tarefa no banco de dados
$sql = "SELECT * FROM contas WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$conta_pagar = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$conta_pagar) {
    echo "Conta não encontrada!";
    exit;
}

// Processar o envio do formulário de edição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $vencimento = $_POST['vencimento'];
    $situacao = $_POST['situacao'];
    
    // Atualizar a tarefa no banco de dados
    $update_sql = "UPDATE contas SET descricao = :descricao, valor = :valor, vencimento = :vencimento, situacao = :situacao WHERE id = :id";
    $stmt = $pdo->prepare($update_sql);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':valor', $valor);
    $stmt->bindParam(':vencimento', $vencimento);
    $stmt->bindParam(':situacao', $situacao);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        header("Location: gestao_contas.php"); // Redirecionar de volta para a lista
        exit;
    } else {
        echo "Erro ao atualizar a conta.";
    }
}
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
      color: #007bff;
    }

    /* Dropdown Menu */
    .dropdown-header {
      font-weight: bold;
      font-size: 0.9rem;
    }
    .container{
      margin-top: 100px;
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
  <!--fim do menu-->
<div class="container">
    <h1>Editar Conta</h1>

    <form method="POST">
        <div class="mb-3">
            <label for="edscricao" class="form-label">Descrição</label>
            <input type="text" class="form-control" id="descricao" name="descricao" value="<?= htmlspecialchars($conta_pagar['descricao']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="valor" class="form-label">Valor</label>
            <textarea class="form-control" id="descricao" name="valor" required><?= htmlspecialchars($conta_pagar['valor']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="data_hora" class="form-label">Vencimento</label>
            <input type="datetime-local" class="form-control" id="data_hora" name="vencimento" value="<?= date('Y-m-d\TH:i', strtotime($conta_pagar['vencimento'])) ?>" required>
        </div>
        <div class="mb-3">
            <label for="situacao" class="form-label">Situação</label>
            <select class="form-control" id="situacao" name="situacao" required>
                <option value="paga" <?= $conta_pagar['situacao'] == 'paga' ? 'selected' : '' ?>>Paga</option>
                <option value="pendente" <?= $conta_pagar['situacao'] == 'pendente' ? 'selected' : '' ?>>Pendente</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
