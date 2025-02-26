<?php
$servername = "localhost";
$username = "root"; // في XAMPP غالبًا بيكون root
$password = "";     // في XAMPP بيكون فاضي غالبًا
$dbname = "userData";

// الاتصال بقاعدة البيانات
$conn = new mysqli($servername, $username, $password, $dbname);

// التأكد من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
} else {
    echo "✅ تم الاتصال بقاعدة البيانات بنجاح!";
}
?>
