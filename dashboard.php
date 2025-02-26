<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.html");
    exit();
}
echo "<h2>أهلاً بك، " . $_SESSION["user"] . "!</h2>";
echo "<a href='logout.php'>تسجيل الخروج</a>";
?>
