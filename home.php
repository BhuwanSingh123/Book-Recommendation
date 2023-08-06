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
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'header.php'; ?>
   <?php include 'ratingsample.php'; ?>

   <section class="home">

      <div class="content">
         <h3>Enjoy a new world inside a book</h3>
         <!-- <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi, quod? Reiciendis ut porro iste totam.</p> -->
         <a href="about.php" class="white-btn">Read more</a>
      </div>

   </section>

   <section class="products">

      <h1 class="title">Top Products</h1>

      <div class="box-container">

         <?php
         $productRatings = array();
         // Clear the existing values in $final
         $final = array();

         // Retrieve the values from the final_array_view table
         $sql = "SELECT * FROM final_array_view";
         $result = mysqli_query($conn, $sql);

         while ($row = mysqli_fetch_assoc($result)) {
            // Extract the book name from the 'BOOK' column
            $bookid = $row['id'];

            // Extract the ratings from the remaining columns
            $ratings = array_slice($row, 2);

            // Create a new row array with the book name and ratings
            $newRow = array_merge([$bookid], $ratings);

            // Append the new row to the $final array
            $final[] = $newRow;
         }
         $productRatings = array();

         foreach ($final as $row) {
            // Extract the product name from the first column
            $productid = $row[0];

            // Extract the ratings from the remaining columns
            $ratings = array_slice($row, 1);

            // Calculate the average rating for the product
            $averageRating = array_sum($ratings) / count($ratings);

            // Store the product name and average rating in the array
            $productRatings[$productid] = $averageRating;
         }
         arsort($productRatings);

         $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
         $fetch_rating = array();
         if (mysqli_num_rows($select_products) > 0) {
            while ($fetch_products = mysqli_fetch_assoc($select_products)) {
               $select_query = "SELECT ROUND(AVG(rating), 0) AS rating FROM user_rating WHERE item_id = '" . $fetch_products['id'] . "'";
               $result = mysqli_query($conn, $select_query);
               $fetch_rating[] = mysqli_fetch_assoc($result);
            }

            // Sort the product ratings array in descending order
            arsort($productRatings);
            $count = 0;
            foreach ($productRatings as $productID => $rating) {
               // Retrieve the product details based on the product ID
               $select_product_query = "SELECT * FROM `products` WHERE id = '$productID'";
               $product_result = mysqli_query($conn, $select_product_query);
               $product = mysqli_fetch_assoc($product_result);
               $averageRating = $fetch_rating[$productID - 1]['rating'];
               if ($count > 2) {
                  break;
               }
               $count++;

         ?>
               <form action="" method="post" class="box">
                  <img class="image" src="uploaded_img/<?php echo $product['image']; ?>" alt="" style="max-width: 100%; height: auto;">
                  <div class="name">
                     <?php echo $product['name']; ?>
                  </div>
                  <div class="price">RS
                     <?php echo $product['price']; ?>/-
                  </div>
                  <input class="star star-5" id="star-5-<?php echo $product['id']; ?>" type="radio" name="star" value="5" <?php if ($averageRating == 5) {
                                                                                                                              echo 'checked';
                                                                                                                           } ?> disabled />
                  <label class="star star-5" for="star-5-<?php echo $product['id']; ?>"></label>

                  <input class="star star-4" id="star-4-<?php echo $product['id']; ?>" type="radio" name="star" value="4" <?php if ($averageRating == 4) {
                                                                                                                              echo 'checked';
                                                                                                                           } ?> disabled />
                  <label class="star star-4" for="star-4-<?php echo $product['id']; ?>"></label>

                  <input class="star star-3" id="star-3-<?php echo $product['id']; ?>" type="radio" name="star" value="3" <?php if ($averageRating == 3) {
                                                                                                                              echo 'checked';
                                                                                                                           } ?> disabled />
                  <label class="star star-3" for="star-3-<?php echo $product['id']; ?>"></label>

                  <input class="star star-2" id="star-2-<?php echo $product['id']; ?>" type="radio" name="star" value="2" <?php if ($averageRating == 2) {
                                                                                                                              echo 'checked';
                                                                                                                           } ?> disabled />
                  <label class="star star-2" for="star-2-<?php echo $product['id']; ?>"></label>

                  <input class="star star-1" id="star-1-<?php echo $product['id']; ?>" type="radio" name="star" value="1" <?php if ($averageRating == 1) {
                                                                                                                              echo 'checked';
                                                                                                                           } ?> disabled />
                  <label class="star star-1" for="star-1-<?php echo $product['id']; ?>"></label>

                  <input type="number" min="1" name="product_quantity" value="1" class="qty">
                  <input type="hidden" name="item_id" value="<?php echo $product['id']; ?>">
                  <input type="hidden" name="product_name" value="<?php echo $product['name']; ?>">
                  <input type="hidden" name="product_price" value="<?php echo $product['price']; ?>">
                  <input type="hidden" name="product_image" value="<?php echo $product['image']; ?>">
                  <input type="submit" value="add to cart" name="add_to_cart" class="btn">
               </form>
         <?php
            }
         } else {
            echo '<p class="empty">no products added yet!</p>';
         }
         ?>
      </div>
   </section>
      <section class="products">
      <h1 class="title">Suggested Products</h1>

<div class="box-container">
      <?php
      $sql = "SELECT COLUMN_NAME
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_NAME = 'final_array_view'";

      $result = mysqli_query($conn, $sql);
      $columnNames = array();

      if (mysqli_num_rows($result) > 0) {
         while ($row = mysqli_fetch_assoc($result)) {
            $columnNames[] = $row['COLUMN_NAME'];
         }
      }

      $userId = $user_id; // Replace with the user's ID to check
      $matchingColumns = array();

      foreach ($columnNames as $columnName) {
         if ($columnName == $userId) {
            $matchingColumns[] = $columnName;
         }
      }
      if (!empty($matchingColumns)) {
         $sql = "SELECT `$matchingColumns[0]` FROM final_array_view";
         $result = mysqli_query($conn, $sql);
         $userfinal = array();

         while ($row = mysqli_fetch_assoc($result)) {
            $userfinal[] = $row[$matchingColumns[0]];
         }
         arsort($userfinal);
         $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
         $fetch_rating = array();
         if (mysqli_num_rows($select_products) > 0) {
            while ($fetch_products = mysqli_fetch_assoc($select_products)) {
               $select_query = "SELECT ROUND(AVG(rating), 0) AS rating FROM user_rating WHERE item_id = '" . $fetch_products['id'] . "'";
               $result = mysqli_query($conn, $select_query);
               $fetch_rating[] = mysqli_fetch_assoc($result);
            }
            $count = 0;
            foreach ($userfinal as $productID => $rating) {
               // Retrieve the product details based on the product ID
               $valuespd = $productID + 1;
               $select_product_query = "SELECT * FROM `products` WHERE id = '$valuespd'";
               $product_result = mysqli_query($conn, $select_product_query);
               $product = mysqli_fetch_assoc($product_result);
               $averageRating = $fetch_rating[$productID]['rating'];
               if ($count > 2) {
                  break;
               }
               $count++;
               ?>
               <form action="" method="post" class="box">
               <img class="image" src="uploaded_img/<?php echo $product['image']; ?>" alt="">
               <div class="name">
                  <?php echo $product['name']; ?>
               </div>
               <div class="price">RS
                  <?php echo $product['price']; ?>/-
               </div>
               <input class="star star-5" id="star-5-<?php echo $product['id']; ?>" type="radio" name="star" value="5" <?php if ($averageRating == 5) {
                                                                                                                           echo 'checked';
                                                                                                                        } ?> disabled />
               <label class="star star-5" for="star-5-<?php echo $product['id']; ?>"></label>

               <input class="star star-4" id="star-4-<?php echo $product['id']; ?>" type="radio" name="star" value="4" <?php if ($averageRating == 4) {
                                                                                                                           echo 'checked';
                                                                                                                        } ?> disabled />
               <label class="star star-4" for="star-4-<?php echo $product['id']; ?>"></label>

               <input class="star star-3" id="star-3-<?php echo $product['id']; ?>" type="radio" name="star" value="3" <?php if ($averageRating == 3) {
                                                                                                                           echo 'checked';
                                                                                                                        } ?> disabled />
               <label class="star star-3" for="star-3-<?php echo $product['id']; ?>"></label>

               <input class="star star-2" id="star-2-<?php echo $product['id']; ?>" type="radio" name="star" value="2" <?php if ($averageRating == 2) {
                                                                                                                           echo 'checked';
                                                                                                                        } ?> disabled />
               <label class="star star-2" for="star-2-<?php echo $product['id']; ?>"></label>

               <input class="star star-1" id="star-1-<?php echo $product['id']; ?>" type="radio" name="star" value="1" <?php if ($averageRating == 1) {
                                                                                                                           echo 'checked';
                                                                                                                        } ?> disabled />
               <label class="star star-1" for="star-1-<?php echo $product['id']; ?>"></label>

               <input type="number" min="1" name="product_quantity" value="1" class="qty">
               <input type="hidden" name="item_id" value="<?php echo $product['id']; ?>">
               <input type="hidden" name="product_name" value="<?php echo $product['name']; ?>">
               <input type="hidden" name="product_price" value="<?php echo $product['price']; ?>">
               <input type="hidden" name="product_image" value="<?php echo $product['image']; ?>">
               <input type="submit" value="add to cart" name="add_to_cart" class="btn">
            </form>
      <?php
            }
         }
     } else {
         // User's ID does not match any column names in the final_array_view table
         echo "No Suggestions for you at the moment!";
     }


      ?>
      <div class="load-more" style="margin-top: 2rem; text-align:center">
         <a href="shop.php" class="option-btn">load more</a>
      </div>
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
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>