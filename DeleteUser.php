<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: Content-Type');

    $connect = new mysqli("localhost", "root", "", "OnlineBookStore");
    if ($connect->connect_error) 
        die("Connection error: " . $connect->connect_error);
    $data = file_get_contents("php://input");
    $data_decoded = json_decode($data, true);
    if($data_decoded)
        $query = $data_decoded["uid"]?$data_decoded["uid"]:"";  
    if (!empty($query)) {
        $stmt = $connect->prepare("DELETE FROM  customer WHERE UID = ?");
        $stmt->bind_param("i", $query);
        if ($stmt->execute()) {
            echo json_encode(["message" => "User deleted"]);
        } else {
            echo json_encode(["message" => "Failed to delete User"]);
        }
        $stmt->close();
    } else 
        echo json_encode(["message" => "No  UID specified"]);
    $connect->close();
?>