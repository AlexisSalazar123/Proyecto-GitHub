<?php
session_start();

session_destroy();
//se destruye la sesión iniciada y redirige a login
header('Location: ../Login/index.php');
?>