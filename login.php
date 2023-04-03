<?php
require 'vendor/autoload.php';
use Laminas\Ldap\Ldap;

ini_set('display_errors', 0);
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
		$_SESSION['expira'] = time() + 216000;
		header("location: menu.php");
	} catch (Exception $e) {
		echo "<b>Contrasenya incorrecta</b><br><br>";
	}
}
?>
<html>

<head>
	<title>
		Login
	</title>
	<link rel="stylesheet" href="stylesheets/login.css">
</head>

<div class="login">
	<h1>Inicia sessió</h1>
    <form method="post">
    	<input type="text" name="adm" placeholder="Usuari" required="required" />
        <input type="password" name="cts" placeholder="Contrasenya" required="required" />
        <button type="submit" class="btn">Inicia sessió</button>
    </form>
</div>
</body>

</html>