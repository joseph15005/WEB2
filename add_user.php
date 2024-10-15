<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Create New User</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS File -->
        <link rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
        integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4"
        crossorigin="anonymous">
        <script src="verify.js"></script>
    </head>

    <body>
        <div class="container" style="margin-top:30px">
        <!-- Header Section -->
        <header class="jumbotron text-center row" style="margin-bottom:2px; background:linear-gradient(white, #0073e6); padding:20px;">
            <?php include('header-admin.php'); ?>
        </header>
        
        <!-- Body Section -->
        <div class="row" style="padding-left:0px;">
        <nav class="col-sm-2">
            <ul class="nav nav-pills flex-column" style="list-style: none;padding-left: 0;">
                <?php include('nav.php'); ?>
            </ul>
        </nav>
            <div class="col-sm-8">
                <h2 class="h2 text-center">Add User</h2>
                
                
                <!-- *******************************QUESTION 2:*******************************
                An html form to add new user -->
                
<form action="add_user.php" method="post" name="addform" id="addform">
    <div class="form-group row">
        <label for="first_name" class="col-sm-4 col-form-label">First Name:</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" maxlength="30" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="last_name" class="col-sm-4 col-form-label">Last Name:</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" maxlength="40" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="email" class="col-sm-4 col-form-label">E-mail:</label>
        <div class="col-sm-8">
            <input type="email" class="form-control" id="email" name="email" placeholder="E-mail" maxlength="60" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="password" class="col-sm-4 col-form-label">Password:</label>
        <div class="col-sm-8">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" maxlength="60" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="registration_date" class="col-sm-4 col-form-label">Registration date:</label>
        <div class="col-sm-8">
            <input type="date" class="form-control" id="registration_date" name="registration_date" placeholder="Registration date" maxlength="60" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="user_level" class="col-sm-4 col-form-label">User Level:</label>
        <div class="col-sm-8">
            <input list="user_level" name="user_level" class="form-control" required>
            <datalist id="user_level">
                <option value="1">
                <option value="2">
                <option value="3">
            </datalist>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-12">
            <input id="submit" class="btn btn-primary" type="submit" name="submit" value="ADD">
        </div>
    </div>
</form>

            <!-- Process add user into database-->
            <?php
            try{
            // This script is a query that INSERTs a record in the user table.
                    // Add the user in the database
                    require ('mysqli_connect.php'); // Connect to the db.

                    // Check If form submitted, insert form data into users table.
                    if(isset($_POST['submit'])) {
                        $first_name = $_POST['first_name'];
                        $last_name = $_POST['last_name'];
                        $email = $_POST['email'];
                        $password = $_POST['password'];
                        $registration_date = $_POST['registration_date'];
                        $user_level = $_POST['user_level'];

                    // Make the query:
                    $query = mysqli_query($dbcon, "INSERT INTO user (first_name, last_name, email, password,registration_date,user_level) VALUES('$first_name', '$last_name', '$email', '$password', '$registration_date', '$user_level')");
                
                    // Show message when user added
                    echo "User added successfully. <a href='admin-view-users.php'>View Users</a>";
                }
            }
                catch(Exception $e){
                        // If it did not run OK.
                        // Public message:
                        $errorstring = "<p class='text-center col-sm-8' style='color:red'>";
                        $errorstring .= "System Error<br />You could not be registered due ";
                        $errorstring .= "to a system error. We apologize for any inconvenience.</p>";
                        echo "<p class=' text-center col-sm-2' style='color:red'>$errorstring</p>";

                        mysqli_close($dbcon); // Close the database connection.
                        // include footer then close program to stop execution
                        echo '<footer class="jumbotron text-center col-sm-12"
                        style="padding-bottom:1px; padding-top:8px;">
                        include("footer.php");
                        </footer>';
                        exit();
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

