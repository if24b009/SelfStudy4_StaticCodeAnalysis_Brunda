<?php
if (session_status() == PHP_SESSION_NONE)
    session_start();

if (isset($_FILES['fileToUpload'])) {
    $targetDir = "../res/uploads/";
    $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);

    //Save filename
    if (!isset($_SESSION['filename'])) {
        $_SESSION['filename'] = "res/uploads/" . basename($_FILES["fileToUpload"]["name"]);
    }

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
        echo "Datei wurde hochgeladen: " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"]));
    } else {
        echo "Fehler beim Hochladen der Datei.";
    }
} else {
    echo "Keine Datei empfangen.";
}
?>