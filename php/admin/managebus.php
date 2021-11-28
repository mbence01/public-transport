<?php

session_start();

if(!isset($_SESSION["logged"]) or (isset($_SESSION["logged"]) and !$_SESSION["logged"]) or $_SESSION["admin"] == 0 or !isset($_GET["type"]))
    http_response_code(403);

include_once("../../sql/db_conn.php");

switch($_GET["type"]) {
    case "add":
        if($_SERVER["REQUEST_METHOD"] != "POST")
            http_response_code(403);

        $check_id = $sql->query("SELECT rendszam FROM busz WHERE rendszam = '" . $_POST["rendszam"] . "'");

        if($check_id->num_rows == 0) {
            if(empty($_POST["rendszam"]))
                sendResponse("A rendszám mező nem lehet üres!");

            if(empty($_POST["tipus"]))
                sendResponse("A típus mező nem lehet üres!");

            if(empty($_POST["ev"]))
                sendResponse("Az év mező nem lehet üres!");

            $sql->query("INSERT INTO busz VALUES('". $_POST["rendszam"] ."', '". $_POST["tipus"] ."', '". $_POST["ev"] ."', " . $_POST["sofor"] . ")");
            sendResponse("Jármű sikeresen rögzítve!", "'/index.php?page=admin&menu=jarmuvek'");
        } else sendResponse("Ezzel a rendszámmal már létezik egy jármű! Válassz másikat!");
        break;

    case "delete":
        if(!isset($_GET["id"]))
            http_response_code(403);

        $sql->query("DELETE FROM busz WHERE rendszam = '". $_GET["id"] ."'");
        sendResponse("Jármű sikeresen törölve!", "'/index.php?page=admin&menu=jarmuvek'");
        break;

    case "edit":
        if($_SERVER["REQUEST_METHOD"] != "POST")
            http_response_code(403);

        $check_id = $sql->query("SELECT rendszam FROM busz WHERE rendszam = '" . $_POST["rendszam"] . "'");

        if($check_id->num_rows == 1) {
            if(empty($_POST["tipus"]))
                sendResponse("A típus mező nem lehet üres!");

            if(empty($_POST["ev"]))
                sendResponse("Az év mező nem lehet üres!");

            $sql->query("UPDATE busz SET tipus = '". $_POST["tipus"] ."', ev = '". $_POST["ev"] ."', sofor_szemelyi_szam = " . $_POST["sofor"] . " WHERE rendszam = '" . $_POST["rendszam"] . "'");
            sendResponse("Jármű sikeresen módosítva!", "'/index.php?page=admin&menu=jarmuvek'");
        } else sendResponse("Ezzel a rendszámmal még nem létezik egy jármű sem!");
        break;

    default:
        http_response_code(403);
        break;
}

function sendResponse($message, $route = "history.back()") {
    echo "<script>alert('". $message ."'); window.location.href = ".$route.";</script>";
}

?>