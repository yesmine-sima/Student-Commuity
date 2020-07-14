<?php include './includes/header.php' ?>
<?php
	if(!isset($_SESSION['loggedIn']) && $_SESSION[loggedIn] != true) {
		header("Location: login.php");
		exit;
	}

?>
</head>

<body>

    <?php include './includes/navbar.php' ?>


    <section id="head" class="p-3">
        <div class="container-fluid">
            <div class="row">

                <!-- POST SECTION -->
            <div class="col-md-8" style= "padding-top :8px;">
               
                    <!-- HOME POST SECTION -->
                    <div class="card-box">
                        <div class="card-box-heading">
                            COMMUNITY FEEDS
                        </div> 
                         <!-- HOME POST FORM -->
                        <form action="addFeed.php" class="card-box-post" method="POST">
                            <textarea name="user_feed" placeholder="Share what you've been up to..." class="form-control"></textarea>
                            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">
                            <div class="actions">
                                <button type="submit" class="btn post-button" name="addFeed">
                                    Post
                                </button>
                            </div>
                        </form> 

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

                            $query = "SELECT * FROM feeds join users where feeds.feed_user_id = users.user_id AND users.user_uni_id = $session_uni_id LIMIT $offset, $no_of_records_per_page";

                            $result = $mysqli->query($query);
                            if($result->num_rows > 0) {
                                while($row = $result->fetch_array()) {
                                    $feed_id = $row['feed_id'];
                                    $feed_content = $row['feed_content'];
                                    $feed_created_time = $row['feed_created_time'];
                                    $feed_created_time= date('j F, Y h:mA', strtotime($feed_created_time));
                                    $feed_user_id = $row['user_id'];
                                    $user_name = $row['user_name'];
                                    $user_image = $row ['user_image'];


                            ?>
                                <!-- POST -->
                                <div class="card mb-3 post">                        
                                    <div class="card-body">
                                        <img src="img/<?php echo $user_image ?>" class="post-user-img" alt="">
                                        <h4 class="card-title post-user"><a href="profile.php?user=<?php echo $feed_user_id; ?>"><?php echo $user_name ?></a></h4>
                                        <p class="card-text"><?php echo $feed_content ?></p>
                                        <!-- <a href="#" class="btn post-button"><b>View More</b></a> -->
                                        <p class="text-muted small post-date"><?php echo $feed_created_time ?></p>
                                    </div>
                                </div>
                            <?php
                                }
                            }
                        
                        ?>
                    
                        <!-- POST PAGINATION -->
                        <ul class="pagination justify-content-center mt-3 pb-3">
                            <li class="page-item <?php echo $page <=1 ? 'disabled' : '' ?>"><a class="page-link" href="index.php?page=<?php echo ($page-1) ?>">Previous</a></li>
                            <li class="page-item"><a class="page-link" href="index.php?page=<?php echo $page ?>"><?php echo $page; ?></a></li>
                            <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : '' ?>"><a class="page-link" href="index.php?page=<?php echo ($page+1) ?>">Next</a></li>
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
                            <input type="hidden" name="cur_page" value="index.php">
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



