<?php
session_start();
$usersFile = "users.txt";

include 'db.php'; // الاتصال بقاعدة البيانات

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT name, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($storedName, $storedEmail, $storedPassword);
        $stmt->fetch();
        if (password_verify($password, $storedPassword)) {
            $_SESSION["user"] = $storedName;
            $_SESSION["email"] = $storedEmail; // ✅ حفظ الإيميل في السيشن
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<p style='color:red; text-align:center;'>❌ كلمة المرور غير صحيحة.</p>";
        }
    } else {
        echo "<p style='color:red; text-align:center;'>❌ الإيميل غير مسجل.</p>";
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: login.html");
    exit();
}
?>
