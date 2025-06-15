<!-- Display username of logged in user -->
<?php
if (session_status() == PHP_SESSION_NONE)
    session_start();

require_once('config/dbaccess.php'); //to retrieve connection details
require_once('config/db_utils.php'); //functions for database access
$db = new mysqli($host, $user, $password, $database);
if ($db->connect_error) {
    echo "Connection Error: " . $db->connect_error;
    exit();
}

/* only for logged in user */
$user = getUserDetails($db, $_SESSION['userid']);
if ($user) echo "<p class='mt-3 ms-0 ms-xl-4 text-center text-xl-start'>Angemeldet als: <span class='fw-bold'>" . $user["username"] . "</span></p>";

?>