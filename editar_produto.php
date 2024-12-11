<?php
require 'db.php';

// Buscar o produto a ser editado
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $sql = "SELECT * FROM produtos WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$produto) {
        echo "Produto não encontrado!";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $quantidade = $_POST['quantidade'];
    $preco = $_POST['preco'];
    $categoria = $_POST['categoria'];

    $sql = "UPDATE produtos SET nome = :nome, descricao = :descricao, quantidade = :quantidade, 
            preco = :preco, categoria = :categoria WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nome' => $nome,
        ':descricao' => $descricao,
        ':quantidade' => $quantidade,
        ':preco' => $preco,
        ':categoria' => $categoria,
        ':id' => $id
    ]);

    header('Location: lista_produtos.php');
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
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
    <h1>Editar Produto</h1>
    <form method="POST">
        <div class="input-group mb-3">
            <span class="input-group-text">Nome</span>
            <input type="text" class="form-control" name="nome" value="<?= htmlspecialchars($produto['nome']) ?>" required>
        </div>
        <div class="mb-3">
            <textarea name="descricao" class="form-control" rows="3"><?= htmlspecialchars($produto['descricao']) ?></textarea>
        </div><br>
        <div class="input-group mb-3">
            <input type="number" class="form-control" name="quantidade" value="<?= htmlspecialchars($produto['quantidade']) ?>" required>
        </div><br>
        <div class="input-group mb-3">
            <input type="number" step="0.01" class="form-control" name="preco" value="<?= htmlspecialchars($produto['preco']) ?>" required>
        </div><br>
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="categoria" value="<?= htmlspecialchars($produto['categoria']) ?>">
        </div><br>
        <button type="submit" class="btn btn-primary">Atualizar Produto</button>
        <a href="lista_produtos.php" class="btn btn-danger w-30 mt-3">Voltar</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>