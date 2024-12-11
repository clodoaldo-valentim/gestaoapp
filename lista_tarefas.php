<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
<?php
require 'db.php';

// Buscar todas as tarefas
$sql = "SELECT * FROM tarefas ORDER BY data_hora ASC";
$stmt = $pdo->query($sql);
$tarefas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Excluir tarefa
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $delete_sql = "DELETE FROM tarefas WHERE id = :id";
    $stmt = $pdo->prepare($delete_sql);
    $stmt->bindParam(':id', $id);
    if ($stmt->execute()) {
        echo "Tarefa excluída com sucesso!";
        header("Location: lista_tarefas.php"); // Redirecionar para a página lista_tarefas.php
        exit;
    } else {
        echo "Erro ao excluir a tarefa.";
    }
}

// Marcar tarefa como concluída
if (isset($_GET['concluir'])) {
    $id = (int) $_GET['concluir'];
    $update_sql = "UPDATE tarefas SET status = 'concluída' WHERE id = :id";
    $stmt = $pdo->prepare($update_sql);
    $stmt->bindParam(':id', $id);
    if ($stmt->execute()) {
       echo " <h1>Tarefa marcada como concluída!</h1>";
       header("Location: lista_tarefas.php"); // Redirecionar para a página lista_tarefas.php
       exit;
    } else {
        echo "Erro ao marcar a tarefa como concluída.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Tarefas</title>
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
    <h1>Minhas Tarefas</h1>

    <a href="add_tarefa.php"><i class="bi bi-clipboard-plus-fill"></i> Adicionar Nova Tarefa</a><br><br>

    <table class="table">
        <thead class="table-dark">
            <tr>
                <th>Título</th>
                <th>Descrição</th>
                <th>Data e Hora</th>
                <th>Frequência</th>
                <th>Prioridade</th>
                <th>Ações</th>
            </tr>
        </thead>
        <?php foreach ($tarefas as $tarefa): ?>
            <tr style="background-color: <?= getCorPrioridade($tarefa['prioridade']) ?>; <?= $tarefa['status'] == 'concluída' ? 'background-color: #90EE90;' : '' ?>">
                <td><?= htmlspecialchars($tarefa['titulo']) ?></td>
                <td><?= htmlspecialchars($tarefa['descricao']) ?></td>
                <td><?= date('d/m/Y H:i', strtotime($tarefa['data_hora'])) ?></td>
                <td><?= ucfirst($tarefa['frequencia']) ?></td>
                <td><?= ucfirst($tarefa['prioridade']) ?></td>
                <td>
                    <!-- Editar -->
                    <a href="editar_tarefa.php?id=<?= $tarefa['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                    <!-- Marcar como concluída -->
                    <?php if ($tarefa['status'] != 'concluída'): ?>
                        <a href="?concluir=<?= $tarefa['id'] ?>" class="btn btn-success btn-sm">Concluir</a>
                    <?php else: ?>
                        <span class="text-success">Concluída</span>
                    <?php endif; ?>
                    <!-- Excluir -->
                    <a href="?delete=<?= $tarefa['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Você tem certeza que deseja excluir esta tarefa?')">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="painel.html" class="btn btn-danger w-30 mt-3">Painel</a>

</div>

<?php
function getCorPrioridade($prioridade) {
    switch ($prioridade) {
        case 'baixa': return '#90EE90'; // Verde
        case 'media': return '#FFD700'; // Amarelo
        case 'alta': return '#FF6347'; // Vermelho
    }
}
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
