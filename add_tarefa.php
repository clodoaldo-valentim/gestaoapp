<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $data_hora = $_POST['data_hora'];
    $frequencia = $_POST['frequencia'];
    $prioridade = $_POST['prioridade'];

    $sql = "INSERT INTO tarefas (titulo, descricao, data_hora, frequencia, prioridade) 
            VALUES (:titulo, :descricao, :data_hora, :frequencia, :prioridade)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':titulo' => $titulo,
        ':descricao' => $descricao,
        ':data_hora' => $data_hora,
        ':frequencia' => $frequencia,
        ':prioridade' => $prioridade
    ]);

    header('Location: lista_tarefas.php');
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Tarefa</title>
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
    <h1>Adicionar Nova Tarefa</h1>

    <form method="POST">
        <!-- Título -->
        <div class="mb-3">
            <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Digite o título da sua tarefa" required>
        </div>

        <!-- Descrição -->
        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea name="descricao" class="form-control" id="descricao" rows="3" placeholder="Descrição" required></textarea>
        </div>

        <!-- Data e Hora -->
        <div class="mb-3">
            <label for="data_hora" class="form-label">Data e Hora</label>
            <input type="datetime-local" class="form-control" id="data_hora" name="data_hora" required>
        </div>

        <!-- Frequência -->
        <div class="mb-3">
            <label for="frequencia" class="form-label">Frequência</label>
            <select name="frequencia" class="form-control" id="frequencia" required>
                <option value="diaria">Diária</option>
                <option value="semanal">Semanal</option>
                <option value="mensal">Mensal</option>
                <option value="anual">Anual</option>
            </select>
        </div>

        <!-- Prioridade -->
        <div class="mb-3">
            <label for="prioridade" class="form-label">Prioridade</label>
            <select name="prioridade" class="form-control" id="prioridade" required>
                <option value="baixa">Baixa</option>
                <option value="media">Média</option>
                <option value="alta">Alta</option>
            </select>
        </div>

        <!-- Botões -->
        <button type="submit" class="btn btn-primary">Adicionar Tarefa</button>
        <a href="painel.html" class="btn btn-danger mt-3">Painel</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
