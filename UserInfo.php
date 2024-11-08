<?php
    
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: Content-Type');

    //connecting to OnlineBookStore database
    $connect = new mysqli("localhost","root","","OnlineBookStore");
    if($connect->connect_error)
        die("Connection error ". $connect->connect_error);

    //data will be stored in json string format in $data variable
    $data = file_get_contents("php://input");
    //data will be converted to array format since true is given as parameter 
    $data_decoded = json_decode($data,true);
    //directly accessing the username like we access the data in other languages stored in array
    $username = $data_decoded['Username'];

    $sql_result = $connect->prepare("Select Password,UID from customer where username = ?");
    //binding the username to the result, s means the username is string 
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