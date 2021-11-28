<script type="text/javascript" src="js/editroute.js"></script>

<style>
    #jaratok-tbl {
        width: 100%;
        margin: 20px auto 10px auto;
        text-align: center;
    }

    #jaratok-tbl th {
        font-size: 17px;
        text-transform: uppercase;
        background: rgba(44, 50, 255, .5);
        height: 50px;
    }

    #jaratok-tbl tr:nth-child(odd) {
        background: rgba(44, 50, 255, .3);
    }

    input {
        outline: none;
        border: 1px solid rgb(44, 50, 255);
        font-size: 13px;
        text-indent: 5px;
        width: 50%;
        height: 100%;
    }

    input[type="submit"] {
        background: rgb(44, 50, 255);
        color: white;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 14px;
        text-indent: 0px;
        width: 25%;
    }

    form {
        margin: 5px 0;
    }

    #pager {
        text-align: center;
    }

    .pager-a {
        display: inline-block;
        width: 50px;
        height: 50px;
        line-height: 20px;
        padding-top: 12px;
        margin: 15px 15px;
        border-radius: 50%;
        font-size: 25px;
        border: 3px solid rgb(44, 50, 255);
    }

    #selected {
        color: white;
        background: rgb(44, 50, 255);
        font-weight: bold;
    }

    #jarat-ttl {
        text-align: left;
        font-size: 22px;
    }

    .form-container input {
        outline: none;
        border: 1px solid rgb(44, 50, 255);
        width: 25%;
        font-size: 13px;
        height: 30px;
        text-indent: 5px;
    }

    .form-container input[type="submit"] {
        width: 50%;
        background: rgb(44, 50, 255);
        color: white;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 16px;
        height: 40px;
    }

    .form-container {
        background: rgba(44, 50, 255, .2);
        margin-top: 50px;
        padding: 25px 25px;
        margin-bottom: 50px;
        text-align: center;
    }
</style>

<table id="jaratok-tbl">
    <tr>
        <th>ID</th>
        <th>Megálló neve</th>
        <th></th>
    </tr>

    <?php

    $start = (isset($_GET["start"])) ? $_GET["start"] : 0;

    $get_megallok = $sql->query("SELECT * FROM megallo ORDER BY id LIMIT " . $start . ",50");

    while($rows = $get_megallok->fetch_array(MYSQLI_ASSOC)) {
        echo "<tr>";
        echo "<td>". $rows["id"] ."</td>";
        echo "<td>
                <form action='php/admin/managestop.php?type=edit&id=". $rows["id"] ."' method='post'>
                    <input type='hidden' name='id' value='". $rows["id"] ."'>
                    <input type='text' name='nev' value='". $rows["nev"] ."' title='A módosításhoz írd be az új nevet és kattints a módosítás gombra!'>
                    <input type='submit' value='Módosítás'>
                </form>
            </td>";
        echo "<td>
                <a href='php/admin/managestop.php?type=delete&id=". $rows["id"] ."'>
                    <img src='img/delete.png' width='16' title='Törlés' onclick='return confirm(`Biztosan törölni szeretnéd a megállót?`)'>
                </a>
              </td>";
        echo "</tr>";
    }

    ?>
</table>

<div id="pager">
    <?php

        $sum = $sql->query("SELECT COUNT(id) AS s FROM megallo")->fetch_array(MYSQLI_ASSOC)["s"];
        $c = 0;
        $curr = isset($_GET["start"]) ? $_GET["start"] : 0;

        for($i = 0; $i <= $sum; $i += 50) {
            echo "<a href='index.php?page=admin&menu=megallok&start=" . $i . "' class='pager-a' ";
            echo (($curr >= $i and $curr < $i + 50) ? "id='selected'" : "") . ">";
            echo ++$c;
            echo "</a>";
        }

    ?>
</div>

<div class="form-container">
    <p id="jarat-ttl">
        <img src="img/add.png" width="32">
        Új megálló hozzáadása
    <hr size="4">
    </p>

    <form action="php/admin/managestop.php?type=add" method="post">
        <p><input type="text" name="nev" placeholder="Megálló neve"></p>
        <p><input type="submit" value="Hozzáadás"></p>
    </form>
</div>