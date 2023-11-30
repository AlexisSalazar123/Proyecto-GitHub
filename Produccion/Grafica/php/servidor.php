<?php

include './mysql.php';
$oMysql = new MySQL();

 $response="";
 $rq = $_POST['rq'];

 if($rq == 4){
    $response = $oMysql->getDatosGrafica();
 }

 echo $response;
?>
