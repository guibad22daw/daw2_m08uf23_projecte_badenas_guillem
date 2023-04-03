<?php
    require '../vendor/autoload.php';
    use Laminas\Ldap\Attribute;
    use Laminas\Ldap\Ldap;

    session_start();
    if (!isset($_SESSION['usuari'])) {
        header("Location: errors/error_acces.php");
    } else if (!isset($_SESSION['expira']) || (time() - $_SESSION['expira'] >= 0)) {
        header("Location: errors/error_expira_sessio.php");
    } else {
        if (isset($_POST['uid']) && isset($_POST['unorg'])) {
            $uid = $_POST['uid'];
            $unorg = $_POST['unorg'];
            $dn = 'uid=' . $uid . ',ou=' . $unorg . ',dc=fjeclot,dc=net';
            $opcions = [
                'host' => 'zend-gubabe.fjeclot.net',
                'username' => 'cn=admin,dc=fjeclot,dc=net',
                'password' => 'fjeclot',
                'bindRequiresDn' => true,
                'accountDomainName' => 'fjeclot.net',
                'baseDn' => 'dc=fjeclot,dc=net',
            ];
            $ldap = new Ldap($opcions);
            $ldap->bind();
            try {
                $ldap->delete($dn);
                $esborrat = 1;
            } catch (Exception $e) {
                $esborrat = 2;
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/esborrar_usuari.css">
</head>

<body>
    <h2 class="titol">Esborrar usuari de la base de dades LDAP</h2>
    <div class="form input-group">
        <h4>Esborrament d'un usuari</h4><br />
        <form action="esborrar_usuari.php" method="POST">
            <label for="uid">Nom de l'usuari (UID): </label> <input type="text" id="uid" name="uid" class="form-control" placeholder="usuari" required> <br />
            <label for="unorg">Unitat Organitzativa: </label> <input type="text" id="unorg" name="unorg" class="form-control" placeholder="exemples" required>
            <br /><br />
            <div style="display: flex; justify-content: center">
                <button class="btn btn-primary">Esborrar</button>
            </div>
        </form>
    </div>
    <br /><br />
    <div style="display: flex; justify-content: center">
        <a class="btn btn-danger" style="width: 250px" href="menu.php">Tornar al menú principal</a>
    </div>
    <?php
        if ($esborrat == 1) {
            echo "<script type='text/javascript'>alert('Usuari esborrat correctament.');</script>";
        } else if ($esborrat == 2) {
            echo "<script type='text/javascript'>alert('Error esborrant usuari. Aquesta entrada no existeix.');</script>";
        }
    ?>
</body>

</html>