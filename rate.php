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
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rate'])) {
        $item_id = $_POST['item_id'];
        $rating = $_POST['star'];

        // Perform necessary validation and sanitization of the input values
    
        // Check if the rating already exists for the user and item
        $select_query = "SELECT * FROM user_rating WHERE user_id = '$user_id' AND item_id = '$item_id'";
        $result = mysqli_query($conn, $select_query);

        if (mysqli_num_rows($result) > 0) {
            // Update the existing rating
            $update_query = "UPDATE user_rating SET rating = '$rating' WHERE user_id = '$user_id' AND item_id = '$item_id'";
            $update_result = mysqli_query($conn, $update_query);

            if ($update_result) {
                echo "Rating updated successfully!";
            } else {
                echo "Error updating rating: " . mysqli_error($conn);
            }
        } else {
            // Insert the rating into the 'user_rating' table
            $insert_query = "INSERT INTO user_rating (user_id, item_id, rating) VALUES ('$user_id', '$item_id', '$rating')";
            $insert_result = mysqli_query($conn, $insert_query);

            if ($insert_result) {
                echo "Rating stored successfully!";
            } else {
                echo "Error storing rating: " . mysqli_error($conn);
            }
        }
        header('location:ratingsample.php');
    }
    ?>

    <?php include 'header.php'; ?>

    <section class="products">

        <h1 class="title">Rating</h1>

        <div class="box-container">

            <?php
            $select_products = mysqli_query($conn, "SELECT DISTINCT p.* FROM orders o JOIN item_ids i ON o.id=i.order_id JOIN products p ON i.item_ids=p.id WHERE o.user_id= $user_id AND o.payment_status='completed';") or die('query failed');

            if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($select_products)) {
                    $select_query = "SELECT * FROM user_rating WHERE user_id = '$user_id' AND item_id = '" . $fetch_products['id'] . "'";
                    $result = mysqli_query($conn, $select_query);
                    $fetch_rating = mysqli_fetch_assoc($result);
                    ?>
                    <form action="" method="post" class="box">
                        <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                        <div class="name">
                            <?php echo $fetch_products['name']; ?>
                        </div>

                        <input type="hidden" name="item_id" value="<?php echo $fetch_products['id']; ?>">
                        <input class="star star-5" id="star-5-<?php echo $fetch_products['id']; ?>" type="radio" name="star"
                            value="5" <?php if ($fetch_rating && $fetch_rating['rating'] == 5) {
                                echo 'checked';
                            } ?> />
                        <label class="star star-5" for="star-5-<?php echo $fetch_products['id']; ?>"></label>

                        <input class="star star-4" id="star-4-<?php echo $fetch_products['id']; ?>" type="radio" name="star"
                            value="4" <?php if ($fetch_rating && $fetch_rating['rating'] == 4) {
                                echo 'checked';
                            } ?> />
                        <label class="star star-4" for="star-4-<?php echo $fetch_products['id']; ?>"></label>

                        <input class="star star-3" id="star-3-<?php echo $fetch_products['id']; ?>" type="radio" name="star"
                            value="3" <?php if ($fetch_rating && $fetch_rating['rating'] == 3) {
                                echo 'checked';
                            } ?> />
                        <label class="star star-3" for="star-3-<?php echo $fetch_products['id']; ?>"></label>

                        <input class="star star-2" id="star-2-<?php echo $fetch_products['id']; ?>" type="radio" name="star"
                            value="2" <?php if ($fetch_rating && $fetch_rating['rating'] == 2) {
                                echo 'checked';
                            } ?> />
                        <label class="star star-2" for="star-2-<?php echo $fetch_products['id']; ?>"></label>

                        <input class="star star-1" id="star-1-<?php echo $fetch_products['id']; ?>" type="radio" name="star"
                            value="1" <?php if ($fetch_rating && $fetch_rating['rating'] == 1) {
                                echo 'checked';
                            } ?> />
                        <label class="star star-1" for="star-1-<?php echo $fetch_products['id']; ?>"></label>

                        <input type="submit" value="Rate" name="rate" class="btn">
                    </form>
                    <?php
                }
            } else {
                echo '<p class="empty">no products added yet!</p>';
            }
            ?>
        </div>

        <div class="load-more" style="margin-top: 2rem; text-align:center">
            <a href="shop.php" class="option-btn">Shop more</a>
        </div>

    </section>
    <!-- custom js file link  -->
    <script src="js/script.js"></script>
</body>

</html>