<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: Content-Type');

    $connect = new mysqli("localhost","root","","OnlineBookStore");
        if($connect->connect_error)
            die("Connection error ". $connect->connect_error);

    $data = file_get_contents("php://input");
    $data_decoded = json_decode($data,true);
    $query = $data_decoded["uid"];
    $sql = "SELECT * FROM cart WHERE UID = '$query'";
    $result = $connect->query($sql);
    $book = [];
    if($result->num_rows > 0) while ($row = $result->fetch_assoc())
        $book[] = $row;
    echo json_encode($book);
    $connect->close();
?>