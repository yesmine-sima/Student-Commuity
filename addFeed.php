<?php
    


    if(isset($_POST['addFeed'])) {
        
        $feed_content = $_POST['user_feed'];
        $user_id = $_POST['user_id'];
        // Insert image file name into database
        require_once('./config/database.php');
        $query = "INSERT INTO feeds (feed_user_id, feed_content) VALUES (?, ?)";
        
        if($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param("ss", $param_user_id, $param_feed_content);
            $param_user_id = $user_id;
            $param_feed_content = $feed_content;

            if($stmt->execute()) {
                header('Location: index.php');
            } else {
                echo "Something went wrong please try again.";
            }

            //close statement
            $stmt->close();
            
        } else {
            die("error: " . $mysqli->error);
        }
                
    } else {
        echo "not working";
    }



?>