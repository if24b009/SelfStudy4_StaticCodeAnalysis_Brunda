<?php
if (session_status() == PHP_SESSION_NONE)
    session_start();

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

/* Validation */
if (count($_POST) > 0 && $_SERVER["REQUEST_METHOD"] == "POST") {

    //Email
    if (empty($_POST["email"])) {
        $errorMessages[] = 'Fehlende E-Mail-Adresse. Bitte gib deine E-Mail-Adresse ein!';
        $errorFields["email"] = true;
    } else if (!preg_match("#^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[_a-z0-9-]+)*(\.[a-z]{2,3})$#", $_POST["email"])) {
        $errorMessages[] = "<i>" . $_POST["email"] . "</i> ist keine gültige E-Mail-Adresse. Bitte überprüfe deine Eingabe!";
        $errorFields["email"] = true;
    }

    //Username
    if (empty($_POST["username"])) {
        $errorMessages[] = "Fehlender Username. Bitte gib deinen Usernamen ein!";
        $errorFields["username"] = true;
    } else {
        $usernames = getUsernames($db);

        if (in_array($_POST["username"], $usernames)) {
            $errorMessages[] = "Der Username <i>" . $_POST["username"] . "</i> existiert bereits. Bitte wähle einen anderen!";
            $errorFields["username"] = true;
        }
        if (strlen($_POST["username"]) <= 3) {
            $errorMessages[] = "Der Username muss mindestens 3 Zeichen enthalten!";
            $errorFields["username"] = true;
        }
        if (strlen($_POST["username"]) >= 20) {
            $errorMessages[] = "Der Username darf maximal 20 Zeichen lang sein!";
            $errorFields["username"] = true;
        }
    }

    //Password
    if (empty($_POST["password1"]) || empty($_POST["password2"])) {
        $errorMessages[] = "Passwort unvollständig!";
        $errorFields["pwd"] = true;
    } else {
        if (!preg_match("#(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$#", $_POST["password1"])) {
            $errorMessages[] = "Passwort muss mindestens 8 Zeichen lang sein und eine Ziffer, Groß- und Kleinbuchstaben und ein Sonderzeichen beinhalten!";
            $errorFields["pwd"] = true;
        }
        if ($_POST["password1"] != $_POST["password2"]) {
            $errorMessages[] = "Die beiden Passwörter stimmen nicht überein!";
            $errorFields["pwd"] = true;
        }
    }

}

//save and redirect if successful registration
if (count($_POST) > 0 && count($errorMessages) === 0) {
    //safe user in database
    $hashed_password = password_hash($_POST['password1'], PASSWORD_DEFAULT);
    saveRegistration($db, $_POST['username'], $_POST['email'], $hashed_password);

    //header("Location: ./login.php?status=success");
    if (!isset($_SESSION['userid'])) {
        $_SESSION['userid'] = getUserId($db, $_POST['username']);
        $_SESSION['userrole'] = getRole($db, $_SESSION['userid']);
    }

    $_SESSION['successRegistration'] = "Erfolgreich registriert!";
    header("Location: ./index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>GeoVista - Registrieren</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- NAV-BAR -->
    <?php include "./base/nav.php"; ?>

    <header class="mt-4">
        <h1 class="text-center text-primary">Registrieren</h1>
    </header>

    <main class="container w-75 my-5">

        <p class="text-center text-muted mb-5">Bitte geben Sie Ihre Daten ein:</p>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
            <div class="p-5 border rounded-4 shadow-sm bg-white">

                <!-- EMAIL -->
                <div class="mb-4">
                    <label for="email" class="form-label fw-semibold">E-Mail-Adresse <span
                            class="text-primary">*</span></label>
                    <input type="email" class="form-control" <?php if ($errorFields['email'])
                        echo 'is-invalid'; ?> id="email" name="email"
                        value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                </div>

                <!-- USERNAME -->
                <div class="mb-4">
                    <label for="user" class="form-label fw-semibold">Username <span
                            class="text-primary">*</span></label>
                    <input type="text" class="form-control <?php if ($errorFields['username'])
                        echo 'is-invalid'; ?>" id="user" name="username"
                        value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                        required autocomplete="username">
                </div>

                <!-- PASSWORD -->
                <div class="mb-4">
                    <label for="pwd1" class="form-label fw-semibold">Passwort <span
                            class="text-primary">*</span></label>
                    <input type="password" class="form-control <?php if ($errorFields['pwd'])
                        echo 'is-invalid'; ?>" id="pwd1" name="password1" required autocomplete="current-password">
                </div>

                <div class="mb-4">
                    <label for="pwd2" class="form-label fw-semibold">Passwort bestätigen <span
                            class="text-primary">*</span></label>
                    <input type="password" class="form-control <?php if ($errorFields['pwd'])
                        echo 'is-invalid'; ?>" id="pwd2" name="password2" required autocomplete="current-password">
                </div>

                <p class="text-center text-muted mb-2">
                    Alle mit <span class="text-primary">*</span> gekennzeichneten Felder sind Pflichtfelder.
                </p>

                <div class="text-center mt-5">
                    <div class="text-muted" style="font-size: smaller; font-style: cursive;">Falls du bereits einen Account hast, kannst du dich hier <a href="login.php">einloggen</a>. </div> 
                </div> 

                <div class="text-center mt-5">
                    <button type="submit" class="btn btn-primary px-5 py-2 rounded-4 fw-bold">
                        Registrieren
                    </button>
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