<?php
$error = true;
$showError = false;
if($_SERVER['REQUEST_METHOD'] == "POST"){

    // Database Connection
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "Register";

    $connect = mysqli_connect($server, $username, $password, $database);
    if(!$connect){
        die("Unable To Connect ".mysqli_error($connect));
    }
    // Database Connection Done

    // Fecth The Data From Form.
    $name = $_POST['username'];
    $email = $_POST['useremail'];
    $userpassword = $_POST['userpassword'];
    $userConfirmPassword = $_POST['userConfirmPassword'];

    // Chech Wheather Email-Id Already Exist Or Not.
    $sqlQuery = "SELECT * FROM Registered WHERE email = '$email'";
    $result = mysqli_query($connect, $sqlQuery);
    $numOfRows = mysqli_num_rows($result);


    if($numOfRows > 0) // it means that email-id already exist.
    {
        $showError = "Email-Id Already Exist.";
    }
    else{ // And If email doen't exist then check wheather password & confirm password matches or not.
        if($userpassword == $userConfirmPassword){
            $error = false;

            // inbuilt funcn ---> password_fast -> convert it into bit hash code 
            $hash = password_hash($userpassword, PASSWORD_DEFAULT); // hashing password.
            $query = "INSERT INTO Registered VALUES ('$name','$email','$hash')";
            mysqli_query($connect, $query);
        }
        else{
            $showError = "Password Does Not Match.";
        }
    }
}
?>

<!-- Navbar -->
<?php require "navbar.php"; ?>
    <!-- Navbar Ending -->
    
    <!-- alert -->
    <?php
    if(!$error){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> You Have Successfully Created Your Account.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        // header("location: index.php");
    }
    if($showError){
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error! </strong>'. $showError. '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    ?>

