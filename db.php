<?php
$servername = "localhost";
$username = "dbadmin";
$password = "dbadministderbesteruser123!!!!";
$dbname = "stundenplan";

// Verbindung zur MySQL-Datenbank herstellen
$conn = new mysqli($servername, $username, $password, $dbname);

// Verbindung überprüfen
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully to the database!<br>";
