<?php
session_start();
include 'db.php'; // الاتصال بقاعدة البيانات

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $age = $_POST["age"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // التحقق من قوة كلمة المرور
    if (strlen($password) < 8 || ctype_alpha($password)) {
        echo "<p style='color:red; text-align:center;'>❌ كلمة المرور يجب أن تحتوي على أرقام أو رموز وألا تقل عن 8 أحرف.</p>";
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // تشفير كلمة المرور

    // ✅ 1. إضافة البيانات إلى قاعدة البيانات
    $stmt = $conn->prepare("INSERT INTO users (name, age, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siss", $name, $age, $email, $hashedPassword);

    try {
        $stmt->execute();

        // ✅ 2. إضافة البيانات إلى users.txt
        $userData = "$name | $age | $email | $hashedPassword\n";
        file_put_contents("users.txt", $userData, FILE_APPEND);

        echo "<p style='color:green; text-align:center;'>✅ تم التسجيل بنجاح!</p>";
        echo "<p style='text-align:center;'><a href='login.html'>🔑 تسجيل الدخول</a></p>";

    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) { // خطأ التكرار (الإيميل موجود بالفعل)
            echo "<p style='color:red; text-align:center;'>⚠ هذا البريد الإلكتروني مسجل بالفعل.</p>";
        } else {
            echo "<p style='color:red; text-align:center;'>❌ حدث خطأ أثناء التسجيل: " . $e->getMessage() . "</p>";
        }
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: signup.html");
    exit();
}
?>
