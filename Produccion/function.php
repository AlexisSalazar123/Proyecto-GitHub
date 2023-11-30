<?php  

public function getDatosGrafica(){
    $jDatos='';
    $rawdata = array();
    $i = 0;

    $strQuery = "SELECT sum(cantidad)as tcantidad,DATE_FORMAT(fecha, '%Y-%m-%d')as fecha FROM produccion GROUP BY DATE_FORMAT(fecha, '%Y-%m-%d')";

    $strQuery->execute();
    $strQuery->setFetchMode(PDO::FETCH_ASSOC);
    while($produccion = $strQuery->fetch()){
        $oGrafica = new Grafica();
        $oGrafica->$totalProduccion = $produccion['tcantidad'];
        $rawdata[$i] = $oGrafica;
        $i++;
    }
    $jDatos = json_encode($rawdata);
    return $jDatos;
}

class Grafica{
    public $totalProduccion = 0;
}
?>