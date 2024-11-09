<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: Content-Type');

    $connect = new mysqli("localhost", "root", "", "OnlineBookStore");
    if(!$connect) die("Connection failed ". $connect->connect_error);

    $data = file_get_contents("php://input");
    $data_decoded = json_decode($data);

    if($data_decoded){
        $UID = $data_decoded["UID"];
        $BID = $data_decoded["BID"];
        $quantity = $data_decoded["quantity"];
        $stmt = $connect->prepare("UPDATE `cart` SET `Quantity` = Quantity + ? WHERE `cart`.`UID` = ? AND `cart`.`B_id` = ?");
        $stmt->bind_param("iii",$quantity,$UID,$BID);

        if ($stmt->execute()) 
            echo json_encode(["message" => "cart Updated"]);
         else 
            echo json_encode(["message" => "Failed to update cart"]);

        $stmt->close();
    }else
        echo json_encode(["message" => "Some error has occured"])
?>