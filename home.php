<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
}

if (isset($_POST['add_to_cart'])) {

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];
   $item_id = $_POST['item_id'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if (mysqli_num_rows($check_cart_numbers) > 0) {
      $message[] = 'already added to cart!';
   } else {
      mysqli_query($conn, "INSERT INTO `cart`(user_id,item_id, name, price, quantity, image) VALUES('$user_id', '$item_id','$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
      $message[] = 'product added to cart!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'header.php'; ?>

   <section class="home">

      <div class="content">
         <h3>Enjoy a new world inside a book</h3>
         <!-- <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi, quod? Reiciendis ut porro iste totam.</p> -->
         <a href="about.php" class="white-btn">Read more</a>
      </div>

   </section>

   <section class="products">

      <h1 class="title">latest products</h1>

      <div class="box-container">

      <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
         if (mysqli_num_rows($select_products) > 0) {
            while ($fetch_products = mysqli_fetch_assoc($select_products)) {
               $select_query = "SELECT ROUND(AVG(rating),0) AS rating FROM user_rating WHERE item_id = '" . $fetch_products['id'] . "'";
                    $result = mysqli_query($conn, $select_query);
                    $fetch_rating = mysqli_fetch_assoc($result);
               ?>
               <form action="" method="post" class="box">
                  <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                  <div class="name">
                     <?php echo $fetch_products['name']; ?>
                  </div>
                  <div class="price">RS
                     <?php echo $fetch_products['price']; ?>/-
                  </div>
                  <input class="star star-5" id="star-5-<?php echo $fetch_products['id']; ?>" type="radio" name="star"
                     value="5" <?php if ($fetch_rating && $fetch_rating['rating'] == 5) {
                        echo 'checked';
                     } ?> disabled/>
                  <label class="star star-5" for="star-5-<?php echo $fetch_products['id']; ?>"></label>

                  <input class="star star-4" id="star-4-<?php echo $fetch_products['id']; ?>" type="radio" name="star"
                     value="4" <?php if ($fetch_rating && $fetch_rating['rating'] == 4) {
                        echo 'checked';
                     } ?> disabled />
                  <label class="star star-4" for="star-4-<?php echo $fetch_products['id']; ?>"></label>

                  <input class="star star-3" id="star-3-<?php echo $fetch_products['id']; ?>" type="radio" name="star"
                     value="3" <?php if ($fetch_rating && $fetch_rating['rating'] == 3) {
                        echo 'checked';
                     } ?> disabled />
                  <label class="star star-3" for="star-3-<?php echo $fetch_products['id']; ?>"></label>

                  <input class="star star-2" id="star-2-<?php echo $fetch_products['id']; ?>" type="radio" name="star"
                     value="2" <?php if ($fetch_rating && $fetch_rating['rating'] == 2) {
                        echo 'checked';
                     } ?> disabled />
                  <label class="star star-2" for="star-2-<?php echo $fetch_products['id']; ?>"></label>

                  <input class="star star-1" id="star-1-<?php echo $fetch_products['id']; ?>" type="radio" name="star"
                     value="1" <?php if ($fetch_rating && $fetch_rating['rating'] == 1) {
                        echo 'checked';
                     } ?> disabled />
                  <label class="star star-1" for="star-1-<?php echo $fetch_products['id']; ?>"></label>

                  <input type="number" min="1" name="product_quantity" value="1" class="qty">
                  <input type="hidden" name="item_id" value="<?php echo $fetch_products['id']; ?>">
                  <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                  <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                  <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                  <input type="submit" value="add to cart" name="add_to_cart" class="btn">
               </form>
               <?php
            }
         } else {
            echo '<p class="empty">no products added yet!</p>';
         }
         ?>
      </div>

      <div class="load-more" style="margin-top: 2rem; text-align:center">
         <a href="shop.php" class="option-btn">load more</a>
      </div>

   </section>

   <section class="about">

      <div class="flex">

         <div class="image">
            <img src="images/about.jpg" alt="">
         </div>

         <div class="content">
            <h3>about us</h3>
            <p>Our mission is simple: To help local, independent bookstores thrive in the age of ecommerce.</p>
            <a href="about.php" class="btn">read more</a>
         </div>

      </div>

   </section>

   <!-- <section class="home-contact">

   <div class="content">
      <h3>have any questions?</h3>
      <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Atque cumque exercitationem repellendus, amet ullam voluptatibus?</p>
      <a href="contact.php" class="white-btn">contact us</a>
   </div>

</section> -->


   <!-- custom js file link  -->
   <script src="js/script.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"></script>
</body>

</html>