<?php
/*The code supplies a sticky form. A sticky form is one that retains the user’s entries when an error is
flagged. Users can become annoyed if they have to fill out the entire form each time they need to correct
an error such as failing to fill out one field. The sticky component is the PHP code following the value. */
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
            <ul class="nav nav-pills flex-column" style="list-style: none;padding-left: 0;">
                <?php include('nav.php'); ?>
            </ul>
        </nav>
        <!--Form Section-->
        <div class="col-sm-8">
                    <h2 class="h2 text-center">Search for a record</h2>
            <h6 class="text-center">Both names are required items</h6>
            
            <!-- *******************************QUESTION 5:*******************************
            A form to search user by their first name and last name -->
<form action="process_view_found_record.php" method="post" autocomplete="on">
    <!--Label First Name-->
    <div class="form-group row">
        <label for="first_name" class="col-sm-4 col-form-label">First Name: </label>
        <div class="col-sm-8">
            <input type="text"
                class="form-control"
                id="first_name"
                name="first_name"
                placeholder="First Name"
                maxlength="30"
                required
                value="<?php if (isset($_POST['first_name'])) echo htmlspecialchars($_POST['first_name'], ENT_QUOTES); ?>">
        </div>
    </div>
    <!--Label Last Name-->
    <div class="form-group row">
        <label for="last_name" class="col-sm-4 col-form-label">Last Name: </label>
        <div class="col-sm-8">
            <input type="text"
                class="form-control"
                id="last_name"
                name="last_name"
                placeholder="Last Name"
                maxlength="40"
                required
                value="<?php if (isset($_POST['last_name'])) echo htmlspecialchars($_POST['last_name'], ENT_QUOTES); ?>">
        </div>
    </div>
    <!--Button Submit-->
    <div class="form-group row">
        <label for="submit" class="col-sm-4 col-form-label"></label>
        <div class="col-sm-8">
            <input id="submit" class="btn btn-primary" type="submit" name="submit" value="Search">
        </div>
    </div>
</form>
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

    





