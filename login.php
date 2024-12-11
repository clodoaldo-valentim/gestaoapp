<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <style>
      body {
        background-color: #f8f9fa;
        font-family: Arial, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
      }
      .container {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        width: 100%;
      }
      .btn-danger {
        background-color: #dc3545;
        border: none;
      }
      .btn-danger:hover {
        background-color: #c82333;
      }
    </style>
  </head>
  <body>
    <div class="container text-center">
      <?php
      session_start(); // Iniciar a sessão para o login

      require 'db.php'; // Incluir o arquivo de conexão PDO

      // Verifica se os dados foram enviados via POST
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          // Sanitize input to prevent SQL injection
          $nome = $_POST['nome'];
          $senha = $_POST['senha'];

          try {
              // Usando prepared statement com PDO para evitar injeção SQL
              $consulta = $pdo->prepare("SELECT * FROM cadastros WHERE nome = :nome AND senha = :senha");
              $consulta->bindParam(':nome', $nome, PDO::PARAM_STR);
              $consulta->bindParam(':senha', $senha, PDO::PARAM_STR);
              $consulta->execute();

              // Se o usuário existir, faça o login
              if ($consulta->rowCount() > 0) {
                  $usuario = $consulta->fetch(PDO::FETCH_ASSOC);

                  // Crie uma sessão para o usuário
                  $_SESSION['usuario'] = $usuario['nome'];

                  // Redirecione o usuário para a página principal
                  header('Location: painel.html');
                  exit(); // Certifique-se de que o script não continue executando após o redirecionamento
              } else {
                  echo "<h1 class='text-danger'>Dados incorretos!</h1>";
                  echo '<a href="index.html" class="btn btn-danger mt-3">Voltar</a>';
              }
          } catch (PDOException $e) {
              echo "<h1 class='text-danger'>Erro: " . $e->getMessage() . "</h1>";
          }

          // Fechar a conexão com o banco de dados
          // O PDO não precisa de close, ele fecha automaticamente
      } else {
          echo "<h1 class='text-danger'>Método inválido</h1>";
      }
      ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>
