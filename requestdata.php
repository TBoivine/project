<?php

include('db_config.php');



//header('Content-Type: application/json');
//echo json_encode($data);
// Fetch latest entries
$sql = "SELECT bin_name, fillLevel, lat, lng, timestamp FROM wastedata ORDER BY timestamp DESC";
$result = $conn->query($sql);

$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}


echo json_encode($data);
$conn->close();
?>