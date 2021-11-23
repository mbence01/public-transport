<?php
    if(!isset($_SESSION["logged"]) or (isset($_SESSION["logged"]) and !$_SESSION["logged"])) {
        include_once("403.html");
        die();
    }
?>

<script type="text/javascript" src="js/jegy.js"></script>

<style>
    #jegy-ttl {
        text-align: left;
        font-size: 22px;
    }

    #jegy-container {
        width: 80%;
        text-align: center;
        margin: 25px auto;
    }

    #jegy-tbl {
        margin: 20px auto;
    }

    span {
        font-size: 11px;
        font-weight: bold;
    }

    input[type="text"] {
        width: 100%;
        height: 35px;
        outline: none;
    }

    input[type="number"] {
        width: 30%;
    }

    #checkbox-text:hover {
        cursor: pointer;
    }

    #jegy-tbl tr td:first-child {
        text-align: right;
    }

    #jegy-tbl tr td {
        padding-left: 5px;
    }

    #jegy-tbl tr {
        height: 50px;
    }

    input[type="submit"] {
        width: 100%;
        text-align: center;
        text-transform: uppercase;
        outline: none;
        border: 1px solid black;
        height: 40px;
    }

    #ticket-list {
        width: 100%;
        margin: auto;
        text-align: center;
        box-shadow: 1px 1px 10px black;
    }

    #ticket-list tr:first-child {
        height: 50px;
        background: rgba(0, 0, 0, .1);
        font-size: 16px;
    }

    #ticket-list tr:nth-child(odd) {
        background: rgba(0, 0, 0, .2);
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12" id="jegy-container">
            <p id="jegy-ttl">
                <img src="/img/ticket.png" width="32">
                Jegyvásárlás
                <hr size="4">
            </p>

            <form action="php/buyticket.php" method="post">
                <table id="jegy-tbl">
                    <tr>
                        <td>
                            <span id="checkbox-text">Másnak vásárlok jegyet</span>
                        </td>
                        <td>
                            <input type="checkbox" id="checkbox">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>E-mail cím</span>
                        </td>
                        <td>
                            <input type="text" name="email" value="<?php echo $_SESSION["usermail"]; ?>"  id="email" readonly="true">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>Teljes név</span>
                        </td>
                        <td>
                            <input type="text" name="name">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>Darabszám</span>
                        </td>
                        <td>
                            <input type="number" name="amount" min="1" value="1">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" value="Vásárlás">
                        </td>
                    </tr>
                </table>
            </form>

            <p id="jegy-ttl">
                <img src="/img/ticket.png" width="32">
                Eddig vásárolt jegyeim
            <hr size="4">
            </p>

            <table id="ticket-list">
                <tr>
                    <th>Jegyazonosító</th>
                    <th>E-mail cím</th>
                    <th>Teljes név</th>
                    <th>Mennyiség</th>
                    <th>Vásárlás dátuma</th>
                </tr>

                <?php

                $get_tickets = $sql->query("SELECT * FROM jegy 
                                                    INNER JOIN felhasznalo ON felhasznalo.id = jegy.user_id
                                                    WHERE user_id = " . $_SESSION["userid"] . " ORDER BY datum DESC");

                while($rows = $get_tickets->fetch_array(MYSQLI_ASSOC)) {
                    echo "<tr>
                            <td>" . sprintf("#%05d", $rows["id"]) . "</td>
                            <td>" . $rows["email"] . "</td>
                            <td>" . $rows["nev"] . "</td>
                            <td>" . $rows["mennyiseg"] . " db</td>
                            <td>" . $rows["datum"] . "</td>
                        </tr>";
                }

                ?>
            </table>
        </div>
    </div>
</div>