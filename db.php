<?php
// Database connection. Edit the password to match the one in schema.sql.
// Do NOT commit your real password to GitHub.
$DB_HOST = "localhost";
$DB_NAME = "CAT2";
$DB_USER = "catuser";
$DB_PASS = "ChangeThisPassword123!";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    $conn->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
    http_response_code(500);
    exit("Could not connect to the database. Check db.php and that MariaDB is running.");
}
