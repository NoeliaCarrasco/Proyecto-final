<?php
require('./pdf/fpdf.php');
require('db_configuration.php');
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(4, 10, '', 0);
$pdf->Image('./assets/images/logo-dark.png' , 10 ,9.5, 40, 30,'png');
$pdf->Cell(150,8,'',0);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(50, 10, 'Fecha: '.date('d-m-Y').'', 0);
$pdf->Ln(18);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(70, 8, '', 0);
$pdf->Cell(100, 8, 'USUARIOS TIENDA NOELIA', 0);
$pdf->Ln(13);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(38, 8, 'IDUSUARIO', 1,0,"C");
$pdf->Cell(38, 8, 'NOMBRE', 1,0,"C");
$pdf->Cell(38, 8, 'APELLIDO', 1,0,"C");
$pdf->Cell(38, 8, 'TIPO', 1,0,"C");
$pdf->Cell(38, 8, 'USUARIO', 1,0,"C");
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);
//CONSULTA
$consulta="SELECT IDUSUARIO,NOMBRE,APELLIDO,TIPO,USUARIO FROM usuarios";
$result = $connection->query($consulta);
$totalli = 0;
$total = 0;
while($fila = $result->fetch_object()){
    $pdf->Cell(38, 8,$fila->IDUSUARIO, 1,0, "C");
	$pdf->Cell(38, 8,$fila->NOMBRE, 1,0, "C");
	$pdf->Cell(38, 8,$fila->APELLIDO, 1,0, "C");
    $pdf->Cell(38, 8,$fila->TIPO, 1,0, "C");
    $pdf->Cell(38, 8,$fila->USUARIO, 1,0, "C");
	$pdf->Ln(8);
}
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Output();
?>