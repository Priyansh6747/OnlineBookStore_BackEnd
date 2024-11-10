<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: Content-Type');

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $connect = new mysqli("localhost", "root", "", "OnlineBookStore");
    if ($connect->connect_error) {
        echo json_encode(["message" => "Connection error: " . $connect->connect_error]);
        exit;
    }

    $data = file_get_contents("php://input");
    $data_decoded = json_decode($data, true);

    if ($data_decoded && isset($data_decoded["UID"], $data_decoded["BID"], $data_decoded["Quantity"])) {
        $UID = $data_decoded["UID"];
        $BID = $data_decoded["BID"];
        $quantity = $data_decoded["Quantity"];

        $stmt = $connect->prepare("UPDATE `cart` SET `Quantity` = Quantity + ? WHERE `cart`.`UID` = ? AND `cart`.`B_id` = ?");
        $stmt->bind_param("sss", $quantity, $UID, $BID);

        if ($stmt->execute()) 
            echo json_encode(["message" => "Cart updated"]);
        else 
            echo json_encode(["message" => "Failed to update cart"]);

        $stmt->close();
    } else {
        echo json_encode(["message" => "Invalid or missing UID/BID/Quantity"]);
    }

    $connect->close();
?>