<?php
require 'db.php';
// Buscar todas as tarefas
$sql = "SELECT * FROM tarefas ORDER BY data_hora ASC";
$stmt = $pdo->query($sql);
$tarefas = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
        header("Location: lista_tarefas.php"); // Redirecionar para a página principal
        exit;
    } else {
        echo "Erro ao excluir a tarefa.";
    }
}

if (isset($_GET['concluir'])) {
    $id = (int) $_GET['concluir'];
    $update_sql = "UPDATE tarefas SET status = 'concluída' WHERE id = :id";
    $stmt = $pdo->prepare($update_sql);
    $stmt->bindParam(':id', $id);
    if ($stmt->execute()) {
        header("Location: lista_tarefas.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Tarefas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" 
      integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" 
      crossorigin="anonymous" 
      rel="stylesheet">
    <style>
        /*cor da logo*/
        .navbar-brand {
      font-weight: bold;
      color: #007bff !important;
    }
          /* Estilos personalizados para melhorar a responsividade */
          .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        /* Estilos para as prioridades */
        .prioridade-baixa {
            background-color: #90EE90 !important; /* Verde */
            color: black;
            font-weight: bold;
        }
        
        .prioridade-media {
            background-color: #FFD700 !important; /* Amarelo */
            color: black;
            font-weight: bold;
        }
        
        .prioridade-alta {
            background-color: #FF6347 !important; /* Vermelho */
            color: white;
            font-weight: bold;
        }

        /* Estilo para tarefas concluídas */
        .tarefa-concluida {
            background-color: #f8f9fa;
            color: #6c757d;
            font-style: italic;
        }
        .table .btn {
        margin: 2px;
    }
        
        @media (max-width: 768px) {
            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
                margin: 2px;
            }
            
            .table td, .table th {
                padding: 0.5rem;
                font-size: 0.875rem;
            }
            
            .container {
                padding: 10px;
            }
            
            h1 {
                font-size: 1.5rem;
                margin-bottom: 1rem;
            }
        }

    </style>
    <script>
// Função para solicitar permissão de notificação
async function solicitarPermissaoNotificacao() {
    if (!("Notification" in window)) {
        console.log("Este navegador não suporta notificações");
        return;
    }

    if (Notification.permission !== "granted") {
        try {
            const permission = await Notification.requestPermission();
            if (permission === "granted") {
                registrarPushManager();
            }
        } catch (error) {
            console.error("Erro ao solicitar permissão:", error);
        }
    } else {
        registrarPushManager();
    }
}

// Função para registrar o Push Manager
async function registrarPushManager() {
    try {
        const registration = await navigator.serviceWorker.ready;
        const subscription = await registration.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: urlBase64ToUint8Array('SUA_CHAVE_PUBLICA_VAPID')
        });
        
        // Enviar a subscription para seu servidor
        await fetch('/registrar-push.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(subscription)
        });
    } catch (error) {
        console.error("Erro ao registrar push notifications:", error);
    }
}

// Função auxiliar para converter chave VAPID
function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding)
        .replace(/\-/g, '+')
        .replace(/_/g, '/');

    const rawData = window.atob(base64);
    const outputArray = new Uint8Array(rawData.length);

    for (let i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}

// Função para verificar tarefas próximas
async function verificarTarefasProximas() {
    try {
        const response = await fetch('verificar_tarefas.php');
        const tarefas = await response.json();
        
        tarefas.forEach(tarefa => {
            const agora = new Date();
            const dataTarefa = new Date(tarefa.data_hora);
            const diferencaHoras = (dataTarefa - agora) / (1000 * 60 * 60);
            const diferencaMinutos = (dataTarefa - agora) / (1000 * 60);

            if (diferencaHoras <= 24 && diferencaHoras >= 23.9) {
                enviarNotificacao(
                    "Tarefa em 24 horas",
                    `A tarefa "${tarefa.titulo}" está programada para amanhã às ${dataTarefa.toLocaleTimeString()}`
                );
            }

            if (diferencaMinutos <= 30 && diferencaMinutos >= 29) {
                enviarNotificacao(
                    "Tarefa em 30 minutos",
                    `A tarefa "${tarefa.titulo}" começará em breve!`
                );
            }
        });
    } catch (error) {
        console.error('Erro ao verificar tarefas:', error);
    }
}

// Função para enviar notificação
async function enviarNotificacao(titulo, mensagem) {
    if (Notification.permission === "granted") {
        const registration = await navigator.serviceWorker.ready;
        await registration.showNotification(titulo, {
            body: mensagem,
            icon: '/192x192.png',
            badge: '/badge-72x72.png',
            vibrate: [100, 50, 100]
        });
    }
}

// Inicializar quando a página carregar
document.addEventListener('DOMContentLoaded', function() {
    solicitarPermissaoNotificacao();
    // Verificar tarefas a cada minuto
    setInterval(verificarTarefasProximas, 60000);
    // Verificar imediatamente ao carregar a página
    verificarTarefasProximas();
});
</script>
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
    <div class="d-flex justify-content-between align-items-center mb-3"></div>
        <a href="add_tarefa.php" class="btn btn-primary btn-sm"><i class="bi bi-clipboard-plus-fill"></i> Adicionar Nova Tarefa</a><br><br>
    </div>
    <div class="table-responsive">
    <table class="table table-bordered">
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
                <td class="prioridade-<?= strtolower($tarefa['prioridade']) ?>">
                            <?= ucfirst($tarefa['prioridade']) ?>
                </td>
                <td>
                    <div class="btn-group" role="group" aria-label="Ações">
                    <!-- Editar -->
                        <a href="editar_tarefa.php?id=<?= $tarefa['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                    <!-- Marcar como concluída -->
                        <?php if ($tarefa['status'] != 'concluída'): ?>
                        <a href="?concluir=<?= $tarefa['id'] ?>" class="btn btn-success btn-sm">Concluir</a>
                        <?php else: ?>
                        <span class="btn btn-success btn-sm disabled">Ok!</span>
                        <?php endif; ?>
                    <!-- Excluir -->
                        <a href="?delete=<?= $tarefa['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Você tem certeza que deseja excluir esta tarefa?')">Excluir</a>
                    </div>
                </td>

            </tr>
        <?php endforeach; ?>
    </table>
    </div>
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
