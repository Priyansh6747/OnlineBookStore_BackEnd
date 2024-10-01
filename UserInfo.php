<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: Content-Type');

    $connect = new mysqli("localhost","root","","OnlineBookStore");
    if($connect->connect_error)
        die("Connection error ". $connect->connect_error);

    $data = file_get_contents("php://input");
    $data_decoded = json_decode($data,true);
    $username = $data_decoded['Username'];
    $sql_result = $connect->prepare("Select Password from customer where username = ?");
    $sql_result->bind_param("s",$username);
    if(!$sql_result)
        die("Invalid query " . $connect->error);
    $sql_result->execute();
    $result = $sql_result->get_result();
    $row = $result->fetch_assoc();

    if ($row) 
        echo json_encode($row);
    else 
        echo json_encode(['error' => 'User not found']);
    $sql_result->close();
    $connect->close();
?>