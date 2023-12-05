<?php
$conn = mysqli_connect("localhost", "root", "", "final_db");

if(isset($_POST["register"])){
    global $conn;

    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $dob = $_POST["dob"];
    $password = $_POST["password"];
    $repeatpassword = $_POST["repeat_password"];

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $errors = array();
                    
    if (empty($firstname) OR empty($lastname) OR empty($email) OR empty($dob) OR empty($phone) OR empty($dob) OR empty($password) OR empty($repeatpassword)) {
        array_push($errors, "All fields are required");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Email is not valid");
    }
    if (strlen($password) < 8) {
        array_push($errors, "Passwords must be alteast 8 characters long");
    }
    if ($password !== $repeatpassword) {
        array_push($errors, "Password does not match");
    }

    if (!$conn) {
        die("Something went wrong!");
    }

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    $rowcount = mysqli_num_rows($result);
    
    if ($rowcount > 0) {
        array_push($errors, "Email already exists!!!");
    }
    if (count($errors) > 0) {
        foreach($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    }
    else {
        $sql = "INSERT INTO users (Firstname, Lastname, Email, Phone, Age, Password) VALUES ( '$firstname', '$lastname', '$email', '$phone', '$dob', '$passwordHash')";
        if ($conn->query($sql) === TRUE){
            session_start();
             header("Location: ../login.html");
             die();
        }
        else {
            die("Something went wrong!!!");
        }
    }
}
?>