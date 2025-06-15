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

$questionNum = 15;

/* if GET isn't set -> redirect to index.php */
if (!isset($_GET["quiz"])) {
    header("Location: index.php");
    exit();
}

$allQuestions = getQuestions($db, htmlspecialchars($_GET["quiz"]));
$quizName = getQuizName($db, htmlspecialchars($_GET["quiz"]));

function shuffleAndSliceQuestions(array $allQuestions, int $limit = 15): array
{
    shuffle($allQuestions);
    return array_slice($allQuestions, 0, $limit);
}

//Set shuffled questions in session
if (!isset($_SESSION['questions'])) {
    $_SESSION['questions'] = shuffleAndSliceQuestions($allQuestions, $questionNum);
}
$questions = $_SESSION['questions'];


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>GeoVista - <?php echo $quizName ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script type="module" src="res/scripts/writeQuestions.js"></script>
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- NAV-BAR -->
    <?php include "./base/nav.php"; ?>

    <!-- PROGRESSBAR -->
    <div class="progress position-sticky" style="top: 0; z-index: 1000; border-radius: 0;">
        <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
            aria-valuenow="<?php echo $current_question_index + 1; ?>" aria-valuemin="0"
            aria-valuemax="<?php echo $questionNum; ?>" ;>
        </div>
    </div>

    <!-- USERNAME -->
    <?php include "./base/username.php"; ?>

    <!-- LEAFLET PLUGIN -->
    <?php include "./base/plugins.php" ?>

    <header class="">
        <h1 class="text-center text-primary"><?php echo $quizName ?></h1>
    </header>

    <main class="m-2 mb-3 m-xl-5">

        <div class="text-center">
            <button class="btn btn-primary px-5 py-2 rounded-4 fw-bold" onclick="location.href='index.php';">Zurück zu
                allen
                Quizzes</button>
        </div>

        <div
            class="border border-5 border-black rounded p-4 mt-5 d-flex flex-column align-items-center justify-content-center">

            <!-- Pass questions array to ts -->
            <div id="questionsContainer" data-questions='<?php echo json_encode($questions); ?>'></div>
            <div id="quizId" data-quizId='<?php echo htmlspecialchars($_GET['quiz']); ?>'></div>

            <div id="mainContent"></div>

        </div>

    </main>

    <!-- FOOTER -->
    <?php include "./base/footer.php"; ?>

    <!-- For bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>