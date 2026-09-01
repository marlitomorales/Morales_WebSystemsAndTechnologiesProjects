<?php

$total = $_GET['total'];

if ($total < 50) {
    $discountRate = 0;
} elseif ($total < 100) {
    $discountRate = 0.10;
} elseif ($total < 200) {
    $discountRate = 0.15;
} else {
    $discountRate = 0.20;
}

$discount = $total * $discountRate;
$finalPrice = $total - $discount;

echo "Original Price: P" . number_format($total, 2) . "<br>";
echo "Discount Amount: P" . number_format($discount, 2) . "<br>";
echo "Final Price: P" . number_format($finalPrice, 2);

?>