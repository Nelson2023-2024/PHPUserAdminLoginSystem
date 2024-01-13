<?php
try{
        // connection to DB
        require('mysqli_connect.php');
        //initialize empty array
        $errors = [];

        //validate first name
        $first_name =ucfirst(strtolower(trim($_POST['first_name'])));
        empty($first_name)? array_push($errors,'You forgot to enter you first name') :'';

        //validate last name
        $last_name =ucfirst(strtolower(trim($_POST['last_name'])));
        empty($last_name) ? array_push($errors, "You forgot to enter your last name"):'';

        //validate email
        $email = strtolower(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
        empty($email) ? array_push($errors, "You forgot to enter your email or the email format is incorect") :'';

        //validate both passwords
        $password1 = trim($_POST['password1']);
        $password2 = trim($_POST['password2']);

        if(!empty($password1)){
            if($password1 !== $password2) array_push($errors, "Your passwords did not match");
        }
        else array_push($errors, "You forgot to enter you password");

        //if everything is OK
        if(empty($errors)){
        //hash the password
        $hashed_passcode = password_hash($password1, PASSWORD_DEFAULT);

        //insertion to DB
        $insert_query = "INSERT INTO users (first_name, last_name, email, password, registration_date) VALUES(?,?,?,?,NOW())";
        $insert_stmt = mysqli_stmt_init($dbcon);
        mysqli_stmt_prepare($insert_stmt, $insert_query);
        mysqli_stmt_bind_param($insert_stmt,'ssss', $first_name, $last_name, $email, $hashed_passcode);
        mysqli_stmt_execute($insert_stmt);

        //if one row is affected
        if(mysqli_stmt_affected_rows($insert_stmt) == 1){
            header('Location: thanks-header.php');
            exit();
        }
        else { // If it did not run OK.
            // Public message:
            $errorstring =
            "<p class='text-center col-sm-8' style='color:red'>";
            $errorstring .=
            "System Error<br />You could not be registered due ";
            $errorstring .=
            "to a system error. We apologize for any inconvenience.</p>";
            echo "<p class=' text-center col-sm-2'
            style='color:red'>$errorstring</p>";
            // Debugging message below do not use in production
            //echo '<p>' . mysqli_error($dbcon) . '<br><br>Query: ' .
            $query . '</p>';
            mysqli_close($dbcon); // Close the database connection.
            // include footer then close program to stop execution
            echo '<footer class="jumbotron text-center col-sm-12"
            style="padding-bottom:1px; padding-top:8px;">
            include("footer.php");
            </footer>';
            exit();
            }

        }
        else { // Report the errors.
            $errorstring =
            "Error! <br /> The following error(s) occurred:<br>";
            foreach ($errors as $msg) { // Print each error.
            $errorstring .= " - $msg<br>\n";
            }
            $errorstring .= "Please try again.<br>";
            echo "<p class=' text-center col-sm-2'
            style='color:red'>$errorstring</p>";
            }// E


    
}
catch(Exception $e) // We finally handle any problems here
 {
 // print "An Exception occurred. Message: " . $e->getMessage();
 print "The system is busy please try later";
 }
 catch(Error $e)
 {
 //print "An Error occurred. Message: " . $e->getMessage();
 print "The system is busy please try again later.";
 }

?>