<?php

session_start();

if(!isset($_SESSION["logged"]) or (isset($_SESSION["logged"]) and !$_SESSION["logged"]) or $_SESSION["admin"] == 0 or !isset($_GET["type"]))
    http_response_code(403);

include_once("../../sql/db_conn.php");

switch($_GET["type"]) {
    case "delete":
        if(!isset($_GET["id"]))
            http_response_code(403);

        $sql->query("DELETE FROM felhasznalo WHERE id = ". $_GET["id"]);
        sendResponse("Felhasználó sikeresen törölve!", "'/index.php?page=admin&menu=felhasznalok'");
        break;

    case "edit":
        if($_SERVER["REQUEST_METHOD"] != "POST")
            http_response_code(403);

        $check_id = $sql->query("SELECT id FROM felhasznalo WHERE id = " . $_GET["id"]);

        if($check_id->num_rows == 1) {
            $newlevel = $_GET["admin"] == 0 ? 1 : 0;

            $sql->query("UPDATE felhasznalo SET admin = " . $newlevel . " WHERE id = " . $_GET["id"]);
            sendResponse("A kiválasztott felhasználó innentől " . ($newlevel == 0 ? "nem " : "") . "adminisztrátor!", "'/index.php?page=admin&menu=felhasznalok'");
        } else sendResponse("Ezzel az azonosítóval még nem létezik egy felhasználó sem!");
        break;

    default:
        http_response_code(403);
        break;
}

function sendResponse($message, $route = "history.back()") {
    echo "<script>alert('". $message ."'); window.location.href = ".$route.";</script>";
}

?>