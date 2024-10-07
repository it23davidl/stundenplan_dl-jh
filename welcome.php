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
<div style="position: absolute; top: 10px; right: 10px;">
    <a href="logout.php" style="text-decoration: none; color: white; background-color: #4CAF50; padding: 10px; border-radius: 5px;">Logout</a>
</div>
<h1>Willkommen, <?php echo $_SESSION['username']; ?>!</h1>
<p>Du bist als <?php echo $_SESSION['user_type'] == 'schueler' ? 'Schüler' : 'Lehrer'; ?> eingeloggt.</p>
<a href="logout.php">Logout</a>
</body>
</html>