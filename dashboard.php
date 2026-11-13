<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require 'partials.php';
page_header('Dashboard');
?>
<h1>Welcome, <?= e($_SESSION['username']) ?></h1>
<p class="ok">You are logged in.</p>
<p><a class="button" href="feedback.php">Leave feedback</a></p>
<?php page_footer(); ?>
