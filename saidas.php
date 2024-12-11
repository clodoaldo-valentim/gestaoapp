<?php
include 'db.php';  // Certifique-se de que o db.php contém a variável $pdo

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validação e sanitização dos dados
    $detalhe = strip_tags($_POST['detalhe']);
    $responsavel = strip_tags($_POST['responsavel']);
    
    $data = $_POST['data'];
    if (!DateTime::createFromFormat('Y-m-d', $data)) {
        die("<h1 class='text-danger'>Data inválida</h1>");
    }
    $data = DateTime::createFromFormat('Y-m-d', $data)->format('Y-m-d');
    
    $categoria = strip_tags($_POST['categoria']);
    $mes = strip_tags($_POST['mes']);
    $situacao = strip_tags($_POST['situacao']);
    
    $valor = $_POST['valor'];
    if (!is_numeric($valor) || $valor <= 0) {
        die("<h1 class='text-danger'>Valor inválido</h1>");
    }

    // Usando PDO para inserir os dados
    try {
        $sql = "INSERT INTO saidas (detalhes, responsavel, data, categoria, mes, situacao, valor) 
                VALUES (:detalhe, :responsavel, :data, :categoria, :mes, :situacao, :valor)";
        
        $stmt = $pdo->prepare($sql);

        // Vinculando os parâmetros
        $stmt->bindParam(':detalhe', $detalhe);
        $stmt->bindParam(':responsavel', $responsavel);
        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->bindParam(':mes', $mes);
        $stmt->bindParam(':situacao', $situacao);
        $stmt->bindParam(':valor', $valor, PDO::PARAM_STR);

        // Executando a query
        $stmt->execute();

        echo "<h1 class='text-success'>Dados cadastrados com sucesso!</h1>";
        echo '<a href="painel.html" class="btn btn-primary mt-3">Painel</a>';
    } catch (PDOException $e) {
        echo "<h1 class='text-danger'>Erro ao cadastrar os dados: " . $e->getMessage() . "</h1>";
    }
} else {
    echo "<h1 class='text-danger'>Método inválido</h1>";
}
?>
