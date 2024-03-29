<?php 
session_start();

if(!isset($_SESSION['user_level']) || $_SESSION['user_level']!==1){
    header("Location: login.php");
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Administration Page</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1,
 shrink-to-fit=no">
        <!-- Bootstrap CSS File -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
            integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
</head>

<body>
    <div class="container" style="margin-top:30px">
        <!-- Header Section -->
        <header class="jumbotron text-center row" style="margin-bottom:2px; background:linear-gradient(white, #0073e6);
 padding:20px;">
            <?php include('admin-header.php'); ?>
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
                <h2 class="text-center">This is the Administration Page</h2>
                <?php var_dump($_SESSION) ?>
                <h3>You have permission to:</h3>
                <p>Edit and Delete a record</p>
                <p>Use the View Members button to page through all the members</p>
                <p>Use the Search button to locate a particular member</p>
                <p>Use the New Password button to change your password.
                </p>
            </div>
            <!-- Right-side Column Content Section -->
            <aside class="col-sm-2">
                <?php include('info-col.php'); ?>
            </aside>
        </div>
        <!-- Footer Content Section -->
        <footer class="jumbotron text-center row" style="padding-bottom:1px; padding-top:8px;">
            <?php include('footer.php'); ?>
        </footer>
    </div>
</body>

</html>