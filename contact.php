<?php

    error_reporting(1);
    
    include $_SERVER['DOCUMENT_ROOT'] . '/app/database/config.php';

?>
<!DOCTYPE html>
<html lang="en">
    <head itemscope="" itemtype="http://schema.org/WebSite">
        <title itemprop="name">Coding Challenge | Contact</title>
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
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-header bg-primary text-white"><i class="fa fa-envelope"></i> Contact us</div>
                                <div class="card-body">
                                    <form>
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Enter name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email address</label>
                                            <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" required>
                                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                                        </div>
                                        <div class="form-group">
                                            <label for="message">Message</label>
                                            <textarea class="form-control" id="message" rows="6" required></textarea>
                                        </div>
                                        <div class="mx-auto">
                                        <button type="submit" class="btn btn-primary text-right">Submit</button></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="card bg-light mb-3">
                                <div class="card-header bg-primary text-white"><i class="fa fa-home"></i> Address</div>
                                <div class="card-body">
                                    <p>Street name</p>
                                    <p>City, Country</p>
                                    <p>ZIP Code</p>
                                    <p>Email : email@example.com</p>
                                    <p>Tel. + 123 465 789</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                                        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script> 

    </body>
</html>
