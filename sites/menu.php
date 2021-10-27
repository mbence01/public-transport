<div id="header" class="container-fluid">
    <div class="row">
        <table>
            <tr>
                <td class="d-none d-lg-inline d-md-inline col-lg-4 col-md-2">
                    <a id="main-logo" href="/index.php">
                        <img src="/img/logo.png" width="64" align="absmiddle" title="Mucsaröcsöge Közlekedési Társaság">
                        <span class="d-none d-lg-inline" id="main-title">Mucsaröcsöge Közlekedési Társaság</span>
                    </a>
                </td>
                <td class="col-lg-8 col-md-10 col-sm-12" id="header-right">
                    <span class="d-inline-block d-md-none d-block" id="menu-title">Menü <hr></span>

                    <ul style="padding: 0;">
                        <li>
                            <a href="index.php?page=index" class="d-inline-block d-md-none d-block"><img src="/img/logo.png" width="32"> Főoldal</a>
                        </li>
                        <li>
                            <a href="index.php?page=jarat" class="d-md-inline-block d-block"><img src="/img/bus.png" width="25"> Járatok</a>
                        </li>
                        <li>
                            <a href="index.php?page=megallo" class="d-md-inline-block d-block"><img src="/img/busstop.png" width="27"> Megállók</a>
                        </li>
                        <li>
                            <a href="#" class="d-md-inline-block d-block"><img src="/img/route.png" width="25"> Útvonaltervezés</a>
                        </li>

                        <li id="last-li" class="d-none d-md-inline-block">
                            <a href="#" class="d-md-inline-block d-block"><img src="/img/other.png" width="35"> Továbbiak</a>

                            <ul id="child-ul">
                                <li>
                                    <a href="#" class="d-md-inline-block d-block"><img src="/img/schedule.png" width="25"> Menetrend</a>
                                </li>
                                <li>
                                    <a href="#" class="d-md-inline-block d-block"><img src="/img/ticket.png" width="25"> Jegyvásárlás</a>
                                </li>
                                <li>
                                    <a href="index.php?page=sofor" class="d-md-inline-block d-block"><img src="/img/driver.png" width="25"> Sofőreink</a>
                                </li>
                                <li>
                                    <a href="index.php?page=login" class="d-md-inline-block d-block"><img src="/img/login.png" width="25">
                                    <?php

                                    if(isset($_SESSION["logged"]) and isset($_SESSION["userid"]) and $_SESSION["logged"] == true) {
                                        echo " Kijelentkezés";
                                    } else {
                                        echo " Bejelentkezés";
                                    }

                                    ?>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="d-block d-md-none">
                            <a href="#" class="d-md-inline-block d-block"><img src="/img/schedule.png" width="25"> Menetrend</a>
                        </li>
                        <li class="d-block d-md-none">
                            <a href="#" class="d-md-inline-block d-block"><img src="/img/ticket.png" width="25"> Jegyvásárlás</a>
                        </li>
                        <li class="d-block d-md-none">
                            <a href="index.php?page=sofor" class="d-md-inline-block d-block"><img src="/img/driver.png" width="25"> Sofőreink</a>
                        </li>
                        <li class="d-block d-md-none">
                            <a href="index.php?page=login" class="d-md-inline-block d-block"><img src="/img/login.png" width="25">
                                <?php

                                if(isset($_SESSION["logged"]) and isset($_SESSION["userid"]) and $_SESSION["logged"] == true) {
                                    echo " Kijelentkezés";
                                } else {
                                    echo " Bejelentkezés";
                                }

                                ?>
                            </a>
                        </li>
                    </ul>
                </td>
            </tr>
        </table>
    </div>
</div>