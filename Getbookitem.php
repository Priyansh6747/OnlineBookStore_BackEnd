<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: Content-Type');

    $connect = new mysqli("localhost","root","","OnlineBookStore");

    if($connect->connect_error)
        die("Connection error ". $connect->connect_error);

    $sql_result =$connect->query("SELECT book.B_id,book.Name,book.URL,book.Price,book.Rating,author.Author_Name FROM `book` JOIN author on book.B_id = author.B_id");
    if(!$sql_result)
        die("Invalid query " . $connect->error);
        
    $data =[];
    while($row = $sql_result->fetch_assoc())
        $data[] = $row;

    echo json_encode($data);
    $connect->close();
?>