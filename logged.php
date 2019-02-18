<?php session_start() ?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Logat</title>
    <style>
        h1, h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Te-ai logat!</h1>
    <h2>Salut, <?php echo $_SESSION['logged_username'] ?>!</h2>
</body>
</html>

