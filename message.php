<?php 

    if(isset($_POST['message_sent'])) {

        include './config/database.php';

        $user_id = $_POST['user_id'];
        $cur_page = $_POST['cur_page'];
        $message_details = $_POST['message'];

        $query = "INSERT INTO `messages` (message_user_id, message_details) VALUES (?, ?);";
            if($stmt = $mysqli->prepare($query)) {
                $stmt->bind_param("ss", $param_user_id, $param_message_details);
                $param_user_id = $user_id;
                $param_message_details = $message_details;
                


                if($stmt->execute()) {
                    if($cur_page == 'profile.php') {
                        header('Location: profile.php?user=' . $user_id);
                    } else {
                        header('Location: index.php');
                    }
                    
                } else {
                    echo "Something went wrong please try again.";
                }

                //close statement
                $stmt->close();
            }
    }


?>