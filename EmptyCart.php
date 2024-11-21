<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');

$connect = new mysqli("localhost", "root", "", "OnlineBookStore");
if ($connect->connect_error) {
    die(json_encode(["message" => "Connection error: " . $connect->connect_error]));
}

$data = file_get_contents("php://input");
$data_decoded = json_decode($data, true);

if ($data_decoded && isset($data_decoded["UID"])) {
    $UID = $data_decoded["UID"];

    $stmt = $connect->prepare("DELETE FROM cart WHERE UID = ?");
    $stmt->bind_param("i", $UID);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Cart deleted"]);
    } else {
        echo json_encode(["message" => "Failed to delete cart"]);
    }

    $stmt->close();
} else {
    echo json_encode(["message" => "Invalid data or missing UID"]);
}

$connect->close();
?>