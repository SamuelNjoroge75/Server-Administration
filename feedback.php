<?php
require 'db.php';
require 'partials.php';

$errors = [];
$saved = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '' || strlen($name) > 100) {
        $errors[] = "Enter your name (up to 100 characters).";
    }
    if ($message === '' || strlen($message) > 1000) {
        $errors[] = "Enter a message (up to 1000 characters).";
    }
    if (!$errors) {
        $stmt = $conn->prepare("INSERT INTO feedback (name, message) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $message);
        $stmt->execute();
        $stmt->close();
        $saved = true;
    }
}

$rows = $conn->query("SELECT id, name, message, submitted_at FROM feedback ORDER BY id DESC");

page_header('Feedback');
?>
<h1>Feedback</h1>
<?php if ($saved): ?><p class="ok">Thanks, your feedback was saved.</p><?php endif; ?>
<?php foreach ($errors as $err): ?><p class="error"><?= e($err) ?></p><?php endforeach; ?>
<form method="POST" action="feedback.php">
  <label>Name
    <input type="text" name="name" required maxlength="100">
  </label>
  <label>Message
    <textarea name="message" rows="4" required maxlength="1000"></textarea>
  </label>
  <button type="submit">Send feedback</button>
</form>

<h2>Stored feedback</h2>
<table>
  <tr><th>ID</th><th>Name</th><th>Message</th><th>Submitted</th></tr>
  <?php while ($r = $rows->fetch_assoc()): ?>
    <tr>
      <td><?= (int)$r['id'] ?></td>
      <td><?= e($r['name']) ?></td>
      <td><?= e($r['message']) ?></td>
      <td><?= e($r['submitted_at']) ?></td>
    </tr>
  <?php endwhile; ?>
</table>
<?php page_footer(); ?>
