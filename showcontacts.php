<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.html");
    exit();
}

include 'db.php'; // الاتصال بقاعدة البيانات
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Show Contact Messages</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        table { margin: 20px auto; border-collapse: collapse; width: 80%; }
        th, td { border: 1px solid #ddd; padding: 10px; }
        th { background-color: #f4f4f4; }
        .btn { padding: 10px 20px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
        .btn:hover { background-color: #45a049; }
    </style>
</head>
<body>
    <h2>📨 أهلاً بك، <?php echo $_SESSION["user"]; ?> - رسائل الزوار</h2>

    <!-- ✅ عرض البيانات من قاعدة البيانات -->
    <h3>🗂 البيانات من قاعدة البيانات (contacts)</h3>
    <table>
        <tr>
            <th>الاسم</th>
            <th>الإيميل</th>
            <th>الرسالة</th>
        </tr>
        <?php
        $result = $conn->query("SELECT name, email, message FROM contacts");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['name']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['message']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='3'>⚠ لا توجد رسائل حتى الآن.</td></tr>";
        }
        ?>
    </table>

    <!-- ✅ عرض البيانات من contacts.txt -->
    <h3>📂 البيانات من ملف contacts.txt</h3>
    <table>
        <tr>
            <th>الاسم</th>
            <th>الإيميل</th>
            <th>الرسالة</th>
        </tr>
        <?php
        $contactsFile = "contacts.txt";
        if (file_exists($contactsFile)) {
            $contacts = file($contactsFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($contacts as $contact) {
                list($name, $email, $message) = explode(" | ", $contact);
                echo "<tr>
                        <td>$name</td>
                        <td>$email</td>
                        <td>$message</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='3'>⚠ لا توجد بيانات في contacts.txt.</td></tr>";
        }
        ?>
    </table>

    <a href="dashboard.php"><button class="btn">⬅ الرجوع إلى Dashboard</button></a>
</body>
</html>

<?php
$conn->close();
?>
