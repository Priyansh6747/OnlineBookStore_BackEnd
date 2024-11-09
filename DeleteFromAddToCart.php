<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: Content-Type');

    $connect = new mysqli("localhost", "root", "", "OnlineBookStore");
    if ($connect->connect_error) 
        die("Connection error: " . $connect->connect_error);
    $data = file_get_contents("php://input");
    $data_decoded = json_decode($data, true);
    if($data_decoded){
        $BID = $data_decoded["B_id"]?$data_decoded["B_id"]:"";
        $UID = $data_decoded["UID"]?$data_decoded["UID"]:""; 
    }
         
    if (!empty($BID)) {
        $stmt = $connect->prepare("DELETE FROM cart WHERE B_id = ? AND UID = ?");
        $stmt->bind_param("ii", $BID,$UID);
        if ($stmt->execute()) 
            echo json_encode(["message" => "Book deleted"]);
        else 
            echo json_encode(["message" => "Failed to delete book"]);
        
        $stmt->close();
    } else 
        echo json_encode(["message" => "No book ID specified"]);
    $connect->close();
?>