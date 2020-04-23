<?php

include '../utility/util.php';

session_start();

$con = open_connection();

if ($update_order = $con->prepare('UPDATE orders SET coupon_id = ?, purchase_amount = ?, completed = 1 WHERE user_id = ? AND completed = 0')) {
    $update_order->bind_param('idi', $_SESSION['product']['product_id'], $_POST['purchase_amount'], $_SESSION['id']);
    $update_order->execute();
    $update_order->close();

    echo 'Succesfully updated order.';

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

            echo 'Succesfully added address.';
        } else {
            echo 'Error building address statement';
            // exit();
        } 
    }
} else {
    echo 'Error building update order statement';
    // exit();
}

$con->close();
unset($_SESSION['product']);

echo 'Succesfully placed order. <a href="../">Homepage</a><br/>';
echo json_encode($_SESSION, JSON_HEX_TAG);
echo '<br/>';
echo json_encode($_POST, JSON_HEX_TAG);

?>
