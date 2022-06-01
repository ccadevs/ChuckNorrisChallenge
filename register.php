<?php

    // Include configuration file
    include $_SERVER['DOCUMENT_ROOT'] . '/app/database/config.php';
    // Registration validation and process
    if (isset($_POST['signUp'])) {
        // Collect image details
        $file = $_FILES['image']['name'];
        $file_location = $_FILES['image']['tmp_name'];
        // Store image to directory
        $directory = $_SERVER['DOCUMENT_ROOT'] . '/public/images/avatar/';
        // Make a string lowercase
        $generateName = strtolower($file);
        // Replace all occurrences of the search string with the replacement string and give a image new name
        $generatedFile = str_replace(' ', '-', $generateName);
        // Collect information from registration form
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $position = $_POST['position'];
        // Moves an uploaded file to a new location
        if (move_uploaded_file($file_location, $directory . $generatedFile)) {
            $photo = $generatedFile;
        }
        // Register to database information we collected
        $sql = "INSERT INTO members (firstName, lastName, email, username, phone, address, position, image, status) VALUES (:firstName, :lastName, :email, :username, :phone, :address, :position, :image, 1)";
        $query = $db->prepare($sql);
        // Binds a parameter to the specified variable name
        $query->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $query->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':phone', $phone, PDO::PARAM_STR);
        $query->bindParam(':address', $address, PDO::PARAM_STR);
        $query->bindParam(':position', $position, PDO::PARAM_STR);
        $query->bindParam(':image', $photo, PDO::PARAM_STR);
        // Executes a prepared statement
        $query->execute();
        // Returns the ID of the last inserted row or sequence value
        $lastInsertId = $db->lastInsertId();
        // Provide message to the visitor who success registered to our database with redirection to index page
        if ($lastInsertId) {
            echo "<script type='text/javascript'>alert('Congratulations! You have successfully registered!!');</script>";
            echo "<script type='text/javascript'> document.location = '/'; </script>";
        } else {
            // If error exists, this message will be provided to the user
            $error = "An error has occurred!";
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
    <head itemscope="" itemtype="http://schema.org/WebSite">
        <title itemprop="name">Coding Challenge | Sign Up</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="public/css/style.css">
        <!-- Check image file and extension, to allow .png extension just enter ,"png" -->
        <script type="text/javascript">
            function validate() {
                var extensions = new Array("jpg","jpeg","webp");
                var image_file = document.regform.image.value;
                var image_length = document.regform.image.value.length;
                var pos = image_file.lastIndexOf('.') + 1;
                var ext = image_file.substring(pos, image_length);
                var final_ext = ext.toLowerCase();
                for (i = 0; i < extensions.length; i++) {
                    if(extensions[i] == final_ext) {
                        return true;
                    }
                }
                <!-- If user try to upload PDF File or XSL or PNG user will get this error -->
                alert("Image Extension Not Valid (Use Jpg,jpeg)");
                return false;
                }
        </script>
    </head>
    <body>
        
        <div id="snippetContent">
            <div class="container">
                <!-- include navigation -->
                <?php include('views/include/nav.php'); ?>
                <div class="main-body">
                    <nav aria-label="breadcrumb" class="main-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Sign Up</li>
                        </ol>
                    </nav>
                    <div class="container mt-2 mb-4">
                        <div class="col-sm-8 ml-auto mr-auto">
                            <div class="tab-content" id="pills-tabContent">
                                <div aria-labelledby="pills-signin-tab" class="tab-pane fade show active" id="pills-signin" role="tabpanel">
                                    <div class="col-sm-12 border border-primary shadow rounded pt-2">
                                        <!-- Call validate() function and process the registration -->
                                        <form method="post" name="signUp" enctype="multipart/form-data" onSubmit="return validate();">
                                            <div class="form-group">
                                                <label class="font-weight-bold">First Name
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input class="form-control" id="firstName" name="firstName" placeholder="Enter First Name" required="" type="text">
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold">Last Name
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input class="form-control" id="lastName" name="lastName" placeholder="Enter Last Name" required="" type="text">
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold">Email Address
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input class="form-control" id="email" name="email" placeholder="Enter valid Email Address" required="" type="email">
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold">Username
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input class="form-control" id="username" name="username" placeholder="Enter Username" required="" type="text">
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold">Phone #</label>
                                                <input class="form-control" id="phone" name="phone" placeholder="(000)-(0000000)" type="text">
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold">Enter Address
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input class="form-control" id="address" name="address" placeholder="Enter your address" type="text">
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold">Enter Position
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input class="form-control" id="position" name="position" placeholder="Enter your Position" type="text">
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold">Avatar
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="file" name="image" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-block btn-primary" name="signUp" type="submit">Sign Up!</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                                        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script> 

    </body>
</html>
