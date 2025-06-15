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

$quizzes = getQuizzes($db);

//Reset session variables for new quiz
if (isset($_SESSION['questions']))
    unset($_SESSION['questions']);


//Toast messages
$successMessage = "";

if (isset($_SESSION['successRegistration'])) {
    $successMessage = $_SESSION['successRegistration'];
    unset($_SESSION['successRegistration']); //Only show once
}
if (isset($_SESSION['successProfilupdate'])) {
    $successMessage = $_SESSION['successProfilupdate'];
    unset($_SESSION['successProfilupdate']);
}
if (isset($_SESSION['successQuestionupload'])) {
    $successMessage = $_SESSION['successQuestionupload'];
    unset($_SESSION['successQuestionupload']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>GeoVista - Home</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- NAV-BAR -->
    <?php include "./base/nav.php"; ?>

    <header class="mt-4">
        <h1 class="text-center text-primary">GeoVista</h1>
    </header>

    <!-- Welcome logged in user -->
    <?php
    $user = getUserDetails($db, $_SESSION['userid']);
    if ($user)
        echo "<p class='mt-3 text-center'>Hallo, <span class='fw-bold'>" . $user["username"] . "</span>!</p>";
    ?>

    <main class="m-5">

        <p class="text-center text-muted mb-5">Wähle ein Quiz:</p>

        <div class="d-flex justify-content-center flex-wrap gap-4">
            <?php
            if ($quizzes) {
                foreach ($quizzes as $quiz) {
                    echo "<div class='card' style='width: 15rem;' onclick=\"location.href='quiz.php?quiz=" . $quiz["id_quiz"] . "';\">";
                    echo "<img class='card-img-top p-5' src='" . $quiz["icon"] . "' alt='Quiz zu " . $quiz["name"] . "'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title text-center'>" . $quiz["name"] . "</h5>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p class='mt-3 text-center'>Keine Quizzes vorhanden.</p>";
            }
            ?>

        </div>

    </main>

    <!-- For bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <!-- Bootstrap toast: success message for registration -->
    <?php if (!empty($successMessage)): ?>
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1100">
            <div id="successToast" class="toast align-items-center text-bg-success border-0 show" role="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <?= htmlspecialchars($successMessage) ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
        <script>
            const toastEl = document.getElementById('successToast');
            const toast = new bootstrap.Toast(toastEl, {
                delay: 4000,
                autohide: true
            });
            toast.show();
        </script>
    <?php endif; ?>

    <!-- FOOTER -->
    <?php include "./base/footer.php"; ?>

</body>

</html>