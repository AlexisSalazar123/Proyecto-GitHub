<?php
require_once('../tcpdf/tcpdf.php'); //Llamando a la Libreria TCPDF
include('../conexion.php');
date_default_timezone_set('America/Bogota');


ob_end_clean(); //limpiar la memoria


class MYPDF extends TCPDF{
    
    	public function Header() {
            if($this->PageNo() == 1){
                $bMargin = $this->getBreakMargin();
                $auto_page_break = $this->AutoPageBreak;
                $this->SetAutoPageBreak(false, 0);
                $img_file = dirname( __FILE__ ) .'/logo.jpg';
                $this->Image($img_file, 13, 16, 85, 37, '', '', '', false, 30, '', false, false, 0);
                $this->SetAutoPageBreak($auto_page_break, $bMargin);
                $this->setPageMark();
            }
	    }
}


//Iniciando un nuevo pdf
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, 'mm', 'Letter', true, 'UTF-8', false);
 
//Establecer margenes del PDF
$pdf->SetMargins(20, 35, 25);
$pdf->SetHeaderMargin(20);
$pdf->setPrintFooter(false);
$pdf->setPrintHeader(true); //Eliminar la linea superior del PDF por defecto
$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM); //Activa o desactiva el modo de salto de página automático
 
//Informacion del PDF
$pdf->SetCreator('ProyectoAnálisis');
$pdf->SetAuthor('ProyectoAnálisis');
$pdf->SetTitle('Informe de Ventas');

$fechaInit = isset($_GET['fechaIngreso']) ? $_GET['fechaIngreso'] : '';
$fechaFin = isset($_GET['fechaFin']) ? $_GET['fechaFin'] : '';

$fechaInicio = date('d-m-Y', strtotime($fechaInit));
$fechaFinF = date('d-m-Y', strtotime($fechaFin));

//Agregando la primera página
$pdf->AddPage();
$pdf->SetFont('helvetica','B',10); //Tipo de fuente y tamaño de letra

$pdf->SetXY(105, 14);
$pdf->SetFillColor(232,232,232);
$pdf->SetFont('helvetica','B',16); //La B es para letras en Negritas
$pdf->Cell(90,10,'Reporte de Ventas',1,0,'C',1);
$pdf->SetXY(105, 24);
$pdf->SetFont('helvetica','B',12); 
$pdf->Cell(90,9,$fechaInicio.' a '.$fechaFinF,1,0,'C');
$pdf->SetXY(105, 33);
$codigoAleatorio = sprintf('Código: %04d%s%s%s', rand(0, 9999), chr(rand(65, 90)), chr(rand(65, 90)), chr(rand(65, 90)));
$pdf->Cell(90, 7, $codigoAleatorio, 1, 0, 'C');
$pdf->SetXY(105, 40);
$pdf->Cell(90, 7, 'Fecha: ' . date('d-m-Y'), 1, 0, 'C');
$pdf->SetXY(105, 47);
$pdf->Cell(90, 7, 'Hora: ' . date('h:i A'), 1, 0, 'C');


$pdf->Ln(35); //Salto de Linea
$pdf->Cell(40,26,'',0,0,'C');
$pdf->SetFont('helvetica','B', 15); 
$pdf->SetXY(54, 80);
$pdf->Cell(100,6,'LISTA DE VENTAS',0,0,'C');


$pdf->Ln(10); //Salto de Linea
$pdf->SetTextColor(0, 0, 0); 

//Almando la cabecera de la Tabla
$pdf->SetXY(8, 100);
$pdf->SetFillColor(232,232,232);
$pdf->SetFont('helvetica','B',12); //La B es para letras en Negritas
$pdf->Cell(18,10,'Número',1,0,'C',1);
$pdf->Cell(40,10,'Nombre Cliente',1,0,'C',1);
$pdf->Cell(50,10,'Producto',1,0,'C',1);
$pdf->Cell(21,10,'Cantidad',1,0,'C',1);
$pdf->Cell(38,10,'Total',1,0,'C',1);
$pdf->Cell(30,10,'Fecha',1,1,'C',1); 

$pdf->SetXY(14, 110);
$pdf->SetFont('helvetica','',14);

$sqlProduccion = ("SELECT *,
            (SELECT nombre FROM productos
            WHERE productos.id_productos=ventas.nombre_producto limit 1)as producto, 
            (SELECT nombre FROM clientes
            WHERE clientes.id_cliente=ventas.nombre_cliente limit 1)as Ncliente 
            FROM ventas WHERE (fecha>='$fechaInit 00:00:00' and fecha <= '$fechaFin 23:59:59') ORDER BY fecha ASC");
$query = mysqli_query($con, $sqlProduccion);

while ($dataRow = mysqli_fetch_array($query)) {
        $pdf->SetX(8);
        $pdf->Cell(18,8,($dataRow['id_ventas']),1,0,'C');
        $pdf->Cell(40,8,$dataRow['producto'],1,0,'C');
        $pdf->Cell(50,8,$dataRow['Ncliente'],1,0,'C');
        $pdf->Cell(21,8,$dataRow['cantidad'],1,0,'C');
        $pdf->Cell(38,8,$dataRow['total'],1,0,'C');
        $pdf->Cell(30,8,(date('m-d-Y', strtotime($dataRow['fecha']))),1,1,'C');
}

$pdf->Ln(10); //Salto de Linea
$pdf->SetTextColor(0, 0, 0);

$pdf->AddPage();

//Almando la cabecera de la Tabla
$pdf->SetXY(14, 200);
$pdf->SetFillColor(232,232,232);
$pdf->SetXY(40, 16);
$pdf->Cell(20,26,'',0,0,'C');
$pdf->SetFont('helvetica','B', 15); 
$pdf->Cell(93,6,'INFORME FINAL',0,0,'C');
$pdf->SetFont('helvetica','B',12); //La B es para letras en Negritas
$pdf->SetXY(25, $pdf->GetY() + 20);
$pdf->Cell(80,10,'Producto',1,0,'C',1);
$pdf->Cell(80,10,'Cantidad',1,0,'C',1);



$query = "SELECT productos.nombre, 
        SUM(ventas.cantidad) as total_cantidad
        FROM productos
        JOIN ventas ON productos.id_productos = ventas.nombre_producto
        WHERE ventas.fecha >= '$fechaInit 00:00:00' AND ventas.fecha <= '$fechaFin 23:59:59'
        GROUP BY productos.nombre
        ORDER BY productos.nombre";

$pdf->SetXY(25, $pdf->GetY() + 10);
$pdf->SetFont('helvetica','',14);
$result = mysqli_query($con, $query);

$totalGeneral = 0;

while ($dataRow = mysqli_fetch_array($result)) {
    $pdf->Cell(80,8,($dataRow['nombre']), 1, 0, 'C');
    $pdf->Cell(80,8,($dataRow['total_cantidad']), 1, 0, 'C');
    $pdf->Ln(8); //Salto de Linea
    $pdf->SetX(25);
    $totalGeneral += ($dataRow['total_cantidad']); // Sumar la cantidad al total general
}

$pdf->SetXY(105, $pdf->GetY());
$pdf->Cell(80,10,'Total: '.$totalGeneral,1,0,'C',1);


$pdf->Output('Reporte_Ventas_PDF_'.date('d_m_y').'.pdf', 'I'); 

// Después de generar el PDF, redirigir a busqueda.php

