<?php
require 'db.php';

$agora = date('Y-m-d H:i:s');
$sql = "SELECT * FROM tarefas WHERE data_hora BETWEEN :agora AND DATE_ADD(:agora, INTERVAL 1 DAY)";
$stmt = $pdo->prepare($sql);
$stmt->execute([':agora' => $agora]);
$tarefas = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($tarefas as $tarefa) {
    $tempoRestante = strtotime($tarefa['data_hora']) - time();

    // Lembrete 1 dia antes
    if ($tempoRestante <= 86400 && $tempoRestante > 85500) { 
        echo "📢 Lembrete: A tarefa '{$tarefa['titulo']}' está programada para " . date('d/m/Y H:i', strtotime($tarefa['data_hora'])) . ".<br>";
    }

    // Lembrete 30 minutos antes
    if ($tempoRestante <= 1800 && $tempoRestante > 1700) { 
        echo "⏰ Alerta: A tarefa '{$tarefa['titulo']}' será realizada em 30 minutos.<br>";
    }
}
?>
