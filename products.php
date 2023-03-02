<?php @include 'config.php'; ?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
<?php

if(isset($message)){
   foreach($message as $message){
      echo '<div class="message"><span>'.$message.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
   };
};

?>

<?php include 'header.php'; ?>

<div class="container">

<section class="products">

   <h1 class="heading">Semua Produk</h1>

   <div class="box-container">

      <?php
      
      $select_products = mysqli_query($conn, "SELECT * FROM `products`");
      if(mysqli_num_rows($select_products) > 0){
         while($fetch_product = mysqli_fetch_assoc($select_products)){
      ?>

      <form action="" method="post">
         <div class="box">
            <img src="uploaded_img/<?php echo $fetch_product['gambar_produk']; ?>" alt="">
            <h3><?php echo $fetch_product['varian']; ?></h3>
            <h4 style="font-size:20px;"><?php echo $fetch_product['berat_bersih']; ?></h4>
            <h4 style="font-size:25px;"><?php echo $fetch_product['harga_box']; ?>/box</h4>
            <h4 style="font-size:25px;"><?php echo $fetch_product['harga_pcs']; ?>/pcs</h4>
            <input type="hidden" name="product_image" value="<?php echo $fetch_product['product_img']; ?>">
<!--            <input type="submit" class="btn" value="add to cart" name="add_to_cart">-->
         </div>
      </form>

      <?php
         };
      };
      ?>

   </div>

</section>

</div>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>