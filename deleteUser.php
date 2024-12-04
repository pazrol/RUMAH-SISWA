<?php
// Call file to connect server Rumah Siswa
include("header.php");

if (isset($_GET['deleteid']))
{
    $delete_id = $_GET['deleteid'];
}
else if(isset($_POST['deleteid']))
{
    $delete_id = $_POST['deleteid'];
}
else
{
    echo 'Accessed Page Error!';
}

$id = $_GET["id"];

$sql = "DELETE FROM `user_form` WHERE user_id = '$delete_id'";

$result = @mysqli_query($connect, $sql);

if ($result) 
{
  echo '<script>window.location.href="listUser.php?id='.$id.'"</script>';
  
} 
else 
{
  echo "Failed: " . mysqli_error($connect);
}
?>