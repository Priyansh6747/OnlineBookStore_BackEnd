<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: Content-Type');

    $connect = new mysqli("localhost","root","","OnlineBookStore");
        if($connect->connect_error)
            die("Connection error ". $connect->connect_error);

    $query = isset($_GET['q']) ? $_GET['q'] : '';
    $sql = "SELECT * FROM book WHERE Name LIKE '%$query%'";
    $result = $connect->query($sql);
    $book = [];
    if($result->num_rows > 0) while ($row = $result->fetch_assoc())
        $book[] = $row;
    echo json_encode($book);
    $connect->close();
?>