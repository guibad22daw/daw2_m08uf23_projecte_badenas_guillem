<?php
require '../vendor/autoload.php';
use Laminas\Ldap\Attribute;
use Laminas\Ldap\Ldap;

error_reporting(0);
session_start();
$modificat = 0;
if (!isset($_SESSION['usuari'])) {
    header("Location: errors/error_acces.php");
} else if (!isset($_SESSION['expira']) || (time() - $_SESSION['expira'] >= 0)) {
    header("Location: errors/error_expira_sessio.php");
} else {
    if (isset($_POST['uid']) && isset($_POST['unorg']) && isset($_POST['atribut'])) {
        $uid = $_POST['uid'];
        $unorg = $_POST['unorg'];
        $nou_contingut = $_POST['nou_contingut'];
        $atribut = $_POST['atribut'];

        # Opcions de connexió a LDAP
        $dn = 'uid=' . $uid . ',ou=' . $unorg . ',dc=fjeclot,dc=net';
        $opcions = [
            'host' => 'zend-gubabe.fjeclot.net',
            'username' => 'cn=admin,dc=fjeclot,dc=net',
            'password' => 'fjeclot',
            'bindRequiresDn' => true,
            'accountDomainName' => 'fjeclot.net',
            'baseDn' => 'dc=fjeclot,dc=net',
        ];

        # Modificant l'entrada
        $ldap = new Ldap($opcions);
        $ldap->bind();
        $entrada = $ldap->getEntry($dn);
        if ($entrada) {
            try {
                Attribute::setAttribute($entrada, $atribut, $nou_contingut);
                $ldap->update($dn, $entrada);
                $modificat = 1;
            } catch (Exception $err) {
                $modificat = 2;
            }
        } else {
            $modificat = 3;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar usuari | Gestió LDAP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/modificar_usuari.css">
</head>

<body>
    <h2 class="titol">Modificar usuari de la base de dades LDAP</h2>
    <div class="form input-group">
        <h4 for="basic-url">Modificació d'usuari</h4><br />
        <form action="modificar_usuari.php" method="POST" class="row g-7">
            <div class="col-12">
                <label for="uid">UID: </label> <input type="text" class="form-control" id="uid" name="uid" placeholder="usuari1" required>
                <label for="unorg">Unitat Organitzativa: </label> <input type="text" class="form-control" placeholder="exemples" id="unorg"
                    name="unorg" required>
            </div>
            <label style="margin-top: 20px"> Atribut a modificar: </label>
            <div class="col-md-6 form-check" style="margin-top: 8px">
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="atribut1" name="atribut" value="uidNumber" checked> 
                    <label class="form-check-label" for="atribut1">Número d'UID</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="atribut2" name="atribut" value="gidNumber"> 
                    <label class="form-check-label" for="atribut2">ID del Grup (GID)</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="atribut3" name="atribut" value="homeDirectory"> 
                    <label class="form-check-label" for="atribut3">Directori personal </label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="atribut4" name="atribut" value="loginShell"> 
                    <label class="form-check-label" for="atribut4">Shell</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="atribut5" name="atribut" value="cn"> 
                    <label class="form-check-label" for="atribut5">Nom complet</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="atribut6" name="atribut" value="sn"> 
                    <label class="form-check-label" for="atribut6">Cognom</label>
                </div>
            </div>
            <div class="col-md-6 form-check" style="margin-top: 8px">
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="atribut7" name="atribut" value="givenName"> 
                    <label class="form-check-label" for="atribut7">Nom de pila</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="atribut8" name="atribut" value="postalAddress"> 
                    <label class="form-check-label" for="atribut8">Adreça</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="atribut9" name="atribut" value="mobile"> 
                    <label class="form-check-label" for="atribut9">Mòbil</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="atribut10" name="atribut" value="telephoneNumber"> 
                    <label class="form-check-label" for="atribut10">Telèfon</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="atribut11" name="atribut" value="title"> 
                    <label class="form-check-label" for="atribut11">Títol</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="atribut12" name="atribut" value="description"> 
                    <label class="form-check-label" for="atribut12">Descripció</label>
                </div>
            </div>
            <div class="col-12">
                <label for="nou_contingut" style="margin-top: 15px;">Nou contingut:</label>
                <input type="text" id="nou_contingut" name="nou_contingut" class="form-control" placeholder="Nou contingut..." required>
                <div style="display: flex; justify-content: center">
                    <button class="btn btn-primary">Modificar usuari</button>
                </div>
            </div>
        </form>
    </div>
    </div>
    <div style="display: flex; justify-content: center">
        <a class="btn btn-danger" style="width: 250px" href="menu.php">Tornar al menú principal</a>
    </div>
    <br />
    <?php
        if ($modificat == 1) {
            echo "<script type='text/javascript'>alert('Usuari modificat correctament.');</script>";
        } else if ($modificat == 2) {
            echo "<script type='text/javascript'>alert('Error modificant usuari.');</script>";
        } else if ($modificat == 3) {
            echo "<script type='text/javascript'>alert('Error modificant usuari. Comprova que l\'UID i la UO existeixen.');</script>";
        }
    ?>
</body>

</html>