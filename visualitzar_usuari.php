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
        if ($usuari)
            $visualitza = 1;
        else
            $visualitza = 2;
    }
}
?>
<html>

<head>
    <title>
        MOSTRANT DADES D'USUARIS DE LA BASE DE DADES LDAP
    </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/visualitzar_usuari.css">
</head>

<body>
    <h2 class="titol">Visualitzar dades d'usuari</h2>
    <div class="form input-group">
        <h4>Introdueix les dades necessàries</h4><br />
        <form action="visualitzar_usuari.php" method="GET">
            Unitat organitzativa: <input type="text" name="ou" class="form-control"
                placeholder="Unitat organitzativa"><br />
            Nom de l'usuari: <input type="text" name="usr" class="form-control" placeholder="usuari"><br>
            <div style="display: flex; justify-content: center">
                <button class="btn btn-primary">Consultar</button>
            </div>
        </form>
    </div>
    <br /><br />
    <?php
    if ($visualitza == 1) {
        echo '<table class="table table-striped table-bordered"><thead><tr><th scope="col">Nom complet</th><th scope="col">Descripció</th><th scope="col">GID</th><th scope="col">Nom de pila</th><th scope="col">Directori personal</th><th scope="col">Shell</th><th scope="col">Núm. de mòbil</th><th scope="col">Object Class</th><th scope="col">Adreça</th><th scope="col">Cognom</th><th scope="col">Núm de telefon</th><th scope="col">Títol</th><th scope="col">UID</th><th scope="col">Número de UID</th></tr></thead><tbody><tr>';
        foreach ($usuari as $atribut => $dada) {
            if ($atribut != "dn")
                echo "<td>$dada[0]</td>";
        }
        echo "</tr></tbody></table><br/><br/>";
    } else if ($visualitza == 2) {
        echo "<script type='text/javascript'>alert('Aquest usuari no existeix. Comprova bé les dades.');</script>";
    }
    ?>
    <div style="display: flex; justify-content: center">
        <a class="btn btn-danger" style="width: 10%" href="menu.php">Tornar al menú principal</a>
    </div>
</body>

</html>