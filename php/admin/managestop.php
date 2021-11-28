<?php

session_start();

if(!isset($_SESSION["logged"]) or (isset($_SESSION["logged"]) and !$_SESSION["logged"]) or $_SESSION["admin"] == 0 or !isset($_GET["type"]))
    http_response_code(403);

include_once("../../sql/db_conn.php");

switch($_GET["type"]) {
    case "add":
        if($_SERVER["REQUEST_METHOD"] != "POST")
            http_response_code(403);

        $check_id = $sql->query("SELECT id FROM megallo WHERE nev = '" . $_POST["nev"] . "'");

        if($check_id->num_rows == 0) {
            if(empty($_POST["nev"]))
                sendResponse("A név mező nem lehet üres!");

            $sql->query("INSERT INTO megallo(nev) VALUES('". $_POST["nev"] ."')");
            sendResponse("Megálló sikeresen rögzítve!", "'/index.php?page=admin&menu=megallok'");
        } else sendResponse("Ezzel a névvel már létezik egy megálló! Válassz másikat!");
        break;

    case "delete":
        if(!isset($_GET["id"]))
            http_response_code(403);

        $sql->query("DELETE FROM megallo WHERE id = '". $_GET["id"] ."'");
        sendResponse("Megálló sikeresen törölve!", "'/index.php?page=admin&menu=megallok'");
        break;

    case "edit":
        if($_SERVER["REQUEST_METHOD"] != "POST")
            http_response_code(403);

        $check_id = $sql->query("SELECT id FROM megallo WHERE id = " . $_POST["id"]);

        if($check_id->num_rows == 1) {
            if(empty($_POST["nev"]))
                sendResponse("A név mező nem lehet üres!");

            $sql->query("UPDATE megallo SET nev = '". $_POST["nev"] ."' WHERE id = ".$_POST["id"]);
            sendResponse("Megállónév sikeresen módosítva!", "'/index.php?page=admin&menu=megallok'");
        } else sendResponse("Ezzel az azonosítóval nem létezik egy megálló sem!");
        break;

    default:
        http_response_code(403);
        break;
}

function sendResponse($message, $route = "history.back()") {
    echo "<script>alert('". $message ."'); window.location.href = ".$route.";</script>";
}

?>