<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sahyog1";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
            echo "Applied Succesfully! ,Your applications:";

}

$NGO_ID = $_SESSION['NGO_ID'];
$type = $_GET['type'];
$id = $_GET['id'];

$table = "";
$id_column = "";
$fields = [];

if ($type == 'jobs') {
    $table = "jobs";
    $id_column = "Job_ID";
    $fields = ['Job_Title', 'Job_Description', 
    'location','Job_Date', 'Eligibility', 'Salary'];
} elseif ($type == 'scheme') {
    $table = "scheme";
    $id_column = "Scheme_ID";
    $fields = ['Scheme_Title', 'Scheme_Description', 'location', 
    'Scheme_Date','Eligibility', 'Category'];
} elseif ($type == 'trainings') {
    $table = "trainings";
    $id_column = "Training_ID";
    $fields = ['Training_Title', 'Training_Description','Training_Date','Duration',
     'location', 'Mode', 'Eligibility', 'Skills','Contact'];
} else {
    die("Invalid type");
}

// Fetch existing data
$stmt = $conn->prepare("SELECT * FROM $table WHERE $id_column = ? AND NGO_ID = ?");
$stmt->bind_param("ii", $id, $NGO_ID);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) die("No record found or access denied");

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $set_clause = [];
    $values = [];

    foreach ($fields as $field) {
        $set_clause[] = "$field = ?";
        $values[] = $_POST[$field];
    }

    $values[] = $id;
    $values[] = $NGO_ID;

    $query = "UPDATE $table SET " . implode(', ', $set_clause) . 
    " WHERE $id_column = ? AND NGO_ID = ?";
    $stmt = $conn->prepare($query);

    // dynamic binding
    $types = str_repeat('s', count($fields)) . "ii";
    $stmt->bind_param($types, ...$values);

    if ($stmt->execute()) {
        echo "<script>alert('Details updated successfully'); 
        window.location.href='14_NGO_dashboard.php';</script>";
        exit;
    } else {
        echo "<script>alert('Error updating details');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit <?= ucfirst($type) ?> Details</title>
</head>
<link rel="stylesheet" href="Styling.css">
</head>
<body>
<div class="PageWrapper">
<form method="POST">
    <h2 class="FormHeadings">Edit <?= ucfirst($type) ?></h2>
    <?php foreach ($fields as $f): ?>
        <label><?= str_replace('_', ' ', $f) ?>:</label>
        <?php if (stripos($f, 'Description') !== false): ?>
            <textarea name="<?= $f ?>"><?= htmlspecialchars($data[$f]) ?></textarea>
        <?php elseif (stripos($f, 'Date') !== false): ?>
            <input type="date" name="<?= $f ?>" value="<?= htmlspecialchars($data[$f]) ?>">
        <?php else: ?>
            <input type="text" name="<?= $f ?>" value="<?= htmlspecialchars($data[$f]) ?>">
        <?php endif; ?>
    <?php endforeach; ?>
    <button type="submit">Update <?= ucfirst($type) ?></button>
</form>
</div>

</body>
</html>
