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
                $this->Image($img_file, 15, 15, 75, 40, '', '', '', false, 30, '', false, false, 0);
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
$pdf->SetCreator('UrianViera');
$pdf->SetAuthor('UrianViera');
$pdf->SetTitle('Informe de Producción');

//SQL para consultas de producción
$fechaInit = date("Y-m-d", strtotime($_POST['fecha_ingreso']));
$fechaFin  = date("Y-m-d", strtotime($_POST['fechaFin']));

//Agregando la primera página
$pdf->AddPage();
$pdf->SetFont('helvetica','B',10); //Tipo de fuente y tamaño de letra

$pdf->SetXY(100, 14);
$pdf->SetFillColor(232,232,232);
$pdf->SetFont('helvetica','B',16); //La B es para letras en Negritas
$pdf->Cell(90,10,'Reporte de Producción',1,0,'C',1);
$pdf->SetXY(100, 24);
$pdf->SetFont('helvetica','B',12); 
$pdf->Cell(90,9,$fechaInit.' a '.$fechaFin,1,0,'C');
$pdf->SetXY(100, 33);
$pdf->Cell(90,7,'Código: 0014ASZ',1,0,'C');
$pdf->SetXY(100, 40);
$pdf->Cell(90, 7, 'Fecha: ' . date('d-m-Y'), 1, 0, 'C');
$pdf->SetXY(100, 47);
$pdf->Cell(90, 7, 'Hora: ' . date('h:i A'), 1, 0, 'C');


$pdf->Ln(35); //Salto de Linea
$pdf->Cell(40,26,'',0,0,'C');
$pdf->SetFont('helvetica','B', 15); 
$pdf->SetXY(54, 80);
$pdf->Cell(100,6,'LISTA DE PRODUCCIÓN',0,0,'C');


$pdf->Ln(10); //Salto de Linea
$pdf->SetTextColor(0, 0, 0); 

//Almando la cabecera de la Tabla
$pdf->SetXY(14, 100);
$pdf->SetFillColor(232,232,232);
$pdf->SetFont('helvetica','B',12); //La B es para letras en Negritas
$pdf->Cell(20,10,'Número',1,0,'C',1);
$pdf->Cell(30,10,'Código',1,0,'C',1);
$pdf->Cell(60,10,'Producto',1,0,'C',1);
$pdf->Cell(30,10,'Cantidad',1,0,'C',1);
$pdf->Cell(42,10,'Fecha',1,1,'C',1); 

$pdf->SetXY(14, 110);
$pdf->SetFont('helvetica','',14);

$sqlProduccion = ("SELECT *,
            (SELECT nombre FROM productos
            WHERE productos.id_productos=produccion.nombre_producto limit 1)as producto 
            FROM produccion WHERE (fecha>='$fechaInit 00:00:00' and fecha <= '$fechaFin 23:59:59') ORDER BY fecha ASC");
$query = mysqli_query($con, $sqlProduccion);

while ($dataRow = mysqli_fetch_array($query)) {
        $pdf->SetX(14);
        $pdf->Cell(20,8,($dataRow['id_produccion']),1,0,'C');
        $pdf->Cell(30,8,$dataRow['codigo_produccion'],1,0,'C');
        $pdf->Cell(60,8,$dataRow['producto'],1,0,'C');
        $pdf->Cell(30,8,$dataRow['cantidad'],1,0,'C');
        $pdf->Cell(42,8,(date('m-d-Y', strtotime($dataRow['fecha']))),1,1,'C');
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
        SUM(produccion.cantidad) as total_cantidad
        FROM productos
        JOIN produccion ON productos.id_productos = produccion.nombre_producto
        WHERE produccion.fecha >= '$fechaInit 00:00:00' AND produccion.fecha <= '$fechaFin 23:59:59'
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
$pdf->Cell(80,10,'Total '.$totalGeneral,1,0,'C',1);


$pdf->Output('Reporte_PDF_'.date('d_m_y').'.pdf', 'I'); 
