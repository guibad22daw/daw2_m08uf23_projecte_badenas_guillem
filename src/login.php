<?php
require '../vendor/autoload.php';
use Laminas\Ldap\Ldap;

ini_set('display_errors', 0);
$logat = 0;
if ($_POST['cts'] && $_POST['adm']) {
	$opcions = [
		'host' => 'zend-gubabe.fjeclot.net',
		'username' => "cn=admin,dc=fjeclot,dc=net",
		'password' => 'fjeclot',
		'bindRequiresDn' => true,
		'accountDomainName' => 'fjeclot.net',
		'baseDn' => 'dc=fjeclot,dc=net',
	];
	$ldap = new Ldap($opcions);
	$dn = 'cn=' . $_POST['adm'] . ',dc=fjeclot,dc=net';
	$ctsnya = $_POST['cts'];
	try {
		$ldap->bind($dn, $ctsnya);
		session_start();
		$_SESSION['usuari'] = $_POST['adm'];
		$_SESSION['expira'] = time() + 3600;
		header("location: menu.php");
	} catch (Exception $e) {
		$logat = 1;
	}
}
?>
<html>

<head>
	<title>
		Login
	</title>
	<link rel="stylesheet" href="css/login.css">
</head>

<body>
	<div class="login">
		<h1>Inicia sessió</h1>
		<form method="post">
			<input type="text" name="adm" placeholder="Usuari" required="required" />
			<input type="password" name="cts" placeholder="Contrasenya" required="required" />
			<button type="submit" class="btn">Inicia sessió</button>
		</form>
	</div>
	<?php
	if ($logat == 1) {
		echo "<script type='text/javascript'>alert('Contrasenya incorrecta.');</script>";
	}
	?>
</body>

</html>