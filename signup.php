<?php
require 'db.php';
require 'partials.php';

$errors = [];
$success = false;
$username = $email = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm'] ?? '';

    // Server-side validation
    if (!preg_match('/^[A-Za-z0-9_]{3,30}$/', $username)) {
        $errors[] = "Username must be 3-30 characters: letters, numbers or underscore.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 100) {
        $errors[] = "Enter a valid email address.";
    }
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters.";
    }
    if ($password !== $confirm) {
        $errors[] = "Passwords do not match.";
    }

    if (!$errors) {
        // Is the username already taken? (prepared statement)
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errors[] = "That username is already taken.";
        }
        $stmt->close();
    }

    if (!$errors) {
        // Store only the hash, never the plain password
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hash);
        $stmt->execute();
        $stmt->close();
        $success = true;
    }
}

page_header('Sign up');
?>
<h1>Create an account</h1>
<?php if ($success): ?>
  <p class="ok">Account created. <a href="login.php">Log in</a></p>
<?php else: ?>
  <?php foreach ($errors as $err): ?><p class="error"><?= e($err) ?></p><?php endforeach; ?>
  <form method="POST" action="signup.php">
    <label>Username
      <input type="text" name="username" required minlength="3" maxlength="30"
             pattern="[A-Za-z0-9_]{3,30}" value="<?= e($username) ?>">
    </label>
    <label>Email
      <input type="email" name="email" required maxlength="100" value="<?= e($email) ?>">
    </label>
    <label>Password
      <input type="password" name="password" required minlength="8">
    </label>
    <label>Confirm password
      <input type="password" name="confirm" required minlength="8">
    </label>
    <button type="submit">Sign up</button>
  </form>
<?php endif; ?>
<?php page_footer(); ?>
