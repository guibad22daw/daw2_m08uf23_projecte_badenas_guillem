<?php
session_start();
error_reporting(0);
if (!isset($_SESSION['usuari'])) {
    header("Location: errors/error_acces.php");
} else if (!isset($_SESSION['expira']) || (time() - $_SESSION['expira'] >= 0)) {
    header("Location: errors/logout_expira_sessio.php");
}
?>
<html>

<head>
    <title>
        PÀGINA WEB DEL MENÚ PRINCIPAL DE L'APLICACIÓ D'ACCÉS A BASES DE DADES LDAP
    </title>
</head>

<body>
    <h2> MENÚ PRINCIPAL DE L'APLICACIÓ D'ACCÉS A BASES DE DADES LDAP</h2>
    <ul>
        <li>
            <a href="visualitzar_usuari.php">Visualització de totes les dades d'un usuari</a>
        </li>
        <li>
            <a href="afegir_usuari.php">Afegir usuari</a>
        </li>
        <li>
            <a href="esborrar_usuari.php">Esborrar usuari</a>
        </li>
        <li>
            <a href="modificar_usuari.php">Modificar usuari</a>
        </li>
        <li>
            <a href="index.php">Torna a la pàgina inicial</a>
        </li>
    </ul>
</body>

</html>