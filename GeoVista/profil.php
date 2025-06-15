<?php
if (session_status() == PHP_SESSION_NONE)
    session_start();

/* if user isn't logged in -> redirect to login without showing this page */
if (!isset($_SESSION["userid"])) {
    header("Location: login.php");
    exit();
}

require_once('config/dbaccess.php'); //to retrieve connection detail
require_once('config/db_utils.php'); //functions for database access
$db = new mysqli($host, $user, $password, $database);
if ($db->connect_error) {
    echo "Connection Error: " . $db->connect_error;
    exit();
}

//Errors
$errorMessages = [];
$errorFields = []; //Identifying fields for different kinds of errors
$errorFields["email"] = false;
$errorFields["username"] = false;
$errorFields["pwd"] = false;

if ($_SESSION["userid"]) {
    $userID = isset($_GET["selected-user"]) ? $_GET["selected-user"] : $_SESSION["userid"];

    $userDetails = getUserDetails($db, $userID);
    $username = $userDetails["username"];
    $pwd = $userDetails["password"];
    $mail = $userDetails["email"];
    $isAdmin = $userDetails["isAdmin"];


    /* Validation */
    if (count($_POST) > 0 && $_SERVER["REQUEST_METHOD"] == "POST") {
        $isAdmin = (isset($_POST["role"])) ? $_POST["role"] : $isAdmin;

        //Email
        if (empty($_POST["email"])) {
            $errorMessages[] = 'Fehlende E-Mail-Adresse. Bitte gib deine E-Mail-Adresse ein!';
            $errorFields["email"] = true;
        } else if (!preg_match("#^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[_a-z0-9-]+)*(\.[a-z]{2,3})$#", $_POST["email"])) {
            $errorMessages[] = "<i>" . $_POST["email"] . "</i> ist keine gültige E-Mail-Adresse. Bitte überprüfe deine Eingabe!";
            $errorFields["email"] = true;
        } else {
            $mail = $_POST["email"];
        }

        //Username
        if (empty($_POST["username"])) {
            $errorMessages[] = "Fehlender Username. Bitte gib deinen Usernamen ein!";
            $errorFields["user"] = true;
        } else {
            $usernames = getUsernames($db);

            if (in_array($_POST["username"], $usernames) && $username != $_POST["username"]) {
                $errorMessages[] = "Der Username <i>" . $_POST["username"] . "</i> existiert bereits. Bitte wähle einen anderen!";
                $errorFields["username"] = true;
            } else if (strlen($_POST["username"]) <= 3) {
                $errorMessages[] = "Der Username muss mindestens 3 Zeichen enthalten!";
                $errorFields["username"] = true;
            } else if (strlen($_POST["username"]) >= 20) {
                $errorMessages[] = "Der Username darf maximal 20 Zeichen lang sein!";
                $errorFields["username"] = true;
            } else {
                $username = $_POST["username"];
            }
        }

        //Password
        if (isset($_GET["selected-user"]) && $_SESSION['userrole'] === "Admin") {
            $_POST["oldPassword"] = $pwd;
        }

        if ($_POST["oldPassword"] != '') { //is password changed?
            //Syntax: password_verify(password, hashed_password)
            if ((!password_verify($_POST["oldPassword"], $pwd)) && $_POST["oldPassword"] != $pwd) {  //2. condition only for admin (oldpassword already hashed)
                //if ($_POST["oldPassword"] != $pwd) {
                $errorMessages[] = "Passwort ist falsch!";
                $errorFields["pwd"] = true;
            } else if (isset($_POST["newPassword1"]) && $_POST["oldPassword"] == $_POST["newPassword1"]) { //check if new password is the same as the old one
                $errorMessages[] = "Neues Passwort kann nicht das alte Passwort sein!";
                $errorFields["pwd"] = true;
            } else if (($_POST["oldPassword"] != '' && $_POST["newPassword1"] != '') && isset($_POST["newPassword2"])) {  //check if new password matches criteria and change when its right
                if (!preg_match("#(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$#", $_POST["newPassword1"])) { //password criteria
                    $errorMessages[] = "Passwort muss mindestens 8 Zeichen lang sein und eine Ziffer, Groß- und Kleinbuchstaben und ein Sonderzeichen beinhalten!";
                    $errorFields["pwd"] = true;
                }
                if ($_POST["newPassword1"] != $_POST["newPassword2"]) {
                    $errorMessages[] = "Die beiden neuen Passwörter stimmen nicht überein!";
                    $errorFields["pwd"] = true;
                } else {
                    $pwd = password_hash($_POST["newPassword1"], PASSWORD_DEFAULT);
                }
            }
        } else if ($_POST["newPassword1"] != '' || $_POST["newPassword2"] != '') {
            $errorMessages[] = "Die Eingabe des alten Passworts ist für die Änderung des Passworts erforderlich!";
            $errorFields["pwd"] = true;
        }

    }
}

//save and redirect if successful profil update
if (count($_POST) > 0 && count($errorMessages) === 0) {
    updateUserDetails($db, $userID, $mail, $username, $pwd, $isAdmin);

    $_SESSION['successProfilupdate'] = "Profil erfolgreich aktualisiert!";
    header("Location: ./index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>GeoVista - Profil</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- NAV-BAR -->
    <?php include "./base/nav.php"; ?>

    <!-- USERNAME -->
    <?php include "./base/username.php"; ?>

    <header class="">
        <h1 class="text-center text-primary">Profil bearbeiten</h1>
    </header>

    <main class="container w-75 my-5">
        <?php if (isset($_GET["selected-user"]) && $_SESSION['userrole'] === "Admin"): ?>
            <div class="text-center mb-5">
                <button class="btn btn-primary px-5 py-2 rounded-4 fw-bold" onclick="location.href='userlist.php';">Zurück
                    zum Usermanagement</button>
            </div>
        <?php endif; ?>

        <p class="text-center text-muted mb-5">Hier werden Profil und Stammdaten verwaltet:</p>

        <form
            action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . (isset($_GET["selected-user"]) ? '?selected-user=' . $_GET["selected-user"] : ''); ?>"
            method="POST">

            <div class="p-5 border rounded-4 shadow-sm bg-white">

                <!-- Admin: edit selected user from usermanagement.php-> only visible for admin, for changing the activity status of the user-->
                <?php if (isset($_GET["selected-user"]) && $_SESSION['userrole'] === "Admin"): ?>
                    <div class="mb-4">
                        <label class="form-label fw-semibold d-block mb-2">Rolle auswählen <span
                                class="text-primary">*</span></label>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="role" id="admin" value="1" <?php if ($isAdmin == 1)
                                echo 'checked'; ?>>
                            <label class="form-check-label" for="admin">Admin</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="role" id="user" value="0" <?php if ($isAdmin == 0)
                                echo 'checked'; ?>>
                            <label class="form-check-label" for="user">User</label>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- EMAIL -->
                <div class="mb-4">
                    <label for="email" class="form-label fw-semibold">E-Mail-Adresse <span
                            class="text-primary">*</span></label>
                    <input type="email" class="form-control" <?php if ($errorFields['email'])
                        echo 'is-invalid'; ?> id="email" name="email"
                        value="<?php echo isset($_SESSION['userid']) ? htmlspecialchars($mail) : ''; ?>" required>
                </div>

                <!-- USERNAME -->
                <div class="mb-4">
                    <label for="user" class="form-label fw-semibold">Username <span
                            class="text-primary">*</span></label>
                    <input type="text" class="form-control <?php if ($errorFields['username'])
                        echo 'is-invalid'; ?>" id="user" name="username"
                        value="<?php echo isset($_SESSION['userid']) ? htmlspecialchars($username) : ''; ?>" required
                        autocomplete="username">
                </div>

                <!-- PASSWORD -->
                <?php if (empty($_GET["selected-user"])): ?>
                    <div class="mb-4">
                        <label for="pwd1" class="form-label fw-semibold">Altes Passwort</label>
                        <input type="password" class="form-control <?php if ($errorFields['pwd'])
                            echo 'is-invalid'; ?>" id="pwd1" name="oldPassword" autocomplete="current-password">
                    </div>
                <?php endif; ?>

                <div class="mb-4">
                    <label for="pwd2" class="form-label fw-semibold">Neues Passwort</label>
                    <input type="password" class="form-control <?php if ($errorFields['pwd'])
                        echo 'is-invalid'; ?>" id="pwd2" name="newPassword1" autocomplete="current-password">
                </div>

                <div class="mb-4">
                    <label for="pwd3" class="form-label fw-semibold">Neues Passwort wiederholen</label>
                    <input type="password" class="form-control <?php if ($errorFields['pwd'])
                        echo 'is-invalid'; ?>" id="pwd3" name="newPassword2" autocomplete="current-password">
                </div>

                <p class="text-center text-muted mb-2">
                    Alle mit <span class="text-primary">*</span> gekennzeichneten Felder sind Pflichtfelder.
                </p>

                <div class="text-center mt-5">
                    <button type="submit" class="btn btn-primary px-5 py-2 rounded-4 fw-bold">
                        Speichern
                    </button>
                    <a href="./index.php" class="btn btn-outline-primary px-5 py-2 rounded-4 fw-bold mt-4 mt-xl-0 ms-0 ms-xl-2">
                        Abbrechen
                    </a>
                </div>

            </div>

        </form>

        <!-- Check after submission -->
        <?php
        if (count($errorMessages) > 0) {
            echo "<div class='alert alert-danger mt-4' role='alert'><p><strong>Fehler beim Speichern des Profils</strong><br>Bitte überprüfe folgende Angaben:</p>";
            echo "<ul class='mb-0'>";
            foreach ($errorMessages as $msg) { //display errormessages
                echo "<li>$msg</li>";
            }
            echo "</ul></div>";
        }
        ?>

    </main>


    <!-- FOOTER -->
    <?php include "./base/footer.php"; ?>

    <!-- For bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>