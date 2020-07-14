<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-grid.css">
    <link rel="stylesheet" href="css/style.css">

    <title>Register</title>
</head>

<?php 
    /// REGISTRATION 
    require_once "./config/database.php";
    $name = $email = $password = "";
    $name_err = $email_err = $password_err = "";

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        // VALIDATE NAME, EMAIL, PASSWORD
        if(empty($_POST['name'])) {
            $name_err = "please enter an username";
        } else {
            $name = $_POST['name'];
        }

        if(empty($_POST['email'])) {
            $email_err = "please enter an email";
        } else {
            $email = $_POST['email'];
        }

        if(empty($_POST['password'])) {
            $password_err = "Please enter a password";
        } else if(strlen(trim($_POST['password'])) < 6) {
            $password_err = "password must be at least 6 charecter long";
        } else {
            $password = trim($_POST['password']);
        }

        // INSERT NEW USER TO DATABASE
        if(empty($name_err) && empty($email_err) && empty($password_err)) {

            $query = "INSERT INTO `users` (user_name, user_uni_id, user_email, user_password, user_created_time) VALUES (?, ?, ?, ?, ?);";
            if($stmt = $mysqli->prepare($query)) {
                $stmt->bind_param("sssss", $param_name, $param_uni_id, $param_email, $param_password, $param_created_time);
                $param_name = $name;
                $param_uni_id = $_POST['university'];
                $param_email = $email;
                $param_password = password_hash($password, PASSWORD_DEFAULT);
                $param_created_time = date('Y-m-d H:i:s');


                if($stmt->execute()) {
                    header('Location: login.php');
                } else {
                    echo "Something went wrong please try again.";
                }

                //close statement
                $stmt->close();
            }

        }


    }



?>


<body style="background-color: #DE6262;">

    <section id="register">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-8 bg-white login-column mx-auto mt-5">
                    <!-- LOGIN FORM -->
                    <h2 class="text-center">Register Form</h2>

                    <form action="register.php" class="login-form py-5" method="POST">
                        <div class="form-group">
                            <label for="password">Name  <span class="text-danger"><?php echo $name_err ?></span></label>
                            <input type="text" class="form-control" placeholder="Enter Name" name="name">
                        </div>
                        <div class="form-group">
                            <label for="password">Unverisity</label>
                            <select class="form-control" name="university">
                                <?php 
                                    require_once './config/database.php';
                                    $sql = "SELECT * FROM `universities`";

                                    $result = $mysqli->query($sql);
                                    if($result->num_rows > 0) {
                                        while($row = $result->fetch_array()) {
                                            $uni_id = $row['uni_id'];
                                            $uni_name = $row['uni_name'];
                                    ?>
                                            <option value=<?php echo $uni_id ?>><?php echo $uni_name ?></option>
                                    <?php

                                        }
                                    }
                                ?>
                              </select>
                        </div>
                        <div class="form-group">
                            <label for="email">Email <span class="text-danger"><?php echo $email_err ?></span></label>
                            <input type="text" class="form-control" placeholder="Enter Email" name="email">
                        </div>
                        <div class="form-group">
                            <label for="password">Password  <span class="text-danger"><?php echo $password_err ?></span></label>
                            <input type="password" class="form-control" placeholder="Enter Password" name="password">
                        </div>
                        <button type="submit" class="btn float-right px-3">Register</button>
                    </form>
                    
                </div>
            </div>
        </div>
    </section>



    <script src="js/jquery-3.4.1.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/style.js"></script>
</body>

</html>