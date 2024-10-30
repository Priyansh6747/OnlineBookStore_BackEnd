<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: Content-Type');

    $connect = new mysqli("localhost","root","","OnlineBookStore");
        if($connect->connect_error)
            die("Connection error ". $connect->connect_error);

    $query = isset($_GET['q']) ? $_GET['q'] : '';
    $sql = "delete from book where B_id = '$query'";
    $result = $connect->query($sql);
    echo json_encode(["message" => "Book deleted"]);
    $connect->close();
?>