<?php

if(!isset($_SESSION["logged"]) or (isset($_SESSION["logged"]) and $_SESSION["admin"] == 0)) {
    include_once("sites/403.html");
    die();
}

?>

<style>
    body {
        background: rgba(44, 50, 255, .4);
    }

    .adminpanel-hr {
        border: 3px dashed rgb(44, 50, 255);
    }

    #adminpanel {
        width: 100%;
        background: rgba(44, 50, 255, .6);
        color: white;
        padding-bottom: 5000px;
    }

    #admin-title {
        text-align: center;
        font-size: 30px;
        font-weight: bold;
        text-transform: uppercase;
        text-shadow: .5px .5px 50px white;
        color: rgba(44, 50, 255, 1);
    }

    #admin-nav {
        text-align: center;
        overflow: hidden;
    }

    #admin-nav a {
        display: block;
        padding: 25px 25px;
        color: white;
        font-size: 16px;
        text-shadow: 1px 1px 5px black;
        text-transform: uppercase;
        transition: .5s;
    }

    #admin-nav a:hover {
        background: rgba(44, 50, 255, .3);
        box-shadow: 1px 1px 10px black;
        transition: .5s;
    }

    <?php
        if(isset($_GET["menu"])) {
            echo "a[menu=\"". $_GET["menu"] ."\"] {
                    background: rgba(44, 50, 255, .3);
                    box-shadow: 1px 1px 10px black;
                }";
        }
    ?>


</style>

<div class="container-fluid">
    <div class="row d-md-none d-xs-block">
        <?php showSideMenu(); ?>
    </div>

    <div class="row">
        <div class="col-md-3 d-md-block d-none" style="padding: 0;">
            <?php showSideMenu(); ?>
        </div>
        <div class="col-md-9 col-xs-12">
            <?php

            require_once("sql/db_conn.php");

            if(!isset($_GET["menu"])) {
                include_once("sites/adminsites/index.php");
            } else {
                if(file_exists("sites/adminsites/" . $_GET["menu"] . ".php"))
                    include_once("sites/adminsites/" . $_GET["menu"] . ".php");
                else
                    include_once("sites/404.html");
            }

            ?>
        </div>
    </div>
</div>

<?php

function showSideMenu() { ?>

    <div id="adminpanel">
        <hr class="adminpanel-hr" style="margin-top: 0;">
        <p id="admin-title">Adminpanel</p>
        <hr class="adminpanel-hr">

        <nav id="admin-nav">
            <a href="index.php?page=admin&menu=jaratok" menu="jaratok">Járatok</a>
            <a href="#">Megállók</a>
            <a href="#">Sofőrök</a>
            <a href="#">Menetrend</a>
            <a href="#">Felhasználók</a>
        </nav>
    </div>

<?php
}
?>