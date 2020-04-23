<?php

include "util.php";

// complete the order for this user
function complete_order($user_id){
    
    
    $con = open_connection();
    
    
    $check_order = $con->prepare("UPDATE orders
                                SET orders.completed = 1
                                WHERE orders.user_id = ?;");
                                    
    $check_order->bind_param("i", $user_id);
    $check_order->execute();
    $results = $check_order->get_result();
    
    $check_order->close();
    $con->close();
    
    
}

// when POST is made
if(isset($_POST['submit']))
{
    complete_order($_POST['user_id']);
    header('Location: ../success/index.php');
    exit();
} 

?>
