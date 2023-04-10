<?php
require '../vendor/autoload.php';
use Laminas\Ldap\Attribute;
use Laminas\Ldap\Ldap;

error_reporting(0);
session_start();
if (!isset($_SESSION['usuari'])) {
    header("Location: errors/error_acces.php");
} else if (!isset($_SESSION['expira']) || (time() - $_SESSION['expira'] >= 0)) {
    header("Location: errors/error_expira_sessio.php");
} else {
    if (isset($_POST['uid']) && isset($_POST['unorg']) && isset($_POST['num_id']) && isset($_POST['grup']) && isset($_POST['dir_pers']) && isset($_POST['sh']) && isset($_POST['cn']) && isset($_POST['sn']) && isset($_POST['nom']) && isset($_POST['mobil']) && isset($_POST['adressa']) && isset($_POST['telefon']) && isset($_POST['titol']) && isset($_POST['descripcio'])) {
        #Dades de la nova entrada
        #
        $uid = $_POST['uid'];
        $unorg = $_POST['unorg'];
        $num_id = $_POST['num_id'];
        $grup = $_POST['grup'];
        $dir_pers = $_POST['dir_pers'];
        $sh = $_POST['sh'];
        $cn = $_POST['cn'];
        $sn = $_POST['sn'];
        $nom = $_POST['nom'];
        $mobil = $_POST['mobil'];
        $adressa = $_POST['adressa'];
        $telefon = $_POST['telefon'];
        $titol = $_POST['titol'];
        $descripcio = $_POST['descripcio'];
        $objcl = array('inetOrgPerson', 'organizationalPerson', 'person', 'posixAccount', 'shadowAccount', 'top');
        #
        #Afegint la nova entrada
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
        $nova_entrada = [];
        Attribute::setAttribute($nova_entrada, 'objectClass', $objcl);
        Attribute::setAttribute($nova_entrada, 'uid', $uid);
        Attribute::setAttribute($nova_entrada, 'uidNumber', $num_id);
        Attribute::setAttribute($nova_entrada, 'gidNumber', $grup);
        Attribute::setAttribute($nova_entrada, 'homeDirectory', $dir_pers);
        Attribute::setAttribute($nova_entrada, 'loginShell', $sh);
        Attribute::setAttribute($nova_entrada, 'cn', $cn);
        Attribute::setAttribute($nova_entrada, 'sn', $sn);
        Attribute::setAttribute($nova_entrada, 'givenName', $nom);
        Attribute::setAttribute($nova_entrada, 'mobile', $mobil);
        Attribute::setAttribute($nova_entrada, 'postalAddress', $adressa);
        Attribute::setAttribute($nova_entrada, 'telephoneNumber', $telefon);
        Attribute::setAttribute($nova_entrada, 'title', $titol);
        Attribute::setAttribute($nova_entrada, 'description', $descripcio);
        $dn = 'uid=' . $uid . ',ou=' . $unorg . ',dc=fjeclot,dc=net';
        try {
            $ldap->add($dn, $nova_entrada);
            $afegit = 1;
        } catch (Exception $err) {
            $afegit = 2;
        }
    }
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afegir usuari - Gestió LDAP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/afegir_usuari.css">
</head>

<body>
    <h2 class="titol">Afegir usuari a la base de dades LDAP</h2>
    <div class="form input-group">
        <h4 for="basic-url">Introdueix les dades necessàries</h4><br />
        <form action="afegir_usuari.php" method="POST" class="row g-7">
            <div class="col-md-6">
                <label class="form-label" for="uid">Nom d'usuari (UID): </label> <input class="form-control" type="text" id="uid" name="uid" placeholder="exemple1" required>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="num_id">Número d'UID: </label> <input class="form-control" type="number" id="num_id" name="num_id" placeholder="1000" required>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="unorg">Unitat Organitzativa: </label> <input class="form-control" type="text" id="unorg" name="unorg" placeholder="exemples" required>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="grup">GIDNumber: </label> <input class="form-control" type="number" id="grup" name="grup" placeholder="100" required>
            </div>
            <div class="col-12">
                <label class="form-label" for="dir_pers">Directori personal: </label> <input class="form-control" type="text" id="dir_pers" name="dir_pers" placeholder="/home/exemple1" required>
                <label class="form-label" for="sh">Shell: </label> <input class="form-control" type="text" id="sh" name="sh" placeholder="/bin/bash" required>
                <label class="form-label" for="cn">Nom complet: </label> <input class="form-control" type="text" id="cn" name="cn" placeholder="John Doe" required>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="nom">Nom de pila: </label> <input class="form-control" type="text" id="nom" name="nom" placeholder="John" required>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="sn">Cognom: </label> <input class="form-control" type="text" id="sn" name="sn" placeholder="Doe" required>
            </div>
            <div class="col-12">
                <label class="form-label" for="adressa">Adreça: </label> <input class="form-control" type="text" id="adressa" name="adressa" placeholder="C/Exemple 33" required> 
            </div>
            <div class="col-md-6">
                <label class="form-label" for="mobil">Mòbil: </label> <input class="form-control" type="number" id="mobil" name="mobil" placeholder="6XXXXXXXX" required> 
            </div>
            <div class="col-md-6">
                <label class="form-label" for="telefon">Telèfon: </label> <input class="form-control" type="number" id="telefon" name="telefon" placeholder="9XXXXXXXX" required>
            </div>
            <div class="col-12">
                <label class="form-label" for="titol">Títol: </label> <input class="form-control" type="text" id="titol" name="titol" placeholder="p.e. Informàtic" required>
                <label class="form-label" for="descripcio">Descripció: </label> <textarea class="form-control" id="descripcio" name="descripcio" placeholder="Afegeix una descripció..." required></textarea>
                <div style="display: flex; justify-content: center">
                    <button class="btn btn-primary">Afegir usuari</button>
                </div>
            </div>
            
        </form>
    </div>
    <div style="display: flex; justify-content: center">
        <a class="btn btn-danger" style="width: 250px" href="menu.php">Tornar al menú principal</a>
    </div>
    <br/>
    <?php
    if ($afegit == 1) {
        echo "<script type='text/javascript'>alert('Usuari afegit correctament.');</script>";
    } else if ($afegit == 2) {
        echo "<script type='text/javascript'>alert('Error afegint usuari.');</script>";
    }
    ?>
</body>

</html>