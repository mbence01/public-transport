<?php

session_start();

if(!isset($_SESSION["logged"]) or (isset($_SESSION["logged"]) and !$_SESSION["logged"]) or $_SESSION["admin"] == 0 or !isset($_GET["type"]))
    http_response_code(403);

include_once("../../sql/db_conn.php");

switch($_GET["type"]) {
    case "add":
        if($_SERVER["REQUEST_METHOD"] != "POST")
            http_response_code(403);

        if(empty($_POST["szemelyi_szam"]))
            sendResponse("A személyi szám mező nem lehet üres!");

        if(empty($_POST["nev"]))
            sendResponse("A név mező nem lehet üres!");

        if($_FILES["profile"]["size"] == 0)
            sendResponse("A fénykép mező nem lehet üres!");


        $check_id = $sql->query("SELECT szemelyi_szam FROM sofor WHERE szemelyi_szam = " . $_POST["szemelyi_szam"]);

        if($check_id->num_rows == 0) {
            $names = explode(" ", $_POST["nev"], 2);

            if(!in_array(strtolower(pathinfo($_FILES["profile"]["name"], PATHINFO_EXTENSION)), array("jpg", "png", "jpeg")))
                sendResponse("A feltöltött fájl nem fénykép!");


            $content = addslashes(file_get_contents($_FILES["profile"]["tmp_name"]));
            unlink($_FILES["profile"]["tmp_name"]);

            $sql->query("INSERT INTO sofor VALUES('" . $names[0] . "', '" . $names[1] . "', " . $_POST["szemelyi_szam"] . ", CURRENT_DATE(), '" . $content . "')");
            sendResponse("Sofőr felvéve!", "'/index.php?page=admin&menu=soforok'");
        } else sendResponse("Ezzel a személyi számmal már létezik egy sofőr!");
        break;

    case "delete":
        if(!isset($_GET["id"]))
            http_response_code(403);

        $sql->query("DELETE FROM sofor WHERE szemelyi_szam = '". $_GET["id"] ."'");
        sendResponse("Sofőr sikeresen elbocsátva!", "'/index.php?page=admin&menu=soforok'");
        break;

    case "edit":
        if($_SERVER["REQUEST_METHOD"] != "POST")
            http_response_code(403);

        if(empty($_POST["nev"]))
            sendResponse("A név mező nem lehet üres!");

        if(empty($_POST["csatlakozas_datuma"]))
            sendResponse("A dátum mező nem lehet üres!");


        $names = explode(" ", $_POST["nev"], 2);

        if($_FILES["profile"]["size"] != 0) {
            if(!in_array(strtolower(pathinfo($_FILES["profile"]["name"], PATHINFO_EXTENSION)), array("jpg", "png", "jpeg")))
                sendResponse("A feltöltött fájl nem fénykép!");

            $content = addslashes(file_get_contents($_FILES["profile"]["tmp_name"]));
            unlink($_FILES["profile"]["tmp_name"]);

            $sql->query("UPDATE sofor SET vezeteknev = '" . $names[0] . "', keresztnev = '" . $names[1] . "', csatlakozas_datuma = '" . $_POST["csatlakozas_datuma"] . "', profil = '" . $content . "' WHERE szemelyi_szam = " . $_POST["szemelyi_szam"]);
        } else {
            $sql->query("UPDATE sofor SET vezeteknev = '" . $names[0] . "', keresztnev = '" . $names[1] . "', csatlakozas_datuma = '" . $_POST["csatlakozas_datuma"] . "' WHERE szemelyi_szam = " . $_POST["szemelyi_szam"]);
        }

        sendResponse("Sofőr adatai sikeresen módosítva!", "'/index.php?page=admin&menu=soforok'");
        break;

    default:
        http_response_code(403);
        break;
}

function sendResponse($message, $route = "history.back()") {
    echo "<script>alert('". $message ."'); window.location.href = ".$route.";</script>";
}

?>