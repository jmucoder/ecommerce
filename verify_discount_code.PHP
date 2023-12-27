<?php
$valid_discount_codes = ['CODE10'];

if (isset($_POST['discount_code'])) {
    if (in_array($_POST['discount_code'], $valid_discount_codes)) {
        echo 'valid';
    } else {
        echo 'invalid';
    }
}
?>