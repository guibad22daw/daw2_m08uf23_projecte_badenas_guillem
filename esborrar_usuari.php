<?php
    require 'vendor/autoload.php';
    use Laminas\Ldap\Attribute;
    use Laminas\Ldap\Ldap;

    session_start();
    if (!isset($_SESSION['usuari'])) {
        header("Location: errors/error_acces.php");
    } else if (!isset($_SESSION['expira']) || (time() - $_SESSION['expira'] >= 0)) {
        header("Location: errors/error_expira_sessio.php");
    } else {
        if(isset($_POST['uid']) && isset($_POST['unorg'])) {
            # Entrada a esborrar: usuari 3 creat amb el projecte zendldap2
            #
            $uid = $_POST['uid'];
            $unorg = $_POST['unorg'];
            $dn = 'uid=' . $uid . ',ou=' . $unorg . ',dc=fjeclot,dc=net';
            #
            #Opcions de la connexió al servidor i base de dades LDAP
            $opcions = [
                'host' => 'zend-gubabe.fjeclot.net',
                'username' => 'cn=admin,dc=fjeclot,dc=net',
                'password' => 'fjeclot',
                'bindRequiresDn' => true,
                'accountDomainName' => 'fjeclot.net',
                'baseDn' => 'dc=fjeclot,dc=net',
            ];
            #
            # Esborrant l'entrada
            #
            $ldap = new Ldap($opcions);
            $ldap->bind();
            try {
                $ldap->delete($dn);
                echo "<script type='text/javascript'>alert('Entrada esborrada');</script>";
            } catch (Exception $e) {
                echo "<script type='text/javascript'>alert('Aquesta entrada no existeix');</script>";
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
<h1>ESBORRAR USUARI</h1>
    <form action="esborrar_usuari.php" method="POST">
        <label for="uid">UID: </label> <input type="text" id="uid" name="uid" required> <br/><br/>
        <label for="unorg">Unitat Organitzativa: </label> <input type="text" id="unorg" name="unorg" required> <br/><br/>
        <button type="submit">Envia</button>                                                                                                            
    </form>
    <br/>
    <a href="menu.php">Tornar al menú</a>
</body>
</html>