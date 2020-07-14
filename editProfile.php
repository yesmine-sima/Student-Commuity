<?php
    

    //  edit profile details
    if(isset($_POST['editProfile'])) {
        
        $user_id = $_POST['user_id'];
        $user_name = $_POST['user_name'];
        $user_email = $_POST['user_email'];
        $user_about_me = $_POST['user_about_me'];

                // Insert image file name into database
            require_once('./config/database.php');
            $query = "UPDATE users SET user_name = ?, user_email = ?, user_about_me = ? WHERE user_id = ?";
            
            if($stmt = $mysqli->prepare($query)) {
                $stmt->bind_param("ssss", $param_user_name, $param_user_email, $param_user_about_me, $param_user_id);
                $param_user_name = $user_name;
                $param_user_email = $user_email;
                $param_user_about_me = $user_about_me;
                $param_user_id = $user_id;

                if($stmt->execute()) {
                    header('Location: profile.php?user='.$user_id);
                } else {
                    echo "Something went wrong please try again.";
                }

                //close statement
                $stmt->close();
                
            } else {
                die("error: " . $mysqli->error);
            }
                
    }


    //edit profile image

    if(isset($_POST['editProfileImage'])) {
        //  include database connection
        include './config/database.php';

        $user_id = $_POST['user_id'];
        // $user_image = $_POST['user_image'];

        // File upload path
        $targetDir = "img/";
        $fileName = basename($_FILES["user_image"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
        $statusMsg= "";

        // Allow certain file formats
        $allowTypes = array('jpg','png','jpeg','gif','pdf');
        if(in_array($fileType, $allowTypes)){
            // Upload file to server
            if(move_uploaded_file($_FILES["user_image"]["tmp_name"], $targetFilePath)){
                // Insert image file name into database
                $query = "UPDATE users SET user_image = ? WHERE user_id = ?";
                

                if($stmt = $mysqli->prepare($query)) {
                    $stmt->bind_param("ss", $param_user_image, $param_user_id);
                    $param_user_image = $fileName;
                    $param_user_id = $user_id;
    
                    if($stmt->execute()) {
                        header('Location: profile.php?user='. $user_id);
                    } else {
                        echo "Something went wrong please try again.";
                    }
    
                    //close statement
                    $stmt->close();
                    
                } else {
                    echo $mysqli->error;
                }
                
            }else{
                $statusMsg = "Sorry, there was an error uploading your file.";
            }
        }else{
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
        }

    }


    // EDIT PROFILE SOCIAL LINKS
    if(isset($_POST['editSocial'])) {
        $user_id = $_POST['user_id'];

        $facebook = $_POST['facebook_link'];
        $instagram = $_POST['instagram_link'];
        $google = $_POST['google_link'];
        $twitter = $_POST['twitter_link'];

                // Insert image file name into database
            require_once('./config/database.php');
            $query = "UPDATE contacts SET facebook = ?, instagram = ?, google = ?, twitter = ? WHERE user_id = ?";
            
            if($stmt = $mysqli->prepare($query)) {
                $stmt->bind_param("sssss", $param_facebook, $param_instagram, $param_google, $param_twitter, $param_user_id);
                $param_facebook = $facebook;
                $param_instagram = $instagram;
                $param_google = $google;
                $param_twitter = $twitter;
                $param_user_id = $user_id;

                if($stmt->execute()) {
                    header('Location: profile.php?user='.$user_id);
                } else {
                    echo "Something went wrong please try again.";
                }

                //close statement
                $stmt->close();
                
            } else {
                die("error: " . $mysqli->error);
            }
    }


?>