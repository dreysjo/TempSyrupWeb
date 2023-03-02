<?php

@include 'config.php';

session_start();

if(!isset($_SESSION['admin_name'])){
//   header('location:login_form.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin page</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<div class="container">

   <div class="content">

      <p>this is an admin page</p>
<!--      <a href="admin_login_form.php" class="btn">login</a>-->
      <a href="admin.php" class="btn" style="margin-bottom:10px;">admin page</a>
      <a href="logout.php" class="btn">logout</a>
   </div>

</div>

</body>
</html>