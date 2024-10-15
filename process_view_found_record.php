<?php
/*The following code shows what has been added or modified in the PHP code. 
These items enable the file to receive the first name and the last name sent from the search.php page.
The first and last names are assigned to variables, and these variables are used to search the database 
so that they can be verified. The variables are then used to display the record(s). */
?>

<DOCTYPE html>
<html>
    <head>
        <title>Search Page</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!--Bootstrap CSS File-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" 
        integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4"
        crossorigin="anonymous">
    </head>

    <body>
        <div class="container" style="margin-top:30px">
        <!--Header Section-->
        <header class="jumbotron text-center row col-sm-14" style="margin-bottom:2px; background:linear-gradient(white, #0073e6);padding:20px;">
            <?php include('header-admin.php'); ?>
        </header>

        <!--Body Section-->
        <div class="row" style="padding-left:0px;">
        <nav class="col-sm-2">
            <ul class="nav nav-pills flex-column" style="list-style: none;padding-left: 0;"​>
                <?php include('nav.php'); ?>
            </ul>
        </nav>
        <div class="col-sm-8">
            <h2 class="h2 text-center">These are found users</h2>
            <?php 
            try{
                //This script retrieves records from the users table.
                require ('./mysqli_connect.php');//Connect to the db
                echo '<p class="text-center">If no record is shown, ';
                echo 'this is because you had an incorrect ';
                echo 'or missing entry in the search form.';
                echo '<br>Click the back button on the browser and try again</p>';
            
                $first_name = htmlspecialchars($_POST['first_name'], ENT_QUOTES);
                $last_name = htmlspecialchars($_POST['last_name'], ENT_QUOTES);
            
                $query = "SELECT last_name, first_name, email, ";
                $query .= "DATE_FORMAT(registration_date, '%M %d, %Y')";
                $query .=" AS regdat, user_id FROM user WHERE ";
                $query .= "last_name=? AND first_name=? ";
                $query .="ORDER BY registration_date ASC ";
                $q = mysqli_stmt_init($dbcon);
                mysqli_stmt_prepare($q, $query);
                // bind values to SQL Statement
                mysqli_stmt_bind_param($q, 'ss', $last_name, $first_name);
                // execute query
                mysqli_stmt_execute($q);
            
                $result = mysqli_stmt_get_result($q);
            
                if ($result) { // If it ran, display the records.
                    //Table header
                    echo '<table class="table table-striped">
                    <tr>
                        <th scope="col">Last Name</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Date Registered</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>';
                    //Fetch and display the records:
                    
                    //*******************************QUESTION 6:*******************************
                    //A PHP script to display all user data found based on the search keywords, in a table
                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        // Remove special characters that might already be in table to reduce the chance of XSS exploits
                        $user_id = htmlspecialchars($row['user_id'], ENT_QUOTES);
                        $last_name = htmlspecialchars($row['last_name'], ENT_QUOTES);
                        $first_name = htmlspecialchars($row['first_name'], ENT_QUOTES);
                        $email = htmlspecialchars($row['email'], ENT_QUOTES);
                        $registration_date = htmlspecialchars($row['regdat'], ENT_QUOTES);
                        echo '<tr>
                            <td>' . $first_name . '</td>
                            <td>' . $last_name . '</td>
                            <td>' . $email . '</td>
                            <td>' . $registration_date . '</td>
                            <td><a href="edit_user.php?id=' . $user_id . '">Edit</a></td>
                            <td><a href="delete_user.php?id=' . $user_id . '">Delete</a></td>
                        </tr>';
                    } //end of while

                    echo '</table>'; //Close the table
                    mysqli_free_result($result);//Free up the resources
                } //end of if($result)
            
                else{ //If it did not run OK
                    //Public message
                    echo '<p class="text-center">The current users could not be retrieved.';
                    echo 'We apologize for any inconvenience.</p>';
                    //Debugging message
                    echo '<p>' . mysqli_error($dbcon) . '<br><br>Query: ' . $q . '</p>';
                }
                // Now display the total number of records/members.
                mysqli_close($dbcon); // Close the database connection.
            
            } //end of try
            
            catch(Exception $e){
                print "The system is currently busy. Please try later.";
            }
            ?>
        </div>
        </div>
        <!-- Footer Content Section -->
        <?php

            include('footer.php');
        ?>
        </footer>
        </div>
    </body>
</html>


