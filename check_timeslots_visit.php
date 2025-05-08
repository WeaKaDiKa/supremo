<?php

require_once 'db/serverinfo.php';


require_once 'db/server.php';

$gmeet_date = $_POST['schedule_date'];


// Prepare and execute the SQL statement
$stmt = $conn->prepare("SELECT schedule_time FROM visit WHERE schedule_date = ?");
$stmt->bind_param("s", $gmeet_date);
$stmt->execute();
$result = $stmt->get_result();

$unavailable = [];
while ($row = $result->fetch_assoc()) {
    $unavailable[] = $row['schedule_time'];
}

// Return as JSON
echo json_encode($unavailable);

$stmt->close();
$conn->close();
