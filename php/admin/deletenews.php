<?php

session_start();

if(!isset($_SESSION["logged"]) or (isset($_SESSION["logged"]) and !$_SESSION["logged"]) or $_SESSION["admin"] == 0 or !isset($_GET["type"]))
    http_response_code(403);

include_once("../../sql/db_conn.php");

if(!isset($_GET["id"]))
    http_response_code(403);

$sql->query("DELETE FROM hir WHERE id = ". $_GET["id"]);
sendResponse("Hír sikeresen törölve!", "'/index.php?page=admin&menu=hirek'");

function sendResponse($message, $route = "history.back()") {
    echo "<script>alert('". $message ."'); window.location.href = ".$route.";</script>";
}

?>