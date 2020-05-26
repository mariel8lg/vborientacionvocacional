<?php session_start();
//Alejandra Olais 
// Comprobamos tenga sesion, si no entonces redirigimos y matamos la ejecución de la página
if(isset($_SESSION['usuario'])) {
	header('Location: inicio.html');
	die();
} else {
	// Enviamos al usuario al formulario de registro
	header('Location: registrate.php');
}

?>