<?php

$number = (int)$_GET['number'];

if ($number > 0) {
    echo "The number is positive.<br>";

    if ($number % 2 == 0) {
        echo "The number is even.";
    } else {
        echo "The number is odd.";
    }
} elseif ($number < 0) {
    echo "The number is negative.";
} else {
    echo "The number is zero.";
}

?>