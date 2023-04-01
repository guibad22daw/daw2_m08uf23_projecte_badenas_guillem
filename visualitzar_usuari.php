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
        if($usuari) $visualitza = 1;
        else $visualitza = 2;
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
        Unitat organitzativa: <input type="text" name="ou"><br/><br/>
        Usuari: <input type="text" name="usr"><br><br/>
        <input type="submit" />
        <input type="reset" />
    </form>
    <br />
    <?php
        if ($$visualitza == 1) {
            echo "<b><u>" . $usuari["dn"] . "</b></u><br>";
            foreach ($usuari as $atribut => $dada) {
                if ($atribut != "dn")
                    echo $atribut . ": " . $dada[0] . '<br>';
            }
        } else if ($visualitza == 2) {
            echo "<script type='text/javascript'>alert('Aquest usuari no existeix. Comprova bé les dades.');</script>";
        }
    ?>
    <br/>
    <a href="menu.php">Tornar al menú</a>
</body>

</html>