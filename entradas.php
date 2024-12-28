<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Entradas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <style>
        body {
            background-color: #F0FFF0;
            font-family: Arial, sans-serif;
            line-height: 1.5;
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
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
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
        $servidor = "localhost";
        $usuario = "root";
        $senha = "";
        $banco = "construcao";
        $conexao = mysqli_connect($servidor, $usuario, $senha, $banco);
        if (!$conexao) {
            die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
        }

        $detalhe = $_POST['detalhe'];
        $valor = $_POST['valor'];
        $data = $_POST['data'];
        $mes = $_POST['mes'];

        // Verificando se os dados já existem
        $inserir = "INSERT INTO entradas(detalhes, valor, data, mes) VALUES ('$detalhe', '$valor', '$data', '$mes')";
        if (mysqli_query($conexao, $inserir)) {
            echo "<h1 class='text-success'>Dados cadastrados com sucesso!</h1>";
            echo '<a href="painel.html" class="btn btn-primary mt-3">Painel</a>';
        } else {
            echo "<h1 class='text-danger'>Erro ao cadastrar</h1>" . mysqli_error($conexao);
            echo '<a href="painel.html" class="btn btn-danger mt-3">Painel</a>';
        }
        // Fechar a conexão com o banco de dados
        mysqli_close($conexao);
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
