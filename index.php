<html>
    <head>
        <title>Főoldal</title>

        <link rel="stylesheet" href="/css/bootstrap/bootstrap.css" />
        <link rel="stylesheet" href="/css/style.css" />

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    </head>
    <body>
        <?php
            include("sites/menu.php");
            include("Controller.php");

            $page = "";

            if(isset($_GET["page"]))
                $page = Controller::get($_GET["page"]);
            else
                $page = Controller::get("index");

            include_once($page);
        ?>
    </body>
</html>