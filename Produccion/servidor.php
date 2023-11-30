<?php

 include './function.php';
 include('../conexion.php');
 $oMysql = new Grafica();

 $response="";
 $rq = $_POST['rq'];

 if($rq == 4){
    $response = $oMysql . getDatosGrafica();
 }

 echo $response;
?>