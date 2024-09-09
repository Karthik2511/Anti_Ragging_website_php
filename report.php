<?php
$success = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $college_name = $_POST['college_name'];
    $accused_name = $_POST['accused_name'];
    $file_name = $_FILES['evidence']['name'];
    $file_tmp = $_FILES['evidence']['tmp_name'];
    $upload_dir = "uploads/";

    // Database connection
    $mysqli = new mysqli("localhost", "username", "password", "anti_ragging_db");

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Move uploaded file
    if (move_uploaded_file($file_tmp, $upload_dir . $file_name)) {
        $stmt = $mysqli->prepare("INSERT INTO reports (college_name, accused_name, evidence) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $college_name, $accused_name, $file_name);
        if ($stmt->execute()) {
            $success = "Report successfully submitted!";
        } else {
            $error = "Error submitting report.";
        }
        $stmt->close();
    } else {
        $error = "Failed to upload evidence.";
    }

    $mysqli->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Report Incident</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
    <h1>Anti-Ragging Campaign</h1>
    <nav>
        <a href="index.php">Home</a>
        <a href="report.php">Report Incident</a>
    </nav>
</header>

<main>
    <section>
        <h2>Report an Incident</h2>
        <?php if ($success) echo "<p class='success'>$success</p>"; ?>
        <?php if ($error) echo "<p class='error'>$error</p>"; ?>
        <form method="POST" enctype="multipart/form-data">
            <label for="college_name">College Name:</label>
            <input type="text" id="college_name" name="college_name" required>

            <label for="accused_name">Accused Student Name:</label>
            <input type="text" id="accused_name" name="accused_name" required>

            <label for="evidence">Upload Evidence (Image/Video):</label>
            <input type="file" id="evidence" name="evidence" required>

            <input type="submit" value="Submit Report">
        </form>
    </section>
</main>

</body>
</html>
