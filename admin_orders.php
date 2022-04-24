<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

if(isset($_POST['update_order'])){

   $order_update_id = $_POST['order_id'];
   $update_payment = $_POST['update_payment'];
   mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment' WHERE id = '$order_update_id'") or die('query failed');
   $message[] = 'Ödeme durumu güncellendi!';

}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Siparişler</title>


   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">


   <link rel="stylesheet" href="admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="orders">

   <h1 class="title">Sipariş Yeri</h1>

   <div class="box-container">
      <?php
      $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
      if(mysqli_num_rows($select_orders) > 0){
         while($fetch_orders = mysqli_fetch_assoc($select_orders)){
      ?>
      <div class="box">
         <p> Kullanıcı ID : <span><?php echo $fetch_orders['user_id']; ?></span> </p>
         <p> Yeri : <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
         <p> İsim : <span><?php echo $fetch_orders['name']; ?></span> </p>
         <p> Cep Telefonu : <span><?php echo $fetch_orders['number']; ?></span> </p>
         <p> E-mail : <span><?php echo $fetch_orders['email']; ?></span> </p>
         <p> Adres : <span><?php echo $fetch_orders['address']; ?></span> </p>
         <p> Toplam ürün : <span><?php echo $fetch_orders['total_products']; ?></span> </p>
         <p> Toplam tutar : <span>₺<?php echo $fetch_orders['total_price']; ?>/-</span> </p>
         <p> Ödeme şekli : <span><?php echo $fetch_orders['method']; ?></span> </p>
         <form action="" method="post">
            <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
            <select name="update_payment">
               <option value="" selected disabled><?php echo $fetch_orders['payment_status']; ?></option>
               <option value="askıda">Askıda</option>
               <option value="tamamlandı">Tamamlandı</option>
            </select>
            <input type="submit" value="Güncelle" name="update_order" class="option-btn">
            <a href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>" onclick="return confirm('Siparişi iptal etmek istiyor musun?');" class="delete-btn">Sil</a>
         </form>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">Henüz sipariş yok!</p>';
      }
      ?>
   </div>

</section>
