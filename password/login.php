<?php

include('conexion.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	header('Location: index.html');
	exit();
}

$usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
$contrasena = isset($_POST['contrasena']) ? trim($_POST['contrasena']) : '';

if ($usuario === '' || $contrasena === '') {
	echo 'Usuario y contraseña son obligatorios';
	exit();
}

if (isset($link) && $link) {
	$query = 'SELECT id_users FROM users WHERE usuario_users = ? AND contrasena_users = ? LIMIT 1';
	$stmt = mysqli_prepare($link, $query);

	if (!$stmt) {
		echo 'Error al preparar la consulta';
		mysqli_close($link);
		exit();
	}

	mysqli_stmt_bind_param($stmt, 'ss', $usuario, $contrasena);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);

	if (mysqli_stmt_num_rows($stmt) > 0) {
		header('Location: netflix.html');
		mysqli_stmt_close($stmt);
		mysqli_close($link);
		exit();
	}

	mysqli_stmt_close($stmt);
	mysqli_close($link);
	echo 'Usuario o contraseña incorrectos';
	exit();
}

echo 'Error de conexión a la base de datos';
?>