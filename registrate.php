<?php session_start();
//Ricardo Morales

// Funcion con la cual  va seguida de index.php y te mueve a esta pagina de registrate.php
if (isset($_SESSION['usuario'])) {
	header('Location: index.php');
	die();
}

// Se guardan las contraseñas de registrateview.php
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$usuario = str_replace(' ','' , filter_var(strtolower($_POST['usuario']), FILTER_SANITIZE_STRING));
	$password = $_POST['password'];
	$password2 = $_POST['password2'];

	$errores = '';

	//Validaciones para poder llevar a acabo este proceso de registrate.php y no se quede ningun campo vacio
	if (empty($usuario) or empty($password) or empty($password2)) {
		$errores = '<li>Por favor rellena todos los datos correctamente</li>';
	} else {

		//Comprueba que la conexion este correcta con la base de datos
		try {
			$conexion = new PDO('mysql:host=localhost;dbname=login_practica', 'root', '');
		} catch (PDOException $e) {
			echo "Error:" . $e->getMessage();
		}

		//Comprueba que todo este correcto y solo haya un usuario
		$statement = $conexion->prepare('SELECT * FROM usuarios WHERE usuario = :usuario LIMIT 1');
		$statement->execute(array(':usuario' => $usuario));

		$resultado = $statement->fetch();
		
		// Se crea validación la cual hara que no se repitan los usuarios
		if ($resultado != false) {
			$errores .= '<li>El nombre de usuario ya existe</li>';
		}

		//Se ponen contraseñas para poder seguir con el proceso
		$password = hash('sha512', $password);
		$password2 = hash('sha512', $password2);

		//Se crea validación para que las contraseñas sean iguales
		if ($password != $password2) {
			$errores.= '<li>Las contraseñas no son iguales</li>';
		}
	}

	//Se comprueba que no haya ningun error, en caso de haberlo te lo mostrara en pantalla
	if ($errores == '') {
		$statement = $conexion->prepare('INSERT INTO usuarios (id, usuario, pass) VALUES (null, :usuario, :pass)');
		$statement->execute(array(
				':usuario' => $usuario,
				':pass' => $password
			));

		header('Location: login.php');
	}
}

require 'views/registrate.view.php';
?>