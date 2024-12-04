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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Rumah Siswa</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    
    <style>
        <?php include("aboutUs.css");?>
    </style>
</head>
<body>
    <?php include("navlist.php"); ?>

    <div class="container-card">
        <section id="about">
            <section class="about">
                <div class="container flex">
                    <div class="left">
                        <div class="heading">
                            <h1>ABOUT US</h1>
                            <h2>Rumah Siswa</h2>
                        </div>
                        <p>
                            Welcome to Rumah Siswa, your go-to platform for hassle-free
                            student housing solutions. At Rumah Siswa, we understand the
                            challenges students face when searching for suitable rental homes
                            within their budget and preferred location. Likewise, we recognize
                            the struggles homeowners encounter in effectively showcasing their
                            properties to potential student tenants. With these concerns in
                            mind, we've developed a comprehensive solution to bridge the gap
                            between students seeking accommodation and homeowners eager to
                            rent out their properties.

                        </p>
                        <div class="icon">
                        <i class='bx bxl-gmail'> rumahsiswa@gmail.com</i>
                        <i class='bx bx-phone'> +603-8911190</i>
                        </div>
                    </div>
                </div>
            </section>
        </section>
    </div>

    
