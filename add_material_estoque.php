<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $quantidade = $_POST['quantidade'];
    $categoria = $_POST['categoria'];
    $localizacao = $_POST['localizacao'];

    $sql = "INSERT INTO estoque (nome, descricao, quantidade, categoria, localizacao) 
            VALUES (:nome, :descricao, :quantidade, :categoria, :localizacao)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nome' => $nome,
        ':descricao' => $descricao,
        ':quantidade' => $quantidade,
        ':categoria' => $categoria,
        ':localizacao' => $localizacao
    ]);

    header('Location: lista_materiais.php');
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Material</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
              <li><a class="dropdown-item" href="listar_produtos.php"><i class="bi bi-cart4"></i> Listar Produtos</a></li>
              <!-- Seção Ativos -->
              <li><h6 class="dropdown-header">Ativos</h6></li>
              <li><a class="dropdown-item" href="add_ativo.php"><i class="bi bi-cart-plus"></i> Adicionar Ativo</a></li>
              <li><a class="dropdown-item" href="lista_ativos.php"><i class="bi bi-cart4"></i> Listar Ativos</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!--fim do menu-->
    <div class="container">
        <h1>Adicionar Material</h1>
        <form method="POST">
            <div class="input-group mb-3">
                <span class="input-group-text">Nome</span>
                <input type="text" class="form-control" name="nome" placeholder="Digite o nome do material" required>
            </div>
            <div class="mb-3">
                <textarea name="descricao" class="form-control" rows="3" placeholder="Descrição"></textarea>
            </div><br>
            <div class="input-group mb-3">
                <input type="number" class="form-control" name="quantidade" placeholder="Quantidade" required>
            </div><br>
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="categoria" placeholder="Categoria">
            </div><br>
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="localizacao" placeholder="Localização">
            </div><br>
            <button type="submit" class="btn btn-primary">Adicionar Material</button>
            <a href="lista_materiais_estoque.php" class="btn btn-danger w-30 mt-3">Voltar</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>