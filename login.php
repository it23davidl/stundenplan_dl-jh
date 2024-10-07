<?php
session_start();
include('db.php');

// Fehlerberichterstattung aktivieren

error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // SQL-Abfrage für Schüler
    $sql_schueler = "SELECT * FROM Schueler WHERE Email = ?";
    $stmt_schueler = $conn->prepare($sql_schueler);
    if (!$stmt_schueler) {
        die("Fehler bei der SQL-Abfrage: " . $conn->error);
    }
    $stmt_schueler->bind_param("s", $email);
    $stmt_schueler->execute();
    $result_schueler = $stmt_schueler->get_result();

    // SQL-Abfrage für Lehrer
    $sql_lehrer = "SELECT * FROM Lehrer WHERE Email = ?";
    $stmt_lehrer = $conn->prepare($sql_lehrer);
    if (!$stmt_lehrer) {
        die("Fehler bei der SQL-Abfrage: " . $conn->error);
    }
    $stmt_lehrer->bind_param("s", $email);
    $stmt_lehrer->execute();
    $result_lehrer = $stmt_lehrer->get_result();

    // Überprüfen, ob der Benutzer ein Schüler oder Lehrer ist
    if ($result_schueler->num_rows > 0) {
        $user = $result_schueler->fetch_assoc();
        if ($password == $user['Passwort']) {  // Klartextvergleich
            $_SESSION['user_type'] = 'schueler';
            $_SESSION['user_id'] = $user['SchuelerID'];
            $_SESSION['username'] = $user['Vorname'] . " " . $user['Nachname'];
            header("Location: stundenplan.php");
            exit;
        }
    } elseif ($result_lehrer->num_rows > 0) {
        $user = $result_lehrer->fetch_assoc();
        if ($password == $user['Passwort']) {  // Klartextvergleich
            $_SESSION['user_type'] = 'lehrer';
            $_SESSION['user_id'] = $user['LehrerID'];
            $_SESSION['username'] = $user['Vorname'] . " " . $user['Nachname'];
            header("Location: stundenplan.php");
            exit;
        }
    } else {
        echo "<script>alert('Ungültige E-Mail-Adresse oder Passwort'); window.location.href='index.php';</script>";
    }

    $stmt_schueler->close();
    $stmt_lehrer->close();
}

// Schließe die Verbindung hier
$conn->close();
?>
