<?php

include '../utility/util.php';

// Add an item to the cart

$con = open_connection();

// check to see if there is an uncompleted order
if ($check_order = $con->prepare('SELECT order_id FROM orders WHERE user_id = ? AND completed = 0')) {
    $check_order->bind_param('i', $_POST['user_id']);
    $check_order->execute();
    $results = $check_order->get_result();

    // if so, update that order with new item
    if ($results->num_rows > 0) {
        while($row = $results->fetch_assoc()) {
            
            $order_id = $row['order_id'];
            
            if ($update_order = $con->prepare('UPDATE orders SET product_id = ? WHERE order_id = ?;')) {
                $update_order->bind_param('ii', $_POST['product_id'], $order_id);
                $update_order->execute();
                $update_order->close();
            } else {
                echo 'Error building update order statement';
            }
        }

    // else make a new order
    } else {
        
        if ($make_order = $con->prepare('INSERT INTO orders (user_id, product_id) VALUES (?, ?)')) {
            $make_order->bind_param('ii', $_POST['user_id'], $_POST['product_id']);
            $make_order->execute();
            $make_order->close();
        } else {
            echo 'Error building maker order statement'; 
        }
    }

    $check_order->close();
} else {
    echo 'Error building check order statement';
}

$con->close();
header('Location: ../main/checkout.php')

?>