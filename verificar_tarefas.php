<?php
header('Content-Type: application/json');
require 'db.php';

try {
    // Buscar tarefas não concluídas para as próximas 24 horas
    $sql = "SELECT id, titulo, data_hora, status 
            FROM tarefas 
            WHERE status != 'concluída' 
            AND data_hora BETWEEN NOW() 
            AND DATE_ADD(NOW(), INTERVAL 24 HOUR)
            ORDER BY data_hora ASC";
    
    $stmt = $pdo->query($sql);
    $tarefas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($tarefas);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>