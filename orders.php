<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>

  
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

  
   <link rel="stylesheet" href="style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Siparişlerin</h3>
   <p> <a href="home.php">Anasayfa</a> / Siparişlerin </p>
</div>

<section class="placed-orders">

   <h1 class="title">Siparişlerin</h1>

   <div class="box-container">

      <?php
         $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id'") or die('query failed');
         if(mysqli_num_rows($order_query) > 0){
            while($fetch_orders = mysqli_fetch_assoc($order_query)){
      ?>
      <div class="box">
         <p> Durum : <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
         <p> İsmin : <span><?php echo $fetch_orders['name']; ?></span> </p>
         <p> Numaranız : <span><?php echo $fetch_orders['number']; ?></span> </p>
         <p> E-Mail : <span><?php echo $fetch_orders['email']; ?></span> </p>
         <p> Adresin : <span><?php echo $fetch_orders['address']; ?></span> </p>
         <p> Ödeme şeklin : <span><?php echo $fetch_orders['method']; ?></span> </p>
         <p> Siparişin: <span><?php echo $fetch_orders['total_products']; ?></span> </p>
         <p> Genel Toplam : <span>₺<?php echo $fetch_orders['total_price']; ?>/-</span> </p>
         <p> Ödeme Durumu : <span style="color:<?php if($fetch_orders['payment_status'] == 'askıda'){ echo 'red'; }else{ echo 'green'; } ?>;"><?php echo $fetch_orders['payment_status']; ?></span> </p>
         </div>
      <?php
       }
      }else{
         echo '<p class="empty">Henüz siparişin yok!</p>';
      }
      ?>
   </div>

</section>








<?php include 'footer.php'; ?>


<script src="script.js"></script>

</body>
</html>