<?php
include 'db.php'; // ملف الاتصال بقاعدة البيانات

$sql = "SELECT name, age, email FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1' style='width:80%; margin:20px auto; text-align:center;'>
            <tr>
                <th>الاسم</th>
                <th>العمر</th>
                <th>البريد الإلكتروني</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["name"] . "</td>
                <td>" . $row["age"] . "</td>
                <td>" . $row["email"] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p style='text-align:center;'>لا يوجد مستخدمين مسجلين.</p>";
}

$conn->close();
?>
