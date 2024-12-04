<?php
// Call file to connect server Rumah Siswa
include("header.php");

if (isset($_GET['houseid']))
{
    $house_id = $_GET['houseid'];
}
else if(isset($_POST['houseid']))
{
    $house_id = $_POST['houseid'];
}
else
{
    echo 'Accessed Page Error!';
}

$id = $_GET["id"];

$sql = "DELETE FROM `house` WHERE house_id = '$house_id'";

$result = @mysqli_query($connect, $sql);

if ($result) 
{
    echo '<script>window.location.href="postlist.php?id='.$id.'"</script>';
 
} 
else 
{
  echo "Failed: " . mysqli_error($connect);
}
?>