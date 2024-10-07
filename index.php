<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="login-container">
<h2>Login</h2>
<form action="login.php" method="post">
<label for="email">E-Mail-Adresse:</label><br>
<input type="email" id="email" name="email" required><br><br>
<label for="password">Passwort:</label><br>
<input type="password" id="password" name="password" required><br><br>
<input type="submit" value="Login">
</form>
</div>
</body>
</html>