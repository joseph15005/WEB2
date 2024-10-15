<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Dashboard Admin</title>
        <meta charset="utf-8">
        <meta name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!--Bootstrap CSS File-->
        <link rel="stylesheet"
        href=
        "https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
        integrity=
        "sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4"
        crossorigin="anonymous">
    </head>

    <body>
        <div class="container" style="margin-top:30px">
        <!--Header Section-->
        <header class="jumbotron text-center row"
        style="margin-bottom:2px; background: linear-gradient(white, #0073e6); padding:20px;">
        <?php include('header-admin.php'); ?>
        </header>
        
        <!--Body Section-->
        <div class="row" style="padding-left: 0px;">
        <nav class="col-sm-2">
            <ul class="nav nav-pills flex-column" style="list-style: none;padding-left: 0;">
                <?php include('nav.php'); ?>
            </ul>
        </nav>
        <!--Center Column Content Section-->
        <div class="col-sm-8">
            <h2 class="text-center">These are the registered users</h2>
            <p>
            
            <!-- *******************************QUESTION 1:******************************* 
            PHP script to select and show the list of all users-->
            <?php
            try {
            // This script retrieves all the records from the users table.
            require('mysqli_connect.php'); // Connect to the database.
            $query = "SELECT last_name, first_name, email, DATE_FORMAT(registration_date, '%M %d, %Y') AS regdat, user_id FROM user 
            ORDER BY registration_date ASC";
            $result = mysqli_query($dbcon, $query); // Run the query.

            if ($result) { // If it ran OK, display the records.
                // Table header.
                echo '<table class="table table-striped">
                <tr>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Date Registered</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                </tr>';

                // Fetch and print all the records:
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                // Remove special characters that might already be in the table to reduce the chance of XSS exploits
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
                    }
                    echo '</table>'; // Close the table.
                    mysqli_free_result($result); // Free up the resources.
                } 
                else { // If it did not run OK.
                // Error message:
                    echo '<p class="text-center">The current users could not be retrieved. ';
                    echo 'We apologize for any inconvenience.</p>';
        
                    exit;
                }
                mysqli_close($dbcon); // Close the database connection.
            } // End of try
            catch (Exception $e) {
                print "The system is busy please try later";
            }
            catch (Error $e) {
                print "The system is busy please try again later.";
            }
            ?>

        </div>
        </div>

        <!-- Footer Content Section -->
        <footer class="jumbotron text-center row" style="padding-bottom:1px; padding-top:8px;">
            <?php include('footer.php'); ?>
        </footer>
        </div>
    </body>
</html>
