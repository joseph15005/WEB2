<?php
try {
    // Check for a valid user ID, through GET or POST: #1
    if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) {

    $id = htmlspecialchars($_GET['id'], ENT_QUOTES);
    } else if ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) {
        // Form submission.
        $id = htmlspecialchars($_POST['id'], ENT_QUOTES);
    } else { // No valid ID, kill the script.
        // return to admin-view-users
        header("Location: admin-view-users.php");
        exit();
    }

    require ('./mysqli_connect.php');
    
    // Check if the form has been submitted:
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sure = htmlspecialchars($_POST['sure'], ENT_QUOTES);
        if ($sure == 'Yes') { // Delete the record.
        $q = mysqli_stmt_init($dbcon);
        mysqli_stmt_prepare($q, 'DELETE FROM user WHERE user_id=? LIMIT 1');
        // bind $id to SQL Statement
        mysqli_stmt_bind_param($q, "s", $id);
        // execute query
        mysqli_stmt_execute($q);
            if (mysqli_stmt_affected_rows($q) == 1) { // It ran OK
                // Print a message:
                echo '<h3 class="text-center">The record has been deleted.</h3>';
                header("refresh:2;url=admin-view-users.php");
            } else { // If the query did not run OK display public message
                echo '<p class="text-center">The record could not be deleted.';
                echo '<br>Either it does not exist or due to a system error.</p>';
                header("refresh:2;url=admin-view-users.php");
            }
        } else { // User did not confirm deletion.
            echo '<h3 class="text-center">The user has NOT been deleted as you requested</h3>';
            header("refresh:2;url=admin-view-users.php");
        }
    } else { // Show the form.
        $q = mysqli_stmt_init($dbcon);
        $query = "SELECT CONCAT(first_name, ' ', last_name) FROM user WHERE user_id=?";
        mysqli_stmt_prepare($q, $query);
        // bind $id to SQL Statement
        mysqli_stmt_bind_param($q, "s", $id);
        // execute query
        mysqli_stmt_execute($q);
        $result = mysqli_stmt_get_result($q);
        $row = mysqli_fetch_array($result, MYSQLI_NUM); // get user info
        if (mysqli_num_rows($result) == 1) {
            // Valid user ID, display the form.
            // Display the record being deleted:
            $user = htmlspecialchars($row[0], ENT_QUOTES);

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
        <!-- Left-side Column Menu Section -->
        <nav class="col-sm-2">
            <ul class="nav nav-pills flex-column" style="list-style: none;padding-left: 0;">
                <?php include('nav.php'); ?>
            </ul>
        </nav>
        <div class="col-sm-8">
            <h2 class="h2 text-center">Are you sure you want to permanently delete <?php echo $user; ?>?</h2>
            
            <!-- *******************************QUESTION 4:*******************************
            A form to confirm deletion of user data -->	
            <form action="delete_user.php" method="post" name="deleteform" id="deleteform">
                <div class ="form-group row">
                    <label for="" class="col-sm-4 col-form-label"></label>
                    <div class="col-sm-8" style="padding-left: 70px;">
                    <input type="hidden" name="id" value="<?php echo$id; ?>">
                    <input id="submit-yes" class="btn btn-primary" type="submit" name="sure" value="Yes">
                    <input id="submit-no" class="btn btn-primary" type="submit" name="sure" value="No">
                </div>
            </div>
            </form>

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

} else { // Not a valid user ID.
            echo '<p class="text-center">This page has been accessed in error.</p>';
        }
    }// End of the main submission conditional.
    mysqli_close($dbcon );
}

catch(Exception $e){
    print "The system is busy. Please try again.";
}

catch(Error $e){
    print "The system is currently busy. Please try again soon.";
}
?>
