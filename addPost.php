<?php
    

    

    if(isset($_POST['addPost'])) {
        // File upload path
        $targetDir = "img/";
        $fileName = basename($_FILES["post_image"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
        $statusMsg= "";
        
        $post_title = $_POST['post_title'];
        $post_price = $_POST['post_price'];
        $post_details = $_POST['post_details'];
        $user_id = $_POST['user_id'];
        

        // Allow certain file formats
        $allowTypes = array('jpg','png','jpeg','gif','pdf');
        if(in_array($fileType, $allowTypes)){
            // Upload file to server
            if(move_uploaded_file($_FILES["post_image"]["tmp_name"], $targetFilePath)){
                // Insert image file name into database
                require_once('./config/database.php');
                $query = "INSERT INTO posts (post_user_id, post_title, post_price, post_image, post_desc) VALUES (?, ?, ?, ?, ?)";
                

                if($stmt = $mysqli->prepare($query)) {
                    $stmt->bind_param("sssss", $param_user_id, $param_post_title, $param_post_price, $param_post_image, $param_post_details);
                    $param_user_id = $user_id;
                    $param_post_title = $post_title;
                    $param_post_price = $post_price;
                    $param_post_image = $fileName;
                    $param_post_details = $post_details;
    
                    if($stmt->execute()) {
                        header('Location: post.php');
                    } else {
                        echo "Something went wrong please try again.";
                    }
    
                    //close statement
                    $stmt->close();
                    
                }
                
            }else{
                $statusMsg = "Sorry, there was an error uploading your file.";
            }
        }else{
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
        }




        
        // $query = "INSERT INTO posts (post_user_id, post_title, post_desc) VALUES (?, ?, ?)";
        
        // if($stmt = $mysqli->prepare($query)) {
        //     $stmt->bind_param("sss", $param_user_id, $param_post_title, $param_post_details);
        //     $param_user_id = $user_id;
        //     $param_post_title = $post_title;
        //     $param_post_details = $post_details;

        //     if($stmt->execute()) {
        //         header('Location: post.php');
        //     } else {
        //         echo "Something went wrong please try again.";
        //     }

        //     //close statement
        //     $stmt->close();
            
        // } else {
        //     die("error: " . $mysqli->error);
        // }
                
    }



?>