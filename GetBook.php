<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: Content-Type');

    $connect = new mysqli("localhost", "root", "", "OnlineBookStore");
    if ($connect->connect_error) 
        die("Connection error: " . $connect->connect_error);

    $data = file_get_contents("php://input");
    $data_decoded = json_decode($data, true);

    if ($data_decoded && isset($data_decoded["bid"])) {
        $bid = $data_decoded["bid"];
        $query = $connect->prepare("SELECT * FROM book WHERE B_id = ?");
        $query->bind_param("s", $bid);

        if ($query->execute()) {
            $result = $query->get_result();
            $book = $result->fetch_assoc(); 
            echo json_encode($book ? $book : ["message" => "Book not found"]);
        } else 
            echo json_encode(["message" => "Query execution failed"]);
        $query->close();
    } else 
        echo json_encode(["message" => "Invalid or missing BID"]);
    
    $connect->close();
?>
