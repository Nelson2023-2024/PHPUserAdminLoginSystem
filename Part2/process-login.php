<?php

try {
    //dbconnection
    require('./mysqli_connect.php');

    //storage array
    $errors = [];

    //email validation
    $email = strtolower(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "You forgot to enter you email address");
        array_push($errors, "or the email format is invalid");
    }

    //password validation
    $password = trim($_POST['password']);
    if (empty($password)) {
        array_push($errors, "You forgot to enter you password");
    }

    //if everything is ok
    if (empty($errors)) {
        //select query
        $select_query = "SELECT user_id, password, first_name, user_level FROM users WHERE email = ?";
        $select_stmt = mysqli_stmt_init($dbcon);
        mysqli_stmt_prepare($select_stmt, $select_query);
        mysqli_stmt_bind_param($select_stmt, 's', $email);
        mysqli_stmt_execute($select_stmt);
        //getting the result from the prepared stmt
        $result = mysqli_stmt_get_result($select_stmt);

        $row = mysqli_fetch_assoc($result);
        //var_dump($row);
        //if the result is found in the DB
        if (mysqli_num_rows($result) == 1) {
            //veriry if the password entered is equal to the password in the Db
            if (password_verify($password, $row['password'])) {

                session_start();

                $_SESSION['user_level'] = $row['user_level'];

                $url = $_SESSION['user_level'] === 1 ? 'adminpage.php' : 'memberpage.php';

                header('Location: ' . $url);
            } else { //if passqord does no match records
                array_push($errors, "Email/Password did not match our records");
                array_push($errors, "Perharps you need to regiseter, just click the register");
                array_push($errors, "button on the header menu");
            }
        } else { //if email does not match records
            array_push($errors, "Email/Password did not match our records");
            array_push($errors, "Perharps you need to regiseter, just click the register");
            array_push($errors, "button on the header menu");
        }
    }

    if (!empty($errors)) {

        $errorstring =
            "Error! <br /> The following error(s) occurred:<br>";
        foreach ($errors as $msg) { // Print each error.
            $errorstring .= " $msg<br>\n";
        }
        $errorstring .= "Please try again.<br>";
        echo "<p class=' text-center col-sm-2' style='color:red'>$errorstring</p>";
    } // End of if (!empty($errors)) IF.

    mysqli_stmt_free_result($select_stmt);
    mysqli_stmt_close($select_stmt);



} catch (Exception $e) // We finally handle any problems here
{
    // print "An Exception occurred. Message: " . $e->getMessage();
    print "The system is busy please try later";
} catch (Error $e) {
    //print "An Error occurred. Message: " . $e->getMessage();
    print "The system is busy please try again later.";
}
