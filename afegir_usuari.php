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
        if(isset($_POST['uid']) && isset($_POST['unorg']) && isset($_POST['num_id']) && isset($_POST['grup']) && isset($_POST['dir_pers']) && isset($_POST['sh']) && isset($_POST['cn']) && isset($_POST['sn']) && isset($_POST['nom']) && isset($_POST['mobil']) && isset($_POST['adressa']) && isset($_POST['telefon']) && isset($_POST['titol']) && isset($_POST['descripcio'])) {
            #Dades de la nova entrada
            #
            $uid=$_POST['uid'];
            $unorg=$_POST['unorg'];
            $num_id=$_POST['num_id'];
            $grup=$_POST['grup'];
            $dir_pers=$_POST['dir_pers'];
            $sh=$_POST['sh'];
            $cn=$_POST['cn'];
            $sn=$_POST['sn'];
            $nom=$_POST['nom'];
            $mobil=$_POST['mobil'];
            $adressa=$_POST['adressa'];
            $telefon=$_POST['telefon'];
            $titol=$_POST['titol'];
            $descripcio=$_POST['descripcio'];
            // $uid='usr3';
            // $unorg='usuaris';
            // $num_id=7000;
            // $grup=100;
            // $dir_pers='/home/usr3';
            // $sh='/bin/bash';
            // $cn="nomis aletse";
            // $sn='nomis';
            // $nom='aletse';
            // $mobil='666778899';
            // $adressa='C/Pi,27,1-1';
            // $telefon='934445566';
            // $titol='analista';
            // $descripcio='analista de sistemes';
            $objcl=array('inetOrgPerson','organizationalPerson','person','posixAccount','shadowAccount','top');
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
            $dn = 'uid='.$uid.',ou='.$unorg.',dc=fjeclot,dc=net';
            if($ldap->add($dn, $nova_entrada)) echo "Usuari creat";	
        }
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>AFEGIR USUARI</h1>
    <form action="afegir_usuari.php" method="POST">
        <label for="uid">UID: </label> <input type="text" id="uid" name="uid" required> <br/><br/>
        <label for="unorg">Unitat Organitzativa: </label> <input type="text" id="unorg" name="unorg" required> <br/><br/>
        <label for="num_id">UIDNumber: </label> <input type="number" id="num_id" name="num_id" required> <br/><br/>
        <label for="grup">GIDNumber: </label> <input type="number" id="grup" name="grup" required> <br/><br/>
        <label for="dir_pers">Directori personal: </label> <input type="text" id="dir_pers" name="dir_pers" required> <br/><br/>
        <label for="sh">Shell: </label> <input type="text" id="sh" name="sh" required> <br/><br/>
        <label for="cn">Nom complet: </label> <input type="text" id="cn" name="cn" required> <br/><br/>
        <label for="sn">Cognom: </label> <input type="text" id="sn" name="sn" required> <br/><br/>
        <label for="nom">Nom: </label> <input type="text" id="nom" name="nom" required> <br/><br/>
        <label for="adressa">Adreça: </label> <input type="text" id="adressa" name="adressa" required> <br/><br/>
        <label for="mobil">Mobil: </label> <input type="number" id="mobil" name="mobil" required> <br/><br/>
        <label for="telefon">Telefon: </label> <input type="number" id="telefon" name="telefon" required> <br/><br/>
        <label for="titol">Títol: </label> <input type="text" id="titol" name="titol" required> <br/><br/>
        <label for="descripcio">Descripció: </label> <input type="text" id="descripcio" name="descripcio" required> <br/><br/>
        <button type="submit">Envia</button>                                                                                                            
    </form>
    <br/>
    <a href="menu.php">Tornar al menú</a>
</body>
</html>