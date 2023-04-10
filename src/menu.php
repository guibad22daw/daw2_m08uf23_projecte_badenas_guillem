<?php
	error_reporting(0);
	session_start();
	if (!isset($_SESSION['usuari'])) {
		header("Location: errors/error_acces.php");
	} else if (!isset($_SESSION['expira']) || (time() - $_SESSION['expira'] >= 0)) {
		header("Location: errors/logout_expira_sessio.php");
	} else if (isset($_POST['logout'])) {
		$cookie_sessio = session_get_cookie_params();
		setcookie("PHPSESSID", "", time() - 3600, $cookie_sessio['path'], $cookie_sessio['domain'], $cookie_sessio['secure'], $cookie_sessio['httponly']);
		session_destroy();
		header("Location: index.php");
	}
?>
<html>

<head>
	<title>
		Menú principal - Gestió LDAP
	</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
		integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="css/menu.css">
</head>

<body>
	<h2 class="titol">Menú principal</h2>
	<div class="card-group">
		<div class="card">
			<img class="card-img-top" src="assets/img/vis_usuaris.webp" alt="Card image cap">
			<div class="card-body">
				<h5 class="card-title">Visualitzar dades</h5>
				<p class="card-text">Visualitzacio de les dades d'un usuari.</p>
				<a href="visualitzar_usuari.php" class="btn btn-light">Anar</a>
			</div>
		</div>
		<div class="card">
			<img class="card-img-top" src="assets/img/afegir_usuari.jpg" alt="Card image cap">
			<div class="card-body">
				<h5 class="card-title">Afegir usuari</h5>
				<p class="card-text">Creació d'un nou usuari a la base de dades LDAP.</p>
				<a href="afegir_usuari.php" class="btn btn-light">Anar</a>
			</div>
		</div>
	</div>
	<div class="card-group">
		<div class="card">
			<img class="card-img-top" src="assets/img/modificar_usuari.png" alt="Card image cap">
			<div class="card-body">
				<h5 class="card-title">Modificar usuari</h5>
				<p class="card-text">Modificació de les dades d'un usuari de la base de dades LDAP.</p>
				<a href="modificar_usuari.php" class="btn btn-light">Anar</a>
			</div>
		</div>
		<div class="card">
			<img class="card-img-top" src="assets/img/esborra_usuaris.png" alt="Card image cap">
			<div class="card-body">
				<h5 class="card-title">Esborrar usuari</h5>
				<p class="card-text">Esborrament d'un usuari de la base de dades LDAP.</p>
				<a href="esborrar_usuari.php" class="btn btn-light">Anar</a>
			</div>
		</div>
	</div>
	<br><br>
	<form action="menu.php" method="POST">
		<div class="boto"> 
			<button type="submit" class="btn btn-danger" name="logout">Finalitza la sessió</button></a>
		</div>
	</form>
	<br>
</body>

</html>