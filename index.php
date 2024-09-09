<?php
// Connect to the database
$mysqli = new mysqli("localhost", "root", "", "anti_ragging_db");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Fetch incidents from the database
$sql = "SELECT college_name, accused_name FROM reports WHERE approved = 1";
$result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Anti-Ragging Campaign</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>

<header>
    <div class="container">
        <h1>Anti-Ragging Campaign</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="report.php">Report Incident</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </div>
</header>

<main>
    <section class="report-section container">
        <h2>Recent Reports</h2>
        <div class="report-table">
            <div class="table-header">
                <span>College Name</span>
                <span>Accused Student</span>
            </div>
            <?php if ($result->num_rows > 0) { ?>
                <?php while($row = $result->fetch_assoc()) { ?>
                    <div class="table-row">
                        <span><?php echo htmlspecialchars($row['college_name']); ?></span>
                        <span><?php echo htmlspecialchars($row['accused_name']); ?></span>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="table-row">
                    <span colspan="2">No incidents reported yet.</span>
                </div>
            <?php } ?>
        </div>
    </section>
</main>

<footer>
    <div class="container">
        <p>&copy; 2024 Anti-Ragging Campaign. All rights reserved.</p>
    </div>
</footer>

</body>
</html>

<?php
$mysqli->close();
?>
