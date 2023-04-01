<?php
    require 'vendor/autoload.php';
    use Laminas\Ldap\Attribute;
    use Laminas\Ldap\Ldap;

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
                } catch(Exception $err) {
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
    <title>Document</title>
</head>

<body>
    <h1>MODIFICAR USUARI</h1>
    <form action="modificar_usuari.php" method="POST">
        <label for="uid">UID: </label> <input type="text" id="uid" name="uid" required> <br /><br />
        <label for="unorg">Unitat Organitzativa: </label> <input type="text" id="unorg" name="unorg" required>
        <br /><br />
        <h3>Atribut a modificar: </h3>
        <input type="radio" name="atribut" value="uidNumber"> uidNumber<br>
        <input type="radio" name="atribut" value="gidNumber"> gidNumber<br>
        <input type="radio" name="atribut" value="homeDirectory"> Directori personal<br>
        <input type="radio" name="atribut" value="loginShell"> Shell<br>
        <input type="radio" name="atribut" value="cn"> Nom complet<br>
        <input type="radio" name="atribut" value="sn"> Cognom<br>
        <input type="radio" name="atribut" value="givenName"> Nom<br>
        <input type="radio" name="atribut" value="postalAddress"> Adreça<br>
        <input type="radio" name="atribut" value="mobile"> Mobil<br>
        <input type="radio" name="atribut" value="telephoneNumber"> Telefon<br>
        <input type="radio" name="atribut" value="title"> Titol<br>
        <input type="radio" name="atribut" value="description"> Descripcio<br>
        <h3>Nou contingut: </h3>
        <input type="text" id="nou_contingut" name="nou_contingut" required>
        <br/><br/>
        <button type="submit">Envia</button>
    </form>
    <br />
    <a href="menu.php">Tornar al menú</a>
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