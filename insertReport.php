<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Method not allowed"]);
    exit;
}

include('db_config.php');

try {
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (!$data) {
        throw new Exception("Invalid JSON data");
    }
    
    $bin_name = isset($data['bin_name']) ? trim($data['bin_name']) : '';
    $action = isset($data['action']) ? trim($data['action']) : '';
    $note = isset($data['note']) ? trim($data['note']) : '';
    
    if (empty($bin_name) || empty($action)) {
        throw new Exception("Bin name and action are required");
    }
    
    // Use prepared statements properly
    $stmt = $conn->prepare("INSERT INTO reports (bin_name, action, note) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $bin_name, $action, $note);
    
    if ($stmt->execute()) {
        echo json_encode([
            "status" => "success", 
            "message" => "Report submitted successfully",
            "report_id" => $conn->insert_id
        ]);
    } else {
        throw new Exception("Failed to insert report");
    }
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        "status" => "error", 
        "message" => $e->getMessage()
    ]);
} finally {
    if (isset($stmt)) $stmt->close();
    $conn->close();
}
?>