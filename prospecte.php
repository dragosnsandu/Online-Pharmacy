<?php
/**
 * Created by PhpStorm.
 * User: drago
 * Date: 20-Dec-18
 * Time: 12:51
 */
include 'header.php';
?>
<div id="main">
    <div class="inner">
        <header>
            <h1>Prospecte</h1>
            <p>Rezumatul prospectelor produselor pe care le comercializam.</p>
        </header>

        <section class="tiles">
            <?php

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "farmacie";

            // Create connection
            $connection = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($connection->connect_error) {
                die("Connection failed: " . $connection->connect_error);
            }

            $sql = "SELECT * FROM prospecte INNER JOIN medicamente ON prospecte.id_prospect = medicamente.id_medicament";
            $results = $connection->query($sql);

            while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) { ?>
                <article>
                    <a href="#">
                        <h2><?php echo "Prospect " . $row["Nume"]?></h2>
                        <div class="content">
                            <li>Doza recomandata adult / zi: <?php echo $row["doza_recomandata_adult_zi"] . " pastile"?></li>
                            <li>Doza recomandata copii / zi: <?php echo $row["doza_recomandata_copil_zi"] . " pastile" ?></li>
                            <li>Mod administrare: <?php echo $row["mod_administrare"] ?></li>
                            <li>Contraindicatii: <?php echo $row["contraindicatii"] ?></li>
                            <li>Reactii adverse: <?php echo $row["reactii_adverse"] ?></li>
                        </div>
                    </a>
                </article>
            <?php } $connection->close(); ?>
        </section>
    </div>
</div>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/browser.min.js"></script>
<script src="js/breakpoints.min.js"></script>
<script src="js/util.js"></script>
<script src="js/main.js"></script>

</body>
</html>
