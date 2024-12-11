<?php
require 'db.php';

// Verificar se o ID da tarefa foi passado
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID da tarefa não fornecido!";
    exit;
}

$id = (int) $_GET['id'];

// Buscar a tarefa no banco de dados
$sql = "SELECT * FROM tarefas WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$tarefa = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$tarefa) {
    echo "Tarefa não encontrada!";
    exit;
}

// Processar o envio do formulário de edição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $data_hora = $_POST['data_hora'];
    $frequencia = $_POST['frequencia'];
    $prioridade = $_POST['prioridade'];
    
    // Atualizar a tarefa no banco de dados
    $update_sql = "UPDATE tarefas SET titulo = :titulo, descricao = :descricao, data_hora = :data_hora, frequencia = :frequencia, prioridade = :prioridade WHERE id = :id";
    $stmt = $pdo->prepare($update_sql);
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':data_hora', $data_hora);
    $stmt->bindParam(':frequencia', $frequencia);
    $stmt->bindParam(':prioridade', $prioridade);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        header("Location: lista_tarefas.php"); // Redirecionar de volta para a lista
        exit;
    } else {
        echo "Erro ao atualizar a tarefa.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tarefa</title>
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
    <h1>Editar Tarefa</h1>

    <form method="POST">
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control" id="titulo" name="titulo" value="<?= htmlspecialchars($tarefa['titulo']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea class="form-control" id="descricao" name="descricao" required><?= htmlspecialchars($tarefa['descricao']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="data_hora" class="form-label">Data e Hora</label>
            <input type="datetime-local" class="form-control" id="data_hora" name="data_hora" value="<?= date('Y-m-d\TH:i', strtotime($tarefa['data_hora'])) ?>" required>
        </div>
        <div class="mb-3">
            <label for="frequencia" class="form-label">Frequência</label>
            <select class="form-control" id="frequencia" name="frequencia" required>
                <option value="diaria" <?= $tarefa['frequencia'] == 'diaria' ? 'selected' : '' ?>>Diária</option>
                <option value="semanal" <?= $tarefa['frequencia'] == 'semanal' ? 'selected' : '' ?>>Semanal</option>
                <option value="mensal" <?= $tarefa['frequencia'] == 'mensal' ? 'selected' : '' ?>>Mensal</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="prioridade" class="form-label">Prioridade</label>
            <select class="form-control" id="prioridade" name="prioridade" required>
                <option value="baixa" <?= $tarefa['prioridade'] == 'baixa' ? 'selected' : '' ?>>Baixa</option>
                <option value="media" <?= $tarefa['prioridade'] == 'media' ? 'selected' : '' ?>>Média</option>
                <option value="alta" <?= $tarefa['prioridade'] == 'alta' ? 'selected' : '' ?>>Alta</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
