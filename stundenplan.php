<?php
session_start();
include('db.php');
 
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
 
$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type'];
 
// Stundenplan für Schüler laden
if ($user_type == 'schueler') {
    $sql = "SELECT Kurse.Kursname, Unterrichtsfaecher.Fachname, Kurse.BeginnZeit, Kurse.EndeZeit, Lehrer.Vorname, Lehrer.Nachname
            FROM SchuelerKurse
            INNER JOIN Kurse ON SchuelerKurse.KursID = Kurse.KursID
            INNER JOIN Unterrichtsfaecher ON Kurse.FachID = Unterrichtsfaecher.FachID
            INNER JOIN Lehrer ON Kurse.LehrerID = Lehrer.LehrerID
            WHERE SchuelerKurse.SchuelerID = ?";
} else {
    // Stundenplan für Lehrer laden
    $sql = "SELECT Kurse.Kursname, Unterrichtsfaecher.Fachname, Kurse.BeginnZeit, Kurse.EndeZeit, Klassenraum.Klassenname, Klassenraum.RaumNummer
            FROM Kurse
            INNER JOIN Unterrichtsfaecher ON Kurse.FachID = Unterrichtsfaecher.FachID
            INNER JOIN Klassenraum ON Kurse.KlassenraumID = Klassenraum.KlassenraumID
            WHERE Kurse.LehrerID = ?";
}
 
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
 
?>
 
<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Stundenplan</title>
<style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
</style>
</head>
<body>
 
<div style="position: absolute; top: 10px; right: 10px;">
    <a href="logout.php" style="text-decoration: none; color: white; background-color: #4CAF50; padding: 10px; border-radius: 5px;">Logout</a>
</div>


<h1>Stundenplan für <?php echo $_SESSION['username']; ?></h1>
 
<table>
<tr>
<th>Kursname</th>
<th>Fach</th>
<th>Beginn</th>
<th>Ende</th>
<?php if ($user_type == 'schueler'): ?>
<th>Lehrer</th>
<?php else: ?>
<th>Klassenraum</th>
<?php endif; ?>
</tr>
 
    <?php while ($row = $result->fetch_assoc()): ?>
<tr>
<td><?php echo $row['Kursname']; ?></td>
<td><?php echo $row['Fachname']; ?></td>
<td><?php echo date("H:i", strtotime($row['BeginnZeit'])); ?></td>
<td><?php echo date("H:i", strtotime($row['EndeZeit'])); ?></td>
<?php if ($user_type == 'schueler'): ?>
<td><?php echo $row['Vorname'] . " " . $row['Nachname']; ?></td>
<?php else: ?>
<td><?php echo $row['Klassenname'] . " (" . $row['RaumNummer'] . ")"; ?></td>
<?php endif; ?>
</tr>
<?php endwhile; ?>
 
</table>
 
</body>
</html>
 
<?php
$stmt->close();
$conn->close();
?>