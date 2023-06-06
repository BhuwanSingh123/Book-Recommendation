<?php
function matrix_factorization($R, $P, $Q, $K, $steps = 5000, $alpha = 0.0002, $beta = 0.02)
{
    $Q = transpose($Q);
    for ($step = 0; $step < $steps; $step++) {
        for ($i = 0; $i < count($R); $i++) {
            for ($j = 0; $j < count($R[$i]); $j++) {
                if ($R[$i][$j] > 0) {
                    $sigmaPQ = 0;
                    for ($z = 0; $z < $K; $z++) {
                        $sigmaPQ += $P[$i][$z] * $Q[$z][$j];
                    }
                    $eij = $R[$i][$j] - $sigmaPQ;
                    for ($k = 0; $k < $K; $k++) {
                        $P[$i][$k] = $P[$i][$k] + $alpha * (2 * $eij * $Q[$k][$j] - $beta * $P[$i][$k]);
                        $Q[$k][$j] = $Q[$k][$j] + $alpha * (2 * $eij * $P[$i][$k] - $beta * $Q[$k][$j]);
                    }
                }
            }
        }
        $e = 0;
        for ($i = 0; $i < count($R); $i++) {
            for ($j = 0; $j < count($R[$i]); $j++) {
                if ($R[$i][$j] > 0) {
                    //pow(x, y, z) = x to the power of y modulo z.

                    $sigmaPQ = 0;
                    for ($z = 0; $z < $K; $z++) {
                        $sigmaPQ += $P[$i][$z] * $Q[$z][$j];
                    }
                    $e = $e + pow($R[$i][$j] - $sigmaPQ, 2);
                    for ($k = 0; $k < $K; $k++) {
                        $e = $e + ($beta / 2) * (pow($P[$i][$k], 2) + pow($Q[$k][$j], 2));
                    }
                }
            }
        }
        if ($e < 0.001) {
            break;
        }
    }
    return [$P, transpose($Q)];
}

$result = mysqli_query($conn, "SELECT * FROM product_ratings_view_no_book_name");

// Define the desired array structure
$R = array();

// Iterate over the result and populate the array
while ($row = mysqli_fetch_assoc($result)) {
    $ratingArray = array();
    foreach ($row as $key => $value) {
        if ($key !== 'Book') {
            $ratingArray[] = $value;
        }
    }
    $R[] = $ratingArray;
}
$N = count($R);
$M = count($R[0]);
//Number of latent factors
$K = 2;

$P = generateRandomArray($N, $K);
$Q = generateRandomArray($M, $K);



$calculatedRatingsMatrix = matrix_factorization($R, $P, $Q, $K);
$final = matrixmult($calculatedRatingsMatrix[0], transpose($calculatedRatingsMatrix[1]));

// Truncate the final_array_view table if it exists
mysqli_query($conn, "DROP TABLE IF EXISTS final_array_view");

// Determine the number of columns in $final
$columnCount = count($final[0]);

// Get the user names whose user_type is 'user'
$userNames = array();
$result = mysqli_query($conn, "SELECT id FROM users WHERE user_type = 'user'");
$result_book = mysqli_query($conn, "SELECT name FROM products");

while ($row = mysqli_fetch_assoc($result)) {
    $userNames[] = $row['id'];
}
while ($row = mysqli_fetch_assoc($result_book)) {
    $bookNames[] = $row['name'];
}
// Generate the column names for the final_array_view table
$columnNames = array();
for ($i = 0; $i < $columnCount; $i++) {
    $columnNames[] = "`$userNames[$i]` FLOAT";
}

// Create the final_array_view table with the generated columns
$sql = "CREATE TABLE final_array_view (id INT AUTO_INCREMENT PRIMARY KEY, BOOK VARCHAR(255), " . implode(", ", $columnNames) . ")";
mysqli_query($conn, $sql);

$columnNames = array();
for ($i = 0; $i < $columnCount; $i++) {
    $columnNames[] = "`$userNames[$i]`";
}
foreach ($final as $index => $row) {
    $values = implode(",", array_map('floatval', $row));
    $bookName = isset($bookNames[$index]) ? $bookNames[$index] : "";
    $sql = "INSERT INTO final_array_view (BOOK, " . implode(", ", $columnNames) . ") VALUES ('$bookName', $values)";
    mysqli_query($conn, $sql);
}

/*
 * Helper functions
 * */
function matrixmult($matrix_a, $matrix_b)
{
    $matrix_a_count = count($matrix_a);
    $c = count($matrix_b[0]);
    $matrix_b_count = count($matrix_b);
    if (count($matrix_a[0]) != $matrix_b_count) {
        throw new Exception('Incompatible matrices');
    }
    $matrix_return = array();
    for ($i = 0; $i < $matrix_a_count; $i++) {
        for ($j = 0; $j < $c; $j++) {
            $matrix_return[$i][$j] = 0;
            for ($k = 0; $k < $matrix_b_count; $k++) {
                $matrix_return[$i][$j] += $matrix_a[$i][$k] * $matrix_b[$k][$j];
            }
        }
    }
    return ($matrix_return);
}
function generateRandomArray($dim, $num)
{
    $newArray = array();
    for ($i = 0; $i < $dim; $i++) {
        for ($j = 0; $j < $num; $j++) {
            $newArray[$i][$j] = mt_rand() / mt_getrandmax();
        }
    }
    return $newArray;
}
function transpose($array)
{
    array_unshift($array, null);
    return call_user_func_array('array_map', $array);
}
?>