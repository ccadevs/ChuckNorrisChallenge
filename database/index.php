<?php

    session_start();
    error_reporting(1);
    
    include $_SERVER['DOCUMENT_ROOT'] . '/app/database/config.php';

?>
<!DOCTYPE html>
<html lang="en">
    <head itemscope="" itemtype="http://schema.org/WebSite">
        <title itemprop="name">Coding Challenge | Records</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="../public/css/style.css">
        <!-- bootstrap css theme -->
        <link rel="stylesheet" href="https://mottie.github.io/tablesorter/css/theme.bootstrap_4.css">
        <script src="https://mottie.github.io/tablesorter/docs/js/jquery-latest.min.js"></script>
        <script src="https://mottie.github.io/tablesorter/js/jquery.tablesorter.js"></script>
        <script src="https://mottie.github.io/tablesorter/js/jquery.tablesorter.widgets.js"></script>
        <!-- Pager plugin -->
        <link rel="stylesheet" href="https://mottie.github.io/tablesorter/addons/pager/jquery.tablesorter.pager.css">
        <script src="https://mottie.github.io/tablesorter/addons/pager/jquery.tablesorter.pager.js"></script>
        <style>
        .tablesorter-pager .btn-group-sm .btn {
            font-size: 1.2em; /* make pager arrows more visible */
        }
        </style>
    </head>
    <body>
        
        <div id="snippetContent">
            <div class="container">
                <?php include('../views/include/nav.php'); ?>
                <div class="main-body">
                    <nav aria-label="breadcrumb" class="main-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Our Records</li>
                        </ol>
                    </nav>
                    <h4>Our records</h4>
                    <div class="row gutters-sm">
                        <?php
                            $sql = "SELECT * FROM members";
                            $query = $db->prepare($sql);
                            $query->execute();
                            $result = $query->fetchAll(PDO::FETCH_OBJ);
                            $u = 1;

                            if ($query->rowCount() > 0) {
                        ?>
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark"> <!-- add class="thead-light" for a light header -->
                                <tr>
                                    <th>#</th>
                                    <th>Domain</th>
                                    <th>Account Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Domain</th>
                                    <th>Account Name</th>
                                    <th>Action</th>
                                </tr>
                                <tr>
                                    <th colspan="4" class="ts-pager">
                                        <div class="form-inline">
                                            <div class="btn-group btn-group-sm mx-1" role="group">
                                                <button type="button" class="btn btn-secondary first" title="first">⇤</button>
                                                <button type="button" class="btn btn-secondary prev" title="previous">←</button>
                                            </div>
                                            <span class="pagedisplay"></span>
                                            <div class="btn-group btn-group-sm mx-1" role="group">
                                                <button type="button" class="btn btn-secondary next" title="next">→</button>
                                                <button type="button" class="btn btn-secondary last" title="last">⇥</button>
                                            </div>
                                            <select class="form-control-sm custom-select px-1 pagesize" title="Select page size">
                                                <option selected="selected" value="10">10</option>
                                                <option value="20">20</option>
                                                <option value="30">30</option>
                                                <option value="all">All Rows</option>
                                            </select>
                                            <select class="form-control-sm custom-select px-4 mx-1 pagenum" title="Select page number"></select>
                                        </div>
                                    </th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                        foreach ($result as $user) {
                                            $parts = explode("@", $user->email);
                                ?>
                                <tr>
                                    <td><?php echo $u++; ?></td>
                                    <td><a href="https://<?php echo htmlentities($parts[1]); ?>"><?php echo htmlentities($parts[1]); ?></a></td>
                                    <td><?php echo htmlentities($parts[0]); ?></td>
                                    <td><a href="../user/<?php echo htmlentities($user->username); ?>">@<?php echo htmlentities($user->username); ?></a></td>
                                </tr>
                                <?php
                                            $u = $u+1;
                                        }
                                ?>
                            </tbody>
                        </table>
                        <?php
                            } else {
                                echo "No records now!";
                            }
                        ?>
                        <a href="../register">Register new Client / Account +</a> &nbsp;or <a href="download?=user-lists">&nbsp;Download&nbsp;</a> entire database for free.
                    </div>
                </div>
            </div>
                                        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script> 
        <script>
            $(function() {
                $("table").tablesorter({
                theme : "bootstrap",
                widthFixed: true,
                // widget code contained in the jquery.tablesorter.widgets.js file
                // use the zebra stripe widget if you plan on hiding any rows (filter widget)
                // the uitheme widget is NOT REQUIRED!
                widgets : [ "filter", "columns", "zebra" ],
                widgetOptions : {
                    // using the default zebra striping class name, so it actually isn't included in the theme variable above
                    // this is ONLY needed for bootstrap theming if you are using the filter widget, because rows are hidden
                    zebra : ["even", "odd"],
                    // class names added to columns when sorted
                    columns: [ "primary", "secondary", "tertiary" ],
                    // reset filters button
                    filter_reset : ".reset",
                    // extra css class name (string or array) added to the filter element (input or select)
                    filter_cssFilter: [
                    'form-control',
                    'form-control',
                    'form-control custom-select', // select needs custom class names :(
                    'form-control'
                    ]
                }
            })
            .tablesorterPager({
                // target the pager markup - see the HTML block below
                container: $(".ts-pager"),
                // target the pager page select dropdown - choose a page
                cssGoto  : ".pagenum",
                // remove rows from the table to speed up the sort of large tables.
                // setting this to false, only hides the non-visible rows; needed if you plan to add/remove rows with the pager enabled.
                removeRows: false,
                // output string - default is '{page}/{totalPages}';
                // possible variables: {page}, {totalPages}, {filteredPages}, {startRow}, {endRow}, {filteredRows} and {totalRows}
                output: '{startRow} - {endRow} / {filteredRows} ({totalRows})'
                });
            });
        </script>

    </body>
</html>
