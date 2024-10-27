<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: Content-Type');
    
    $connect = new mysqli("localhost","root","","OnlineBookStore");

    if($connect->connect_error)
        die("Connection error ". $connect->connect_error);

    $data = file_get_contents("php://input");
    $data_decoded = json_decode($data, true);

    if($data_decoded) {
        $BName = $data_decoded["bookName"];
        $url = $data_decoded["url"];
        $price = $data_decoded["price"];
        $rating = $data_decoded["rating"];
        $authorName = $data_decoded["authorName"];
        $authorBio = $data_decoded["authorBio"];
        $authorURL = $data_decoded["authorURL"];

        $query = $connect->prepare("INSERT INTO book(Name, URL, Price, Rating) VALUES (?, ?, ?, ?)");
        $query->bind_param("ssss", $BName, $url, $price, $rating);

        if ($query->execute()) {
            $sql = $connect->query("SELECT B_id FROM book WHERE Name = '$BName' AND URL = '$url'");
            $BID_row = $sql->fetch_assoc();
            $BID = $BID_row['B_id'];

            $author_query = $connect->prepare("INSERT INTO author(B_id, Author_Name, Author_Bio, Image) VALUES (?, ?, ?, ?)");
            $author_query->bind_param("isss", $BID, $authorName, $authorBio, $authorURL);

            if ($author_query->execute()) 
                echo json_encode(["message" => "Book added successfully"]);
            else 
                echo json_encode(["message" => "Error in adding author"]);
        } else 
            echo json_encode(["error" => "Failed to add book"]);

    }

    $connect->close();
?>
