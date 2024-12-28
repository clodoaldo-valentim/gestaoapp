<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>

<?php
ob_start(); // Inicia o buffer de saída

require('bibliotecas/fpdf.php');
// Configuração do banco de dados
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "construcao";

$conn = new mysqli($servidor, $usuario, $senha, $banco);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Consulta no banco de dados
$mes = $_POST['mes'] ?? date('m');
$ano = $_POST['ano'] ?? date('Y');
$sql = "SELECT * FROM saidas WHERE MONTH(data) = ? AND YEAR(data) = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $mes, $ano);
$stmt->execute();
$resultado = $stmt->get_result();

// Configurar o PDF
class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Relatorio de Saidas do Mes', 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

// Inicializa o PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('P', 'A4');
$pdf->SetFont('Arial', '', 12);

// Tabela de dados
$pdf->SetFont('Arial', 'B', 10);
// Convertendo a cor #007bff para RGB (0, 123, 255)
$pdf->SetFillColor(0, 123, 255);
// Definindo a cor do texto para branco para melhor contraste
$pdf->SetTextColor(255, 255, 255);

// Tabela de dados
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(15, 10, 'ID', 1, 0, 'C', true);
$pdf->Cell(60, 10, 'Descricao', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Data', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Valor', 1, 0, 'C', true);
$pdf->Cell(45, 10, 'Responsavel', 1, 0, 'C', true);
$pdf->Ln();

// Resetando a cor do texto para preto para os dados
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 10);

while ($row = $resultado->fetch_assoc()) {
    $pdf->Cell(15, 10, $row['id'], 1, 0, 'C');
    $pdf->Cell(60, 10, substr($row['detalhes'], 0, 30), 1);
    $pdf->Cell(30, 10, $row['data'], 1, 0, 'C');
    $pdf->Cell(30, 10, 'R$ ' . number_format($row['valor'], 2, ',', '.'), 1);
    $pdf->Cell(45, 10, $row['responsavel'], 1, 0, 'c');
    $pdf->Ln();
}

// Saída do PDF
$pdf->Output('D', 'relatorio_saidas.pdf');

// Fecha a conexão
$conn->close();
?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>