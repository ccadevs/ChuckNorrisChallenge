<?php
    
    include $_SERVER['DOCUMENT_ROOT'] . '/app/database/config.php';
    // Magic, on click user will get complete database records in .XSL extension

?>
<table border="1">
    <thead>
        <tr>
            <th>#</th>
            <th>Person First Name</th>
            <th>Person Last Name</th>
            <th>Person Email</th>
            <th>Person Phone</th>
            <th>Position</th>
        </tr>
    </thead>
    <?php

        // Provide name to the generated file
        $filename = 'User lists - Coding Challenge';
        $sql = "SELECT * FROM members";
        $query = $db->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        $u = 1;

        if ($query->rowCount() > 0) {
            foreach ($results as $list) {
                echo '
                    <tr>
                        <td>' . $u . '</td>
                        <td>' . $list->firstName . '</td>
                        <td>' . $list->lastName . '</td>
                        <td>' . $list->email . '</td>
                        <td>' . $list->phone . '</td>
                        <td>' . $list->position . '</td>
                    </tr>
                ';
                header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=" . $filename . "-report.xls");
                header("Pragma: no-cache");
                header("Expires: 0");
                $u++;
            }
        }

    ?>
</table>
