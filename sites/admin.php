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
    <div class="row">
        <div class="d-md-none d-xs-block"> <!-- MOBIL -->
            <?php showSideMenu(true); ?>
        </div>

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

function showSideMenu($mobile = false) { ?>
    <div id="adminpanel" <?php echo !$mobile ? "style='padding-bottom: 5000px;'>" : ""; ?>
        <hr class="adminpanel-hr" style="margin-top: 0;">
        <p id="admin-title">Adminpanel</p>
        <hr class="adminpanel-hr">

        <nav id="admin-nav">
            <a href="index.php?page=admin&menu=jaratok" menu="jaratok">Járatok</a>
            <a href="index.php?page=admin&menu=jaratvarazslo" menu="jaratvarazslo">Járatvarázsló</a>
            <a href="index.php?page=admin&menu=megallok" menu="megallok">Megállók</a>
            <a href="index.php?page=admin&menu=soforok" menu="soforok">Sofőrök</a>
            <a href="index.php?page=admin&menu=jarmuvek" menu="jarmuvek">Járművek</a>
            <a href="index.php?page=admin&menu=felhasznalok" menu="felhasznalok">Felhasználók</a>
            <a href="index.php?page=admin&menu=hirek" menu="hirek">Hírek</a>
            <a href="index.php?page=admin&menu=letoltesek" menu="letoltesek">Továbbiak</a>
        </nav>
    </div>

<?php
}
?>