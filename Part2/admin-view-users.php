<?php
session_start();

if(!isset($_SESSION['user_level']) or $_SESSION['user_level'] !==1){
    header("Location: login.php");
    exit();
}

var_dump($_SESSION['user_level'])

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Template for an interactive web page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS File -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
</head>

<body>
    <div class="container" style="margin-top:30px">
        <!-- Header Section -->
        <header class="jumbotron text-center row" style="margin-bottom:2px; background: linear-gradient(white, #0073e6); padding:20px;">
            <?php include('header.php'); ?>
        </header>
        <!-- Body Section -->
        <div class="row" style="padding-left: 0px;">
            <!-- Left-side Column Menu Section -->
            <nav class="col-sm-2">
                <ul class="nav nav-pills flex-column">
                    <?php include('nav.php'); ?>
                </ul>
            </nav>
            <!-- Center Column Content Section -->
            <div class="col-sm-8">
                <h2 class="text-center">These are the registered users</h2>
                <p>
                    <?php
                    try {
                        //db connection
                        require('./mysqli_connect.php');

                        //sql query
                        $select_query = "SELECT last_name, first_name, email, DATE_FORMAT(registration_date, '%M %d, %Y') AS regdat, user_id, user_level FROM users ORDER BY registration_date ASC";

                        $result = mysqli_query($dbcon, $select_query); // run the query

                        if ($result) {
                            //if the query excecute
                            echo
                            "
                            <table class='table table-striped'>
                            <tr>

                            <th scope='col'>Edit</th>
                            <th scope='col'>Delete</th>
                            <th scope='col'>Last Name</th>
                            <th scope='col'>First Name</th>
                            <th scope='col'>Email</th>
                            <th scope='col'>Date Registered</th>
                            <th scope='col'>User Level</th>

                            </tr> 
                            ";
                            //fetch and print all the records
                            while ($row = mysqli_fetch_assoc($result)) {
                                //remove special characters that might already be in the table to reduce the chance of XSS exploit
                                //var_dump($row);
                                $user_id = htmlspecialchars($row['user_id']);
                                $last_name = htmlspecialchars($row['last_name']);
                                $first_name = htmlspecialchars($row['first_name']);
                                $email = htmlspecialchars($row['email']);
                                $registration_date = htmlspecialchars($row['regdat'], ENT_QUOTES);
                                $user_level = htmlspecialchars($row['user_level']);
                                

                                echo
                                "
                                <tr>
                                <td><a href='edit_user.php?id=$row[user_id]'>Edit</a></td>
                                <td><a href='delete_user.php?id=$row[user_id]'>Delete</a></td>

                                <td>$last_name</td>
                                <td>$first_name</td>
                                <td>$email</td>
                                <td>$registration_date</td>
                                <td>".($user_level == 1 ? '<strong>ADMIN</strong>' :'USER')."</td>
                                
                                
                                </tr>
                                
                                ";

                               
                            }
                        } else { //if the query did not execute
                            echo
                            '<p class="text-center">The current users could not be retrieved. ';
                            echo 'We apologize for any inconvenience.</p>';
                        }
                    } catch (Exception $e) // We finally handle any problems here
                    {
                        // print "An Exception occurred. Message: " . $e->getMessage();
                        print "The system is busy please try later";
                    } catch (Error $e) {
                        //print "An Error occurred. Message: " . $e->getMessage();
                        print "The system is busy please try again later.";
                    }

                    ?>
                </p>
            </div>
        </div>
    </div>
</body>

</html>