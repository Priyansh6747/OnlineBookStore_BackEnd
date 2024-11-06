<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: Content-Type');

    $connect = new mysqli("localhost","root","","OnlineBookStore");
    if(!$connect) die("Connection error". $connect->connect_error);
    $data = file_get_contents("php://input");
    $data_decoded = json_decode($data,true);
    if($data_decoded){
        $UID = $data_decoded["UID"];
        $BID = $data_decoded["BID"];
        $quatity = $data_decoded["Quantity"];

        $Query  = $connect->prepare("INSERT INTO `cart` (`UID`, `B_id`, `Quantity`) VALUES ('?', '?', '?');");
        $Query->bind_param("sss",$UID,$BID,$quatity);

        if ($Query->execute()) 
            echo json_encode(["message" => "Book added successfully"]);
        else 
            echo json_encode(["error" => "Failed to add data"]);
    }
    else 
        echo json_encode(["error" => "Invalid input"]);
    
        $connect->close();
?>