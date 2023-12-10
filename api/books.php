<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "library";
$con = new mysqli($host, $user, $pass, $db);

if (!$con) {
    echo "There is a problem";
} 
else {
    // Handle GET request
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $qry = "SELECT * FROM `info`";
        $result = $con->query($qry);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $bookid = $row["id"];
                $bookname = $row["Book"];
                $bookauthor = $row["Author"];

                $book_data["bookName"] = $bookname;
                $book_data["bookauthor"] = $bookauthor;
                $book_data["bookid"] = $bookid;
                $data[$bookid] = $book_data;
            }
            $data["Result"] = "True";
            $data["Message"] = "Books fetched successfully";
        } 
        else {
            $data["Result"] = "False";
            $data["Message"] = "No Books Found";
        }
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    // Handle POST request
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents("php://input"), true);

        $Id = isset($data['ID']) ? $data['ID'] : '';
        $name = isset($data['name']) ? $data['name'] : '';
        $author = isset($data['author']) ? $data['author'] : '';
        if (!is_numeric($Id) || !is_int($Id + 0)) {
            echo "ID should be an integer.";
        } 
        else if (empty($Id) || empty($name) || empty($author)) {
            echo "Please provide all required fields.";
        } 
        else {
        $qry1 = "SELECT * FROM `info` where id=?"; //query to get the table of id=$Id
        $stmt = $con->prepare($qry1);
        $stmt->bind_param("i", $Id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            echo "Data Already existed"; //if we get rows with our present id then a data already exitsed in database, so it gives already existed
        } 
        else{
            $qry = "INSERT INTO `info`(`id`,`Book`,`Author`) VALUES (?, ?, ?)";//query to insert our data into database
            $stmt = $con->prepare($qry);
            $stmt->bind_param("iss", $Id, $name, $author);
            $stmt->execute();

            if (!$stmt) {
                echo "There is a problem " . $con->error;
            } else {
                echo "Data inserted";// after successfull insertion shows data inserted
            }
        }
      }
    }

    // Handle PUT request
    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        $data = json_decode(file_get_contents("php://input"), true);
        $id = isset($data['ID']) ? $data['ID'] : '';
        $name = isset($data['name']) ? $data['name'] : '';
        $author = isset($data['author']) ? $data['author'] : '';
        if (!is_numeric($id) || !is_int($id + 0)) {
            echo "ID should be an integer.";
        }
        else if (empty($id) || empty($name) || empty($author)) {
            echo "Please provide all required fields.";  //if all fields are not filled then ouput to provide required fields
        } 
        else {
            // Your update logic here
            $qry1 = "SELECT Book, Author FROM `info` where id=?"; //query to get the table contaning  where id=ID
            $stmt = $con->prepare($qry1);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result) {
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    if ($row['Book'] == $name && $row['Author'] == $author) {
                        echo "Data Already existed";  //if data already present in the table it shows that already existed
                    } 
                    else {
                        $qry = "UPDATE `info` SET Book = ?, Author= ? WHERE  id= ?"; // query to update the table
                        $stmt = $con->prepare($qry);
                        $stmt->bind_param("ssi", $name, $author, $id);
                        $stmt->execute();

                        if (!$stmt) {
                            echo "There is a problem " . $con->error;
                        } else {
                            echo "Data Updated"; //After updating shows data updated
                        }
                    }
                } 
                else {
                    echo "No data found for the given ID"; //If user trying to update the book which doesnt exist then it shows no data found
                }
            } 
            else {
                echo "Problem with query";
            }
        }
    }

    // Close the database connection
    $con->close();
}
?>
