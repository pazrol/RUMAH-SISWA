<html>
<head>
    <title>RUMAH SISWA</title>
</head>
<body>
    <?php
      //connect to server
      $connect = mysqli_connect("localhost","root","","rumahsiswa");

      if (!$connect)
      {
        die('ERROR :'.mysqli_connect_error());
      }
      //echo 'successfull connect';
      ?>
</body>
</html>