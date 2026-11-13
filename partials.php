<?php
function e($s) { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

function page_header($title) {
    if (session_status() === PHP_SESSION_NONE) { session_start(); }
    $user = $_SESSION['username'] ?? null;
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
    echo '<title>' . e($title) . ' | IS Project 1</title>';
    echo '<link rel="stylesheet" href="style.css"></head><body>';
    echo '<header><a class="brand" href="index.php">IS Project 1</a><nav>';
    if ($user) {
        echo '<a href="dashboard.php">Dashboard</a><a href="feedback.php">Feedback</a>';
        echo '<a href="logout.php">Log out (' . e($user) . ')</a>';
    } else {
        echo '<a href="login.php">Log in</a><a href="signup.php">Sign up</a><a href="feedback.php">Feedback</a>';
    }
    echo '</nav></header><main>';
}

function page_footer() {
    echo '</main></body></html>';
}
