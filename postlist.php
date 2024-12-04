<?php
// Call file to connect server Rumah Siswa
include("header.php");

// Logout functionality
if (isset($_GET['logout'])) {
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


// Fetch pending house posts from the database
$qp = "SELECT * FROM house WHERE status='pending'";
$result_pending = @mysqli_query($connect, $qp);

include("navlist.php"); 


// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    // Check if approve or reject button is clicked
    if (isset($_POST['approve'])) 
    {
        $house_id = $_POST['house_id'];
        // Update the status of the post to 'approved'
        $query = "UPDATE house SET status='approved' WHERE house_id=$house_id";
        if (@mysqli_query($connect, $query)) 
        {
            // Redirect back to the same page after approving
            echo 
            '<script>
                window.location.href = "postlist.php?id='.$id.'";
            </script>';
            exit();
        } 
        else 
        {
            echo "Error updating record: " . mysqli_error($connect);
        }
    } 
    elseif (isset($_POST['reject'])) 
    {
        $house_id = $_POST['house_id'];
        // Update the status of the post to 'rejected'
        $query = "UPDATE house SET status='rejected' WHERE house_id=$house_id";
        if (@mysqli_query($connect, $query)) 
        {
            // Redirect back to the same page after rejecting
            echo 
            '<script>
                window.location.href = "postlist.php?id='.$id.'";
            </script>';
            exit();
        } 
        else 
        {
            echo "Error updating record: " . mysqli_error($connect);
        }
    } 
    elseif (isset($_POST['delete'])) 
    {
        $house_id = $_POST['house_id'];
        // Delete the post
        $query = "DELETE FROM house WHERE house_id=$house_id";
        if (@mysqli_query($connect, $query)) 
        {
            // Redirect back to the same page after deleting
            echo 
            '<script>
                window.location.href = "postlist.php?id='.$id.'";
            </script>';
            exit();
        } 
        else 
        {
            echo "Error deleting record: " . mysqli_error($connect);
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending House Posts</title>
    
</head>

<body>
    <style><?php include ("postlist.css");?></style>

    
    <section class="container">
    <h2>Pending House Posts</h2>
    <table class="house-table">
        <tr>
            <th>ID</th>
            <th>TITLE</th>
            <th>DESCRIPTION</th>
            <th>PRICE (RM)</th>
            <th>ADDRESS</th>
            <th>ADDRESS 2</th>
            <th>STATE</th>
            <th>PHONE NUMBER</th>
            <th>HOUSE TYPE</th>
            <th>FURNISHING</th>
            <th>STATUS</th>
            <th>ACTONS</th>
        </tr>
        <?php
        // Display pending house posts
        while ($row = mysqli_fetch_assoc($result_pending)) 
        {
            echo "<tr>";
            echo "<td>" . $row['house_id'] . "</td>";
            echo "<td>" . $row['title'] . "</td>";
            echo "<td>" . $row['description'] . "</td>";
            echo "<td>" . $row['price'] . "</td>";
            echo "<td>" . $row['address'] . "</td>";
            echo "<td>" . $row['address2'] . "</td>";
            echo "<td>" . $row['state'] . "</td>";
            echo "<td>" . $row['phone_num'] . "</td>";
            echo "<td>" . $row['house_type'] . "</td>";
            echo "<td>" . $row['furnishing'] . "</td>";
            echo "<td>" . $row['status'] . "</td>";
            echo "<td class='actions-buttons'>
                    <form action='postlist.php?id=$id ' method='POST'>
                        <input type='hidden' name='house_id' value='" . $row['house_id'] . "'>
                        <button type='submit' name='approve'>Approve</button>
                        <button type='submit' name='reject'>Reject</button>
                    </form>
                  </td>";
            echo "</tr>";
        }
        ?>
    </table>
    </section>

    <section class="container">
    <h2>Post List</h2>
    <table class="house-table">    
        <tr>
            <th>ID</th>
            <th>TITLE</th>
            <th>DESCRIPTION</th>
            <th>PRICE (RM)</th>
            <th>ADDRESS</th>
            <th>ADDRESS 2</th>
            <th>STATE</th>
            <th>PHONE NUMBER</th>
            <th>HOUSE TYPE</th>
            <th>FURNISHING</th>
            <th>STATUS</th>
            <th>ACTONS</th>
        </tr>
        <?php
        // Fetch approved house posts from the database
        $qa = "SELECT * FROM house WHERE status='approved'";
        $result_approved = @mysqli_query($connect, $qa);

        // Display approved house posts
        while ($row = mysqli_fetch_assoc($result_approved)) 
        {
            echo "<tr>";
            echo "<td>" . $row['house_id'] . "</td>";
            echo "<td>" . $row['title'] . "</td>";
            echo "<td>" . $row['description'] . "</td>";
            echo "<td>" . $row['price'] . "</td>";
            echo "<td>" . $row['address'] . "</td>";
            echo "<td>" . $row['address2'] . "</td>";
            echo "<td>" . $row['state'] . "</td>";
            echo "<td>" . $row['phone_num'] . "</td>";
            echo "<td>" . $row['house_type'] . "</td>";
            echo "<td>" . $row['furnishing'] . "</td>";
            echo "<td>" . $row['status'] . "</td>";
            echo "<td class='actions-buttons'>
                    <button onclick='confirmDelete(" . $row['house_id'] . ")' class='btn-delete'>Delete</button>
                  </td>";
            echo "</tr>";
        }
        ?>
    </table>
</section>

<script>
    function confirmDelete(houseId) {
        if (confirm("Are you sure you want to delete?")) {
            // If user confirms deletion, redirect to deletePost.php
            window.location.href = "deletePost.php?id=<?php echo $id; ?>&houseid=" + houseId;
        }
    }
</script>

</body>

</html>
