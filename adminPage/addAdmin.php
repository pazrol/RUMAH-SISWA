<?php
session_start(); // Start the session
// Call file to connect server Rumah Siswa
include("../header.php");

// Logout functionality
if (isset($_GET['logout'])) 
{
    // Unset all session variables
    session_unset();
    // Destroy the session
    session_destroy();
    // Redirect to the login page
    header("location: ../login.php");
    exit();
}


$message = array();

if (isset($_POST['submit'])) 
{
    $name = mysqli_real_escape_string($connect, ($_POST['name']));
    $user = mysqli_real_escape_string($connect, ($_POST['user']));
    $pass = mysqli_real_escape_string($connect, ($_POST['password']));
    $p = mysqli_real_escape_string($connect, ($_POST['p']));
    $user_type = mysqli_real_escape_string($connect, ($_POST['user_type']));

    $select = mysqli_query($connect, "SELECT * FROM `user_form` WHERE user = '$user'") or die('Query failed');

    if(mysqli_num_rows($select) > 0) 
    {
        $message[] = 'User already exists'; 
    } 
    else 
    {
       
        $query = "INSERT INTO `user_form` (name, user, password, user_type) VALUES ('$name', '$user', '$pass', '$user_type')";
        if(mysqli_query($connect, $query)) 
        {
            $message[] = 'Registration Successful!';
        } 
        else 
        {
            $message[] = 'Registration Failed!';
        }
            
    }
}

?>

<html>
<head>
    <title>Register</title>
</head>
<body> 
    <style>
        <?php include('addAdmin.css'); ?>
    </style>

<header>
        <div class="content flex_space">
            <div class="logo">
                <img src="../RUMAH SISWA LOGO.png" alt="" />
            </div>

            <div class="navlinks">
                <ul id="menulist">
                    <li><a href="../homepage.php">home</a></li>
                    <li><a href="#about">about</a></li>
                    <li><a href="../house.php">houses</a></li>                                  
                    <li><a href="../profile.php">profile</a></li>
                    <li><a href="admin.php">admin</a></li>
                    <!-- If user clicks the logout button -->
                    <li><a href="?logout=true">log out</a></li>
                    <li><i class="fa fa-search"></i></li>
                    <li><button class="primary-btn">ADVERTISE NOW !</button></li>
                </ul>
                <span class="fa fa-bars" onclick="menutoggle()"></span>
            </div>
        </div>
    </header>

    <script>
        var menulist = document.getElementById("menulist");
        menulist.style.maxHeight = "0px";

        function menutoggle() {
            if (menulist.style.maxHeight == "0px") {
                menulist.style.maxHeight = "100vh";
            } else {
                menulist.style.maxHeight = "0px";
            }
        }
    </script>

    <div class="form-container">
        <form action="" method="post">
        <div class="container">
        <div class="text-center mb-4">
        <h3>Add Admin</h3>
        <p class="text-muted">Click submit after adding new admin</p>
        </div>

            <?php
            if(isset($message)) 
            {
                foreach($message as $msg) 
                {
                    echo '<div class="message">'.$msg.'</div>';
                }
            }
            ?>

            <input type="text" name="name" placeholder="Enter your name" class="box" required>
            <input type="text" name="user" placeholder="Enter username" class="box" required>
            <input type="password" name="password" placeholder="Enter password" class="box" required>
            <input type="password" name="p" placeholder="Confirm password" class="box" required>

            <select name="user_type" class="box" required>
                <option value="">Position</option>
                <option value="user">Student</option>
                <option value="admin">House Owners</option>
        </select>
            
            <input type="submit" name="submit" value="Submit" class="btn">
        </form>
    </div>

</body>
</html>