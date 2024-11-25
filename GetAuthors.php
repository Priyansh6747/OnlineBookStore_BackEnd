<?php 
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: Content-Type');

    $connect = new mysqli("localhost","root","","OnlineBookStore");

    if($connect->connect_error)
        die("Connection error ". $connect->connect_error);

    $sql_result =$connect->query("Select * from author");
    if(!$sql_result)
        die("Invalid query " . $connect->error);
        
    $data =[];
    while($row = $sql_result->fetch_assoc())
        $data[] = $row;

        // Convert PHP array to JSON string and send it 
    echo json_encode($data);
    $connect->close();

?>