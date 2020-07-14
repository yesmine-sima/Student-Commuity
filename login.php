<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-grid.css">
    <link rel="stylesheet" href="css/style.css">

    <title>Login</title>
</head>

<?php 
    session_start();
    if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) {
        header("Location: index.php");
        exit;
    }

?>

<?php 
    require_once "./config/database.php";

    $email = $password = "";
    $email_err = $password_err = "";

    //validate Login
    if($_SERVER["REQUEST_METHOD"] == "POST") {
                
        //validate email
        if(empty(trim($_POST['email']))) {
            $email_err = "please enter your email address.";
        } else {
            $email = trim($_POST['email']);
        }

        //validate email
        if(empty(trim($_POST['password']))) {
            $password_err = "please enter your email address.";
        } else {
            $password = trim($_POST['password']);
        }

        if(empty($email_err) && empty($password_err)) {

            $sql = "SELECT user_id, user_email, user_password, user_uni_id FROM `users` WHERE users.user_email = ?";

            if($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param("s", $param_email);
                $param_email = $email;

                if($stmt->execute()) {
                    $stmt->store_result();

                    if($stmt->num_rows == 1) {
                        $stmt->bind_result($id, $email, $hashed_password, $user_uni_id);

                        if($stmt->fetch()) {
                            if(password_verify($password, $hashed_password)) {
                                
                                $_SESSION['loggedIn'] = true;
                                $_SESSION['user_id'] = $id;
                                $_SESSION['user_uni_id'] = $user_uni_id;

                                header("Location: index.php");

                            } else {
                                $password_err = "Incorrect password";
                            }
                        }
                    } else {
                        $email_err = "Invalid email address, please try again.";
                    }
                } else {
                    echo "something went wrong, please try again.";
                }
                //close statement
            $stmt->close();

            }

            

        }

        //close database
        $mysqli->close();

    }




?>


<body style="background-color: #DE6262;">

    <section id="login">
        <div class="container">
            <div class="row my-5">
                <div class="col-md-12 col-lg-4 bg-white login-column">
                    <!-- LOGIN FORM -->
                    <h2 class="text-center">Login Form</h2>

                    <form action="login.php" class="login-form" method="POST">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" placeholder="Enter Email" name="email">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" placeholder="Enter Password" name="password">
                        </div>
                        <button class="btn float-right px-3" type="submit">Login</button>
                    </form>
                    <p class="lead text-center">If you're new, <a href="register.php">click here</a> to register</p>
                </div>

                <div class="d-none d-lg-block col-lg-8 image-column">
                    <!-- IMAGE SECTION -->
                    <div class="image-sec">
                        <div class="overlay text-white">
                            <div class="container h-100">
                                <div class="row h-100">
                                    <div class="col-md-12 my-auto ml-5">
                                        <h3 class="display-4">Welcome, Dear student.</h3>
                                        <p class="lead">To get a fresh start of your day, login to the system.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>







    <script src="js/jquery-3.4.1.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/style.js"></script>
</body>

</html>