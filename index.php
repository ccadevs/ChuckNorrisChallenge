<?php

    session_start();
    error_reporting(1);
    
    include $_SERVER['DOCUMENT_ROOT'] . '/app/database/config.php';

?>
<!DOCTYPE html>
<html lang="en">
    <head itemscope="" itemtype="http://schema.org/WebSite">
        <title itemprop="name">Coding Challenge | Home</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="public/css/style.css">
    </head>
    <body>
        
        <div id="snippetContent">
            <div class="container">
                <?php include('views/include/nav.php'); ?>
                <div class="main-body">
                    <h4>Latest registered</h4>
                    <div class="row gutters-sm">
                        <?php

                            $sql = "SELECT * FROM members";
                            $query = $db->prepare($sql);
                            $query->execute();
                            $result = $query->fetchAll(PDO::FETCH_OBJ);
                            $u = 1;

                            if ($query->rowCount() > 0) {
                                foreach ($result as $user) {

                        ?>
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-column align-items-center text-center">
                                        <img src="/public/images/avatar/<?php echo htmlentities($user->image); ?>" height="110" alt="Admin" class="rounded-circle" width="150">
                                        <div class="mt-3">
                                            <h4><?php echo htmlentities($user->firstName . ' ' . $user->lastName);?></h4>
                                            <p class="text-secondary mb-1"><?php echo htmlentities($user->position);?></p>
                                            <p class="text-muted font-size-sm"><?php echo htmlentities($user->address);?></p>
                                            <a href="user/<?php echo htmlentities($user->username); ?>">View Profile</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                                $u = $u+1;
                                }
                            } else {
                                echo "<a href='register'>No records found! You can register new Client / Account +</a>";
                            }

                        ?>
                    </div>
                </div>
            </div>
                                        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>

    </body>
</html>
