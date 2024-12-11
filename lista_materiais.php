<?php
require 'db.php';

// Buscar todos os materiais
$sql = "SELECT * FROM materiais ORDER BY data_adicao ASC";
$stmt = $pdo->query($sql);
$materiais = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Excluir material
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $delete_sql = "DELETE FROM materiais WHERE id = :id";
    $stmt = $pdo->prepare($delete_sql);
    $stmt->bindParam(':id', $id);
    if ($stmt->execute()) {
        echo "Material excluído com sucesso!";
        header("Location: lista_materiais.php");
        exit;
    } else {
        echo "Erro ao excluir o material.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Materiais</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <h1>Lista de Materiais</h1>

    <a href="add_material.php" class="btn btn-primary mb-3">Adicionar Novo Material</a>

    <table class="table">
        <thead class="table-dark">
            <tr>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Quantidade</th>
                <th>Categoria</th>
                <th>Localização</th>
                <th>Ações</th>
            </tr>
        </thead>
        <?php foreach ($materiais as $material): ?>
            <tr>
                <td><?= htmlspecialchars($material['nome']) ?></td>
                <td><?= htmlspecialchars($material['descricao']) ?></td>
                <td><?= htmlspecialchars($material['quantidade']) ?></td>
                <td><?= htmlspecialchars($material['categoria']) ?></td>
                <td><?= htmlspecialchars($material['localizacao']) ?></td>
                <td>
                    <!-- Editar -->
                    <a href="editar_material.php?id=<?= $material['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                    <!-- Excluir -->
                    <a href="?delete=<?= $material['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este material?')">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="painel.html" class="btn btn-danger w-30 mt-3">Painel</a>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
