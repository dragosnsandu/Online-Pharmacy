<?php
/**
 * Created by PhpStorm.
 * User: drago
 * Date: 20-Dec-18
 * Time: 12:51
 */
 include 'header.php';

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

//Query pentru salvare modificari
if(isset($_POST['register'])) {
    $nume = $connection->real_escape_string($_POST['nume']);
    $prenume = $connection->real_escape_string($_POST['prenume']);
    $CNP = $connection->real_escape_string($_POST['cnp']);
    $telefon = $connection->real_escape_string($_POST['telefon']);
    $email = $connection->real_escape_string($_POST['email']);
    $ocupatie = $connection->real_escape_string($_POST['ocupatie']);
    $judet = $connection->real_escape_string($_POST['judet']);
    $strada = $connection->real_escape_string($_POST['strada']);
    $oras = $connection->real_escape_string($_POST['oras']);
    $username = $connection->real_escape_string($_POST['username']);
    $password = $connection->real_escape_string($_POST['password']);

    $sql = "INSERT INTO clienti (CNP,Nume,Prenume,Ocupatie,Strada,Oras,Judet,Telefon,email,username,password) VALUES
('$CNP','$nume','$prenume','$ocupatie','$strada','$oras','$judet','$telefon','$email','$username','$password')";

    if ($connection->query($sql) === TRUE) {
        echo "<h2 style=\"text-align: center\">Record updated successfully</h2>";
    } else {
        echo "<h2 style=\"text-align: center\">Error updating record: $connection->error </h2>";
    }

}

$connection->close();

?>
    <div id="main">
        <div class="inner">
            <header>
                <h1>Cont nou</h1>
                <p>Completeaza formularul de mai jos si apasa pe butonul Creare Cont.</p>
            </header>

            <form id="form" method="post">
                <span>Nume*:</span>
                <input name="nume" type="text" required/>
                <span>Prenume*:</span>
                <input name="prenume" type="text" required/>
                <span>CNP*:</span>
                <input name="cnp" type="text" maxlength="13" minlength="13" required/>
                <span>Email*:</span>
                <input name="email" type="email" required/>
                <span>Telefon*:</span>
                <input name="telefon" type="tel" maxlength="10" minlength="10" required/>
                <span>Ocupatie:</span>
                <input name="ocupatie" type="text"/>
                <span>Strada*:</span>
                <input name="strada" type="text" required/>
                <span>Oras*:</span>
                <input name="oras" type="text" required/>
                <span>Judet*:</span>
                <input name="judet" type="text" required/>
                <span>Username*:</span>
                <input name="username" type="text" required/>
                <span>Parola*:</span>
                <input name="password" type="password" required/>

                <input class="submit" name="register" type="submit" style="margin-top: 10px" value="Creare cont" />
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
