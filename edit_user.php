<?php

try{
    if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) {
        $id = htmlspecialchars($_GET['id'], ENT_QUOTES);
    } elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) {
        $id = htmlspecialchars($_POST['id'], ENT_QUOTES);
    } else {
        echo '<p class="text-center">This page has been accessed in error.</p>';
        include ('footer.php');
        exit();
    }

    require ('./mysqli_connect.php');
    // Has the form been submitted?
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = array();
    // Look for the first name:
        $first_name = filter_var( $_POST['first_name'], FILTER_SANITIZE_STRING);
        if (empty($first_name)) {
            $errors[] = 'You forgot to enter your first name.';
        }
    // Look for the last name:
        $last_name = filter_var( $_POST['last_name'], FILTER_SANITIZE_STRING);
        if (empty($last_name)) {
            $errors[] = 'You forgot to enter your last name.';
        }
    // Look for the email address:
        $email = filter_var( $_POST['email'], FILTER_SANITIZE_EMAIL);
        if ((empty($email)) || (!filter_var($email, FILTER_VALIDATE_EMAIL))) {
            $errors[] = 'You forgot to enter your email address';
            $errors[] = ' or the e-mail format is incorrect.';
        }
        $password = filter_var( $_POST['password'], FILTER_SANITIZE_STRING);
        if (empty($password)) {
            $errors[] = 'You forgot to enter your password.';
        }
        $registration_date = $_POST['registration_date'];
        $user_level = filter_var( $_POST['user_level'], FILTER_SANITIZE_STRING);
        if (empty($user_level)) {
            $errors[] = 'You forgot to enter your user_level.';
        }
        if (empty($errors)) { // If everything's OK
            $query = mysqli_query($dbcon, "UPDATE user SET first_name='$first_name', last_name='$last_name', email='$email', password='$password', registration_date='$registration_date', user_level='$user_level' WHERE user_id=$id");
                if ($query==true) { // Update OK
                    // Echo a message if the edit was satisfactory:
                    echo '<h3 class="text-center">The user has been edited.</h3>';
                } else { // Echo a message if the query failed.
                    echo '<p class="text-center">The user could not be edited due ';
                    echo 'to a system error.';
                    echo ' We apologize for any inconvenience.</p>'; // Public message.
                }
        } else { // Display the errors.
            echo '<p class="text-center">The following error(s) occurred:<br />';
            foreach ($errors as $msg) { // Echo each error.
                echo " - $msg<br />\n";
            }
            echo '</p><p>Please try again.</p>';
        } // End of if (empty($errors))section.
    } // End of the conditionals
    
    // Select the user's information to display in textboxes:

        //*******************************QUESTION 3:*******************************
        //A query to retrieve existing user data in the table
        $query = mysqli_query($dbcon, "SELECT first_name, last_name, email, password, registration_date, user_level FROM user WHERE user_id=$id");

        // execute query
    $row = mysqli_fetch_array($query);
    if (mysqli_num_rows($query) > 0) { // Valid user ID, display the form.
        // Get the user's information:
        // Create the form:
?>


<DOCTYPE html>
<html>
    <head>
        <title>Edit User</title>
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
            <ul class="nav nav-pills flex-column" style="list-style: none;padding-left: 0;">
                <?php include('nav.php'); ?>
            </ul>
        </nav>
            <div class="col-sm-8">
                <h2 class="h2 text-center">Edit Record</h2>
                <form action="edit_user.php" method="post" name="editform" id="editform">
                    <div class="form-group row">
                        <label for="first_name" class="col-sm-4 col-form-label">First Name:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" maxlength="30" required value="<?php echo htmlspecialchars($row[0], ENT_QUOTES); ?>" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="last_name" class="col-sm-4 col-form-label">Last Name:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" maxlength="40" required value="<?php echo htmlspecialchars($row[1], ENT_QUOTES); ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-4 col-form-label">E-mail:</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" id="email" name="email" placeholder="E-mail" maxlength="60" required value="<?php echo htmlspecialchars($row[2], ENT_QUOTES); ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-4 col-form-label">Password:</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" maxlength="60" required value="<?php echo htmlspecialchars($row[3], ENT_QUOTES); ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="registration_date" class="col-sm-4 col-form-label">Registration date:</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control" id="registration_date" name="registration_date" placeholder="Registration_date" maxlength="60" required value="<?php echo htmlspecialchars($row[4], ENT_QUOTES); ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="user_level" class="col-sm-4 col-form-label">User Level:</label>
                        <div class="col-sm-8">
                        <input list="user_level" name="user_level" class="form-control" required>
                            <datalist id="user_level">
                                <option value=1>
                                <option value=2>
                                <option value=3>
                            </datalist>
                        </div>
                    </div>
                    <input type="hidden" name="id" value=" <?php echo $id ?>" />
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-8">
                            <input id="submit" class="btn btn-primary" type="submit" name="submit" value="Submit">
                        </div>
                    </div>
                </form>

        
                <a href="admin-view-users.php">Return</a>
            </div>
        </div>
        
            <!-- Footer Content Section -->
            <footer class="jumbotron text-center row" style="padding-bottom:1px; padding-top:8px;">
                <?php include('footer.php'); ?>
            </footer>
        </div>
    </body>
</html>

<?php
} else { // The user could not be validated
    echo '<p class="text-center">This page has been accessed in error.</p>';
    
}
mysqli_close($dbcon);
}

catch(Exception $e) {
    print "The system is busy. Please try later";
    print "An Error occurred. Message: " . $e->getMessage();
}

catch(Error $e) {
    print "The system is currently busy. Please try later";
    print "An Error occurred. Message: " . $e->getMessage();
}
?>