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

//Look for a valid user id, either through GET or POST
if ((isset($_GET['id'])) && (is_numeric($_GET['id'])))
{
    $id = $_GET['id'];
}
else if ((isset($_POST['id'])) && (is_numeric($_POST['id'])))
{
    $id = $_POST['id'];
}
else
{
    echo '<p class = "error">This page has been accessed in error.</p>';
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
    $position = mysqli_real_escape_string($connect, ($_POST['position']));

    $select = mysqli_query($connect, "SELECT * FROM `user_form` WHERE user = '$user'") or die('Query failed');

    if(mysqli_num_rows($select) > 0) 
    {
        $message[] = 'User already exists'; 
    } 
    else 
    {
       
        $query = "INSERT INTO `user_form` (name, user, password, user_type,  position) VALUES ('$name', '$user', '$pass','$user_type', '$position')";
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
        <?php include('addUser.css'); ?>
    </style>

<?php include('navlist.php');?>
    

    <div class="form-container">
        <form action="addUser.php?id=<?php echo $id; ?>" method='POST' id="registrationForm">
            <div class="container">
                <div class="text-center mb-4">
                    <h3>Add User</h3>
                    <p class="text-muted">Click submit after adding new user</p>
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

                <select name="user_type" class="box" id="user_type" required>
                    <option value="">User Type</option>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>

                <select name="position" class="box" id="position" style="display:none;">
                    <option value="">Position</option>
                    <option value="Student">Student</option>
                    <option value="Houseowner">House Owner</option>
                </select>
                
                <input type="submit" name="submit" value="Submit" class="btn">
            </div>
        </form>
    </div>

    <script>
        // JavaScript to show/hide the position dropdown based on the selected user type
        document.getElementById("user_type").addEventListener("change", function() {
            var userType = this.value;
            var positionDropdown = document.getElementById("position");

            if (userType === "user") {
                positionDropdown.style.display = "block";
            } else {
                positionDropdown.style.display = "none";
            }
        });
    </script>
</body>
</html>


