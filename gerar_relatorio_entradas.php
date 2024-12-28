<?php
ob_start();

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
$sql = "SELECT * FROM entradas WHERE MONTH(data) = ? AND YEAR(data) = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $mes, $ano);
$stmt->execute();
$resultado = $stmt->get_result();

// Configurar o PDF
class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Relatorio de Entradas do Mes', 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
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

// Cabeçalho da tabela com preenchimento
$pdf->Cell(15, 10, 'ID', 1, 0, 'C', true);
$pdf->Cell(60, 10, 'Detalhe', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Valor', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Data', 1, 0, 'C', true);
$pdf->Cell(35, 10, 'Mes', 1, 1, 'C', true);

// Resetando a cor do texto para preto para os dados
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 10);

while ($row = $resultado->fetch_assoc()) {
    $pdf->Cell(15, 10, $row['id'], 1, 0, 'C');
    $pdf->Cell(60, 10, substr($row['detalhes'], 0, 30), 1, 0);
    $pdf->Cell(40, 10, 'R$ ' . number_format($row['valor'], 2, ',', '.'), 1, 0);
    $pdf->Cell(40, 10, date('d/m/Y', strtotime($row['data'])), 1, 0, 'C');
    $pdf->Cell(35, 10, date('m', strtotime($row['data'])), 1, 1, 'C');
}

// Saída do PDF
$pdf->Output();

// Fecha a conexão
$conn->close();
?>