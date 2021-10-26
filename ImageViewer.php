<?php

if(isset($_GET["table"]) and isset($_GET["field"]) and isset($_GET["value"]) and isset($_GET["selected_field"])) {
    include_once('sql/db_conn.php');

    $query_str = "SELECT " . $_GET["selected_field"] . " FROM " . $_GET["table"] . " WHERE " . $_GET["field"] . " = '" . $_GET["value"] . "' LIMIT 1";
    $get_img = $sql->query($query_str);

    $rows = $get_img->fetch_array(MYSQLI_ASSOC);

    header('Content-type: image/jpg');
    echo $rows[$_GET["selected_field"]];
}

?>