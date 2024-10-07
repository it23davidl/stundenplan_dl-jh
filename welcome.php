<?php
session_start();
 
if(!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Willkommen</title>
</head>
<body>
<h1>Willkommen, <?php echo $_SESSION['username']; ?>!</h1>
<p>Du bist als <?php echo $_SESSION['user_type'] == 'schueler' ? 'Schüler' : 'Lehrer'; ?> eingeloggt.</p>
<a href="logout.php">Logout</a>
</body>
</html>