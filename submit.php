<?php

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "students_db"; 


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Databe connection failed: " . $conn->connect_error);
}

$full_name = $_POST["full_name"];
$email = $_POST["email"];
$gender = $_POST["gender"];

$errors = array();

if (empty($full_name)) {
    $errors[] = "Full Name field cannot be left blank.";
}

if (empty($email)) {
    $errors[] = "Email Address field cannot be left blank.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Enter a valid Email Address.";
}

if (empty($gender)) {
    $errors[] = "Gender field cannot be left blank.";
}

if (empty($errors)) {
    // Veritabanına ekleme sorgusu
    $sql = "INSERT INTO students (full_name, email, gender)
            VALUES ('$full_name', '$email', '$gender')";

    if ($conn->query($sql) === TRUE) {
        echo "The data has been successfully added to the database.";
    } else {
        echo "Data insertion error: " . $conn->error;
    }
} else {
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
}


$sql = "SELECT * FROM students";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Registered Students:</h2>";
    echo "<table>";
    echo "<tr><th>ID</th><th>Full Name</th><th>Email</th><th>Gender</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row["id"]."</td>";
        echo "<td>".$row["full_name"]."</td>";
        echo "<td>".$row["email"]."</td>";
        echo "<td>".$row["gender"]."</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "There are no registered students yet.";
}

$conn->close();

?>
