<?php
	# Incluyendo librerias necesarias #
    require "./code128.php";
    include('../../conexion.php');

    #Id envia si llego y guardado de id en ventas
    if(isset($_GET['id'])){
        $id_ventas= $_GET['id'];
    }

    $pdf = new PDF_Code128('P','mm',array(80,258));
    $pdf->SetMargins(4,10,4);
    $pdf->AddPage();
    
    # Encabezado y datos de la empresa #
    $pdf->SetFont('Arial','B',10);
    $pdf->SetTextColor(0,0,0);
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1",strtoupper("El Berriondo")),0,'C',false);
    $pdf->SetFont('Arial','',9);
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","RUC: 0000000000"),0,'C',false);
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Direccion Urrao, Colombia"),0,'C',false);
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Teléfono: 00000000"),0,'C',false);
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Email: elberriondo@gmail.com"),0,'C',false);

    $pdf->Ln(1);
    $pdf->Cell(0,5,iconv("UTF-8", "ISO-8859-1","------------------------------------------------------"),0,0,'C');
    $pdf->Ln(5);

    #------ LA FECHA Y DEMAS ------
    #Busqueda de fecha y verificacion
    $busqueda_fecha = "SELECT fecha 
                       FROM ventas  
                       WHERE id_ventas=$id_ventas";
    $resultado = mysqli_query($con, $busqueda_fecha);

    // Recuperar la fila de resultados
    $fila = mysqli_fetch_assoc($resultado);

    if($fila){
        $horafecha = $fila['fecha'];
    }
    
    #Imprimir fecha
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Fecha: ".$horafecha),0,'C',false);
    #---------
    
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Caja Nro: 1"),0,'C',false);
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Cajero: Carlos Alfaro"),0,'C',false);
    $pdf->SetFont('Arial','B',10);

    #------ Modificacion de numero ticket ------
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1",strtoupper("Ticket Nro: ".$id_ventas)),0,'C',false);
    #----------
    $pdf->SetFont('Arial','',9);

    $pdf->Ln(1);
    $pdf->Cell(0,5,iconv("UTF-8", "ISO-8859-1","------------------------------------------------------"),0,0,'C');
    $pdf->Ln(5);

    #-----Modificacion nombre cliente -------
    $consulta_ventas= "SELECT ventas.nombre_cliente, clientes.nombre 
                         FROM ventas 
                         JOIN clientes ON ventas.nombre_cliente = clientes.id_cliente
                         WHERE ventas.id_ventas = '$id_ventas' ";
    $resultado_ventas= mysqli_query($con, $consulta_ventas);

    if ($resultado_ventas) {
        while ($fila = mysqli_fetch_assoc($resultado_ventas)) {
         $nombre_cliente = $fila['nombre'];
        }
    } 

    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Cliente: " . $nombre_cliente),0,'C',false);
    #----------------

    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Documento: DNI 00000000"),0,'C',false);
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Teléfono: 00000000"),0,'C',false);
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Dirección: Rionegro, Antioquia"),0,'C',false);

    $pdf->Ln(1);
    $pdf->Cell(0,5,iconv("UTF-8", "ISO-8859-1","-------------------------------------------------------------------"),0,0,'C');
    $pdf->Ln(3);

    # Tabla de productos #
    $pdf->Cell(10,5,iconv("UTF-8", "ISO-8859-1","Cant."),0,0,'C');
    $pdf->Cell(19,5,iconv("UTF-8", "ISO-8859-1","Producto"),0,0,'C');
    $pdf->Cell(28,5,iconv("UTF-8", "ISO-8859-1","Total"),0,0,'C');

    $pdf->Ln(3);
    $pdf->Cell(72,5,iconv("UTF-8", "ISO-8859-1","-------------------------------------------------------------------"),0,0,'C');
    $pdf->Ln(5);



    /*----------  Detalles de la tabla  ----------*/
    #---- PRODUCTOS A VENDER --------

    #----Moodificacion cantidad producto
    $consulta_cantidad= "SELECT cantidad
                         FROM ventas
                         WHERE ventas.id_ventas = '$id_ventas' ";
    $resultado_cantidad= mysqli_query($con, $consulta_cantidad); 

    if ($resultado_cantidad) {
        while ($fila = mysqli_fetch_assoc($resultado_cantidad)) {
         $cantidad = $fila['cantidad'];
        }
    }

    $pdf->Cell(10,4,iconv("UTF-8", "ISO-8859-1",$cantidad),0,0,'C');

    #--------------------------

    #-----Modificacion nombre producto -------
     $consulta_producuto= "SELECT ventas.nombre_producto, productos.nombre
                         FROM productos
                         JOIN ventas ON productos.id_productos = ventas.nombre_producto
                         WHERE ventas.id_ventas = '$id_ventas' ";
    $resultado_producto= mysqli_query($con, $consulta_producuto); 

    if ($resultado_producto) {
        while ($fila = mysqli_fetch_assoc($resultado_producto)) {
         $nombre_producto = $fila['nombre'];
        }
    } 
    $pdf->Cell(19,4,iconv("UTF-8", "ISO-8859-1",$nombre_producto),0,0,'C');
    # -----------------------------


    #--- Modificacion de precio ----
    $consulta_precio= "SELECT productos.precio, ventas.total
                         FROM productos
                         JOIN ventas ON productos.id_productos = ventas.nombre_producto
                         WHERE ventas.id_ventas = '$id_ventas' ";
    $resultado_precio= mysqli_query($con, $consulta_precio); 

    if ($resultado_precio) {
        while ($fila = mysqli_fetch_assoc($resultado_precio)) {
         $precio_arepa = $fila['precio'];
        }
    }

    #Con el precio de la arepa usamos la cantidad y multiplicamos
    $precio_total= $cantidad * $precio_arepa;


    $pdf->Cell(28,4,iconv("UTF-8", "ISO-8859-1", $precio_total),0,0,'C');

    #--------------------

    $pdf->Ln(5);
    
    /*----------  Fin Detalles de la tabla  ----------*/

    $pdf->Cell(72,5,iconv("UTF-8", "ISO-8859-1","-------------------------------------------------------------------"),0,0,'C');

    $pdf->Ln(5);

    $pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
    $pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1","TOTAL A PAGAR"),0,0,'C');
    $pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1",$precio_total),0,0,'C');

    $pdf->Ln(10);

    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","*** Precios de productos incluyen impuestos. Para poder realizar un reclamo o devolución debe de presentar este ticket ***"),0,'C',false);

    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(0,7,iconv("UTF-8", "ISO-8859-1","Gracias por su compra"),'',0,'C');

    $pdf->Ln(9);

    # Codigo de barras #
    $pdf->Code128(5,$pdf->GetY(),"COD000001V0001",70,20);
    $pdf->SetXY(0,$pdf->GetY()+21);
    $pdf->SetFont('Arial','',14);
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","COD000001V0001"),0,'C',false);
    
    # Nombre del archivo PDF #
    $pdf->Output("I","Ticket_Nro_1.pdf",true);