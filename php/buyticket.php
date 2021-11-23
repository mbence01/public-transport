<?php
    $redirect = $_SERVER["REQUEST_METHOD"] != "POST" or
                !isset($_SESSION["logged"]) or
                (isset($_SESSION["logged"]) and !$_SESSION["logged"]);

    if($redirect)
        header("location: ../index.php");

    if($_POST["amount"] < 1)
        echo "<script>alert('Hibás darabszám!'); window.location = history.back();</script>";

    if(empty($_POST["name"]))
        echo "<script>alert('A név mező nem lehet üres!'); window.location = history.back();</script>";


    include_once("../sql/db_conn.php");

    $check_email = $sql->query("SELECT id FROM felhasznalo WHERE email = '" . $_POST["email"] . "'");

    if($check_email->num_rows == 0)
        echo "<script>alert('Nincs ilyen regisztrált e-mail cím!'); window.location = history.back();</script>";

    $id = $check_email->fetch_array(MYSQLI_ASSOC)["id"];

    $sql->query("INSERT INTO jegy(user_id, nev, mennyiseg, datum) VALUES(" . $id . ", '" . $_POST["name"] . "', " . $_POST["amount"] . ", CURRENT_TIMESTAMP)");
    echo "<script>alert('Sikeres jegyvásárlás!'); window.location = '../index.php?page=jegy';</script>";
?>