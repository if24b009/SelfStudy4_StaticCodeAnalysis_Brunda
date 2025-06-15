<?php
//Access to database


/* User */
function getUserId($db, $username)
{
    $result = null;
    try {
        $sql = "SELECT id_user FROM user WHERE username = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_array()["id_user"];
        $stmt->close();
    } catch (Exception $e) {
        echo '<div class="alert alert-danger" role="alert">Error: ' . $e->getMessage() . "</div>\n";
    } finally {
        return $result;
    }
}

function getUserDetails($db, $id)
{
    $result = null;
    try {
        $sql = "SELECT * FROM user WHERE id_user = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $id); // "i" specifies that the parameter is an integer
        $stmt->execute();
        $result = $stmt->get_result()->fetch_array();
        $stmt->close();
    } catch (Exception $e) {
        echo '<div class="alert alert-danger" role="alert">Error: ' . $e->getMessage() . "</div>\n";
    } finally {
        return $result;
    }
}

function getRole($db, $id)
{
    $result = null;
    try {
        $sql = "SELECT isAdmin FROM user WHERE id_user = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $id); // "i" specifies that the parameter is an integer
        $stmt->execute();
        $result = $stmt->get_result()->fetch_array();
        $stmt->close();
    } catch (Exception $e) {
        echo '<div class="alert alert-danger" role="alert">Error: ' . $e->getMessage() . "</div>\n";
    } finally {
        return $result["isAdmin"] == 1 ? "Admin" : "User";
    }
}

function updateUserDetails($db, $id, $email, $username, $password, $isAdmin)
{
    try {
        $sql = "UPDATE user SET email = ?, username = ?, password = ?, isAdmin = ? WHERE id_user = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("sssii", $email, $username, $password, $isAdmin, $id);
        $stmt->execute();
        $stmt->close();
    } catch (Exception $e) {
        echo '<div class="alert alert-danger" role="alert">Error: ' . $e->getMessage() . "</div>\n";
    }
}

function getUsers($db)
{
    $users = [];
    try {
        $sql = "SELECT * FROM user ORDER BY id_user";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }
    } catch (Exception $e) {
        echo '<div class="alert alert-danger" role="alert">Error: ' . $e->getMessage() . "</div>\n";
    } finally {
        return $users;
    }
}

function getUsernames($db)
{
    $users = [];
    try {
        $sql = "SELECT username FROM user ORDER BY id_user";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row["username"];
            }
        }
    } catch (Exception $e) {
        echo '<div class="alert alert-danger" role="alert">Error: ' . $e->getMessage() . "</div>\n";
    } finally {
        return $users;
    }
}


/* Quizzes */
function getQuizzes($db)
{
    $quizzes = [];
    try {
        $sql = "SELECT * FROM quiz ORDER BY id_quiz";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $quizzes[] = $row;
            }
        }
    } catch (Exception $e) {
        echo '<div class="alert alert-danger" role="alert">Error: ' . $e->getMessage() . "</div>\n";
    } finally {
        return $quizzes;
    }
}

function getQuizName($db, $quiz_id)
{
    $result = null;
    try {
        $sql = "SELECT name FROM quiz WHERE id_quiz = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $quiz_id); // "i" specifies that the parameter is an integer
        $stmt->execute();
        $result = $stmt->get_result()->fetch_array()["name"];
        $stmt->close();
    } catch (Exception $e) {
        echo '<div class="alert alert-danger" role="alert">Error: ' . $e->getMessage() . "</div>\n";
    } finally {
        return $result;
    }
}

/* Questions */
function getQuestions($db, $quiz_id)
{
    $questions = [];
    try {
        //Fetch all questions for the quiz
        $sql = "SELECT id_question, description as q_desc, image FROM question WHERE fk_quiz = ? ORDER BY id_question";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $quiz_id); //"i" specifies that the parameter is an integer
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                //Fetch answers for each question
                $answers = getAnswersToQuestion($db, $row['id_question']);
                $row['answers'] = $answers; //Add answers as a nested array
                $questions[] = $row;
            }
        }
    } catch (Exception $e) {
        echo '<div class="alert alert-danger" role="alert">Error: ' . $e->getMessage() . "</div>\n";
    } finally {
        return $questions;
    }
}

function getAnswersToQuestion($db, $id_question){
    $answers = [];
    try {
        $sql = "SELECT id_answer, description as a_desc, isCorrectAnswer FROM answer WHERE fk_question = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $id_question); // "i" specifies that the parameter is an integer
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $answers[] = $row;
            }
        }
    } catch (Exception $e) {
        echo '<div class="alert alert-danger" role="alert">Error: ' . $e->getMessage() . "</div>\n";
    } finally {
        return $answers;
    }
}


function saveRegistration($db, $username, $email, $password) {
    try {
        $sql = "INSERT INTO user (username, email, password, isAdmin, fk_geovista) 
                VALUES (?, ?, ?, 0, 1);";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $password);
        $stmt->execute();
        $stmt->close();
    } catch (Exception $e) {
        echo '<div class="alert alert-danger" role="alert">Error: ' . $e->getMessage() . "</div>\n";
    }
}

function saveQuestion($db, $description, $answers, $quiz_id, $image = null) {
    try {
        //Insert question
        $sql = "INSERT INTO question (description, image, fk_quiz) VALUES (?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("ssi", $description, $image, $quiz_id);
        $stmt->execute();
        $question_id = $db->insert_id; //get id of last inserted question
        $stmt->close();

        //Insert answers
        foreach ($answers as $answer) {
            $sql = "INSERT INTO answer (description, isCorrectAnswer, fk_question) VALUES (?, ?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("ssi", $answer['description'], $answer['isCorrect'], $question_id);
            $stmt->execute();
            $stmt->close();
        }
    } catch (Exception $e) {
        echo '<div class="alert alert-danger" role="alert">Error: ' . $e->getMessage() . "</div>\n";
    }
}


?>