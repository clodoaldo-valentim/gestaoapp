
<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "gestao";
$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);
if (!$conexao) {
    die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
  }

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$telefone = $_POST['telefone'];
// Verificando se os dados já existem
$consulta = "SELECT * FROM cadastros WHERE nome = '$nome' AND senha = '$senha'";
$result = mysqli_query($conexao, $consulta);
if (mysqli_num_rows($result) > 0) {
    // Exibir dados existentes
    $dados = mysqli_fetch_assoc($result);
    echo "Nome: " . $dados['nome'] . "<br>";
    echo "Email: " . $dados['email'] . "<br>";
    echo "Senha: " . $dados['senha'] . "<br>";
    echo "Telefone: " . $dados['telefone'] . "<br>";
    echo "<h1>Dados já cadastrados.</h1>";
}else{
$inserir = "INSERT INTO cadastros(nome, email, senha, telefone)VALUES('$nome','$email','$senha','$telefone')";
    if (mysqli_query($conexao, $inserir)) {
        echo "<h1>Cadastrado com sucesso!!"."<br>";
        echo '<a href="painel.html" class="btn btn-danger">Painel</a>'.'<br>';
    }
    else {
        echo "<h1>Erro ao cadastrar</h1>" . mysqli_error($conn);
        echo '<a href="painel.html" class="btn btn-danger">Painel</a>'.'<br>';
    }
}
   // Fechar a conexão com o banco de dados
   mysqli_close($conexao);
?>
</body>
</html>