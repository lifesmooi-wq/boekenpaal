<?php
session_start();
require "config.php";

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "Not logged in"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$score = (int)($data['score'] ?? 0);
$quiz_name = $data['quiz_name'] ?? 'default';
$user_id = $_SESSION['user_id'];


/* Add points to user */
$stmt = $conn->prepare("UPDATE users SET points = points + ? WHERE id = ?");
$stmt->bind_param("ii", $score, $user_id);
$stmt->execute();
$stmt->close();


/* Save highscore */
$stmt = $conn->prepare("
    INSERT INTO highscores (user_id, quiz_name, score)
    VALUES (?, ?, ?)
    ON DUPLICATE KEY UPDATE score = GREATEST(score, VALUES(score))
");
$stmt->bind_param("isi", $user_id, $quiz_name, $score);
$stmt->execute();
$stmt->close();


/* Get updated total points */
$stmt = $conn->prepare("SELECT points FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($total_points);
$stmt->fetch();
$stmt->close();


/* Return data to JS */
echo json_encode([
    "success" => true,
    "score_added" => $score,
    "total_points" => $total_points
]);
?>
