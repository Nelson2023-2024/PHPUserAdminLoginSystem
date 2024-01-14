<?php 
session_start();

if(!isset($_SESSION['user_level']) || $_SESSION['user_level']!==1){
    header("Location: login.php");
    exit();
}


//include the connection 
require('./mysqli_connect.php');

$select_query = "SELECT user_id, CONCAT(first_name, ' ', last_name) AS name, email, registration_date AS regdat FROM users ORDER BY  regdat ASC ";
$select_stmt = mysqli_stmt_init($dbcon);
mysqli_stmt_prepare($select_stmt, $select_query);
mysqli_stmt_execute($select_stmt);

$result = mysqli_stmt_get_result($select_stmt);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Template for an interactive web page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS File -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
        integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <script src="verify.js"></script>
</head>

<body>
    <div class="container" style="margin-top:30px">
        <!-- Header Section -->
        <header class="jumbotron text-center row"
            style="margin-bottom:2px; background:linear-gradient(white, #0073e6); padding:20px;">
            <?php include('./register-header.php'); ?>
        </header>

        <div class="row" style="padding-left: 0px;">
            <!-- Left-side Column Menu Section -->
            <nav class="col-sm-2">
                <ul class="nav nav-pills flex-column">
                    <?php include('nav.php'); ?>
                </ul>
            </nav>
            <div class="col-sm-10">
                <?php var_dump($_SESSION) ?>
                <table class="table table-striped ">
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Registration Date</th>
                    </tr>
                    <?php
                    while($row = mysqli_fetch_assoc($result)){
                       // var_dump($row);
                        echo "
                    <tr>
                        <td>$row[user_id]</td>
                        <td>$row[name]</td>
                        <td>$row[email]</td>
                        <td>$row[regdat]</td>
                    </tr>
                    ";
                    
                    }
                    
                    ?>

                </table>

            </div>
        </div>
    </div>
</body>

</html>