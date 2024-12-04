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
    header("location: login.php");
    exit();
}


$user_id = $_SESSION['user_id']; // Get the user's session ID

// Retrieve current user information from the database
$q = "SELECT * FROM `user_form` WHERE user_id='$user_id'";
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
    $q2 = "UPDATE user_form SET user='$user', name='$name', password='$password', position='$position'  WHERE user_id='$user_id'";

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


<!DOCTYPE html>
<html lang="en">
    

  <head>
    <title>Rumah Siswa</title>
  </head>

  <body>

    <style>
      <?php include("navlist.php");?>
    </style>
    <style>
      <?php include("profile.css");?>
    </style>


  <form action="" method="POST">

  <div class="container">
    <h4>Profile Settings</h4>
    <?php if (isset($message)): ?>
        <?php foreach ($message as $msg): ?>
            <div class="message"><?php echo $msg; ?></div>
        <?php endforeach; ?>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form action="profile.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="user" value="<?php echo $info['user'] ?>" placeholder="Username"/>
                </div>

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" value="<?php echo $info['name'] ?>" placeholder="Full Name"/>
                </div>

                <div class="form-group">
                    <label>New Password</label>
                    <input type="text" name="password" value="<?php echo $info['password'] ?>"placeholder="New Password"/>
                </div>

                <div class="form-group">
                    <label>Position</label>
                    <select name="position">
                        <option value=" " <?php if ($info['position'] === '') echo 'selected'; ?>></option>
                        <option value="Student" <?php if ($info['position'] === 'Student') echo 'selected'; ?>>
                        Student
                        </option>
                        <option value="House Owner" <?php if ($info['position'] === 'House Owner') echo 'selected'; ?>>
                            House Owner
                        </option>
                    </select>
                </div>

                <button type="submit" name="submit" class="btn">Save changes</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>