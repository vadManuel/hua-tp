<?php

include 'util.php';

// Add an item to the cart
function add_to_cart($product_id, $user_id){
    
    $con = open_connection();
    
    // check to see if there is an uncompleted order
    $check_order = $con->prepare("SELECT order_id FROM orders where user_id = ? AND completed = 0");
    $check_order->bind_param("i", $user_id);
    $check_order->execute();
    $results = $check_order->get_result();
    $check_order->close();
    
    // if so, update that order with new item
    if ($results->num_rows > 0) {
        while($row = $results->fetch_assoc()) {
            
            
            $order_id = $row["order_id"];
            
            $update_order = $con->prepare("UPDATE orders SET product_id = ? WHERE order_id = ?;");
            $update_order->bind_param("ii", $product_id, $order_id);
            $update_order->execute();
            $update_order->close();
        }
    //else make a new order
    } else {
        
        $make_order = $con->prepare("INSERT INTO orders (user_id, product_id) VALUES (?, ?)");
        $make_order->bind_param("ii", $user_id, $product_id);
        $make_order->execute();
        $make_order->close(); 
    }
    
    
    
    $con->close();

    return;
} 

// when POST is made
if($_SERVER['REQUEST_METHOD']=='POST'){
    
    add_to_cart($_POST['product_id'], $_POST['user_id']);
    header('Location: ../main/index.php');
    exit();
} 

?>
