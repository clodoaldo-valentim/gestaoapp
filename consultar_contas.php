<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
 <!--menu-->
 <nav class="navbar navbar-expand-lg bg-white shadow-sm">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">CS Construções</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
        aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
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
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
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
<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "construcao";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Consulta de contas
$query = "SELECT * FROM contas ORDER BY vencimento";
$result = $conn->query($query);

// Exibição dos resultados
echo "<br><br>";
echo "<h2>Contas a Pagar e a Receber</h2>";
echo "<table class='table table-hover table-bordered'>";
echo "<thead class='table-dark'>";
echo "<tr><th>ID</th><th>Descrição</th><th>Tipo</th><th>Valor</th><th>Vencimento</th></tr>";
echo "</thead>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['descricao']}</td>
            <td>{$row['tipo']}</td>
            <td>R$ " . number_format($row['valor'], 2, ',', '.') . "</td>
            <td>" . date("d/m/Y", strtotime($row['vencimento'])) . "</td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='5'>Nenhuma conta cadastrada.</td></tr>";
}
echo "</table>";

$conn->close();
?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>