<?php include './includes/header.php' ?>
<?php include './config/database.php' ?>
</head>


<?php 
    if(isset($_GET['post'])) {
        
        $post_id = $_GET['post'];

        $query = "SELECT * FROM posts join users WHERE posts.post_user_id = users.user_id AND posts.post_id = $post_id ";
        $result = $mysqli->query($query);
        if($result->num_rows == 1) {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $user_id = $row['user_id'];
            $user_name =  $row['user_name'];
            $user_email = $row['user_email'];

            $post_id = $row['post_id'];
            $post_title = $row['post_title'];
            $post_price = $row['post_price'];
            $post_image = $row['post_image'];
            $post_desc = $row['post_desc'];
            $post_created_time = $row['post_created_time'];
            $post_created_time = date('j F, Y h:mA', strtotime($post_created_time));

        } else {
            echo 'no post found';
        }

    } else {
        // header('Location: index.php');
    }

?>


<body>

<?php include './includes/navbar.php' ?>


    <section id="head" class="p-3">
        <div class="container-fluid">
            <div class="row">

                <!-- ADS POST SECTION -->
                <div class="col-md-8">
                       
                    <div class="card mx-auto">
                        <div class="card-body">
                            <div class="logo mb-3"><img class="img-fluid" src="img/<?php echo $post_image ?>" /></div>
                            <h3 class="card-title"><?php echo $post_title ?></h3>
                            <h6 class="card-subtitle mb-2 text-muted note"><?php echo $post_desc ?></h6>
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <p class="text-muted"><i class="far fa-check-circle"></i> Price</p>
                                    <p class="text-muted"><i class="far fa-check-circle"></i> Posted On</p>
                                    <!-- <p class="text-muted"><i class="far fa-check-circle"></i> Meeting Place</p> -->
                                    <p class="text-muted"><i class="far fa-check-circle"></i> Posted By</p>
                                    <p class="text-muted"><i class="far fa-check-circle"></i> Contact Number</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-muted"><i class='far fa-clock'></i> <?php echo $post_price ?></p>
                                    <p class="text-muted"><i class='far fa-clock'></i> <?php echo $post_created_time ?></p>
                                    <!-- <p class="text-muted"><i class="fa fa-map-marker"></i> Shyial Bari Mor near BUBT</p> -->
                                    <p class="text-muted"><i class='fas fa-user-alt'></i> <?php echo $user_name ?></p>
                                    <p class="text-muted"><a class="btn text-primary" href="mailto:<?php echo $user_email ?>" ><i class="fa fa-google"></i> Click here</a></p>
                                </div> 
                                <div class="col-md-12">
                                    <div class="d-flex flex-column mt-4"><a href="post.php" class="btn btn-primary btn-sm" role="button">BACK TO ADS</a><button class="btn btn-outline-primary btn-sm mt-2" type="button">REPORT THIS AD</button></div>
                                </div>                                       
                           </div>             
                        </div>
                    </div>
                    


                </div>

               
            </div>
        </div>

    </section>




<?php include './includes/footer.php' ?>