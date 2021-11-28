<?php

session_start();

if(!isset($_SESSION["logged"]) or (isset($_SESSION["logged"]) and !$_SESSION["logged"]) or $_SESSION["admin"] == 0 or $_SERVER["REQUEST_METHOD"] != "POST")
    http_response_code(403);

include_once("../../sql/db_conn.php");

$jarat = "";
$menetido = 0;
$megallok_szama = 0;
$megallok = array();

$c = 0;
foreach($_POST as $elem) {
    if($c == 0)
        $jarat = $elem;
    else if($c == 1)
        $menetido = $elem;
    else if($c == 2)
        $sql->query("UPDATE jarat SET megallok_szama = megallok_szama + " . $elem . " WHERE megnevezes = '" . $jarat . "'");
    else {
        $sql->query("INSERT INTO megall VALUES(" . $elem . ", '" . $jarat . "', " . ($c - 2) . ")");
    }
    $c++;
}

if(!empty($menetido))
    $sql->query("UPDATE jarat SET menetido = " . $menetido . " WHERE megnevezes = '" . $jarat . "'");

echo "<script>alert('Járat sikeresen módosítva'); window.location.href = '../../index.php?page=admin&menu=jaratok';</script>";

?>