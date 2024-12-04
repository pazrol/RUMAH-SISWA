<?php
session_start(); // Start the session
// Call file to connect server Rumah Siswa
include("header.php");

// Logout functionality
if (isset($_GET['logout'])) 
{
    // Unset all session variables
    session_unset();
    // Destroy the session
    session_destroy();
    // Redirect to the login page
    header("location:login.php");
    exit();
}

if (isset($_GET['editid']))
{
    $edit_id = $_GET['editid'];
}
else if(isset($_POST['editid']))
{
    $edit_id = $_POST['editid'];
}
else
{
    echo 'Accessed Page Error!';
}


// Retrieve current user information from the database
$q = "SELECT * FROM `user_form` WHERE user_id='$edit_id'";
$result = mysqli_query($connect, $q);
$info = mysqli_fetch_assoc($result);

// Check if the form is submitted
if (isset($_POST['submit']))
{
    //Get updated username, name, password, and position
    $user = mysqli_real_escape_string($connect, $_POST['user']);
    $name = mysqli_real_escape_string($connect, $_POST['name']);
    $password = mysqli_real_escape_string($connect, $_POST['password']);
    $position = mysqli_real_escape_string($connect, $_POST['position']);

    // SQL UPDATE query to update user information
    $q2 = "UPDATE user_form SET user='$user', name='$name', password='$password', position='$position'  WHERE user_id='$edit_id'";

    // Execute the UPDATE query
    if (mysqli_query($connect, $q2)) 
    {
        $message[] = "User information updated successfully";
    }
    else if (!empty($message)) 
    {
        $message[] = "Please fill in all the information" . mysqli_error($connect);
    }
} 
?>

<html>
<head>
    <title>Edit User Information</title>
</head>
<body> 
    <style>
        <?php include('editUser.css'); ?>
    </style>

<?php include('navlist.php');?>

    <div class="form-container">
        <form action="" method="post">
        <div class="container">
        <div class="text-center mb-4">
        <h3>Edit User Information</h3>
        <p class="text-muted">Click update after changing any information</p>
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

            <input type="text" name="name" value="<?php echo $info['name'] ?>" placeholder="Enter your name" class="box" required>
            <input type="text" name="user" value="<?php echo $info['user'] ?>" placeholder="Enter username" class="box" required>
            <input type="text" name="password" value="<?php echo $info['password'] ?>" placeholder="Enter password" class="box" required>
            <input type="text" name="p" value="<?php echo $info['password'] ?>" placeholder="Confirm password" class="box" required>

            <select name="position" value="<?php echo $info['position'] ?>" class="box" required>
                <option value=" " <?php if ($info['position'] === '') echo 'selected'; ?>>Position</option>
                <option value="Student" <?php if ($info['position'] === 'Student') echo 'selected'; ?>>Student</option>
                <option value="House Owner" <?php if ($info['position'] === 'House Owner') echo 'selected'; ?>>House Owner</option>
        </select>
            
            <input type="submit" name="submit" value="UPDATE" class="btn">
        </form>
    </div>

</body>
</html>