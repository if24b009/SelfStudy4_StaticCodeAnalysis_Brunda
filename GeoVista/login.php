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
$errorFields["username"] = false;
$errorFields["pwd"] = false;

$userid = null;

/* Validation */
if (count($_POST) > 0 && $_SERVER["REQUEST_METHOD"] == "POST") {

    //Username
    if (empty($_POST["username"])) {
        $errorMessages[] = "Fehlender Username. Bitte gib deinen Usernamen ein!";
        $errorFields["username"] = true;
    } else {
        $usernames = getUsernames($db);

        if (!in_array($_POST["username"], $usernames)) {
            $errorMessages[] = "Der Username <i>" . $_POST["username"] . "</i> existiert nicht. Bitte registriere dich zuerst!";
            $errorFields["username"] = true;
        } else {
            $userid = getUserId($db, $_POST["username"]);
        }
    }

    //Password
    if (empty($_POST["password"])) {
        $errorMessages[] = "Passwort unvollständig!";
        $errorFields["pwd"] = true;
    } else if ($userid) {
        $user = getUserDetails($db, $userid);
        if (!$user || !password_verify($_POST["password"], $user['password'])) {
            $errorMessages[] = "Falsches Passwort!";
            $errorFields["pwd"] = true;
        }
    }

}

//redirect if successful login
if (count($_POST) > 0 && count($errorMessages) === 0) {
    if (!isset($_SESSION['userid'])) {
        $_SESSION['userid'] = $userid;
        $_SESSION['userrole'] = getRole($db, $_SESSION['userid']);
    }

    header("Location: ./index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>GeoVista - Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- NAV-BAR -->
    <?php include "./base/nav.php"; ?>

    <header class="mt-4">
        <h1 class="text-center text-primary">Login</h1>
    </header>

    <main class="container w-75 my-5">

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
            <div class="p-5 border rounded-4 shadow-sm bg-white">

                <!-- USERNAME -->
                <div class="mb-4">
                    <label for="user" class="form-label fw-semibold">Username</label>
                    <input type="text" class="form-control <?php if ($errorFields['username'])
                        echo 'is-invalid'; ?>" id="user" name="username"
                        value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                        required autocomplete="username">
                </div>

                <!-- PASSWORD -->
                <div class="mb-4">
                    <label for="pwd" class="form-label fw-semibold">Passwort</label>
                    <input type="password" class="form-control <?php if ($errorFields['pwd'])
                        echo 'is-invalid'; ?>" id="pwd" name="password" required autocomplete="current-password">
                </div>

                <div class="text-center mt-5">
                    <div class="text-muted" style="font-size: smaller; font-style: cursive;">Falls du noch keinen Account hast, kannst du dich hier <a href="registration.php">registrieren</a>. </div> 
                </div> 
                  
                <div class="text-center mt-5">
                    <button type="submit" class="btn btn-primary px-5 py-2 rounded-4 fw-bold">
                        Login
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
        } else if (count($_POST) > 0) {
            echo "<p class='alert alert-success mt-4 text-center' role='alert'><strong>Erfolgreich registriert!</strong></p>";
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