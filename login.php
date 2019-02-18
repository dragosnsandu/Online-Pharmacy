
<?php include 'header.php' ?>
<?php

/**
 * Created by PhpStorm.
 * User: drago
 * Date: 19-Dec-18
 * Time: 09:02
 */

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "farmacie";

$insertedUsername = "";
$insertedPassword = "";

// Create connection
$connection = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

//TODO -> preluare date din form

if(isset($_POST['username']))
    $insertedUsername = $connection->real_escape_string($_POST['username']);
if(isset($_POST['password']))
    $insertedPassword = $connection->real_escape_string($_POST['password']);

$sql = "SELECT `username`,`password` FROM `clienti`
    WHERE `username`='$insertedUsername' AND `password`='$insertedPassword'";
$results = $connection->query($sql);

if ($results->num_rows == 1) {
    $_SESSION['logged_username'] = $insertedUsername;
    header ('location: index.php');
}

else if(isset($_POST['username']) || isset($_POST['password'])) {
    header ('location: login.php');
}

$connection->close();

?>

    <!-- Main -->
 <?php if(!isset($_SESSION['logged_username'])) { ?>
    <div id="main">
        <div class="inner">
            <header>
                <h1>Login</h1>
                <p>Intra acum in contul tau</p>
            </header>

        <form id="form" method="post">
                <div class="user">
                    <input name="username" placeholder="Username..." type="text" required/>
                </div>
                <div class="pass">
                    <input name="password" placeholder="Password..." type="password" required/>
                </div>
                <input class="submit" name="submit" type="submit" value="Login" />
        </form>
        </div>
    </div>
    <?php } ?>
    <?php if(isset($_SESSION['logged_username'])) {

        // Create connection
        $connection = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }

        //Query pentru pagina de profil
        $sql = "SELECT * FROM clienti WHERE username='" .$_SESSION['logged_username'] ."'";
        $sql_comenzi = "SELECT id_comanda,status,livrare FROM comenzi WHERE id_client = (SELECT id_client FROM clienti WHERE username='" . $_SESSION['logged_username'] . "')";

        $results = $connection->query($sql);
        $results_comenzi = $connection->query($sql_comenzi);
        $results = mysqli_fetch_array($results, MYSQLI_ASSOC);

        //Query pentru stergere cont
        if(isset($_POST['delete'])) {
            $sql = "DELETE FROM clienti WHERE username='" . $_SESSION['logged_username'] . "'";
            if ($connection->query($sql) === TRUE) {
                session_unset();
                header('Location: index.php');
            } else {
                echo "Error deleting user" . $connection->error;
            }
        }

        //Query pentru salvare modificari
        if(isset($_POST['update'])) {
            $nume = $connection->real_escape_string($_POST['nume']);
            $prenume = $connection->real_escape_string($_POST['prenume']);
            $CNP = $connection->real_escape_string($_POST['cnp']);
            $telefon = $connection->real_escape_string($_POST['telefon']);
            $ocupatie = $connection->real_escape_string($_POST['ocupatie']);
            $strada = $connection->real_escape_string($_POST['strada']);
            $oras = $connection->real_escape_string($_POST['oras']);
            $password = $connection->real_escape_string($_POST['password']);

            $sql = "UPDATE clienti SET CNP='$CNP',Nume='$nume',Prenume='$prenume',Telefon='$telefon',Ocupatie='$ocupatie',Strada='$strada',Oras='$oras', password='$password' WHERE username='" . $_SESSION['logged_username'] . "'";


            if ($connection->query($sql) === TRUE) {
                echo "Record updated successfully";
            } else {
                echo "Error updating record: " . $connection->error;
            }

        }

        $connection->close();
        ?>
        <div id="main">
            <div class="inner">
                <header>
                    <h1>Contul meu</h1>
                    <p>Iti poti actualiza datele personale, simplu si rapid!</p>
                </header>

                <form id="form" method="post">
                    <span>Nume:</span>
                    <input name="nume" type="text" value="<?php echo $results['Nume'] ?>" required/>
                    <span>Prenume:</span>
                    <input name="prenume" type="text" value="<?php echo $results['Prenume'] ?>" required/>
                    <span>CNP:</span>
                    <input name="cnp" type="text" maxlength="13" minlength="13" value="<?php echo $results['CNP'] ?>" required/>
                    <span>Email:</span>
                    <input name="email" type="email" value="<?php echo $results['email'] ?>" disabled/>
                    <span>Telefon:</span>
                    <input name="telefon" type="tel" maxlength="10" minlength="10" value="<?php echo $results['Telefon'] ?>" required/>
                    <span>Ocupatie:</span>
                    <input name="ocupatie" type="text" value="<?php echo $results['Ocupatie'] ?>"/>
                    <span>Strada:</span>
                    <input name="strada" type="text" value="<?php echo $results['Strada'] ?>" required/>
                    <span>Oras:</span>
                    <input name="oras" type="text" value="<?php echo $results['Oras'] ?>" required/>
                    <span>Username:</span>
                    <input name="username" type="text" value="<?php echo $results['username'] ?>" disabled/>
                    <span>Parola:</span>
                    <input name="password" type="password" value="<?php echo $results['password'] ?>" required/>


                    <input class="submit" name="update" type="submit" style="margin-top: 10px" value="Actualizare Date" />
                    <input class="submit" name="delete" type="submit" style="margin-top: 10px" value="Stergere cont" />
                </form>

                <h1>Comenzile plasate</h1>

                <?php while ($row = mysqli_fetch_array($results_comenzi, MYSQLI_ASSOC)) { ?>
                    <p style="width: 100%">Comanda cu numarul <b><?php echo $row['id_comanda'] ?></b>, facuta la data <b><?php echo $row['livrare'] ?></b> are statusul <b><?php echo $row['status'] ?></b></p>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/browser.min.js"></script>
<script src="js/breakpoints.min.js"></script>
<script src="js/util.js"></script>
<script src="js/main.js"></script>

</body>
</html>