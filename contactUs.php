<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.html");
    exit();
}

include 'db.php'; // الاتصال بقاعدة البيانات

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    // ✅ التحقق من تطابق الإيميل مع المستخدم المسجل
    $userEmail = $_SESSION["email"]; 
    if ($email !== $userEmail) {
        echo "<p style='color:red; text-align:center;'>❌ الإيميل الذي أدخلته لا يطابق الإيميل المسجل.</p>";
        echo "<p style='text-align:center;'><a href='contactUs.html'>الرجوع إلى Contact Us</a></p>";
        exit();
    }

    // ✅ حفظ البيانات في ملف نصي contacts.txt
    $contactFile = "contacts.txt";
    $contactData = "$name | $email | $message\n";
    file_put_contents($contactFile, $contactData, FILE_APPEND);

    // ✅ حفظ البيانات في قاعدة البيانات contacts
    $stmt = $conn->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        echo "<p style='color:green; text-align:center;'>✅ تم إرسال رسالتك بنجاح! شكرًا لتواصلك معنا.</p>";
        echo "<p style='text-align:center;'><a href='index.html'>الرجوع إلى الصفحة الرئيسية</a></p>";
    } else {
        echo "<p style='color:red; text-align:center;'>❌ حدث خطأ أثناء إرسال الرسالة.</p>";
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: contactUs.html");
    exit();
}
?>

