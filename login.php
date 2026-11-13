<?php
require 'db.php';
session_start();

$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($id, $dbUser, $dbHash);
    $found = $stmt->fetch();
    $stmt->close();

    if ($found && password_verify($password, $dbHash)) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $dbUser;
        header("Location: dashboard.php");
        exit;
    }
    // Same message for both cases so attackers can't tell which was wrong
    $error = "Incorrect username or password.";
}

require 'partials.php';
page_header('Log in');
?>
<h1>Log in</h1>
<?php if ($error): ?><p class="error"><?= e($error) ?></p><?php endif; ?>
<form method="POST" action="login.php">
  <label>Username
    <input type="text" name="username" required maxlength="30">
  </label>
  <label>Password
    <input type="password" name="password" required>
  </label>
  <button type="submit">Log in</button>
</form>
<p>No account yet? <a href="signup.php">Sign up</a></p>
<?php page_footer(); ?>
