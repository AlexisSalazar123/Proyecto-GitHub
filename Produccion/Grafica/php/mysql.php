<?php
include 'config.php';

class MySQL{
    private $oConBD = null;

    public function __construct(){
        global $usuarioBD, $passBD, $ipBD, $nombreBD;
        $this->usuarioBD = $usuarioBD;
        $this->passBD = $passBD;
        $this->ipBD = $ipBD;
        $this->nombreBD = $nombreBD;
    }

    public function conBDPDO()
    {
        try{
            $this->oConBD = new PDO("mysql:host=" . $this->ipBD . ";dbname=" . $this->nombreBD, $this->usuarioBD, $this->passBD);
            return true;
        } catch (PDOException $e){
            echo "Error al conectar a la base de datos: " . $e->getMessage() . "\n";
            return false;
        }
    }

    public function getDatosGrafica(){
        $jDatos='';
        $rawdata = array();
        $i = 0;
    
        try{
            $strQuery = "SELECT sum(cantidad)as tcantidad,DATE_FORMAT(fecha, '%Y-%m')as fecha FROM produccion GROUP BY DATE_FORMAT(fecha, '%Y-%m')";
            if ($this->conBDPDO()){
                $pQuery = $this->oConBD->prepare($strQuery);
                $pQuery->execute();
                $pQuery->setFetchMode(PDO::FETCH_ASSOC);

                while($produccion = $pQuery->fetch()){
                    $oGrafica = new Grafica();
                    $oGrafica->totalProduccion = $produccion['tcantidad'];
                    $oGrafica->fechaVenta = $produccion['fecha'];
                    $rawdata[$i] = $oGrafica;
                    $i++;
                }
                $jDatos = json_encode($rawdata);
    
            }
        } catch (PDOException $e){
            echo "MYSQL.getDatosGrafica: " . $e->getMessage() . "\n";
            return -1;
        }
        return $jDatos;
    }
}

class Grafica{
   public $totalProduccion = 0;
   public $fechaVenta = 0;
}
?>