<?php
session_start(); // Start the session

//Call file to connect server Rumah Siswa
include("header.php");

$message = array();

if (isset($_POST['submit'])) 
{
    $name = mysqli_real_escape_string($connect, ($_POST['name']));
    $user = mysqli_real_escape_string($connect, ($_POST['user']));
    $pass = mysqli_real_escape_string($connect, ($_POST['password']));
    $p = mysqli_real_escape_string($connect, ($_POST['p']));
    $user_type = mysqli_real_escape_string($connect, ($_POST['user_type']));
    $admin_id = mysqli_real_escape_string($connect, ($_POST['admin_id']));

    $select = mysqli_query($connect, "SELECT * FROM `user_form` WHERE user = '$user'") or die('Query failed');

    if(mysqli_num_rows($select) > 0) 
    {
        $message[] = 'User already exists'; 
    } 
    else 
    {
        if ($pass != $p) 
        {
            $message[] = 'Confirm password not matched!';
        } 
        else 
        {
            if ($user_type == 'admin') 
            {
                if ($admin_id != 'RS10') 
                {
                    $message[] = 'Invalid admin ID!';
                } 
                else 
                {
                    $query = "INSERT INTO `user_form` (name, user, password, user_type, admin_id) VALUES ('$name', '$user', '$pass', '$user_type', '$admin_id')";
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
    }
}
?>

<html>
<head>
    <title>Register</title>
</head>
<body> 
    <style>
        <?php include('register.css'); ?>
    </style>
    <div class="form-container">
        <form action="" method="post">
            <h3>Sign Up</h3>

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
                <option value="">Select User Type</option>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>

            <input type="text" name="admin_id" placeholder="Enter Admin ID" class="box admin-id" style="display: none;">
            
            <input type="submit" name="submit" value="Register" class="btn">
            <p>Already have an account? <a href="login.php">Login Now!</a></p>
        </form>
    </div>

    <script>
        document.querySelector('select[name="user_type"]').addEventListener('change', function() 
        {
            var adminIdField = document.querySelector('.admin-id');
            if (this.value === 'admin') 
            {
                adminIdField.style.display = 'block';
                adminIdField.required = true;
            } 
            else 
            {
                adminIdField.style.display = 'none';
                adminIdField.required = false;
            }
        });
    </script>
</body>
</html>