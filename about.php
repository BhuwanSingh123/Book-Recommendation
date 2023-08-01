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
   <title>about</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>about us</h3>
   <p> <a href="home.php">home</a> / about </p>
</div>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/about.jpg" alt="">
      </div>

      <div class="content">
         <h3>why choose us?</h3>
         <p>‍We believe local bookstores are essential community hubs that foster culture, curiosity, and a love of reading, and we're committed to helping them thrive.</p>
         <a href="contact.php" class="btn">contact us</a>
      </div>

   </div>

</section>

<section class="reviews">

   <h1 class="title">client's reviews</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/pic-1.jpg" alt="">
         <p>Reasonable Price</p>
      
         <h3>Chiran</h3>
      </div>

      <div class="box">
         <img src="images/pic-2.jpg" alt="">
         <p>Recommend Nice Books</p>
       
         <h3>Robin</h3>
      </div>

      <div class="box">
         <img src="images/pic-3.jpg" alt="">
         <p>Wide Variety of Books</p>
     
         <h3>Rakesh</h3>
      </div>


</section>

<section class="authors">

   <h1 class="title">Authors</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/author.jpg" alt="">
        
         <h3>Parijat</h3>
      </div>

      <div class="box">
         <img src="images/author2.jpg" alt="">
        
         <h3>Madhav Prasad Ghimire</h3>
      </div>

      <div class="box">
         <img src="images/author3.jpg" alt="">
        
         <h3>Bhanubhakta Acharya</h3>
      </div>

    

</section>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>