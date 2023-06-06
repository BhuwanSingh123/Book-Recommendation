DROP DATABASE IF EXISTS shop_db;
CREATE DATABASE shop_db;
USE shop_db;
CREATE TABLE `cart` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `item_id` int NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `image` varchar(100) NOT NULL,
   PRIMARY KEY (`id`)
);

CREATE TABLE `message` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
);
CREATE TABLE `orders` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` varchar(50) NOT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`id`)
);
INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES
(10, 3, 'rijan', '982324445', 'bhuwansingh199@gmail.com', 'cash on delivery', 'flat no. , kool, ,  - ', ', Harry Potter (1) ', 500, '12-May-2023', 'completed'),
(11, 3, 'fdsfsd', '98232323', 'sdsd@gmail.com', 'cash on delivery', 'flat no. , dsd, ,  - ', ', Harry Potter (1) ', 500, '12-May-2023', 'pending'),
(12, 3, 'kool', '982322223', 'bhuwans@gmail.com', 'cash on delivery', 'khsud', ', Harry Potter (1) ', 500, '12-May-2023', 'pending'),
(13, 3, 'chandan', '999', 'chandan@gmail.com', 'paytm', 'Dallu', ', The Book Of Names (1) ', 400, '06-Jun-2023', 'pending'),
(14, 3, 'chandan', '9843177805', 'chandan123@gmail.com', 'khalti', 'dallu', ', The Book Of Names (1) ', 400, '06-Jun-2023', 'pending');

CREATE TABLE `products` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
);
INSERT INTO `products` (`id`, `name`, `price`, `image`) VALUES
(1, 'The Book Of Names', 400, 'book1.jpg'),
(3, 'Harry Potter', 500, 'book2.jpg'),
(4, 'The Unspoken Name', 500, 'images.jpg'),
(5, 'THE LIAR\'S DICTNORY', 1000, 'd.jpg'),
(6, 'A Boy Called BAT', 550, 'imag.jpg'),
(8, 'The Silver Serpent', 500, 'g.jpg');

CREATE TABLE `users` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`)
);
INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`) VALUES
(3, 'Bhuwan', 'bhuwansingh279@gmail.com', '4bda6a1acf63d79fffc155df4656c76a', 'user'),
(4, 'bhuwan', 'bhuwansingh913@gmail.com', '3792c1792d74142aed6899ee1cfc414c', 'admin'),
(5, 'bhuwan', 'bhuwansingh913@gmail.com', '4bda6a1acf63d79fffc155df4656c76a', 'admin');

CREATE TABLE `user_rating` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `user_id` int(100) NOT NULL,
  `item_id` int(100) NOT NULL,
  `rating` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_user_rating_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_user_rating_book_id` FOREIGN KEY (`book_id`) REFERENCES `products` (`id`)
);


create table item_ids(
  `order_id` int NOT NULL,
  `item_ids` int NOT NULL,
  Foreign Key (order_id) REFERENCES orders(id),
  FOREIGN KEY (item_ids) REFERENCES products(id)
)


SET @sql = NULL;

SELECT
  GROUP_CONCAT(DISTINCT
    CONCAT(
      'GROUP_CONCAT(IFNULL(CASE WHEN u.id = ',
      id,
      ' THEN r.rating END, \'\') ORDER BY u.id) AS ',
      name
    )
  ) INTO @sql
FROM users;

SET @sql = CONCAT('SELECT p.name AS Book, ', @sql, '
                   FROM products p
                   LEFT JOIN user_rating r ON p.id = r.item_id
                   LEFT JOIN users u ON r.user_id = u.id
                   GROUP BY p.id');

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
