<script type="text/javascript" src="js/editdriver.js"></script>

<style>
    .flex-record {
        transition: .5s;
        padding: 10px 10px;
        margin: 20px 20px;
        background: rgba(44, 50, 255, .2);
        box-shadow: 1px 1px 10px black;
    }

    .flex-record:hover {
        transition: .5s;
        transform: scale(1.1);
    }

    .flex-record table {
        text-align: center;
    }

    .flex-record p {
        padding: 0;
        margin: 0;
    }

    .flex-record img {
        border-radius: 50%;
    }

    .driver-name {
        font-size: 22px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .driver-id {
        font-size: 15px;
    }

    .driver-date {
        font-size: 11px;
    }

    .driver-plates {
        font-weight: bold;
    }

    .flex-record a {
        display: inline-block;
        width: 90%;
        color: white;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 12px;
        padding: 10px 5px;
        margin: 5px;
    }

    .editdriver-btn {
        background: rgb(44, 50, 255);
    }

    .deldriver-btn {
        background: #ff313b;
    }

    #jarat-ttl {
        text-align: left;
        font-size: 22px;
    }

    input:not([type="file"]) {
        outline: none;
        border: 1px solid rgb(44, 50, 255);
        width: 50%;
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

<div class="d-flex flex-wrap align-items-center justify-content-center">
    <?php

    $query_str = "SELECT	
                    CONCAT(vezeteknev, ' ', keresztnev) AS nev,
                    szemelyi_szam,
                    csatlakozas_datuma,
                    GROUP_CONCAT(busz.rendszam ORDER BY busz.rendszam SEPARATOR ', ') AS rendszamok
                FROM
                    sofor
                LEFT JOIN busz ON busz.sofor_szemelyi_szam = szemelyi_szam
                GROUP BY szemelyi_szam
                ORDER BY nev";

    $get_drivers = $sql->query($query_str);

    while($rows = $get_drivers->fetch_array(MYSQLI_ASSOC)) {
        $imgViewerUrl = "ImageViewer.php?table=sofor&selected_field=profil&field=szemelyi_szam&value=" . $rows["szemelyi_szam"];

        echo "<div class='flex-record'>";
        echo "<table><tr>";
        echo "    <td><img src='" . $imgViewerUrl . "' height='120'></td>";
        echo "    <td style='vertical-align: top; padding: 10px;'>";
        echo "        <p class='driver-name'>" . $rows["nev"] . "</p>";
        echo "        <p class='driver-id'>" . $rows["szemelyi_szam"] . "</p>";
        echo "        <p class='driver-date'>" . $rows["csatlakozas_datuma"] . "</p>";
        echo "        <p class='driver-plates' style='margin-top: 5px;'>" . ((strlen($rows["rendszamok"]) == 0) ? "Nincs hozzárendelt busz!" : $rows["rendszamok"]) . "</p>";
        echo "    </td></tr>";
        echo "    <tr><td colspan='2'>";
        echo "        <a href='index.php?page=admin&menu=soforok#edit' class='editdriver-btn' onclick='fillForm(`" . $rows["nev"] . "," . $rows["szemelyi_szam"] . "," . $rows["csatlakozas_datuma"] . "`)'>Adatok módosítása</a>";
        echo "        <a href='php/admin/managedriver.php?type=delete&id=" . $rows["szemelyi_szam"] . "' class='deldriver-btn' onclick='return confirm(`Biztosan el akarod bocsátani ". $rows["nev"] ."-t?`)'>Elbocsátás</a>";
        echo "    </td>";
        echo "</tr></table>";
        echo "</div>";
        echo $sql->error;
    }


    ?>
</div>

<div class="form-container">
    <p id="jarat-ttl">
        <img src="img/add.png" width="32">
        Új sofőr felvétele
    <hr size="4">
    </p>

    <form action="php/admin/managedriver.php?type=add" method="post" enctype="multipart/form-data">
        <p><input type="text" name="nev" placeholder="Teljes név"></p>
        <p><input type="text" name="szemelyi_szam" placeholder="Személyi igazolvány szám"></p>
        <p><input type="file" name="profile" value="Fénykép feltöltése"></p>
        <p><input type="submit" value="Felvétel" id="edit"></p>
    </form>
</div>

<div class="form-container">
    <p id="jarat-ttl">
        <img src="img/edit.png" width="32">
        Adatok szerkesztése
    <hr size="4">
    </p>

    <form action="php/admin/managedriver.php?type=edit" method="post" enctype="multipart/form-data">
        <p><input type="hidden" name="szemelyi_szam" id="input_szemelyi_szam"></p>
        <p><input type="text" name="nev" placeholder="Teljes név" id="input_nev"></p>
        <p><input type="date" name="csatlakozas_datuma" id="input_csatlakozas_datuma"></p>
        <p><input type="file" name="profile" value="Fénykép feltöltése"></p>

        <p style="color: darkred; font-size: 10px;">Kattints a megfelelő sofőrnél az 'Adatok módosítása' gombra!</p>
        <p style="color: darkred; font-size: 10px;">Sofőrhöz tartozó járműveket módosítani csak a Járművek menüpont alatt lehet!</p>

        <p><input type="submit" value="Módosítás"></p>
    </form>
</div>