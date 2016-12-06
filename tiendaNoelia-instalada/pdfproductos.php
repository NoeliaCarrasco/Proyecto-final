<?php
require('./pdf/fpdf.php');
require('db_configuration.php');
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(4, 10, '', 0);
$pdf->Image('./assets/images/logo-dark.png' , 10 ,9.5, 12 , 12,'png');
$pdf->Cell(10,8,'',0);
$pdf->Cell(150, 10, 'Deportes Noelia', 0);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(50, 10, 'Fecha: '.date('d-m-Y').'', 0);
$pdf->Ln(18);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(70, 8, '', 0);
$pdf->Cell(100, 8, 'USUARIOS TIENDA NOELIA', 0);
$pdf->Ln(13);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(60, 8, 'NOMBRE', 1,0,"C");
$pdf->Cell(60, 8, 'PRECIO', 1,0,"C");
$pdf->Cell(60, 8, 'STOCK', 1,0,"C");
$pdf->Cell(60, 8, 'FOTO', 1,0,"C");
$pdf->Cell(60, 8, 'IDCATEGORIA', 1,0,"C");
$pdf->Cell(60, 8, 'DESCRIPCION', 1,0,"C");
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);
//CONSULTA
$consulta="SELECT * FROM productos,categorias WHERE productos.IDCATEGORIA=categorias.IDCATEGORIA";
$result = $connection->query($consulta);
$totalli = 0;
$total = 0;
while($fila = $result->fetch_object()){
	$pdf->Cell(60, 8,$fila->IDPRODUCTO, 1,0,"C");
	$pdf->Cell(60, 8,$fila->NOMBRE, 1,0,"C");
	$pdf->Cell(60, 8,$fila->PRECIO." E",1,0,"C");
    $pdf->Cell(60, 8,$fila->STOCK." E",1,0,"C");
    $pdf->Cell(60, 8,$fila->FOTO, 1,0,"C");
    $pdf->Cell(60, 8,$fila->IDCATEGORIA, 1,0,"C");
    $pdf->Cell(60, 8,$fila->DESCRIPCION, 1,0,"C");
	$pdf->Ln(8);
}
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Output();
?>