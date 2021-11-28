<?php

session_start();

if(!isset($_SESSION["logged"]) or (isset($_SESSION["logged"]) and !$_SESSION["logged"]) or $_SESSION["admin"] == 0 or $_SERVER["REQUEST_METHOD"] != "POST")
    http_response_code(403);

if(empty($_POST["cim"]))
    sendResponse("A cím mező nem lehet üres!");

if(empty($_POST["szoveg"]))
    sendResponse("A szöveg mező nem lehet üres!");

include_once("../../sql/db_conn.php");

$sql->query("INSERT INTO hir(cim, szoveg, irta, datum) VALUES('" . $_POST["cim"] . "', '" . $_POST["szoveg"] . "', " . $_SESSION["userid"] . ", CURRENT_TIMESTAMP())");
sendResponse("Hír sikeresen rögzítve!", "'../../index.php'");

function sendResponse($message, $route = "history.back()") {
    echo "<script>alert('" . $message . "'); window.location.href = " . $route . ";</script>";
}

?>