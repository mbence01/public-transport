<?php

session_start();

if(!isset($_SESSION["logged"]) or (isset($_SESSION["logged"]) and !$_SESSION["logged"]) or $_SESSION["admin"] == 0 or !isset($_GET["type"]))
    http_response_code(403);

include_once("../../sql/db_conn.php");

switch($_GET["type"]) {
    case "add":
        if($_SERVER["REQUEST_METHOD"] != "POST")
            http_response_code(403);

        $check_id = $sql->query("SELECT megnevezes FROM jarat WHERE megnevezes = '" . $_POST["megnevezes"] . "'");

        if($check_id->num_rows == 0) {
            if(empty($_POST["megnevezes"]))
                sendResponse("A megnevezés nem lehet üres!");

            if(empty($_POST["menetido"]) or $_POST["menetido"] < 1)
                sendResponse("A menetidőnek 1-nél nagyobbnak kell lennie!");

            if(empty($_POST["megallok_szama"]) or $_POST["megallok_szama"] < 1)
                sendResponse("A megállók számának 1-nél nagyobbnak kell lennie!");

            $sql->query("INSERT INTO jarat VALUES('". $_POST["megnevezes"] ."', ". $_POST["menetido"] .", ". $_POST["megallok_szama"] .")");
            sendResponse("Járat sikeresen rögzítve!", "'/index.php?page=admin&menu=jaratok'");
        } else sendResponse("Ezzel a járatszámmal már létezik egy buszjárat! Válassz másikat!");
        break;

    case "delete":
        if(!isset($_GET["id"]))
            http_response_code(403);

        $sql->query("DELETE FROM jarat WHERE megnevezes = '". $_GET["id"] ."'");
        sendResponse("Járat sikeresen törölve!", "'/index.php?page=admin&menu=jaratok'");
        break;

    case "edit":
        if($_SERVER["REQUEST_METHOD"] != "POST")
            http_response_code(403);

        $check_id = $sql->query("SELECT megnevezes FROM jarat WHERE megnevezes = '" . $_POST["megnevezes"] . "'");

        if($check_id->num_rows == 1) {
            if(empty($_POST["megnevezes"]))
                sendResponse("A megnevezés nem lehet üres!");

            if(empty($_POST["menetido"]) or $_POST["menetido"] < 1)
                sendResponse("A menetidőnek 1-nél nagyobbnak kell lennie!");

            if(empty($_POST["megallok_szama"]) or $_POST["megallok_szama"] < 1)
                sendResponse("A megállók számának 1-nél nagyobbnak kell lennie!");

            $sql->query("UPDATE jarat SET menetido = ". $_POST["menetido"] .", megallok_szama = ". $_POST["megallok_szama"] ." WHERE megnevezes = '".$_POST["megnevezes"]."'");
            sendResponse("Járat sikeresen módosítva!", "'/index.php?page=admin&menu=jaratok'");
        } else sendResponse("Ezzel a járatszámmal nem létezik egy buszjárat sem!");
        break;

    default:
        http_response_code(403);
        break;
}

function sendResponse($message, $route = "history.back()") {
    echo "<script>alert('". $message ."'); window.location.href = ".$route.";</script>";
}

?>