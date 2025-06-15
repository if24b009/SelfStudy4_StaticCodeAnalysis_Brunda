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

$quizzes = getQuizzes($db);

$errorMessages = [];
$errorFields = []; //Identifying fields for different kinds of errors
$errorFields["quiz"] = false;
$errorFields["question"] = false;
$errorFields["answer"] = false;
$errorFields["isCorrect"] = false;
$errorFields["picture"] = false;

if (count($_POST) > 0 && $_SERVER["REQUEST_METHOD"] == "POST") {

    //Quiz
    if (empty($_POST["selection"])) {
        $errorMessages[] = "Fehlendes Quiz. Bitte wähle ein Quiz aus!";
        $errorFields["quiz"] = true;
    }

    //Question
    if (empty($_POST["question"])) {
        $errorMessages[] = "Fehlender Fragentitel. Bitte gib eine Frage ein!";
        $errorFields["question"] = true;
    }

    //Answers
    if (empty($_POST["answer1"]) || empty($_POST["answer2"]) || empty($_POST["answer3"]) || empty($_POST["answer4"])) {
        $errorMessages[] = "Fehlende Antwortmöglichkeit. Bitte fülle alle Antwortfelder aus!";
        $errorFields["answer"] = true;
    }

    $corrects = ['isCorrect1', 'isCorrect2', 'isCorrect3', 'isCorrect4'];
    $setCorrects = array_filter($corrects, function ($field) {
        return isset($_POST[$field]) && $_POST[$field] !== '';
    });
    if (count($setCorrects) !== 1) {
        $errorMessages[] = "Bitte markiere genau eine Antwortmöglichkeit als richtig!";
        $errorFields["isCorrect"] = true;
    }
}


//save and redirect if successful profil update
if (count($_POST) > 0 && count($errorMessages) === 0) {
    $answers = [
        [
            'description' => $_POST['answer1'],
            'isCorrect' => isset($_POST['isCorrect1']) ? 1 : 0
        ],
        [
            'description' => $_POST['answer2'],
            'isCorrect' => isset($_POST['isCorrect2']) ? 1 : 0
        ],
        [
            'description' => $_POST['answer3'],
            'isCorrect' => isset($_POST['isCorrect3']) ? 1 : 0
        ],
        [
            'description' => $_POST['answer4'],
            'isCorrect' => isset($_POST['isCorrect4']) ? 1 : 0
        ]
    ];

    $filename = null;
    if (isset($_SESSION['filename'])) {
        $filename = $_SESSION['filename'];
        unset($_SESSION['filename']);
    } else if (isset($_POST["selection"]) && ($_POST["selection"] == "1" || $_POST["selection"] == "4")) {
        $filename = $_POST['countryCode'];
    }

    saveQuestion($db, $_POST['question'], $answers, $_POST['selection'], $filename);

    $_SESSION['successQuestionupload'] = "Frage erfolgreich hochgeladen!";
    header("Location: ./index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>GeoVista - Fragenerstellung</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script type="module" src="res/scripts/upload_question.js"></script>
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- NAV-BAR -->
    <?php include "./base/nav.php"; ?>

    <header class="mt-4">
        <h1 class="text-center text-primary">Neue Frage erstellen</h1>
    </header>

    <main class="container w-75 my-5">

        <p class="text-center text-muted mb-5">Bitte füllen Sie diese Felder aus:</p>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
            <div class="p-5 border rounded-4 shadow-sm bg-white">

                <!-- Quiz -->
                <section
                    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-2">
                    <div>
                        <label for="selection" class="form-label fw-semibold mb-2">Wähle ein Quiz:<span
                                class="text-primary">*</span></label>
                        <select id="selection" name="selection" class="form-select <?php if ($errorFields['quiz'])
                            echo 'is-invalid'; ?>" required>
                            <option value="" disabled selected>Wähle ein Quiz...</option>
                            <?php
                            if ($quizzes) {
                                foreach ($quizzes as $quiz) {
                                    echo "<option value='" . htmlspecialchars($quiz["id_quiz"]) . "'>" . htmlspecialchars($quiz["name"]) . "</option>";
                                }
                            } else {
                                echo "<option value='' disabled>Keine Quizzes vorhanden.</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <p id="displayQuiz" class="mb-0 ms-md-3 mt-2 mt-md-0"></p>
                </section>



                <!-- Frage -->
                <div class="mb-4">
                    <label for="question" class="form-label fw-semibold">Frage<span
                            class="text-primary">*</span></label>
                    <input type="text" class="form-control" <?php if ($errorFields['question'])
                        echo 'is-invalid'; ?> id="question" name="question"
                        value="<?php echo isset($_POST['question']) ? htmlspecialchars($_POST['question']) : ''; ?>"
                        required>
                </div>

                <!-- Antwortmoeglichkeiten -->
                <div class="table-responsive mb-4">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Nummer</th>
                                <th scope="col">Antworten<span class="text-primary">*</span></th>
                                <th scope="col" <?php if ($errorFields['isCorrect'])
                                    echo 'is-invalid'; ?>>Korrekte Antwort<span class="text-primary">*</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td scope="row" class="py-3"><label for="answer1"
                                        class="form-label fw-semibold">1</label></td>
                                <td scope="row" class="py-3"><input type="text" <?php if ($errorFields['answer'])
                                    echo 'is-invalid'; ?> class="form-control" id="answer1" name="answer1"
                                        value="<?php echo isset($_POST['answer1']) ? htmlspecialchars($_POST['answer1']) : ''; ?>"
                                        required></td>
                                <td class="py-3"><input type="checkbox" id="isCorrect1" name="isCorrect1"></td>
                            </tr>
                            <tr>
                                <td scope="row" class="py-3"><label for="answer2"
                                        class="form-label fw-semibold">2</label></td>
                                <td scope="row" class="py-3"><input type="text" <?php if ($errorFields['answer'])
                                    echo 'is-invalid'; ?> class="form-control" id="answer2" name="answer2"
                                        value="<?php echo isset($_POST['answer2']) ? htmlspecialchars($_POST['answer2']) : ''; ?>"
                                        required></td>
                                <td class="py-3"><input type="checkbox" id="isCorrect2" name="isCorrect2"></td>
                            </tr>
                            <tr>
                                <td scope="row" class="py-3"><label for="answer3"
                                        class="form-label fw-semibold">3</label></td>
                                <td scope="row" class="py-3"><input type="text" <?php if ($errorFields['answer'])
                                    echo 'is-invalid'; ?> class="form-control" id="answer3" name="answer3"
                                        value="<?php echo isset($_POST['answer3']) ? htmlspecialchars($_POST['answer3']) : ''; ?>"
                                        required></td>
                                <td class="py-3"><input type="checkbox" id="isCorrect3" name="isCorrect3"></td>
                            </tr>
                            <tr>
                                <td scope="row" class="py-3"><label for="answer3"
                                        class="form-label fw-semibold">4</label></td>
                                <td scope="row" class="py-3"><input type="text" <?php if ($errorFields['answer'])
                                    echo 'is-invalid'; ?> class="form-control" id="answer4" name="answer4"
                                        value="<?php echo isset($_POST['answer4']) ? htmlspecialchars($_POST['answer4']) : ''; ?>"
                                        required></td>
                                <td class="py-3"><input type="checkbox" id="isCorrect4" name="isCorrect4"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="dependentData">
                </div>

                <p class="text-center text-muted mt-4 mb-2">
                    Alle mit <span class="text-primary">*</span> gekennzeichneten Felder sind Pflichtfelder.
                </p>

                <div class="text-center mt-5">
                    <button type="submit" id="uploadBtn" class="btn btn-primary px-5 py-2 rounded-4 fw-bold">
                        Upload
                    </button>
                    <a href="./index.php"
                        class="btn btn-outline-primary px-5 py-2 rounded-4 fw-bold mt-4 mt-xl-0 ms-0 ms-xl-2">
                        Abbrechen
                    </a>
                </div>

            </div>

        </form>

        <!-- Check after submission -->
        <?php
        if (count($errorMessages) > 0) {
            echo "<div class='alert alert-danger mt-4' role='alert'><p><strong>Fehler beim Hochladen der Frage.</strong><br>Bitte überprüfe folgende Angaben:</p>";
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