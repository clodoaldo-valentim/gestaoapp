<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão Financeira</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }
        .card:hover {
            transform: scale(1.02);
        }
        .btn-primary {
            background-color: #0d6efd;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0b5ed7;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Gestão Financeira</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link active" href="#">Início</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contas">Contas a Pagar/Receber</a></li>
                    <li class="nav-item"><a class="nav-link" href="#fluxo">Fluxo de Caixa</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        <!-- Seção de Contas a Pagar/Receber -->
        <div id="contas" class="mb-5">
            <h2 class="text-primary">Controle de Contas a Pagar e a Receber</h2>
            <form action="add_conta.php" method="post" class="row g-3">
                <div class="col-md-4">
                    <label for="descricao" class="form-label">Descrição</label>
                    <input type="text" class="form-control" id="descricao" name="descricao" required>
                </div>
                <div class="col-md-3">
                    <label for="tipo" class="form-label">Tipo</label>
                    <select class="form-select" id="tipo" name="tipo" required>
                        <option value="receber">Receber</option>
                        <option value="pagar">Pagar</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="valor" class="form-label">Valor</label>
                    <input type="number" class="form-control" id="valor" name="valor" required step="0.01">
                </div>
                <div class="col-md-2">
                    <label for="vencimento" class="form-label">Data de Vencimento</label>
                    <input type="date" class="form-control" id="vencimento" name="vencimento" required>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Adicionar</button>
                </div>
            </form>
        </div>

        <!-- Seção de Fluxo de Caixa -->
        <div id="fluxo" class="mb-5">
            <h2 class="text-primary">Fluxo de Caixa</h2>
            <form action="fluxo_caixa.php" method="get" class="row g-3">
                <div class="col-md-6">
                    <label for="data_inicial" class="form-label">Data Inicial</label>
                    <input type="date" class="form-control" id="data_inicial" name="data_inicial" required>
                </div>
                <div class="col-md-6">
                    <label for="data_final" class="form-label">Data Final</label>
                    <input type="date" class="form-control" id="data_final" name="data_final" required>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Gerar Relatório</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
