<?php

include '../utility/util.php';

session_start();

$con = open_connection();

if (!isset($_SESSION['product']['coupon_id'])) {
    if ($create_coupon = $con->prepare('INSERT INTO coupons (discount, product_id) VALUES (?,?)')) {
        $new_discount = $_SESSION['product']['price']*.01;
        $create_coupon->bind_param('di', $new_discount, $_SESSION['product']['product_id']);
        $create_coupon->execute();
        $id = $con->insert_id;
        $_SESSION['product']['coupon_id'] = $id;
        $create_coupon->close();
    } else {
        echo 'Error building coupon creation statement';
        exit();
    }
} else {
    if ($update_coupon = $con->prepare('UPDATE coupons SET discount = discount + ? WHERE coupon_id = ?')) {
        $add_discount = $_SESSION['product']['price']*.01;
        $update_coupon->bind_param('di', $add_discount, $_SESSION['product']['coupon_id']);
        $update_coupon->execute();
        $update_coupon->close();
    } else {
        echo 'Error building coupon update statement';
        exit();
    }
}

if ($update_order = $con->prepare('UPDATE orders SET coupon_id = ?, purchase_amount = ?, completed = 1 WHERE user_id = ? AND completed = 0')) {
    $update_order->bind_param('idi', $_SESSION['product']['coupon_id'], $_POST['purchase_amount'], $_SESSION['id']);
    $update_order->execute();
    $update_order->close();

    if (!isset($_SESSION['address_1']) ||
        $_SESSION['address_1'] != $_POST['address_1']
        || $_SESSION['address_2'] != $_POST['address_2'] 
        || $_SESSION['zip'] != $_POST['zip'] 
        || $_SESSION['city'] != $_POST['city'] 
        || $_SESSION['state'] != $_POST['state'] 
    ) {
        if ($update_address = $con->prepare('UPDATE users SET address_1 = ?, address_2 = ?, zip = ?, city = ?, `state` = ? WHERE user_id = ?')) {
            $update_address->bind_param('sssssi', $_POST['address_1'], $_POST['address_2'], $_POST['zip'], $_POST['city'], $_POST['state'], $_SESSION['id']);
            $update_address->execute();
            $update_address->close();

        } else {
            echo 'Error building address statement';
            exit();
        } 
    }
} else {
    echo 'Error building update order statement';
    exit();
}

$con->close();
unset($_SESSION['product']);

header('Location: ../main/success.php');

?>
