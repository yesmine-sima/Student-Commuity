<?php include './includes/header.php' ?>
<?php include './config/database.php' ?>
</head>

<body>

<?php include './includes/navbar.php' ?>


    <section id="head" class="p-3">
        <div class="container-fluid">
            <div class="row">

                <!-- ADS POST SECTION -->
                <div class="col-md-8">
                    <div class="d-flex justify-content-center row mt-2">
                        <div class="col-md-10">
                            <div class="row p-2 bg-white border rounded">
                                <button class="btn btn-new-ads" type="button" data-toggle="modal" data-target="#addPostModal"><i class="fa fa-plus-square"></i> Add Post</button>
                                <?php include './includes/addPostModal.php' ?>
                             </div>
                        </div>
                        <?php
                            require_once './config/database.php'; 
                            // $uesr_id = $_SESSION['user_id'];
                            $session_uni_id = $_SESSION['user_uni_id'];

                            // pagination query
                            if(isset($_GET['page'])) {
                                $page = $_GET['page'];
                            } else {
                                $page = 1;
                            }

                            $no_of_records_per_page = 10;
                            $offset = ($page-1) * $no_of_records_per_page;

                            $total_pages_sql = "SELECT count(*) FROM feeds";
                            $results = $mysqli->query($total_pages_sql);
                            $rows = $results->fetch_array();
                            $total_rows = $rows[0];
                            $total_pages = ceil($total_rows / $no_of_records_per_page);
                            // end pagination

                            $query = "SELECT * FROM posts join users where posts.post_user_id = users.user_id LIMIT $offset, $no_of_records_per_page";

                            $result = $mysqli->query($query);
                            if($result->num_rows > 0) {
                                while($row = $result->fetch_array()) {
                                    $post_id = $row['post_id'];
                                    $post_title = $row['post_title'];
                                    $post_price = $row['post_price'];
                                    $post_image = $row['post_image'];
                                    $post_created_time = $row['post_created_time'];
                                    $post_created_time = date('j F, Y h:mA', strtotime($post_created_time));

                                    $post_user_id = $row['user_id'];
                                    $post_user_name = $row['user_name'];


                            ?>
                                <!-- ADS POST  -->
                                <div class="col-md-10">
                                    <div class="row p-2 bg-white border rounded">
                                        <div class="col-md-3 mt-1"><img class="img-fluid img-responsive rounded product-image" src="img/<?php echo $post_image ?>">
                                        </div>
                                        <div class="col-md-6 mt-1">
                                            <h5><?php echo $post_title ?></h5>
                                            <div class="item-show">
                                                <p><i class='far fa-clock'></i> <?php echo $post_created_time ?></p>
                                                <!-- <p><i class="fa fa-map-marker"></i> Shyial Bari Mor near BUBT</p> -->
                                                <p><i class='fas fa-user-alt'></i> <?php echo $post_user_name ?></p>
                                            </div>                       
                                        </div>
                                        <div class="align-items-center align-content-center col-md-3 border-left mt-1">
                                            <div class="d-flex flex-row align-items-center">
                                                <h4 class="mr-1">৳<?php echo $post_price ?></h4>
                                            </div>
                                            <!-- <h6 class="text-success">USED BOOK</h6> -->
                                            <div class="d-flex flex-column mt-4">
                                                <a href="post-details.php?post=<?php echo $post_id?>" class="btn btn-primary btn-sm">Details</a>
                                                
                                                <!-- <button class="btn btn-outline-primary btn-sm mt-2" type="button">Add to wishlist</button> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                                }
                            }

                        ?>
                        <!-- POST PAGINATION -->
                        <ul class="pagination justify-content-center mt-3 pb-3">
                            <li class="page-item <?php echo $page <=1 ? 'disabled' : '' ?>"><a class="page-link" href="post.php?page=<?php echo ($page-1) ?>">Previous</a></li>
                            <li class="page-item"><a class="page-link" href="post.php?page=<?php echo $page ?>"><?php echo $page; ?></a></li>
                            <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : '' ?>"><a class="page-link" href="post.php?page=<?php echo ($page+1) ?>">Next</a></li>
                        </ul>
                         
                    </div>    
                              
                </div>

                <!-- MESSAGE SECTION -->
                <div class="col-md-4 border chatbox">
                    <div class="chatbox-heading">
                        COMMUNITY CHAT
                    </div>
                    <div class="messages">
                        <ul>

                        <?php 
                            $session_uni_id = $_SESSION['user_uni_id'];
                            $query = "SELECT message_id, message_user_id, message_details, message_created_time,
                                    user_id, user_name, user_uni_id, user_image from messages join users
                                    where messages.message_user_id = users.user_id and users.user_uni_id = $session_uni_id ORDER BY message_id DESC;";

                            $result = $mysqli->query($query);
                            if($result->num_rows > 0) {
                                while($row = $result->fetch_array()) {
                                    $message_user_id = $row['message_user_id'];
                                    $message = $row['message_details'];
                                    $user_image = $row['user_image'];

                        ?>
                            <li class="<?php echo $message_user_id == $_SESSION['user_id'] ? 'replies' : 'sent' ?>">
                                <img src="img/<?php echo $user_image ?>" alt="" />
                                <p><?php echo $message ?></p>
                            </li>
                        <?php
                                }
                            }
                        ?>

                        </ul>
                    </div>

                    <form action="message.php" method="POST">
                        <div class="input-group mb-3 message-input">
                            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                            <input type="hidden" name="cur_page" value="post.php">
                            <input type="text" name="message" class="form-control" style="border-radius: 50px;
                            margin-right: 10px;" placeholder="Write Message" aria-label="Recipient's username" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                            <input name="message_sent" class="btn btn-outline-secondary" style="border-radius: 50px;
                            padding: 0 20px;" type="submit">
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </section>






    <?php include './includes/footer.php' ?>