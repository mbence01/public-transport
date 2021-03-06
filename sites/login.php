<?php

if(isset($_SESSION["logged"]) and isset($_SESSION["userid"]) and $_SESSION["logged"] == true) {
    unset($_SESSION["logged"]);
    unset($_SESSION["userid"]);
    unset($_SESSION["admin"]);
    echo "<script>window.location.href = 'index.php';</script>";
}

?>

<style>
    #login {
        margin: 25px auto;
        padding: 25px 25px;
        text-align: center;
        color: grey;
        box-shadow: inset 1px 1px 150px lightblue;
    }

    #login-ttl {
        font-size: 30px;
        text-transform: uppercase;
    }

    input {
        display: block;
        width: 80%;
        height: 40px;
        margin: 10px auto;
        border: none;
        border-radius: 10px;
        outline: none;
        box-shadow: 1px 1px 5px grey;
        color: grey;
    }

    input:not([type="submit"]) {
        text-indent: 45px;
    }

    input[type="submit"] {
        transition: 1s;
        width: 50%;
        margin-top: 50px;
        font-weight: bold;
        box-shadow: inset 1px 1px 50px cornflowerblue;
    }

    input[type="submit"]:hover {
        transition: 1s;
        color: white;
        background: cornflowerblue;
    }

    #email {
        background-image: url('img/email.png');
        background-size: 32px;
        background-position: 5px 4px;
        background-repeat: no-repeat;
    }

    .password {
        background-image: url('img/password.png');
        background-size: 32px;
        background-position: 3px 4px;
        background-repeat: no-repeat;
    }

    #username {
        background-image: url('img/login-icon.png');
        background-size: 32px;
        background-position: 5px 4px;
        background-repeat: no-repeat;
    }

    #bottom-txt {
        font-size: 12px;
        margin: 0;
    }

    #bottom-txt a:hover {
        text-decoration: underline;
    }
</style>

<?php

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_GET["type"]) and $_GET["type"] == "reg") {
        if(strlen($_POST["username"]) == 0 or strlen($_POST["password"]) == 0 or strlen($_POST["email"]) == 0) {
            echo "<script>alert('Nem t??lt??tt??l ki minden mez??t!'); window.location = history.back();</script>";
        } else if($_POST["password"] != $_POST["password2"]) {
            echo "<script>alert('A megadott jelszavak nem egyeznek!'); window.location = history.back();</script>";
        } else {
            $check_user = $sql->query("SELECT id FROM felhasznalo WHERE email = '" . $_POST["email"] . "' OR felhasznalonev = '" . $_POST["username"] . "'");

            if($check_user->num_rows == 0) {
                $query_str = "INSERT INTO felhasznalo(felhasznalonev, email, jelszo, admin) VALUES('" . $_POST["username"] . "', '" . $_POST["email"] . "', '" . md5(md5($_POST["password"])) . "', 0)";
                $sql->query($query_str);

                echo "<script>alert('Sikeres regisztr??ci??!'); window.location.href = 'index.php?page=login';</script>";
            } else {
                echo "<script>alert('A megadott felhaszn??l??n??v vagy e-mail c??m m??r haszn??latban van!'); window.location = history.back();</script>";
            }
        }
    } else {
        $query_str = "SELECT id, email, admin FROM felhasznalo WHERE email = '" . $_POST["email"] . "' AND jelszo = '" . md5(md5($_POST["password"])) . "'";
        $check_user = $sql->query($query_str);

        if($check_user->num_rows != 0) {
            $row = $check_user->fetch_array(MYSQLI_ASSOC);

            $_SESSION["logged"] = true;
            $_SESSION["userid"] = $row["id"];
            $_SESSION["usermail"] = $row["email"];
            $_SESSION["admin"] = $row["admin"];

            echo "<script>alert('Sikeres bejelentkez??s!'); window.location.href = 'index.php';</script>";
        } else {
            echo "<script>alert('Sikertelen bejelentkez??si kis??rlet!'); window.location = history.back();</script>";
        }
    }
} else {
    if(!isset($_GET["type"]) or $_GET["type"] != "reg") { ?>
        <div class="container-fluid">
            <div class="row">
                <div id="login" class="col-lg-6 col-md-8 col-sm-10 col-xs-12">
                    <img src="img/login-icon.png" width="128">
                    <p id="login-ttl">Bejelentkez??s</p>

                    <form action="index.php?page=login" method="POST">
                        <input type="email" name="email" id="email" placeholder="E-mail c??m">
                        <input type="password" name="password" class="password" placeholder="Jelsz??">
                        <input type="submit" value="Bejelentkez??s">
                    </form>

                    <p id="bottom-txt">
                        Nincs m??g fi??kod? Regisztr??lj egyet <a href="index.php?page=login&type=reg">ITT</a>!
                    </p>
                </div>
            </div>
        </div><?php
    } else { ?>
        <div class="container-fluid">
            <div class="row">
                <div id="login" class="col-lg-6 col-md-8 col-sm-10 col-xs-12">
                    <img src="img/login-icon.png" width="128">
                    <p id="login-ttl">Regisztr??ci??</p>

                    <form action="index.php?page=login&type=reg" method="post">
                        <input type="text" name="username" id="username" placeholder="Felhaszn??l??n??v">
                        <input type="email" name="email" id="email" placeholder="E-mail c??m">
                        <input type="password" name="password" class="password" placeholder="Jelsz??">
                        <input type="password" name="password2" class="password" placeholder="Jelsz?? m??gegyszer">
                        <input type="submit" value="Regisztr??ci??">
                    </form>

                    <p id="bottom-txt">
                        Van m??r fi??kod? Jelentkezz be <a href="index.php?page=login">ITT</a>!
                    </p>
                </div>
            </div>
        </div><?php
    }
}
?>