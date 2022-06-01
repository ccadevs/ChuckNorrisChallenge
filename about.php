<?php

    session_start();
    error_reporting(1);
    
    include $_SERVER['DOCUMENT_ROOT'] . '/app/database/config.php';

?>
<!DOCTYPE html>
<html lang="en">
    <head itemscope="" itemtype="http://schema.org/WebSite">
        <title itemprop="name">Coding Challenge | About</title>
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
                    <h4>WHO WE ARE?</h4>
                    <p>Challenge Code is a project that helps visitors find the right developer, graphic designer or seo specialist. You have the option of viewing the latest registered IT Engineers as well as a list of all registered IT Engineers from our database which you can download completely free of charge.</p>
                    <p>If you want to register in our database, please visit <a href="register">Registration</a> page.</p>
                    <p>If you want to download the list of our registered members, please visit the page <a href="database/">Our Records</a>.</p>
                    <p>You can contact us at any time via email <a href="mailto:example@example.com">example@example.com</a> or <a href="">contact form</a>.</p>
                </div>
            </div>
                                        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script> 

    </body>
</html>
