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

if ($_SESSION['userrole'] === "User") {
    header("Location: index.php");
    exit();
}

$users = getUsers($db);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>GeoVista - Usermanagement</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script type="module" src="res/scripts/userlistClick.js"></script>
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- NAV-BAR -->
    <?php include "./base/nav.php"; ?>

    <header class="mt-4">
        <h1 class="text-center text-primary">Usermanagement</h1>
    </header>

    <!-- USERNAME -->
    <?php include "./base/username.php"; ?>

    <main class="m-5">
        <p class="text-center text-muted mb-5">Zum Bearbeiten der Stammendaten eines Users, klicke auf den User</p>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Username</th>
                        <th scope="col">E-Mail-Adresse</th>
                        <th scope="col">Admin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr class="clickable-row" data-href="profil.php?selected-user=<?php echo $user["id_user"]; ?>">
                            <th scope="row" class="py-3"><?php echo $user["id_user"]; ?></th>
                            <td class="py-3"><?php echo $user["username"]; ?></td>
                            <td class="py-3"><?php echo $user["email"]; ?></td>
                            <td class="py-3"><?php echo ($user["isAdmin"]) ? "Ja" : "Nein" ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>


    <!-- FOOTER -->
    <?php include "./base/footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

    <!-- For bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>