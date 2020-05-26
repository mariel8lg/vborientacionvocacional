<?php session_start();
//Alejandra Olais

//Destruye toda la información registrada de una sesión 
session_destroy();
$_SESSION = array();

//Después de destruir dicha información, redirigimos a la página de login 
header('Location: login.php');
die();

?>