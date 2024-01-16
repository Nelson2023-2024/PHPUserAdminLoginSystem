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
                        //including the connectio
                        require('./mysqli_connect.php');

                        //setting the number of rows displayed per page
                        $pagerow = 4;

                        //Has the total number of pages already been calculated ?
                        if(isset($_GET['p']) && is_numeric($_GET['p'])){
                            //already been calculated
                            $pages = htmlspecialchars($_GET['p'], ENT_QUOTES);
                            //prevent XSS
                        }
                        else{
                            $select_query = "SELECT COUNT(user_id) FROM users";
                            $result = mysqli_query($dbcon, $select_query);

                            //fetching the data
                            $row = mysqli_fetch_assoc($result);
                            var_dump($row);

                            $records = htmlspecialchars($row["COUNT(user_id)"], ENT_QUOTES);

                            var_dump($records);

                            //make sure it is not excecuteable XSS
                            if($records > $pagerow){
                                //if record will fill more than one page , calculate the number of pages and round the result up to the nearest integer
                                $pages = ceil($records / $pagerow);
                            }
                            else{
                                $pages = 1;
                            }
                        }
                        if(isset($_GET['s']) && is_numeric($_GET['s'])){
                            $start = htmlspecialchars($_GET['s'], ENT_QUOTES);
                        }
                        else{
                            $start = 0;
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