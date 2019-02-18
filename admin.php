<?php
/**
 * Created by PhpStorm.
 * User: drago
 * Date: 21-Dec-18
 * Time: 15:28
 */

 include 'header.php';

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

//Query pentru adaugare Medicament
if(isset($_POST['adaugareMedicament'])) {
    $producator = $connection->real_escape_string($_POST['producator']);
    $concentratie = $connection->real_escape_string($_POST['concentratie']);
    $Nume = $connection->real_escape_string($_POST['Nume']);
    $Pret = $connection->real_escape_string($_POST['Pret']);
    $Procent_reducere = $connection->real_escape_string($_POST['Procent_reducere']);
    $nr_pastile = $connection->real_escape_string($_POST['nr_pastile']);

    $sql = "INSERT INTO medicamente (id_producator,concentratie,Nume,Pret,Procent_reducere,nr_pastile) VALUES
('$producator','$concentratie','$Nume','$Pret','$Procent_reducere','$nr_pastile')";

    if ($connection->query($sql) === TRUE) {
        echo "<h2 style=\"text-align: center\">Medicament adaugat cu succes</h2>";
    } else {
        echo "<h2 style=\"text-align: center\">Eroare la adaugarea medicamentului: $connection->error </h2>";
    }

}

//Query pentru gasirea medicamentului ce se doreste a fi modificat

if(isset($_POST['NumemodificareMedicament'])) {
    $numeMedicament = $_POST['NumeMedicamentModificat'];
    $_SESSION['numeMedicament'] = $numeMedicament;
    $sql = "SELECT * FROM medicamente WHERE Nume='$numeMedicament'";
    $valpremodif = $connection->query($sql);
    $valpremodif = mysqli_fetch_array($valpremodif, MYSQLI_ASSOC);

}
if(isset($_POST['modificareMedicament'])) {
    $producator = $connection->real_escape_string($_POST['producator']);
    $concentratie = $connection->real_escape_string($_POST['concentratie']);
    $Nume = $connection->real_escape_string($_POST['Nume']);
    $Pret = $connection->real_escape_string($_POST['Pret']);
    $Procent_reducere = $connection->real_escape_string($_POST['Procent_reducere']);
    $nr_pastile = $connection->real_escape_string($_POST['nr_pastile']);

    $sql = "UPDATE medicamente SET id_producator='$producator',concentratie='$concentratie',Nume='$Nume',Pret='$Pret',Procent_reducere='$Procent_reducere',nr_pastile='$nr_pastile' WHERE Nume='" . $_SESSION['numeMedicament'] . "'";

    if ($connection->query($sql) === TRUE) {
        echo "<h2 style=\"text-align: center\">Medicament modificat cu succes</h2>";
    } else {
        echo "<h2 style=\"text-align: center\">Eroare la modificarea medicamentului: $connection->error </h2>";
    }

}

//Query pentru stergere medicament
if(isset($_POST['stergereMedicament'])) {
    $Nume = $connection->real_escape_string($_POST['Nume']);

    $sql = "DELETE FROM medicamente WHERE Nume='$Nume'";

    if ($connection->query($sql) === TRUE) {
        echo "<h2 style=\"text-align: center\">Medicament sters cu succes</h2>";
    } else {
        echo "<h2 style=\"text-align: center\">Eroare la stergere</h2>";
    }

}

$connection->close();

?>
    <div id="main">
        <div class="inner">
            <header>
                <h1>Administrare</h1>
                <p>Adauga, editeaza sau sterge un medicament.</p>
            </header>

            <h2 style="text-align: center">Adauga medicament</h2>

            <form id="form" method="post">
                <span>Nume*:</span>
                <input name="Nume" type="text" required/>
                <span>Producator id*:</span>
                <input name="producator" type="number" required/>
                <span>Concentratie*:</span>
                <input name="concentratie" type="number" required/>
                <span>Pret*:</span>
                <input name="Pret" type="number" required/>
                <span>Procent reducere*:</span>
                <input name="Procent_reducere" type="number" required/>
                <span>Numar pastile*:</span>
                <input name="nr_pastile" type="number" required/>

                <input class="submit" name="adaugareMedicament" type="submit" style="margin-top: 10px" value="Adaugare Medicament" />
            </form>

            <h2 style="text-align: center">Modificare medicament existent</h2>
            <form id="form" method="post">
                <span>Nume medicament de modificat*:</span>
                <input name="NumeMedicamentModificat" type="text" required/>

                <input class="submit" name="NumemodificareMedicament" type="submit" style="margin-top: 10px" value="Setare Nume" />
            </form>

            <form id="form" method="post">
                <span>Nume*:</span>
                <input name="Nume" type="text" value="<?php if(isset($valpremodif)) echo $valpremodif['Nume'] ?>" required/>
                <span>Producator id*:</span>
                <input name="producator" type="number" value="<?php if(isset($valpremodif)) echo $valpremodif['id_producator'] ?>" required/>
                <span>Concentratie*:</span>
                <input name="concentratie" type="number" value="<?php if(isset($valpremodif)) echo $valpremodif['concentratie'] ?>" required/>
                <span>Pret*:</span>
                <input name="Pret" type="number" value="<?php if(isset($valpremodif)) echo $valpremodif['Pret'] ?>" required/>
                <span>Procent reducere*:</span>
                <input name="Procent_reducere" type="number" value="<?php if(isset($valpremodif)) echo $valpremodif['Procent_reducere'] ?>" required/>
                <span>Numar pastile*:</span>
                <input name="nr_pastile" type="number" value="<?php if(isset($valpremodif)) echo $valpremodif['nr_pastile'] ?>" required/>

                <input class="submit" name="modificareMedicament" type="submit" style="margin-top: 10px" value="Modificare medicament" />
            </form>

            <h2 style="text-align: center">Stergere medicament</h2>

            <form id="form" method="post">
                <span>Nume medicament*:</span>
                <input name="Nume" type="text" required/>

                <input class="submit" name="stergereMedicament" type="submit" style="margin-top: 10px" value="Sterge Medicament" />
            </form>
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
