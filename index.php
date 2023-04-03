<html>

<head>
	<title>
		Pàgina inicial
	</title>
</head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
	integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
<style>
	* {
		box-sizing: border-box;
		padding: 5;
	}

	.container {
		display: flex;
		align-items: center;
		justify-content: center;
		height: 100%;
	}

	body {
		background-image: url('assets/img/data_warehouse.png');
		background-repeat: no-repeat;
		background-size: cover;
	}

	.centered-element {
		display: flex;
		flex-direction: column;
		justify-content: center;
		align-items: center;
		color: white;
	}

	.centered-element h1 {
		font-weight: bold;
		font-size: 55px;
	}
</style>

<body>
	<div class="container">
		<div class="centered-element">
			<h1> APLICACIÓ D'ACCÉS A BASES DE DADES LDAP</h1>
			<h3> Consulta, afegeix, edita i esborra usuaris de la base de dades LDAP.</h3>
			<a class="btn btn-primary" href="login.php">Inicia sessió</a>
		</div>
	</div>
</body>

</html>