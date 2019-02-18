<?php session_start() ?>
<!DOCTYPE html>
<html>
<head>
    <title>Farmacie online | Login</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="css/style.css" type="text/css"/>
</head>
<body class="is-preload">

<!-- Wrapper -->
<div id="wrapper">

    <!-- Header -->
    <header id="header">
        <div class="inner">

            <!-- Logo -->
            <a href="index.php" class="logo">
                <span class="symbol"><img src="images/logo.svg" alt="" /></span><span class="title">SANITAS</span>
            </a>

            <!-- Nav -->
            <nav>
                <ul>
                    <li><a href="#menu">Menu</a></li>
                    <?php if(isset($_SESSION['logged_username'])) { ?>
                        <li> Bine ai venit, <?php echo $_SESSION['logged_username'] . "!" ?></li>
                    <?php }  ?>
                </ul>
            </nav>

        </div>
    </header>

    <!-- Menu -->
    <nav id="menu">
        <?php if(isset($_GET['logout'])) {
            session_unset();
            header('Location: index.php');
        } ?>
        <h2>Menu</h2>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="prospecte.php">Prospecte</a></li>
            <li><a href="login.php">
                    <?php if(isset($_SESSION['logged_username'])) echo "Contul meu"; else echo "Login"; ?>
                </a>
            </li>
            <?php //verificam daca user-ul logat este administrator

            if (isset($_SESSION['logged_username'])) {

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

            $sql = "SELECT 1 FROM clienti WHERE username='" . $_SESSION['logged_username'] . "' AND isadmin=1";
            $resultisadmin = $connection->query($sql);
            $resultisadmin = mysqli_fetch_array($resultisadmin, MYSQLI_ASSOC);

            if( sizeof($resultisadmin) == 1 ) { ?>
                <li><a href="admin.php">Administrare</a></li>
            <?php $connection->close(); } }  ?>
            <?php if(!isset($_SESSION['logged_username'])) { ?>
                <li><a href="register.php">Register</a></li>
            <?php }  ?>
            <?php if(isset($_SESSION['logged_username'])) { ?>
                <li><a href="?logout=true">Logout</a></li>
            <?php }  ?>
        </ul>
    </nav>