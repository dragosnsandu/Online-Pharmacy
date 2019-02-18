<?php include 'header.php' ?>
    <!-- Main -->
    <div id="main">
        <div class="inner">
            <header>
                <h1>Sanatate inainte de toate!</h1>
                <p>Nu mai trebuie sa bati drumul pana la farmacia de la colt. Suntem aici pentru tine! Cumpara acum medicamentele de care ai nevoie!</p>
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

            $sql = "SELECT * FROM medicamente INNER JOIN producatori ON medicamente.id_producator = producatori.id_producator";
            $sql_comenzi = "SELECT clienti.Prenume, COUNT(comenzi.id_client) totalOrders FROM clienti LEFT JOIN comenzi ON clienti.id_client = comenzi.id_client GROUP BY clienti.id_client";
            $sql_topMedicamenteCumparate = "SELECT medicamente.Nume, SUM(continut_comanda.cantitate_medicament) totalMedicamente FROM medicamente INNER JOIN continut_comanda ON continut_comanda.id_medicament = medicamente.id_medicament GROUP BY continut_comanda.id_medicament ORDER BY totalMedicamente DESC";
            $sql_valoareComenzi = "SELECT continut_comanda.id_comanda, SUM(continut_comanda.cantitate_medicament * medicamente.Pret) AS valoareComanda FROM continut_comanda LEFT JOIN medicamente ON continut_comanda.id_medicament = medicamente.id_medicament GROUP BY continut_comanda.id_comanda";
            $sql_Producatori = "SELECT producatori.nume, COUNT(medicamente.id_medicament) AS numar_medicamente FROM producatori LEFT JOIN medicamente ON medicamente.id_producator = producatori.id_producator GROUP BY producatori.id_producator";
            $sql_judete = "SELECT clienti.Judet , COUNT(comenzi.id_client) AS totalComenzi FROM comenzi, clienti WHERE clienti.id_client = comenzi.id_client GROUP BY clienti.Judet ORDER BY totalComenzi";

            if(isset($_POST['numeMedicament'])) {
                $medicamentDoza = $connection->real_escape_string($_POST['numeMedicament']);


                $sql_verificareDoza = "SELECT prospecte.doza_recomandata_adult_zi FROM prospecte WHERE prospecte.id_prospect = (SELECT id_medicament FROM medicamente WHERE Nume='$medicamentDoza')";
                $sql_informatiiaditionale = "SELECT producatori.nume, producatori.telefon, producatori.email, prospecte.mod_administrare FROM producatori, prospecte WHERE id_producator = (SELECT id_producator FROM medicamente WHERE Nume = '$medicamentDoza') AND id_prospect = (SELECT id_medicament FROM medicamente WHERE Nume = '$medicamentDoza')";

                $result_verificareDoza = $connection->query($sql_verificareDoza);
                $result_info = $connection->query($sql_informatiiaditionale);

            }

            $results = $connection->query($sql);
            $results_comenzi = $connection->query($sql_comenzi);
            $results_medicamente = $connection->query($sql_topMedicamenteCumparate);
            $results_valoarecomenzi = $connection->query($sql_valoareComenzi);
            $results_producatori = $connection->query($sql_Producatori);
            $results_judete = $connection->query($sql_judete);

            while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) { ?>
                <article>
                        <a href="#">
                            <h2><?php echo $row["Nume"]?></h2>
                            <div class="content">
                                <li>Producator: <?php echo $row["nume"] ?></li>
                                <li>Concentratie: <?php echo $row["concentratie"] . " mg" ?></li>
                                <li>Pastile: <?php echo $row["nr_pastile"] . " comprimate" ?></li>
                                <li>Pret: <?php echo $row["Pret"] . " lei" ?></li>
                            </div>
                        </a>
                </article>
            <?php } ?>
                <h2 style="width: 100%; margin-top: 20px">Verificare rapida a dozei zilnice: </h2>
                <p>Introduceti numele medicamentului si apasati pe butonul Verificare Doza</p>
                <form id="form" method="post">
                    <input name="numeMedicament" type="text" required/>
                    <input class="submit" name="verficareDoza" type="submit" style="margin-top: 10px" value="Verificare Doza" />
                </form>
                <?php if(isset($result_verificareDoza)) { ?>
                <?php while ($row = mysqli_fetch_array($result_verificareDoza, MYSQLI_ASSOC)) { ?>
                        Doza recomandata este de <?php echo $row['doza_recomandata_adult_zi']; ?> pastile

                        <?php if(isset($result_info)) { ?>
                            <?php while ($row_info = mysqli_fetch_array($result_info, MYSQLI_ASSOC)) { ?>
                                <br>Mod de administrare: <?php echo $row_info['mod_administrare']; ?>;<br/>
                                <h3 style="width:100%; text-align: center">Detalii producator: </h3>
                                <li style="width:100%">Nume: <?php echo $row_info['nume'] ?></li>
                                <li style="width:100%">Telefon: <?php echo $row_info['telefon'] ?></li>
                                <li style="width:100%">Email: <?php echo $row_info['email'] ?></li>
                            <?php } } ?>

                <?php } } ?>

                <h2 style="width: 100%; margin-top: 20px">Numar de comenzi: </h2>
            <?php while ($row = mysqli_fetch_array($results_comenzi, MYSQLI_ASSOC)) { ?>
                <p style="width: 100%"><?php echo $row['Prenume'] ?> are <?php echo $row['totalOrders'] ?> comenzi plasate.</p>
            <?php } ?>
                <h2 style="width: 100%; margin-top: 20px">Cele mai cumparate medicamente: </h2>
                <?php while ($row = mysqli_fetch_array($results_medicamente, MYSQLI_ASSOC)) { ?>
                    <p style="width: 100%">Au fost cumparate <?php echo $row['totalMedicamente'] ?> cutii de <?php echo $row['Nume'] ?></p><?php } ?>
                <h2 style="width: 100%; margin-top: 20px">Valoare comenzi: </h2>
                <?php while ($row = mysqli_fetch_array($results_valoarecomenzi, MYSQLI_ASSOC)) { ?>
                <p style="width: 100%">Comanda <?php echo $row['id_comanda'] ?> are valoarea <?php echo $row['valoareComanda'] ?> lei.</p><?php } ?>
                <h2 style="width: 100%; margin-top: 20px">Producatori: </h2>
                <?php while ($row = mysqli_fetch_array($results_producatori, MYSQLI_ASSOC)) { ?>
                    <p style="width: 100%">Comercializam <?php echo $row['numar_medicamente'] ?> produse de la firma <?php echo $row['nume'] ?>.</p><?php } ?>
                <h2 style="width: 100%; margin-top: 20px">Top vanzari dupa Judete: </h2>
                <?php while ($row = mysqli_fetch_array($results_judete, MYSQLI_ASSOC)) { ?>
                    <p style="width: 100%">Judetul <b><?php echo $row['Judet'] ?></b> are <b><?php echo $row['totalComenzi'] ?></b> comenzi plasate.</p>


                <?php } $connection->close(); ?>
            </section>
        </div>
    </div>

</div>

<!-- Scripts -->
<script src="js/jquery.min.js"></script>
<script src="js/browser.min.js"></script>
<script src="js/breakpoints.min.js"></script>
<script src="js/util.js"></script>
<script src="js/main.js"></script>

</body>
</html>