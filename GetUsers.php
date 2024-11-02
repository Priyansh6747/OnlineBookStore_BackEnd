<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: Content-Type');

    $connection = new mysqli("localhost","root","","OnlineBookStore");
    if(!$connection)
        die("Connection error ".$connection_error);
    $query = "select * from customer";
    $result = $connection->query($query);
    if(!$result)
        die("Invalid query ".$connection->error);
    $data = [];
    while($row = $result->fetch_assoc())
        $data[] = $row;
    echo json_encode($data);
    $connection->close();
?>