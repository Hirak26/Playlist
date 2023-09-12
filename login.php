<?php
$login = false;
$error = false;
if($_SERVER['REQUEST_METHOD'] == "POST"){

    // variable k andr store hoga 
    $email = $_POST['useremail'];
    $userpassword = $_POST['userpassword'];

    // Database Connection
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "coursemap";
    
    // inbuilt func --> mysqli_connect
    $connect = mysqli_connect($server, $username, $password, $database); // connect to database.

    if(!$connect){
            die("Unable To Connect ".mysqli_error($connect));
    }
    
    $query = "SELECT * FROM Registered WHERE email = '$email'";

    // inbuilt func --> mysqli_query 
    $result = mysqli_query($connect, $query); // execute query.
    $rows = mysqli_num_rows($result);

    if($rows == 1){ // if email-id already exists
// The fetch_assoc() / mysqli_fetch_assoc() function fetches a result row as an associative array.
        while($record = mysqli_fetch_assoc($result)){

            // inbuilt func --> password_verify 
            if(password_verify($userpassword, $record['Password'])){ //if password match 

                // if $login true thn we will get sucess msg 
                $login = true;

                // Session variables are set with the PHP global variable: $_SESSION.
                // session variables are not passed individually to each new page, instead they are retrieved from the session we open at the beginning of each page (session_start()).
                session_start();

                // logged in is true becoz if we go to any page aftr log in it will give the info and if we will log out thn wont be able to see any of our page
                $_SESSION['loggedin'] = true;
                $_SESSION['email'] = $email;

                // after user log in thn the page will redirect to index.php after checking all details
                header("location: index.php");
                exit;
            }
            else{
                $error = "Invalid Password"; // if hash password doesn't match.
            }
        }
    }
    else{
        $error = "Invalid Credentials"; // if email-id is not there.
    }
}
else{ // if database connection failed.
    $error = "Something Went Wrong! ";
}
?>

<!-- Navbar -->
<?php require "navbar.php"; ?>
    <!-- Navbar Ending -->

    <!-- alert -->
    <!-- pink color rectangle of error -->
    <?php
    if(!$login || $error){
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error! </strong>'.$error.'
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    ?>
    <!-- Alert End -->

<?php require "footer.php" ?>


