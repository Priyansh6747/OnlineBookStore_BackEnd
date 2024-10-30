<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: Content-Type');

    $connect = new mysqli("localhost", "root", "", "OnlineBookStore");
    if ($connect->connect_error) 
        die("Connection error: " . $connect->connect_error);
    $query = isset($_GET['q']) ? $_GET['q'] : '';    
    if (!empty($query)) {
        $stmt = $connect->prepare("DELETE FROM book WHERE B_id = ?");
        $stmt->bind_param("i", $query);
        if ($stmt->execute()) {
            echo json_encode(["message" => "Book deleted"]);
        } else {
            echo json_encode(["error" => "Failed to delete book"]);
        }
        $stmt->close();
    } else 
        echo json_encode(["error" => "No book ID specified"]);
    $connect->close();
?>