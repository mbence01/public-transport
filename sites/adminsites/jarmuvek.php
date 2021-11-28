<script type="text/javascript" src="js/editbus.js"></script>

<style>
    #jaratok-tbl {
        width: 100%;
        margin: 20px auto 50px auto;
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

    #jarat-ttl {
        text-align: left;
        font-size: 22px;
    }

    input {
        outline: none;
        border: 1px solid rgb(44, 50, 255);
        width: 25%;
        font-size: 13px;
        height: 30px;
        text-indent: 5px;
    }

    input[type="submit"] {
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
        padding: 25px 25px;
        margin-bottom: 50px;
        text-align: center;
    }
</style>

<table id="jaratok-tbl">
    <tr>
        <th>Rendszám</th>
        <th>Típus</th>
        <th>Vásárlás éve</th>
        <th>Hozzárendelt sofőr</th>
        <th></th>
    </tr>

    <?php

    $get_jaratok = $sql->query("SELECT busz.*, CONCAT(sofor.vezeteknev, ' ', sofor.keresztnev) AS nev FROM busz LEFT JOIN sofor ON sofor.szemelyi_szam = sofor_szemelyi_szam ORDER BY rendszam");

    while($rows = $get_jaratok->fetch_array(MYSQLI_ASSOC)) {
        $data = $rows["rendszam"] . "," . $rows["tipus"] . "," . $rows["ev"] . "," . $rows["sofor_szemelyi_szam"] . "," . $rows["nev"];

        echo "<tr>";
        echo "<td>". $rows["rendszam"] ."</td>";
        echo "<td>". $rows["tipus"] ."</td>";
        echo "<td>". $rows["ev"] ."</td>";
        echo "<td>". $rows["nev"] ." (" . $rows["sofor_szemelyi_szam"] . ")</td>";
        echo "<td>
                <a href='index.php?page=admin&menu=jarmuvek#edit' onclick='fillForm(`". $data ."`)'>
                    <img src='img/edit.png' width='16' title='Módosítás'>
                </a>
                
                <a href='php/admin/managebus.php?type=delete&id=". $rows["rendszam"] ."'>
                    <img src='img/delete.png' width='16' title='Törlés' onclick='return confirm(`Biztosan törölni szeretnéd a járművet?`)'>
                </a>
              </td>";
        echo "</tr>";
    }

    ?>
</table>

<div class="form-container">
    <p id="jarat-ttl">
        <img src="img/add.png" width="32">
        Új jármű hozzáadása
    <hr size="4">
    </p>

    <form action="php/admin/managebus.php?type=add" method="post">
        <p><input type="text" name="rendszam" placeholder="Rendszám"></p>
        <p><input type="text" name="tipus" placeholder="Típus"></p>
        <p><input type="date" name="ev"></p>

        <?php

        $get_drivers = $sql->query("SELECT CONCAT(vezeteknev, ' ', keresztnev) AS nev, szemelyi_szam FROM sofor ORDER BY nev");

        echo "<p>";
        echo "<select name='sofor'>";

        while($rows = $get_drivers->fetch_array(MYSQLI_ASSOC)) {
            echo "<option value='" . $rows["szemelyi_szam"] . "'>" . $rows["nev"] . " (" . $rows["szemelyi_szam"] . ")</option>";
        }

        echo "</select>";
        echo "</p>";

        ?>

        <p><input type="submit" value="Hozzáadás" id="edit"></p>
    </form>
</div>

<div class="form-container">
    <p id="jarat-ttl">
        <img src="img/edit.png" width="32">
        Jármű szerkesztése
    <hr size="4">
    </p>

    <form action="php/admin/managebus.php?type=edit" method="post">
        <p><input type="hidden" name="rendszam" id="input_rendszam"></p>
        <p><input type="text" name="tipus" placeholder="Típus" id="input_tipus"></p>
        <p><input type="date" name="ev" id="input_ev"></p>

        <?php

        $get_drivers = $sql->query("SELECT CONCAT(vezeteknev, ' ', keresztnev) AS nev, szemelyi_szam FROM sofor ORDER BY nev");

        echo "<p>";
        echo "<select name='sofor' id='input_sofor'>";

        while($rows = $get_drivers->fetch_array(MYSQLI_ASSOC)) {
            echo "<option value='" . $rows["szemelyi_szam"] . "'>" . $rows["nev"] . " (" . $rows["szemelyi_szam"] . ")</option>";
        }

        echo "</select>";
        echo "</p>";

        ?>

        <p style="color: darkred; font-size: 10px;">Használd a fenti táblázatban található Módosítás ikont!</p>

        <p><input type="submit" value="Módosítás"></p>
    </form>
</div>