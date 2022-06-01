<?php

    error_reporting(1);

    include $_SERVER['DOCUMENT_ROOT'] . '/app/database/config.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/app/functions/getJoke.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/app/functions/mailTemplate.php';

    $username = null;

    if(!empty($_GET['id'])) {
        $username = $_GET['id'];
    }

    if (null === $username) {
        /**
         * If a user with a username or id tries to enter another username or id, it will be automatically redirected to the home page
         * 
        */
        header('../index');
    } else {
        // Collect user information and make from ?id to username to make SEO Friendly URL's
        $sql = "SELECT * FROM members WHERE username=:username";
        $query = $db->prepare($sql);
        $query->bindParam(':username', $username, PDO::PARAM_INT);
        $query->execute(array(':username' => $_GET['id']));
        $user = $query->fetch(PDO::FETCH_ASSOC);
        $u = 1;
    }
    // Code to send email to user and get Chuck Norris random Joke
    $from = 'noreply@example.com';
    $sendTo = $user['email'];
    $subject = 'Chuck Norris Challenge';
    // Convert HTML entities to their corresponding characters
    $message = html_entity_decode(ChuckNorrisChallenge());
    $okMessage = $message . " - Was send to " . "<b>" . $user['firstName'] . "</b>";
    $errorMessage = "Problem with sendign a joke!";
    try {
        if (!empty($_POST)) {
            // HTML Template
            $emailText = '<!DOCTYPE html>
            <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
            <head>
              <meta charset="UTF-8">
              <meta name="viewport" content="width=device-width,initial-scale=1">
              <meta name="x-apple-disable-message-reformatting">
              <title></title>
              <!--[if mso]>
              <noscript>
                <xml>
                  <o:OfficeDocumentSettings>
                    <o:PixelsPerInch>96</o:PixelsPerInch>
                  </o:OfficeDocumentSettings>
                </xml>
              </noscript>
              <![endif]-->
              <style>
                table, td, div, h1, p {font-family: Arial, sans-serif;}
              </style>
            </head>
            <body style="margin:0;padding:0;">
              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
                <tr>
                  <td align="center" style="padding:0;">
                    <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                      <tr>
                        <td align="center" style="padding:40px 0 30px 0;background:#70bbd9;">
                          <img src="https://www.business2community.com/wp-content/uploads/2013/04/Internet-Marketing-Chuck-Norris-600x387.jpg" alt="" width="300" style="height:auto;display:block;" />
                        </td>
                      </tr>
                      <tr>
                        <td style="padding:36px 30px 42px 30px;">
                          <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                            <tr>
                              <td style="padding:0 0 36px 0;color:#153643;">
                                <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">You have been poked on Coding Challenge website.</h1>
                                <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">' . $message . '</p>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td style="padding:30px;background:#ee4c50;">
                          <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                            <tr>
                              <td style="padding:0;width:50%;" align="left">
                                <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                  &reg; Iventa, Coding Challenge 2022<br/>
                                </p>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </body>
            </html>';
            $headers = array('From: ' . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=iso-8859-1' . "\r\n" . 'X-Mailer: PHP/' . phpversion());
            mail($sendTo, $subject, $emailText, implode("\n", $headers));
            // Display message to the user that joke was sent successfully
            $responseArray = array('type' => 'success', 'message' => $okMessage);
        }
    } catch (Exception $e) {
        // if problem exists
        $responseArray = array('type' => 'danger', 'message' => $e->getMessage());
    }

    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        // Returns the JSON representation of a value
        $encoded = json_encode($responseArray);
        header('Content-Type: application/json');
        echo $encoded;
    } else {

?>
<!DOCTYPE html>
<html lang="en">
    <head itemscope="" itemtype="http://schema.org/WebSite">
        <title itemprop="name">Coding Challenge | Profile - <?php echo htmlentities($user['firstName'] . $user['lastName']); ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="../public/css/style.css">
        <!-- Display errors without refreshing the page using ajax -->
        <script>
            $(function () {
                $('#chucknorris').on('submit', function (e) {
                    if (!e.isDefaultPrevented()) {
                        var url = "https://example.com/user/<?php echo htmlentities($user['username']); ?>";
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: $(this).serialize(),
                            success: function (data) {
                                var messageAlert = 'alert-' + data.type;
                                var messageText = data.message;
                                if (messageAlert && messageText) {
                                    $('#chucknorris').find('.messages').html(alertBox);
                                    $('#chucknorris')[0].reset();
                                }
                            }
                        });
                        return false;
                    }
                })
            });
        </script>
    </head>
    <body>
        
        <div id="snippetContent">
            <div class="container">
                <?php include('../views/include/nav.php'); ?>
                <div class="main-body">
                    <nav aria-label="breadcrumb" class="main-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/">Home</a>
                            </li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">User</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo htmlentities($user['firstName'] . ' ' . $user['lastName']); ?></li>
                        </ol>
                    </nav>
                    <div class="row gutters-sm">
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-column align-items-center text-center">
                                        <img src="/public/images/avatar/<?php echo htmlentities($user['image']); ?>" alt="<?php echo htmlentities($user['firstName'] . ' ' . $user['lastName']); ?>" class="rounded-circle" width="150">
                                        <div class="mt-3">
                                            <h4><?php echo htmlentities($user['firstName'] . ' ' . $user['lastName']); ?></h4>
                                            <p class="text-secondary mb-1"><?php echo htmlentities($user['position']); ?></p>
                                            <p class="text-muted font-size-sm"><?php echo htmlentities($user['address']); ?></p>
                                            <form id="chucknorris" method="post"  role="form" novalidate="true">
                                                <input type="submit" class="btn btn-outline-primary" name="send" value="Poke <?php echo htmlentities($user['firstName']); ?> with Chuck Norris Joke">
                                            </form>
                                        </div>
                                        <!-- Display user successfull message and display what user will recieve -->
                                        <p><?php if ($responseArray) { echo "<div class='alert alert-success' role='alert'>" . $responseArray['message'] . "</div>"; } ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Full Name</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary"><?php echo htmlentities($user['firstName'] . ' ' . $user['lastName']); ?></div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Email</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary"><a href="mailto:<?php echo htmlentities($user['email']); ?>"><?php echo htmlentities($user['email']); ?></a></div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Phone</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary"><a href="tel:<?php echo htmlentities($user['phone']); ?>"><?php echo htmlentities($user['phone']); ?></a></div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Address</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary"><?php echo htmlentities($user['address']); ?></div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Username</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">@<b><?php echo htmlentities($user['username']); ?></b></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row gutters-sm">
                                <div class="col-sm-12 mb-6">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h6 class="d-flex align-items-center mb-3">
                                                <i class="material-icons text-info mr-2">Top Skills</i>
                                            </h6>
                                            <small>Web Design</small>
                                            <div class="progress mb-3" style="height: 5px">
                                                <div class="progress-bar bg-primary" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <small>Website Markup</small>
                                                <div class="progress mb-3" style="height: 5px"><div class="progress-bar bg-primary" role="progressbar" style="width: 72%" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <small>One Page</small>
                                            <div class="progress mb-3" style="height: 5px">
                                                <div class="progress-bar bg-primary" role="progressbar" style="width: 89%" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <small>Mobile Template</small>
                                            <div class="progress mb-3" style="height: 5px">
                                                <div class="progress-bar bg-primary" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <small>Backend API</small>
                                            <div class="progress mb-3" style="height: 5px">
                                                <div class="progress-bar bg-primary" role="progressbar" style="width: 66%" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
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
<?php } ?>
