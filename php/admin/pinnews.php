<?php

session_start();

if(!isset($_SESSION["logged"]) or (isset($_SESSION["logged"]) and !$_SESSION["logged"]) or $_SESSION["admin"] == 0 or !isset($_GET["type"]))
    http_response_code(403);

include_once("../../sql/db_conn.php");

if(!isset($_GET["id"]))
    http_response_code(403);

$get_pin_status = $sql->query("SELECT rogzitett FROM hir WHERE id = " . $_GET["id"]);
$rows = $get_pin_status->fetch_array(MYSQLI_ASSOC);

if($rows["rogzitett"] == 0) {
    $sql->query("UPDATE hir SET rogzitett = 1 WHERE id = ". $_GET["id"]);
    sendResponse("Hír kiemelve!", "'/index.php?page=admin&menu=hirek'");
} else {
    $sql->query("UPDATE hir SET rogzitett = 0 WHERE id = ". $_GET["id"]);
    sendResponse("Hír törölve a kiemeltek közül!", "'/index.php?page=admin&menu=hirek'");
}

function sendResponse($message, $route = "history.back()") {
    echo "<script>alert('". $message ."'); window.location.href = ".$route.";</script>";
}

?>