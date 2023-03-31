<?php
require 'vendor/autoload.php';
use Laminas\Ldap\Ldap;

session_start();
if (!isset($_SESSION['usuari'])) {
    header("Location: errors/error_acces.php");
} else if (!isset($_SESSION['expira']) || (time() - $_SESSION['expira'] >= 0)) {
    header("Location: errors/error_expira_sessio.php");
} else {
    if ($_GET['usr'] && $_GET['ou']) {
        $domini = 'dc=fjeclot,dc=net';
        $opcions = [
            'host' => 'zend-gubabe.fjeclot.net',
            'username' => "cn=admin,$domini",
            'password' => 'fjeclot',
            'bindRequiresDn' => true,
            'accountDomainName' => 'fjeclot.net',
            'baseDn' => 'dc=fjeclot,dc=net',
        ];
        $ldap = new Ldap($opcions);
        $ldap->bind();
        $entrada = 'uid=' . $_GET['usr'] . ',ou=' . $_GET['ou'] . ',dc=fjeclot,dc=net';
        $usuari = $ldap->getEntry($entrada);
        echo $usuari;
        if ($usuari) {
            echo "<b><u>" . $usuari["dn"] . "</b></u><br>";
            foreach ($usuari as $atribut => $dada) {
                if ($atribut != "dn")
                    echo $atribut . ": " . $dada[0] . '<br>';
            }
        } else {
            echo "<b>Aquest usuari no existeix. Comprova bé les dades.</b><br><br>";
        }
    }
}
?>
<html>

<head>
    <title>
        MOSTRANT DADES D'USUARIS DE LA BASE DE DADES LDAP
    </title>
</head>

<body>
    <h2>Formulari de selecció d'usuari</h2>
    <form action="visualitzar_usuari.php" method="GET">
        Unitat organitzativa: <input type="text" name="ou"><br>
        Usuari: <input type="text" name="usr"><br>
        <input type="submit" />
        <input type="reset" />
    </form>
    <br />
    <a href="menu.php">Tornar al menú</a>
</body>

</html>