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
    <title>Show Users</title>
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
    <h2>✅ أهلاً بك، <?php echo $_SESSION["user"]; ?> - بيانات المستخدمين</h2>

    <!-- ✅ عرض البيانات من قاعدة البيانات -->
    <h3>📊 البيانات من قاعدة البيانات</h3>
    <table>
        <tr>
            <th>الاسم</th>
            <th>العمر</th>
            <th>الإيميل</th>
        </tr>
        <?php
        $result = $conn->query("SELECT name, age, email FROM users");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['name']}</td>
                        <td>{$row['age']}</td>
                        <td>{$row['email']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='3'>لا يوجد مستخدمين.</td></tr>";
        }
        ?>
    </table>

    <!-- ✅ عرض البيانات من users.txt -->
    <h3>📂 البيانات من ملف users.txt</h3>
    <table>
        <tr>
            <th>الاسم</th>
            <th>العمر</th>
            <th>الإيميل</th>
        </tr>
        <?php
        $usersFile = "users.txt";
        if (file_exists($usersFile)) {
            $users = file($usersFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($users as $user) {
                list($name, $age, $email, $password) = explode(" | ", $user);
                echo "<tr>
                        <td>$name</td>
                        <td>$age</td>
                        <td>$email</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='3'>⚠ لا يوجد بيانات في users.txt.</td></tr>";
        }
        ?>
    </table>

    <a href="dashboard.php"><button class="btn">⬅ الرجوع إلى Dashboard</button></a>
</body>
</html>

<?php
$conn->close();
?>
